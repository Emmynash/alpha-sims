import React from "react";
import { MDBContainer, MDBRow, MDBCol, MDBListGroup, MDBListGroupItem, MDBIcon, MDBSpinner, MDBAlert } from "mdbreact";
import './mainbody.style.scss';
import StudentColumn from '../leftrightcolumn/leftcolumn/studentcolumn'
import SubjectRoom from '../leftrightcolumn/subjectroom/subjectroom'
import ChatSection from '../chatsection/chatsection'
import uuid from 'react-uuid'

class MainBodyElearning extends React.Component {
  constructor(props){
    super(props);
    this.state={
      toggleStudent:false,
      toggleTeachers:false,
      studentdata:'',
      subjectroom:'',
      isLoading:true,
      isLoadingRoom:true,
      chatid: "",
      profileimg:"",
      first:"",
      middle:"",
      last:"",
      chattypes:"",
      chatarray:[],
      isLoadingRoomf:true
    }
    this.toggleStudentColumn = this.toggleStudentColumn.bind(this)
    this.toggleTeachersColumn = this.toggleTeachersColumn.bind(this)
    this.fetchStudentsbyvlass = this.fetchStudentsbyvlass.bind(this)
    this.fetchsubjectsRoom = this.fetchsubjectsRoom.bind(this)
    this.switchChat = this.switchChat.bind(this)
    this.fetchAllChatsforSelectedUsers = this.fetchAllChatsforSelectedUsers.bind(this)
  }

  toggleStudentColumn(){
    this.setState({
      toggleStudent:!this.state.toggleStudent
    })
  }

  fetchStudentsbyvlass(){
    axios.get('/api/fetchallstudents/'+this.props.useridnew)
    .then(result => this.setState({
        studentdata: result.data.data,
        isLoading: false
    })
    )
    .catch(error => 
        console.log(error)
    );
  }

  toggleTeachersColumn(){
    this.setState({
      toggleTeachers:!this.state.toggleTeachers
    })
  }

  fetchsubjectsRoom(){
    axios.get('/api/fetchallsubjectsroom/'+this.props.useridnew)
    .then(result => this.setState({
        subjectroom: result.data.data,
        isLoadingRoom: false
    })
    )
    .catch(error => 
        console.log(error)
    );
  }

  switchChat(chatidmain, profilepix, firstname, middlename, lastname, chattype){
    this.setState({
        chatid: chatidmain,
        profileimg:profilepix,
        first:firstname,
        middle:middlename,
        last:lastname,
        chattypes:chattype,
        toggleStudent:false,
        toggleTeachers:false
    })
    // console.log(chatidmain)
    this.fetchAllChatsforSelectedUsers(chatidmain, chattype)
}

  fetchAllChatsforSelectedUsers(chatidmain, chattype){
    axios.get('api/fetchchats/'+ this.props.useridnew +'/'+ chatidmain +'/'+ chattype)
    .then(result => this.setState({
      chatarray: result.data.data,
      isLoadingRoomf:false
    })
    )
    .catch(error => 
        console.log(error)
    );
  }

  componentDidMount(){
    this.fetchStudentsbyvlass()
    this.fetchsubjectsRoom()
    // console.log(this.props.useridnew)
  }
  render(){
    return (
      <MDBContainer fluid style={{height:'100vh'}}>
        <MDBRow style={{height:'100%'}}>
          <MDBCol id="sidelistdesktop" md="3" className="default-color-dark">
            <StudentColumn chatdata = {{studentdata:this.state.studentdata, isLoading:this.state.isLoading, chatid:this.state.chatid, switchChat:this.switchChat, useridnew:this.props.useridnew}}/>
          </MDBCol>
            <MDBCol md="6" className="warning-color-dark">
            
                <div className="card" style={{height:'50px', marginTop:'5px', display:'flex', flexDirection:'row'}}>
                  {this.state.chatid == "" ? "" :<button className="btn btn-sm" onClick={()=>this.fetchAllChatsforSelectedUsers(this.state.chatid, this.state.chattypes)}><MDBIcon icon="redo-alt" /></button> }
                  <button id="sidemenubtn" className="btn btn-sm" onClick={this.toggleStudentColumn}><MDBIcon icon="user-graduate" /></button>
                  <button id="sidemenubtn" className="btn btn-sm" onClick={this.toggleTeachersColumn}><MDBIcon icon="users" /></button>
                  <div style={{flex:'1'}}></div>
                  <div style={{display:'flex', alignItems:'center', marginRight:'10px'}}>
                    <i id="namedisplaydesktop" style={{marginRight:'5px', fontSize:'12px', fontStyle:'normal'}}>{this.state.first} {this.state.middle} {this.state.last}</i>
                    
                    {this.state.chatid == "" ? "" : <img src={'storage/schimages/'+this.state.profileimg} className="rounded-circle" width="40px" height="40px"/>}
                  </div>
                </div>
    {/* ............................................ */}
               
                
                  <div>
                    <div id="sidemenubtn" className="card" style={{height:'20px', marginTop:'5px', display:'flex', alignItems:'center'}}>
                      <i style={{marginRight:'5px', fontSize:'12px', fontStyle:'normal'}}>{this.state.first} {this.state.middle} {this.state.last}</i>
                    </div>
                    
                    { this.state.toggleStudent ? 
                        <div className="card" style={{height:'300px', width:'80%', position:'absolute', left:'0', top:'0', borderRadius:'0px'}}>
                          <div className="" style={{display:'flex', alignItems:'center'}}>
                            <i style={{marginLeft:'10px', fontStyle:'normal'}}>Student List</i>
                              <div style={{flex:'1'}}></div>
                            <button className="btn btn-sm" onClick={this.toggleStudentColumn}><MDBIcon icon="times" /></button>
                          </div>
                          <MDBListGroup className="scrolltext" style={{ width: "100%", height:'250px', overflowY:'scroll' }}>
                            {this.state.studentdata == "" ? 
                            
                            <div className="container">
                              <MDBAlert color="primary" >
                                You don't have students in your school. Start by adding students.
                              </MDBAlert>
                            </div>
                             : ""}
                            {!this.state.isLoading ? this.state.studentdata.map(data => {
                              const {id, firstname, middlename, lastname, profileimg, userid}=data
                              return(
                                <MDBListGroupItem onClick={()=>this.switchChat(userid, profileimg, firstname, middlename, lastname, "single")} key={uuid()} style={{display:'flex', flexDirection:'row', alignItems:'center'}}>
                                  <img src={'storage/schimages/'+ profileimg} className="rounded-circle" width="40px" height="40px"/>
                                  <i style={{marginLeft:'5px', fontSize:'12px', fontStyle:'normal'}}>{firstname} {middlename} {lastname}</i>
                                </MDBListGroupItem>
                              )
                            }) : 
                            
                            <MDBSpinner/>
                            
                            }
                            
                            

                          </MDBListGroup>
                        </div>
                    :
                    
                        ""
                    }

                    { this.state.toggleTeachers ? 
                        <div className="card" style={{height:'300px', width:'80%', position:'absolute', left:'0', top:'0', borderRadius:'0px'}}>
                          <div className="clearfix">
                            <button className="btn btn-sm float-right" onClick={this.toggleTeachersColumn}><MDBIcon icon="times" /></button>
                          </div>
                          <MDBListGroup className="scrolltext" style={{ width: "100%", height:'250px', overflowY:'scroll' }}>
                          {this.state.subjectroom == "" ? 
                            
                            <div className="container">
                              <MDBAlert color="primary" >
                                You don't have subject rooms in your school. Start by adding subjects and teachers.
                              </MDBAlert>
                            </div>
                             : ""}
                            {!this.state.isLoadingRoom ? this.state.subjectroom.map(data => {
                              const {id, subject, firstname, middlename, lastname, profileimg, subjectname, userid}=data
                              
                                return(
                                  <MDBListGroupItem key={uuid()} onClick={()=>this.switchChat(subject, profileimg, subjectname, firstname, '', "group")} style={{display:'flex', flexDirection:'row', alignItems:'center'}}>
                                    <img src={'storage/schimages/'+profileimg} className="rounded-circle" width="40px" height="40px"/>
                                    <div style={{display:'flex', flexDirection:'column'}}>
                                    <i style={{fontStyle:'normal', fontSize:'15px', marginLeft:'5px'}}>{subjectname}</i>
                                    <i style={{fontStyle:'normal', fontSize:'10px', marginLeft:'5px'}}>{firstname} {middlename} {lastname}</i>
                                    </div>
                                  </MDBListGroupItem>
                                )
                              
                              }) 
                            
                              : 
                              <MDBSpinner />
                              }

                          </MDBListGroup>
                        </div>
                    :
                    
                    ""
                    }

                    {this.state.chatid ?
                    
                      <ChatSection chatdata={{chatid:this.state.chatid, useridnew:this.props.useridnew, chattypes:this.state.chattypes, chatarray:this.state.chatarray, isLoadingRoom:this.state.isLoadingRoom}}/>
                     : 
                     
                     <div className="default-color" style={{height:'300px', display:'flex', alignItems:'center', justifyContent:'center', flexDirection:'column'}}>
                        <div className="container-fluid">

                        </div>
                      <i className="fas fa-globe" style={{fontSize:'70px'}}></i>
                      <i style={{fontSize:'17px', fontWeight:'bold'}}>eLearning Platform. Learn from a distance</i>
                    </div>
                     
                     }
                    
                    
                </div>

            </MDBCol>
          <MDBCol id="sidelistdesktop" md="3" className="default-color-dark">
            <SubjectRoom chatdata = {{subjectroom:this.state.subjectroom, chatid:this.state.chatid, switchChat:this.switchChat, useridnew:this.props.useridnew, isLoadingRoom:this.state.isLoadingRoom}}/>
          </MDBCol>
        </MDBRow>
      </MDBContainer>
    );
  }
}

export default MainBodyElearning;