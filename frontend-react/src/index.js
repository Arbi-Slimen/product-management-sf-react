import React from 'react';
import ReactDOM from 'react-dom/client';
import reportWebVitals from './reportWebVitals';
import './assets/css/styles.css';
import {BrowserRouter, Routes, Route} from 'react-router-dom'
import Header from "./component/Header";
import Footer from "./component/Footer";
import ListProduct from "./component/ListProduct";
import DetailProduct from "./component/DetailProduct";
import Error from "./component/Error";

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <React.StrictMode>
        <BrowserRouter>
            <Header/>
            <Routes>
                <Route path="/" element={<ListProduct/>}/>
                <Route path="/show/:id" element={<DetailProduct/>}/>
                <Route path="/*" element={<Error/>}></Route>
            </Routes>
            <Footer/>
        </BrowserRouter>
    </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();