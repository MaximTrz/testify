import * as React from "react";
import ReactDOM from "react-dom/client";

const rootElement = document.getElementById("root");
let root;


if (rootElement) {

    root = ReactDOM.createRoot(rootElement);


    const App = () => {
        return <div>
            Привет!
        </div>
    }

    root.render(
        <App />
    );

}