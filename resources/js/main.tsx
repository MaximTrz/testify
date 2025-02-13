// main.tsx (Новый файл - точка входа)
import React from "react";
import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import { store } from "./store";
import Router from "./Router";

const rootElement = document.getElementById("test-app");

if (rootElement) {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
        <Provider store={store}>
            <Router />
        </Provider>,
    );
}
