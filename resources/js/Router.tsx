import * as React from "react";
import { useEffect } from "react";
import {
    BrowserRouter,
    Routes,
    Route,
    useLocation,
    useNavigate,
} from "react-router-dom";
import Description from "./pages/description";
import Question from "./pages/question";

function Router() {
    return (
        <BrowserRouter
            future={{
                v7_startTransition: true,
                v7_relativeSplatPath: true,
            }}
        >
            <NavigationBlocker />
            <Routes>
                <Route path="/tests/:id" element={<Description />} />
                <Route path="/tests/:id/questions" element={<Question />} />
            </Routes>
        </BrowserRouter>
    );
}

const NavigationBlocker = () => {
    const navigate = useNavigate();
    const location = useLocation();

    useEffect(() => {
        const disableNavigation = () => {
            window.history.replaceState(null, "", window.location.href);
        };

        const handlePopState = () => {
            disableNavigation();
            navigate(location.pathname, { replace: true });
        };

        disableNavigation();

        window.addEventListener("popstate", handlePopState);

        return () => {
            window.removeEventListener("popstate", handlePopState);
        };
    }, [navigate, location]);

    return null;
};

export default Router;
