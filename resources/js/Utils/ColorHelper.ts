export function generatePalette(hex: string): Record<number, string> {
    const parseHex = (h: string): [number, number, number] => {
        h = h.replace(/^#/, '');

        if (h.length === 3) {
            h = h
                .split('')
                .map((x) => x + x)
                .join('');
        }

        return [
            parseInt(h.substring(0, 2), 16),
            parseInt(h.substring(2, 4), 16),
            parseInt(h.substring(4, 6), 16),
        ];
    };

    const rgbToHsl = (
        r: number,
        g: number,
        b: number,
    ): [number, number, number] => {
        r /= 255;
        g /= 255;
        b /= 255;
        const max = Math.max(r, g, b),
            min = Math.min(r, g, b);
        const l = (max + min) / 2;

        if (max === min) {
            return [0, 0, l];
        }

        const d = max - min;
        const s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        let h = 0;

        switch (max) {
            case r:
                h = (g - b) / d + (g < b ? 6 : 0);
                break;
            case g:
                h = (b - r) / d + 2;
                break;
            default:
                h = (r - g) / d + 4;
                break;
        }

        return [h / 6, s, l];
    };

    const hueToRgb = (p: number, q: number, t: number): number => {
        if (t < 0) {
            t += 1;
        }

        if (t > 1) {
            t -= 1;
        }

        if (t < 1 / 6) {
            return p + (q - p) * 6 * t;
        }

        if (t < 1 / 2) {
            return q;
        }

        if (t < 2 / 3) {
            return p + (q - p) * (2 / 3 - t) * 6;
        }

        return p;
    };

    const hslToRgb = (
        h: number,
        s: number,
        l: number,
    ): [number, number, number] => {
        if (s === 0) {
            const v = Math.round(l * 255);

            return [v, v, v];
        }

        const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        const p = 2 * l - q;

        return [
            Math.round(hueToRgb(p, q, h + 1 / 3) * 255),
            Math.round(hueToRgb(p, q, h) * 255),
            Math.round(hueToRgb(p, q, h - 1 / 3) * 255),
        ];
    };

    const [r, g, b] = parseHex(hex);
    const [h, s, l0] = rgbToHsl(r, g, b);

    const scale: Record<number, number> = {
        50: 0.95,
        100: 0.85,
        200: 0.7,
        300: 0.5,
        400: 0.25,
        500: 0.0,
        600: -0.15,
        700: -0.3,
        800: -0.5,
        900: -0.7,
    };

    const palette: Record<number, string> = {};
    Object.entries(scale).forEach(([keyStr, delta]) => {
        const key = parseInt(keyStr);
        let l = delta > 0 ? l0 + (1 - l0) * delta : l0 * (1 + delta);
        l = Math.max(0, Math.min(1, l));

        const sAdj = s * (key <= 100 ? 0.8 : key >= 800 ? 0.9 : 1.0);

        const [rr, gg, bb] = hslToRgb(h, sAdj, l);
        palette[key] = `rgb(${rr} ${gg} ${bb})`;
    });

    return palette;
}

export function getPaletteVars(name: string, hex: string): string {
    const palette = generatePalette(hex);

    return Object.entries(palette)
        .map(([shade, rgb]) => `--${name}-${shade}: ${rgb};`)
        .join('\n');
}
