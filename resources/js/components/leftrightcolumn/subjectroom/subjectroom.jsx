import React from 'react';
import { MDBContainer, MDBSpinner, MDBAlert, MDBListGroup, MDBListGroupItem } from "mdbreact";
import uuid from 'react-uuid'

class SubjectRoom extends React.Component{
    render(){
        return(
            <>
                <div className="card" style={{height:'50px', marginTop:'5px', display:'flex', alignItems:'center', justifyContent:'center'}}>
                    <i>Subject Rooms</i>
                </div>

                <MDBListGroup className="scrolltext" style={{ width: "100%", marginTop:'5px', height:'80vh', overflowY:'scroll' }}>
                            {this.props.chatdata.subjectroom == "" ? 
                                <div className="container">
                                <MDBAlert color="primary" >
                                    You don't have subject rooms in your school. Start by adding subjects and teachers.
                                </MDBAlert>
                                </div>
                             : ""}
                    {!this.props.chatdata.isLoadingRoom ? this.props.chatdata.subjectroom.map(data => {
                        const {id, subject, firstname, middlename, lastname, profileimg, subjectname,userid}=data
                        return(
                            <MDBListGroupItem onClick={()=>this.props.chatdata.switchChat(subject, profileimg, subjectname, firstname, '', "group")} key={uuid()} style={{marginBottom:'2px', display:'flex', alignItems:'center'}}>
                                <img src={'storage/schimages/'+profileimg} className="rounded-circle" width="40px" height="40px"/>
                                <div style={{display:'flex', flexDirection:'column'}}>
                                <i style={{fontStyle:'normal', fontSize:'15px', marginLeft:'5px'}}>{subjectname}</i>
                                <i style={{fontStyle:'normal', fontSize:'10px', marginLeft:'5px'}}>{firstname} {middlename} {lastname}</i>
                                </div>
                            </MDBListGroupItem>
                        )
                    }) :
                    
                    <MDBSpinner/>

                    }
                    

                </MDBListGroup>
            </>
        )
    }
}

export default SubjectRoom;