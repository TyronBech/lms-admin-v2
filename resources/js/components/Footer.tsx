import { usePage } from '@inertiajs/react';
import React from 'react';

interface Settings {
    org_name?: string;
    org_logo_base64?: string;
    org_address?: string;
    contact_number?: string;
    email?: string;
    social_links?: {
        website?: string;
        facebook?: string;
        instagram?: string;
        twitter?: string;
        youtube?: string;
    };
}

interface FooterProps {
    disableAnchors?: boolean;
}

type LinkOrTextProps = {
    href: string;
    children: React.ReactNode;
    className: string;
    external?: boolean;
    disableAnchors?: boolean;
};

function LinkOrText({
    href,
    children,
    className,
    external = false,
    disableAnchors = false,
}: LinkOrTextProps) {
    if (disableAnchors) {
        return <span className={className}>{children}</span>;
    }

    return (
        <a
            href={href}
            target={external ? '_blank' : undefined}
            rel={external ? 'noopener noreferrer' : undefined}
            className={className}
        >
            {children}
        </a>
    );
}

export default function Footer({ disableAnchors = false }: FooterProps) {
    const { settings } = usePage<{ settings?: Settings }>().props;

    const orgName = settings?.org_name || 'Library Management System';
    const logoSrc = settings?.org_logo_base64 || '';
    const orgAddress = settings?.org_address || '123 Main St, City, Country';
    const contactNumber = settings?.contact_number || 'N/A';
    const email = settings?.email || 'N/A';
    const socialLinks = settings?.social_links || {};

    // Fallback if the environment variable wasn't shared explicitly
    const elibraryUrl = import.meta.env.VITE_ELIBRARY_URL || '#';

    return (
        <footer className="mt-10 border-t border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900">
            <div className="mx-auto w-full max-w-7xl px-4 py-6 lg:py-8">
                <div className="md:flex md:justify-between md:gap-6 lg:gap-8">
                    <div className="mb-6 md:mb-0 md:max-w-xs lg:max-w-md">
                        <div className="flex items-center">
                            {logoSrc && (
                                <img
                                    src={logoSrc}
                                    className="me-3 h-12 w-12 shrink-0 rounded-full md:h-16 md:w-16"
                                    alt={`${orgName} Logo`}
                                />
                            )}
                            <div className="min-w-0">
                                <span className="text-sm font-semibold break-words md:text-lg dark:text-white">
                                    {orgName}
                                </span>
                                <p className="mt-1 text-xs break-words text-gray-500 dark:text-gray-400">
                                    {orgAddress}
                                </p>
                            </div>
                        </div>
                        <p className="mt-4 text-xs text-gray-500 md:text-sm dark:text-gray-400">
                            Library Management System Admin Panel for managing
                            school library attendance and resources.
                        </p>
                    </div>
                    <div className="grid flex-1 grid-cols-2 gap-6 sm:grid-cols-3 sm:gap-6">
                        <div>
                            <h2 className="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                Official Links
                            </h2>
                            <ul className="font-medium text-gray-500 dark:text-gray-400">
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={socialLinks.website || '#'}
                                        external
                                        className="hover:underline"
                                    >
                                        Official Website
                                    </LinkOrText>
                                </li>
                                <li>
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={elibraryUrl}
                                        external
                                        className="hover:underline"
                                    >
                                        E-Library
                                    </LinkOrText>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 className="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                Follow us
                            </h2>
                            <ul className="font-medium text-gray-500 dark:text-gray-400">
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={socialLinks.facebook || '#'}
                                        external
                                        className="hover:underline"
                                    >
                                        Facebook
                                    </LinkOrText>
                                </li>
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={socialLinks.instagram || '#'}
                                        external
                                        className="hover:underline"
                                    >
                                        Instagram
                                    </LinkOrText>
                                </li>
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={socialLinks.twitter || '#'}
                                        external
                                        className="hover:underline"
                                    >
                                        X (Twitter)
                                    </LinkOrText>
                                </li>
                                <li>
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={socialLinks.youtube || '#'}
                                        external
                                        className="hover:underline"
                                    >
                                        YouTube
                                    </LinkOrText>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 className="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">
                                Contact Us
                            </h2>
                            <ul className="font-medium text-gray-500 dark:text-gray-400">
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={
                                            contactNumber !== 'N/A'
                                                ? `tel:${contactNumber}`
                                                : '#'
                                        }
                                        className="hover:underline"
                                    >
                                        {contactNumber}
                                    </LinkOrText>
                                </li>
                                <li className="mb-4">
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href={
                                            email !== 'N/A'
                                                ? `mailto:${email}`
                                                : '#'
                                        }
                                        className="hover:underline"
                                    >
                                        {email}
                                    </LinkOrText>
                                </li>
                                <li>
                                    <LinkOrText
                                        disableAnchors={disableAnchors}
                                        href="mailto:owlquery.tech@gmail.com"
                                        className="hover:underline"
                                    >
                                        owlquery.tech@gmail.com
                                    </LinkOrText>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr className="my-6 border-gray-200 sm:mx-auto lg:my-8 dark:border-gray-700" />
                <div className="sm:flex sm:items-center sm:justify-between">
                    <span className="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                        &copy; {new Date().getFullYear()}{' '}
                        <LinkOrText
                            disableAnchors={disableAnchors}
                            href="mailto:owlquery.tech@gmail.com"
                            className="hover:underline"
                        >
                            OwlQuery Group
                        </LinkOrText>
                        . All Rights Reserved.
                    </span>
                    {!disableAnchors && (
                        <div className="mt-4 flex sm:mt-0 sm:justify-center">
                            <a
                                href={socialLinks.facebook || '#'}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-gray-500 hover:text-gray-900 dark:hover:text-white"
                            >
                                <svg
                                    className="h-4 w-4"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 8 19"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                                <span className="sr-only">Facebook page</span>
                            </a>
                            <a
                                href={socialLinks.instagram || '#'}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="ms-5 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                            >
                                <svg
                                    className="h-4 w-4"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 21 21"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M10.5 1.052a9.45 9.45 0 0 0-9.45 9.45c0 5.223 4.227 9.45 9.45 9.45s9.45-4.227 9.45-9.45-4.227-9.45-9.45-9.45Zm0 16.906a7.456 7.456 0 1 1 0-14.912 7.456 7.456 0 0 1 0 14.912Z"
                                        clipRule="evenodd"
                                    />
                                    <path
                                        fillRule="evenodd"
                                        d="M10.5 5.277a5.225 5.225 0 1 0 0 10.45 5.225 5.225 0 0 0 0-10.45Zm0 8.451a3.225 3.225 0 1 1 0-6.45 3.225 3.225 0 0 1 0 6.45Z"
                                        clipRule="evenodd"
                                    />
                                    <path d="M16.35 5.7a1.05 1.05 0 1 1-2.1 0 1.05 1.05 0 0 1 2.1 0Z" />
                                </svg>
                                <span className="sr-only">Instagram page</span>
                            </a>
                            <a
                                href={socialLinks.twitter || '#'}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="ms-5 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                            >
                                <svg
                                    className="h-4 w-4"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 20 17"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M19.973 2.426a8.16 8.16 0 0 1-2.35.634 4.067 4.067 0 0 0 1.798-2.26 8.213 8.213 0 0 1-2.6.98A4.056 4.056 0 0 0 14.01 0c-2.234 0-4.044 1.792-4.044 4.005 0 .31.035.612.1.906A11.51 11.51 0 0 1 1.745.91a4.01 4.01 0 0 0-.544 2.02c0 1.39.716 2.616 1.8 3.339a4.033 4.033 0 0 1-1.83-.5v.05c0 1.94 1.392 3.56 3.24 3.93a4.07 4.07 0 0 1-1.82.07 4.04 4.04 0 0 0 3.77 2.78A8.13 8.13 0 0 1 .7 14.95a11.47 11.47 0 0 0 6.22 1.8c7.46 0 11.54-6.1 11.54-11.42q0-.26-.01-.52a8.2 8.2 0 0 0 2.02-2.09Z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                                <span className="sr-only">X page</span>
                            </a>
                            <a
                                href={socialLinks.youtube || '#'}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="ms-5 text-gray-500 hover:text-gray-900 dark:hover:text-white"
                            >
                                <svg
                                    className="h-4 w-4"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 20 14"
                                >
                                    <path
                                        fillRule="evenodd"
                                        d="M19.7 3.03a2.48 2.48 0 0 0-1.75-1.75C16.22.8 10 .8 10 .8s-6.22 0-7.95.48A2.48 2.48 0 0 0 .3 3.03C0 4.56 0 7 0 7s0 2.44.3 3.97a2.48 2.48 0 0 0 1.75 1.75C3.78 13.2 10 13.2 10 13.2s6.22 0 7.95-.48a2.48 2.48 0 0 0 1.75-1.75c.3-1.53.3-3.97.3-3.97s0-2.44-.3-3.97ZM8 9.56V4.44L13.03 7 8 9.56Z"
                                        clipRule="evenodd"
                                    />
                                </svg>
                                <span className="sr-only">YouTube channel</span>
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </footer>
    );
}
