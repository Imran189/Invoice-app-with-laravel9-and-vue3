import { createRouter, createWebHistory } from "vue-router";
import InvoiceIndex from "../components/invoices/index.vue";
import NewInvoice from "../components/invoices/new.vue";
import notFound from "../components/notFound.vue";

const routes = [
    {
        path: "/",
        name: InvoiceIndex,
        component: InvoiceIndex,
    },
    {
        path: "/invoice/new",
        name: NewInvoice,
        component: NewInvoice,
    },
    {
        path: "/:pathMatch(.*)*",
        name: notFound,
        component: notFound,
    },
];
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
});

export default router;
