import React from 'react';
import ReactDOM from 'react-dom';
import Main from './main';
import {BrowserRouter} from 'react-router-dom'
import 'bootstrap/dist/css/bootstrap.css';
// import './index.style.scss';
import "@fortawesome/fontawesome-free/css/all.min.css";
import "bootstrap-css-only/css/bootstrap.min.css";
import "mdbreact/dist/css/mdb.css";


ReactDOM.render(
    <BrowserRouter>
        <Main userid={user}/>
    </BrowserRouter>
, 
document.getElementById('root'));