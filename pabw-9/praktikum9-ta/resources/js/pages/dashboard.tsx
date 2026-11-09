import { Head, Link } from '@inertiajs/react';
import { BookOpen, ClipboardList, ShieldCheck, Users } from 'lucide-react';
import { useSharedProps } from '@/hooks/use-shared-props';
import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem } from '@/types';

type DashboardProps = {
    totalBuku: number;
    totalPeminjaman: number;
    totalUsers: number | null;
};

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Dashboard', href: '/dashboard' }];

export default function Dashboard({
    totalBuku,
    totalPeminjaman,
    totalUsers,
}: DashboardProps) {
    const { user, isAdmin } = useSharedProps();

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex flex-1 flex-col gap-4 p-4">
                <div className="rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                    <h1 className="text-xl font-semibold">
                        Selamat datang, {user.name}!
                    </h1>
                    <p className="mt-1 flex items-center gap-2 text-sm text-muted-foreground">
                        <ShieldCheck className="size-4" />
                        Anda login sebagai {isAdmin ? 'Admin' : 'User'}.
                    </p>
                </div>

                <div className="grid gap-4 md:grid-cols-2">
                    <Link
                        href="/buku"
                        className="rounded-xl border border-sidebar-border/70 p-6 transition hover:bg-accent dark:border-sidebar-border"
                    >
                        <BookOpen className="size-6 text-muted-foreground" />
                        <p className="mt-4 text-3xl font-bold">{totalBuku}</p>
                        <p className="text-sm text-muted-foreground">Jumlah buku</p>
                    </Link>

                    <Link
                        href="/peminjaman"
                        className="rounded-xl border border-sidebar-border/70 p-6 transition hover:bg-accent dark:border-sidebar-border"
                    >
                        <ClipboardList className="size-6 text-muted-foreground" />
                        <p className="mt-4 text-3xl font-bold">{totalPeminjaman}</p>
                        <p className="text-sm text-muted-foreground">
                            Jumlah peminjaman
                        </p>
                    </Link>

                    {isAdmin && totalUsers !== null && (
                        <Link
                            href="/admin/users"
                            className="rounded-xl border border-sidebar-border/70 p-6 transition hover:bg-accent dark:border-sidebar-border"
                        >
                            <Users className="size-6 text-muted-foreground" />
                            <p className="mt-4 text-3xl font-bold">{totalUsers}</p>
                            <p className="text-sm text-muted-foreground">
                                Jumlah user
                            </p>
                        </Link>
                    )}
                </div>
            </div>
        </AppLayout>
    );
}
