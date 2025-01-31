import * as React from "react";
import ReactDOM from "react-dom/client";

import Router from "./Router";

const rootElement = document.getElementById("test-app");

let root;

if (rootElement) {

    root = ReactDOM.createRoot(rootElement);

    const App = () => {

        const path = window.location.pathname; 
        const testId = path.split("/tests/")[1];

        return <div>
           <Router />
        </div>
    }

    root.render(
        <App />
    );

}
