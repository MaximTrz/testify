import * as React from "react";
import { useEffect } from "react";
import ReactDOM from "react-dom/client";
import { Provider, useDispatch, useSelector } from "react-redux";

import Router from "./Router";

import { store } from "./store";
import { RootState } from "./store";
import { AppDispatch } from "./store";

import { fetchTest } from "./store/reducer";

import { ERequestStatus } from "./types/ERequestStatus";

const rootElement = document.getElementById("test-app");

let root;

if (rootElement) {
    root = ReactDOM.createRoot(rootElement);

    const App = () => {
        const dispatch = useDispatch<AppDispatch>();

        const loaded = useSelector(
            (state: RootState) =>
                state.testSlice.testLoaded === ERequestStatus.SUCCEEDED,
        );

        const path = window.location.pathname;
        const testId = path.split("/tests/")[1];

        useEffect(() => {
            const data = fetchTest(Number(testId));
            dispatch(data);
        }, []);

        return (
            <div>
                <Router />
            </div>
        );
    };

    root.render(
        <Provider store={store}>
            <App />
        </Provider>,
    );
}
