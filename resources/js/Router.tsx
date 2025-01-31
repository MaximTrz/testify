import * as React from "react";
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
        <Route path="/tests/:id" element={<div>Привет, Тест!</div>} />
      </Routes>
    </BrowserRouter>
  );
}

export default Router;