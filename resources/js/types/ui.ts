import type { ReactNode } from 'react';
import type { Auth } from '@/types/auth';
import type { BreadcrumbItem } from '@/types/navigation';

export type AppLayoutProps = {
    children: ReactNode;
    breadcrumbs?: BreadcrumbItem[];
};

export type AppVariant = 'header' | 'sidebar';

export type AuthLayoutProps = {
    children?: ReactNode;
    name?: string;
    title?: string;
    description?: string;
};

export type ThemeColors = {
    primary?: string;
    secondary?: string;
    tertiary?: string;
};

export type UiSettings = {
    org_name?: string;
    org_initial?: string;
    org_address?: string;
    org_logo_base64?: string | null;
    org_logo_full_base64?: string | null;
    email?: string;
    contact_number?: string;
    social_links?: {
        website?: string;
        facebook?: string;
        instagram?: string;
        twitter?: string;
        youtube?: string;
    };
    theme_colors?: ThemeColors;
};

export type SharedProps = {
    name: string;
    auth: Auth;
    settings?: UiSettings;
    sidebarOpen: boolean;
    [key: string]: unknown;
};
