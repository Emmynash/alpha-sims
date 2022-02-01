import React from 'react';
import { MDBContainer, MDBAlert, MDBSpinner, MDBListGroup, MDBListGroupItem } from "mdbreact";
import axios from 'axios';
import uuid from 'react-uuid'

class StudentColumn extends React.Component{
    constructor(props){
        super(props)
        this.state = {
       
        }
        
    }

        // fetchStudentsbyvlass(){
        //     axios.get('/api/fetchallstudents/10')
        //     .then(result => this.setState({
        //         studentdata: result.data.data,
        //         isLoading: false
        //     })
        //     )
        //     .catch(error => 
        //         console.log(error)
        //     );
        // }

        componentDidMount(){
            console.log(this.props.chatdata.isLoading)
        }
    
    render(){
        return(
            <>
                <div className="card" style={{height:'50px', marginTop:'5px', display:'flex', alignItems:'center', justifyContent:'center'}}>
                    <i>Student List</i>
                </div>

                <MDBListGroup className="scrolltext" style={{ width: "100%", marginTop:'5px', height:'80vh', overflowY:'scroll' }}>
                    {this.props.chatdata.studentdata == "" ?       
                        <div className="container">
                            <MDBAlert color="primary" >
                            You don't have students in your school. Start by adding students.
                            </MDBAlert>
                        </div>
                    : ""}
                    {!this.props.chatdata.isLoading ? this.props.chatdata.studentdata.map(data => {
                        const {id, firstname, middlename, lastname, profileimg, userid}=data
                        return(
                            this.props.chatdata.useridnew != userid ? 

                            <MDBListGroupItem onClick={()=>this.props.chatdata.switchChat(userid, profileimg, firstname, middlename, lastname, "single")} key={uuid()} style={{marginBottom:'2px', display:'flex', alignItems:'center'}}>
                                <img src={'/storage/schimages/'+profileimg} className="rounded-circle" width="40px" height="40px"/>
                                <i style={{fontStyle:'normal', fontSize:'15px', marginLeft:'5px'}}>{firstname} {middlename} {lastname}</i>
                            </MDBListGroupItem>
                            : 
                            
                            ''

                        )
                    }) : <MDBSpinner/>} 
                    

                </MDBListGroup>
            </>
        )
    }
}

export default StudentColumn;