import React from 'react';
import ReactDOM from 'react-dom';
import { render } from 'react-dom'
import FeesCollection from './feescollection';
import { transitions, positions, Provider as AlertProvider } from 'react-alert'
import AlertTemplate from 'react-alert-template-basic'
import './Style.css';

const options = {
    // you can also just use 'bottom center'
    position: positions.BOTTOM_CENTER,
    timeout: 5000,
    offset: '30px',
    // you can also just use 'scale'
    transition: transitions.SCALE
  }
 
const Root = () => (
    <AlertProvider template={AlertTemplate} {...options}>
      <FeesCollection />
    </AlertProvider>
  )
  
  ReactDOM.render(<Root />, document.getElementById('feesrootroot'))