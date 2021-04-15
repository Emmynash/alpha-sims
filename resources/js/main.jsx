import React, { Component } from 'react';
import NavbarPage from './components/header/header'
import MainBodyElearning from './components/mainbody/mainbody'

class Main extends React.Component{
    render(){
        return(
            <div style={{height:'100%'}}>
            {/* <NavbarPage/> */}
            <MainBodyElearning useridnew = {this.props.userid}/>
                
            </div>
        )
    }
}

export default Main;