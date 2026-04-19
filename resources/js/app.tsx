import { createInertiaApp, usePage } from '@inertiajs/react';
import { TooltipProvider } from '@/components/ui/tooltip';
import { initializeTheme } from '@/hooks/use-appearance';
import AppLayout from '@/layouts/app-layout';
import AuthLayout from '@/layouts/auth-layout';
import SettingsLayout from '@/layouts/settings/layout';
import type { SharedProps } from '@/types';
import { getPaletteVars } from '@/Utils/ColorHelper';

const appName = import.meta.env.VITE_APP_NAME || 'Library Management System for Admin';

function ThemeColorProvider({ children }: { children: React.ReactNode }) {
    const { settings } = usePage<SharedProps>().props;

    const primaryColor = settings?.theme_colors?.primary || '#20246c';
    const secondaryColor = settings?.theme_colors?.secondary || '#EBF5FF';
    const tertiaryColor = settings?.theme_colors?.tertiary || '#C27803';

    return (
        <div className="min-h-screen bg-secondary-500 text-black transition-colors duration-300 dark:bg-gray-900 dark:text-white">
            <style>
                {`
                    :root {
                        ${getPaletteVars('primary', primaryColor)}
                        ${getPaletteVars('secondary', secondaryColor)}
                        ${getPaletteVars('tertiary', tertiaryColor)}
                    }
                `}
            </style>
            {children}
        </div>
    );
}

const RootLayout = ({ children }: { children: React.ReactNode }) => (
    <ThemeColorProvider>{children}</ThemeColorProvider>
);

createInertiaApp({
    title: (title) => {
        let orgName = appName;

        if (typeof window !== 'undefined') {
            const pageData = document.getElementById('app')?.dataset.page;

            if (pageData) {
                try {
                    const parsed = JSON.parse(pageData);

                    if (parsed?.props?.settings?.org_name) {
                        orgName = parsed.props.settings.org_name;
                    }
                } catch {
                    // Ignore parsing error
                }
            }
        }

        return title ? `${title} - ${orgName}` : `${orgName}`;
    },
    layout: (name: string) => {
        switch (true) {
            case name === 'welcome':
                return RootLayout;
            case name.startsWith('auth/'):
                return [RootLayout, AuthLayout];
            case name.startsWith('settings/'):
                return [RootLayout, AppLayout, SettingsLayout];
            default:
                return [RootLayout, AppLayout];
        }
    },
    strictMode: true,
    withApp(app: React.ReactNode) {
        return <TooltipProvider delayDuration={0}>{app}</TooltipProvider>;
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
