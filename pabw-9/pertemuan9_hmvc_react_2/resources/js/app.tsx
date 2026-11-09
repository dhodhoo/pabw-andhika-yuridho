import { createInertiaApp } from "@inertiajs/react";
import type { ComponentType } from "react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Toaster } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { initializeTheme } from "@/hooks/use-appearance";
import AppLayout from "@/layouts/app-layout";
import AuthLayout from "@/layouts/auth-layout";
import SettingsLayout from "@/layouts/settings/layout";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob([
            "./pages/**/*.tsx",
            "../../Modules/*/resources/js/pages/**/*.tsx",
        ]) as Record<string, () => Promise<ComponentType<any>>>;

        // Halaman modul ditulis dengan format NamaModul::nama-halaman
        if (name.includes("::")) {
            const [module, page] = name.split("::");

            return resolvePageComponent<ComponentType<any>>(
                `../../Modules/${module}/resources/js/pages/${page}.tsx`,
                pages,
            );
        }

        return resolvePageComponent<ComponentType<any>>(
            `./pages/${name}.tsx`,
            pages,
        );
    },
    layout: (name) => {
        switch (true) {
            case name === "welcome":
                return null;
            // Halaman modul dan dashboard memakai <AppLayout> sendiri,
            // sehingga tidak perlu dibungkus lagi oleh layout bawaan starter kit.
            case name.includes("::"):
            case name === "dashboard":
                return null;
            case name.startsWith("auth/"):
                return AuthLayout;
            case name.startsWith("settings/"):
                return [AppLayout, SettingsLayout];
            default:
                return AppLayout;
        }
    },
    strictMode: true,
    withApp(app) {
        return (
            <TooltipProvider delayDuration={0}>
                {app}
                <Toaster />
            </TooltipProvider>
        );
    },
    progress: {
        color: "#4B5563",
    },
});

// This will set light / dark mode on load...
initializeTheme();
