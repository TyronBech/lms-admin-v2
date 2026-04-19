import { Link } from '@inertiajs/react';
import Footer from '@/components/Footer';
import PublicHeader from '@/components/public-header';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div className="flex min-h-svh flex-col bg-secondary-500 dark:bg-gray-900">
            <PublicHeader showNavigation={false} disableAnchors />

            <main className="flex flex-1 items-center justify-center px-4 py-12 sm:px-6 md:py-16">
                <Card
                    variant="highlighted"
                    className="w-full max-w-xl rounded-2xl border border-slate-200/80 bg-white/95 p-7 shadow-2xl shadow-slate-900/10 backdrop-blur-sm sm:p-9 dark:border-gray-700 dark:bg-gray-800/95 dark:shadow-black/35"
                >
                    <CardHeader className="mb-8 items-center gap-4 p-0 text-center">
                        <Link
                            href={home()}
                            className="flex flex-col items-center gap-2 font-medium"
                        >
                            <img
                                src="/img/OwlQuery.png"
                                alt="OwlQuery logo"
                                className="h-14 w-14 object-contain dark:hidden"
                            />
                            <img
                                src="/img/OwlQuery Dark.png"
                                alt="OwlQuery logo dark"
                                className="hidden h-14 w-14 object-contain dark:block"
                            />
                            <span className="sr-only">{title}</span>
                        </Link>

                        <div className="space-y-2">
                            <CardTitle className="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">
                                {title}
                            </CardTitle>
                            <CardDescription className="text-sm text-slate-500 dark:text-gray-300">
                                {description}
                            </CardDescription>
                        </div>
                    </CardHeader>

                    <CardContent className="p-0">{children}</CardContent>
                </Card>
            </main>

            <Footer disableAnchors />
        </div>
    );
}
