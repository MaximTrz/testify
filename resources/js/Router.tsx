import * as React from "react";
import { useEffect } from "react";
import {
    BrowserRouter,
    Routes,
    Route,
    useLocation,
    useNavigate,
} from "react-router-dom";
import Question from "./pages/question";



function Router() {
    return (
        <BrowserRouter
            future={{
                v7_startTransition: true,
                v7_relativeSplatPath: true,
            }}
        >
            <Routes>
                <Route path="/tests/:id/questions" element={<Question/>} />
            </Routes>
        </BrowserRouter>
    );
}



export default Router;
