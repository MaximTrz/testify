import * as React from "react";

import { BrowserRouter, Routes, Route } from "react-router-dom";

import App from "./app";

function Router() {
    return (
        <BrowserRouter
            future={{
                v7_startTransition: true,
                v7_relativeSplatPath: true,
            }}
        >
            <Routes>
                <Route path="/tests/:testId/questions" element={<App />} />
            </Routes>
        </BrowserRouter>
    );
}

export default Router;
