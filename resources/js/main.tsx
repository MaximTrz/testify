import React from "react";
import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import { store } from "./store";
import Router from "./Router";

const rootElement = document.getElementById("test-app");

document.addEventListener("DOMContentLoaded", () => {
    const burger = document.querySelector(".header__burger");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.querySelector(".sidebar-overlay");

    const body = document.body;

    if (burger && sidebar) {
        const closeMenu = () => {
            burger.classList.remove("is-active");
            sidebar.classList.remove("is-open");
            overlay.classList.remove("active");
            body.style.overflow = "";
        };

        burger.addEventListener("click", () => {
            burger.classList.toggle("is-active");
            sidebar.classList.toggle("is-open");
            overlay.classList.toggle("active");
            body.style.overflow = sidebar.classList.contains("is-open")
                ? "hidden"
                : "";
        });

        document.addEventListener("click", (event) => {
            if (
                sidebar.classList.contains("is-open") &&
                !sidebar.contains(event.target) &&
                !burger.contains(event.target)
            ) {
                closeMenu();
            }
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });
    } else {
        console.error("Burger or sidebar elements are not found in the DOM.");
    }
});

if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <Provider store={store}>
            <Router />
        </Provider>,
    );
}
