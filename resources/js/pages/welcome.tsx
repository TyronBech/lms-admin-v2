import { Head, usePage } from '@inertiajs/react';
import Footer from '@/components/Footer';
import PublicHeader from '@/components/public-header';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Settings {
    org_name?: string;
    org_logo_base64?: string;
    theme_colors?: {
        primary?: string;
        secondary?: string;
        tertiary?: string;
    };
}

interface SharedPageProps {
    [key: string]: unknown;
    name?: string;
    settings?: Settings;
}

export default function Welcome() {
    const { name, settings } = usePage<SharedPageProps>().props;
    const orgName = settings?.org_name || 'School Name';
    const appName = name
        ? `${name} - Library Management System`
        : 'Library Management System';
    const logoSrc = settings?.org_logo_base64 || '/img/default-logo.png'; // fallback to a default image
    const services = [
        {
            title: 'Book Management',
            description:
                "Efficiently catalog and manage your library's book collection with easy-to-use tools for adding, updating, and organizing books.",
        },
        {
            title: 'User Accounts',
            description:
                'Create and manage user accounts for library members, allowing them to borrow books and access library resources seamlessly.',
        },
        {
            title: 'Reporting and Analytics',
            description:
                'Gain valuable insights into library usage and performance with detailed reports and analytics tools.',
        },
        {
            title: 'Inventory Management',
            description:
                'Keep track of inventory levels, manage stock, and ensure availability of books for users.',
        },
        {
            title: 'Borrowing and Returning',
            description:
                'Simplify the borrowing and returning process with an intuitive interface for both users and library staff.',
        },
        {
            title: 'Security and Authentication',
            description:
                'Implement robust security measures to protect library data and user accounts from unauthorized access.',
        },
    ];

    return (
        <>
            <Head title="Welcome" />

            <PublicHeader />

            <main className="relative container mx-auto flex-col px-2">
                {/* Main Welcome Hero (main-welcome.blade.php equivalent) */}
                <div
                    id="main-welcome"
                    className="mx-auto flex max-w-7xl items-center justify-center px-4 pt-16 pb-4 sm:px-6 md:my-24 md:px-10 lg:my-48"
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
                                {appName}
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
                    className="flex items-center justify-center py-8 sm:py-4 lg:min-h-screen"
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
                        {services.map((service) => (
                            <Card
                                key={service.title}
                                className="rounded-lg bg-white p-6 shadow transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-lg dark:bg-gray-800"
                            >
                                <CardHeader className="mb-4 p-0">
                                    <CardTitle className="text-xl text-gray-900 dark:text-white">
                                        {service.title}
                                    </CardTitle>
                                </CardHeader>
                                <CardContent className="p-0">
                                    <p className="text-gray-600 dark:text-gray-300">
                                        {service.description}
                                    </p>
                                </CardContent>
                            </Card>
                        ))}
                    </div>
                </div>
            </main>

            <Footer />
        </>
    );
}
