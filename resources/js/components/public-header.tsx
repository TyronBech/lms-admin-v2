import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import type { MouseEvent } from 'react';
import { home, login } from '@/routes';

type PublicHeaderProps = {
    showNavigation?: boolean;
    disableAnchors?: boolean;
};

type UiSettings = {
    org_name?: string;
    org_logo_base64?: string;
};

type SharedPageProps = {
    name?: string;
    settings?: UiSettings;
};

export default function PublicHeader({
    showNavigation = true,
    disableAnchors = false,
}: PublicHeaderProps) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);
    const { name, settings } = usePage<SharedPageProps>().props;

    const orgName = settings?.org_name || 'School Name';
    const appName = name || 'Library Management System';
    const logoSrc = settings?.org_logo_base64 || '/img/default-logo.png';

    const handleScroll = (
        e: MouseEvent<HTMLAnchorElement>,
        targetId: string,
    ) => {
        e.preventDefault();
        const element = document.getElementById(targetId);

        if (element) {
            const delay = isMenuOpen ? 50 : 0;
            setIsMenuOpen(false);

            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth' });
            }, delay);
        }
    };

    return (
        <header className="sticky top-0 z-50">
            <nav className="border-gray-200 bg-primary-500">
                <div className="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4">
                    {disableAnchors ? (
                        <div className="flex items-center space-x-3 rtl:space-x-reverse">
                            <img
                                className="h-16 w-16 rounded-full object-cover md:h-20 md:w-20"
                                src={logoSrc}
                                alt="School Logo"
                            />
                            <div className="flex flex-col justify-center text-start">
                                <h1 className="text-sm font-semibold text-white md:text-lg lg:text-xl">
                                    {orgName}
                                </h1>
                                <hr className="my-1 h-px border-0 bg-gray-200" />
                                <h1 className="text-sm font-semibold text-white md:text-base lg:text-lg">
                                    {appName} - Library Management System
                                </h1>
                            </div>
                        </div>
                    ) : (
                        <Link
                            href={home()}
                            className="flex items-center space-x-3 rtl:space-x-reverse"
                        >
                            <img
                                className="h-16 w-16 rounded-full object-cover md:h-20 md:w-20"
                                src={logoSrc}
                                alt="School Logo"
                            />
                            <div className="flex flex-col justify-center text-start">
                                <h1 className="text-sm font-semibold text-white md:text-lg lg:text-xl">
                                    {orgName}
                                </h1>
                                <hr className="my-1 h-px border-0 bg-gray-200" />
                                <h1 className="text-sm font-semibold text-white md:text-base lg:text-lg">
                                    {appName} - Library Management System
                                </h1>
                            </div>
                        </Link>
                    )}

                    {showNavigation && (
                        <>
                            <button
                                onClick={() => setIsMenuOpen(!isMenuOpen)}
                                type="button"
                                className="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/20 p-2 text-sm text-white transition-colors hover:bg-white/10 focus:ring-2 focus:ring-white/50 focus:outline-none lg:hidden"
                                aria-controls="navbar-dropdown"
                                aria-expanded={isMenuOpen}
                            >
                                <span className="sr-only">
                                    {isMenuOpen
                                        ? 'Close main menu'
                                        : 'Open main menu'}
                                </span>
                                {isMenuOpen ? (
                                    <svg
                                        className="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                ) : (
                                    <svg
                                        className="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                    </svg>
                                )}
                            </button>

                            <div
                                className={`${isMenuOpen ? 'max-h-[400px] pb-4 opacity-100' : 'max-h-0 opacity-0 lg:max-h-fit lg:opacity-100'} w-full overflow-hidden transition-all duration-300 ease-in-out lg:block lg:w-auto`}
                                id="navbar-dropdown"
                            >
                                <ul className="mt-4 flex flex-col gap-2 rounded-xl border border-white/20 bg-primary-600/50 p-4 font-medium shadow-lg backdrop-blur-md lg:mt-0 lg:flex-row lg:space-x-8 lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none rtl:space-x-reverse">
                                    <li>
                                        <a
                                            href="#about"
                                            onClick={(e) =>
                                                handleScroll(e, 'about')
                                            }
                                            className="block rounded-lg px-4 py-3 text-white transition-all hover:bg-tertiary-600 lg:px-3 lg:py-2"
                                        >
                                            About
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="#services"
                                            onClick={(e) =>
                                                handleScroll(e, 'services')
                                            }
                                            className="block rounded-lg px-4 py-3 text-white transition-all hover:bg-tertiary-600 lg:px-3 lg:py-2"
                                        >
                                            Services
                                        </a>
                                    </li>
                                    <li>
                                        <Link
                                            href={login()}
                                            className="block w-full rounded-lg px-4 py-3 text-left text-white transition-all hover:bg-tertiary-600 lg:px-3 lg:py-2"
                                        >
                                            Login
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </>
                    )}
                </div>
            </nav>
        </header>
    );
}
