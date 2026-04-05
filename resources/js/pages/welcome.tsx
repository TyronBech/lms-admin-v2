import { Head, Link } from '@inertiajs/react';
import React, { useState } from 'react';
import Footer from '@/components/Footer';

// Assuming we pass settings from backend, otherwise we could provide fallback
interface Settings {
    org_name?: string;
    org_logo_base64?: string;
    theme_colors?: {
        primary?: string;
        secondary?: string;
        tertiary?: string;
    };
}

interface WelcomeProps {
    settings?: Settings;
}

export default function Welcome({ settings }: WelcomeProps) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    const orgName = settings?.org_name || 'School Name';
    const logoSrc = settings?.org_logo_base64 || '/img/default-logo.png'; // fallback to a default image

    const handleScroll = (
        e: React.MouseEvent<HTMLAnchorElement>,
        targetId: string,
    ) => {
        e.preventDefault();
        const element = document.getElementById(targetId);

        if (element) {
            const delay = isMenuOpen ? 50 : 0;
            setIsMenuOpen(false); // Close the mobile menu on click

            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth' });
            }, delay);
        }
    };

    return (
        <>
            <Head title="Welcome" />

            <header className="sticky top-0 z-50">
                <nav className="border-gray-200 bg-primary-500">
                    <div className="mx-auto flex max-w-7xl flex-wrap items-center justify-between p-4">
                        {/* Logo and Titles */}
                        <a
                            href="#"
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
                                <h1 className="text-sm font-semibold text-white md:text-lg lg:text-xl">
                                    Library Management System
                                </h1>
                            </div>
                        </a>

                        {/* Mobile Menu Button */}
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

                        {/* Navbar Links */}
                        <div
                            className={`${isMenuOpen ? 'max-h-100 pb-4 opacity-100' : 'max-h-0 opacity-0 lg:max-h-fit lg:opacity-100'} w-full overflow-hidden transition-all duration-300 ease-in-out lg:block lg:w-auto`}
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
                                        href="/login"
                                        className="block w-full rounded-lg px-4 py-3 text-left text-white transition-all hover:bg-tertiary-600 lg:px-3 lg:py-2"
                                    >
                                        Login
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <main className="relative container mx-auto flex-col px-2">
                {/* Main Welcome Hero (main-welcome.blade.php equivalent) */}
                <div
                    id="main-welcome"
                    className="mx-auto pt-16 pb-4 flex max-w-7xl items-center justify-center px-4 sm:px-6 md:my-24 md:px-10 lg:my-48"
                >
                    <div className="flex flex-col items-center justify-between gap-8 md:flex-row md:gap-10 lg:gap-12">
                        <img
                            className="order-1 h-32 w-32 rounded-full object-cover transition-transform duration-300 ease-in-out hover:scale-105 sm:h-40 sm:w-40 md:h-56 md:w-56 lg:h-72 lg:w-72"
                            src={logoSrc}
                            alt={`${orgName} Logo`}
                        />
                        <div className="order-2 flex flex-col items-center text-center">
                            <h1 className="text-xl font-semibold text-black sm:text-2xl md:text-2xl lg:text-3xl dark:text-white">
                                {orgName}
                            </h1>
                            <hr className="my-2 h-px w-full max-w-xs border-0 bg-gray-500 dark:bg-white" />
                            <h2 className="text-lg font-semibold text-black sm:text-xl md:text-xl lg:text-2xl dark:text-white">
                                Library Management System
                            </h2>
                            <h4 className="my-4 text-base font-semibold text-black sm:text-lg md:text-base lg:text-lg dark:text-white">
                                Developed by
                            </h4>
                            <h3 className="text-2xl font-extrabold text-black sm:text-2xl md:text-2xl lg:text-3xl dark:text-white">
                                OwlQuery Group
                            </h3>
                        </div>
                        <div className="order-3">
                            <img
                                className="block h-auto w-40 transition-transform duration-300 ease-in-out hover:scale-105 sm:w-48 md:w-56 lg:w-60 dark:hidden"
                                src="/img/OwlQuery.png"
                                alt="OwlQuery"
                            />
                            <img
                                className="hidden h-auto w-40 transition-transform duration-300 ease-in-out hover:scale-105 sm:w-48 md:w-56 lg:w-60 dark:block"
                                src="/img/OwlQuery Dark.png"
                                alt="OwlQuery (Dark)"
                            />
                        </div>
                    </div>
                </div>

                {/* About Section */}
                <div
                    id="about"
                    className="flex lg:min-h-screen items-center justify-center py-8 sm:py-4"
                >
                    <div className="mx-auto flex max-w-7xl flex-col items-center gap-8 px-4 sm:px-6 md:flex-row md:gap-12 lg:gap-16 lg:px-8">
                        <div className="shrink-0 md:w-1/3">
                            <img
                                className="mx-auto h-48 w-48 object-contain sm:h-56 sm:w-56 md:h-auto md:w-full"
                                src="/gif/OwlQuery.gif"
                                alt="OwlQuery Animated Logo"
                            />
                        </div>
                        <div className="text-center md:text-left">
                            <h2 className="text-3xl font-extrabold tracking-tight text-gray-900 md:text-4xl dark:text-white">
                                About the Library Management System
                            </h2>
                            <p className="mt-6 text-lg text-gray-600 md:text-xl dark:text-gray-300">
                                A streamlined solution for managing books,
                                users, and resources. It offers efficient
                                cataloging, borrowing, and returning processes,
                                enhancing user experience and library
                                operations.
                            </p>
                            <p className="mt-4 text-lg text-gray-600 md:text-xl dark:text-gray-300">
                                With features like inventory management, user
                                accounts, and reporting, it simplifies library
                                administration and improves accessibility to
                                information.
                            </p>
                        </div>
                    </div>
                </div>

                {/* Services Section */}
                <div
                    id="services"
                    className="flex min-h-screen flex-col justify-center py-5 sm:py-4"
                >
                    <h2 className="mb-12 text-center text-3xl font-extrabold tracking-tight text-gray-900 md:text-4xl dark:text-white">
                        Our Services
                    </h2>
                    <div className="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 sm:grid-cols-2 sm:px-6 md:grid-cols-3 lg:px-8">
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                Book Management
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Efficiently catalog and manage your library's
                                book collection with easy-to-use tools for
                                adding, updating, and organizing books.
                            </p>
                        </div>
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                User Accounts
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Create and manage user accounts for library
                                members, allowing them to borrow books and
                                access library resources seamlessly.
                            </p>
                        </div>
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                Reporting and Analytics
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Gain valuable insights into library usage and
                                performance with detailed reports and analytics
                                tools.
                            </p>
                        </div>
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                Inventory Management
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Keep track of inventory levels, manage stock,
                                and ensure availability of books for users.
                            </p>
                        </div>
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                Borrowing and Returning
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Simplify the borrowing and returning process
                                with an intuitive interface for both users and
                                library staff.
                            </p>
                        </div>
                        <div className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-103 hover:shadow-lg dark:bg-gray-800">
                            <h3 className="mb-4 text-xl font-semibold text-gray-900 dark:text-white">
                                Security and Authentication
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Implement robust security measures to protect
                                library data and user accounts from unauthorized
                                access.
                            </p>
                        </div>
                    </div>
                </div>
            </main>

            <Footer />
        </>
    );
}
