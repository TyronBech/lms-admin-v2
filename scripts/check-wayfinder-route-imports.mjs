import { existsSync, readdirSync, readFileSync, statSync } from 'node:fs';
import path from 'node:path';
import process from 'node:process';

const rootDir = process.cwd();
const pagesDir = path.join(rootDir, 'resources', 'js', 'pages');
const aliasRootDir = path.join(rootDir, 'resources', 'js');

const sourceExtensions = ['.ts', '.tsx', '.js', '.jsx', '.mts', '.cts'];

function walkFiles(dirPath) {
    const entries = readdirSync(dirPath);
    const files = [];

    for (const entry of entries) {
        const fullPath = path.join(dirPath, entry);
        const stats = statSync(fullPath);

        if (stats.isDirectory()) {
            files.push(...walkFiles(fullPath));
            continue;
        }

        if (sourceExtensions.includes(path.extname(entry))) {
            files.push(fullPath);
        }
    }

    return files;
}

function toPosixPath(filePath) {
    return path.relative(rootDir, filePath).replaceAll('\\', '/');
}

function resolveAliasModule(importPath) {
    const relativeImport = importPath.replace(/^@\//, '');
    const modulePath = path.join(aliasRootDir, relativeImport);

    const candidates = [
        modulePath,
        ...sourceExtensions.map((ext) => `${modulePath}${ext}`),
        ...sourceExtensions.map((ext) => path.join(modulePath, `index${ext}`)),
    ];

    return candidates.some((candidatePath) => existsSync(candidatePath));
}

function findMissingWayfinderRouteImports(filePath) {
    const missing = [];
    const lines = readFileSync(filePath, 'utf8').split(/\r?\n/);

    for (const [index, line] of lines.entries()) {
        if (!line.includes('@/routes')) {
            continue;
        }

        if (!/(^|\s)(import|export)\b/.test(line)) {
            continue;
        }

        const importMatches = line.matchAll(
            /['"](@\/routes(?:\/[^'"]*)?)['"]/g,
        );

        for (const match of importMatches) {
            const importPath = match[1];

            if (!resolveAliasModule(importPath)) {
                missing.push({
                    filePath,
                    line: index + 1,
                    importPath,
                });
            }
        }
    }

    return missing;
}

if (!existsSync(pagesDir)) {
    console.error('Route import guard failed: pages directory was not found.');
    process.exit(1);
}

const pageFiles = walkFiles(pagesDir);
const missingImports = pageFiles.flatMap((filePath) =>
    findMissingWayfinderRouteImports(filePath),
);

if (missingImports.length === 0) {
    console.log('Wayfinder route import guard passed.');
    process.exit(0);
}

console.error('Wayfinder route import guard failed. Missing modules:');

for (const issue of missingImports) {
    console.error(
        `- ${toPosixPath(issue.filePath)}:${issue.line} imports ${issue.importPath} (module not found)`,
    );
}

console.error(
    'Tip: run "php artisan wayfinder:generate --with-form --no-interaction" after route changes.',
);
process.exit(1);
