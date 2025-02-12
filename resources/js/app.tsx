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

        const testLoaded = useSelector(
            (state: RootState) => state.testSlice.testLoaded,
        );

        const path = window.location.pathname;
        const testId = path.split("/tests/")[1];

        useEffect(() => {
            dispatch(fetchTest(Number(testId)));
        }, [dispatch, testId]);

        if (testLoaded !== ERequestStatus.SUCCEEDED) {
            return <div>Загрузка теста...</div>;
        }

        return <Router />;
    };

    root.render(
        <Provider store={store}>
            <App />
        </Provider>,
    );
}
