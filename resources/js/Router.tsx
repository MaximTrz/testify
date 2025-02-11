import * as React from "react";
import Description from "./pages/description";
import Question from "./pages/question";
import { BrowserRouter, Routes, Route } from "react-router-dom";

function Router() {
    return (
        <BrowserRouter
            future={{
                v7_startTransition: true,
                v7_relativeSplatPath: true,
            }}
        >
            <Routes>
                <Route path="/tests/:id" element={<Description />} />
                <Route path="/tests/:id/questions" element={<Question />} />
            </Routes>
        </BrowserRouter>
    );
}

export default Router;
