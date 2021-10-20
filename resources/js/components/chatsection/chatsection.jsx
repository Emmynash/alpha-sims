import React from 'react';
import uuid from 'react-uuid'
import Background from '../../../../public/images/chatback.png';
import { MDBSpinner } from "mdbreact";

class ChatSection extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            message:"",
        }
        this.handleSubmit = this.handleSubmit.bind(this)
        this.handleChange = this.handleChange.bind(this)
        // this.fetchAllChatsforSelectedUsers = this.fetchAllChatsforSelectedUsers.bind(this)
    }

        handleSubmit = async event => {
            event.preventDefault();
    
            if (this.state.message == "") {
                return
            }
    
            axios({
                method: 'post',
                url: '/api/sendchat',
                data: {
                  message: this.state.message,
                  chatid: this.props.chatdata.chatid,
                  senderid:this.props.chatdata.useridnew,
                  chattypes:this.props.chatdata.chattypes
                }
              })
              .then(response => {
                return response;
                }).then(json => {
                  console.log(json.data)
                  if (json.data.data) {
                    
                  } else {
                      alert(`Our System Failed To Register Your Account!`);
                  }
             })
             .catch(error => {
                 console.log(error);
             });
    
             this.setState({
                message: ''
              });
    
    
        }

        // fetchAllChatsforSelectedUsers(){
        //     axios.get('fetchchats/'+ this.props.chatdata.useridnew +'/'+ this.props.chatdata.chatid +'/'+ this.props.chatdata.chattypes)
        //     .then(result => this.setState({
        //         chatarray: result.data.data,
        //         isLoading: false
        //     })
        //     )
        //     .catch(error => 
        //         console.log(error)
        //     );
        // }




        handleChange = event => {
            const {value, name} = event.target;
            console.log(event.target.value)
            this.setState({[name]: value})
        }

        componentDidMount(){
            // console.log(this.props.chatdata.chatid);
        }
    
    render(){
        return(
            <>
            <div className="bg-success" style={{height:"80vh", backgroundImage: "url(" + Background + ")"}}>
                <div className="scrolltext" style={{height:"80vh", margin:'5px 5px 5px 5px', overflowY:'scroll', overflowWrap:'anywhere', overflowX:'hidden' }}>

                    {!this.props.chatdata.isLoadingRoom ?  this.props.chatdata.chatarray.map(data=>{
                        const {senderid, message,chattype, firstname, chattime, chatdate} = data
                        return(

                            chattype == "single" ? 

                            this.props.chatdata.useridnew == senderid ? 
                            
                            <div key={uuid()} className="clearfix" style={{width:'100%', marginBottom:'5px'}}>
                                
                                <div className="float-right" style={{display:'flex', justifyContents:'center', flexDirection:'column', backgroundColor:'#ddd', borderRadius:'10px', maxWidth:'80%'}}>
                                    <i style={{fontSize:'9px', margin:'5px 0 0 5px'}}>{chatdate}</i>
                                    <div style={{overflowWrap:'anywhere', margin:'5px'}}><i style={{fontStyle:'normal', fontSize:'12px'}}>{ message }</i> <i style={{fontSize:'7px', fontStyle:'normal', margin:'0 10px 0 0'}}>{chattime}</i></div>
                                </div>
                                <br/>
                                {/* <small className="badge badge-success float-right" style={{marginLeft:'5px'}}>You</small> */}
                            </div>
                            
                            : 
                            
                            
                            <div key={uuid()} className="clearfix" style={{width:'100%', marginBottom:'5px'}}>
                            <div className="float-left" style={{display:'flex', justifyContents:'center', flexDirection:'column', backgroundColor:'#ddd', borderRadius:'10px', maxWidth:'80%'}}>
                                    <i style={{fontSize:'9px', margin:'5px 0 0 5px'}}>{chatdate}</i>
                                    {/* <img src={'storage/schimages/profile.png'} className="rounded-circle" width="50px" height="50px"/> */}
                                    <div style={{overflowWrap:'anywhere', margin:'5px'}}><i style={{fontStyle:'normal', fontSize:'12px'}}>{ message }</i> <i style={{fontSize:'7px', fontStyle:'normal', margin:'0 10px 0 0'}}>{chattime}</i></div>
                                </div>
                                <br/>
                                {/* <small className="badge badge-danger float-left" style={{marginLeft:'5px'}}>You</small> */}
                            </div>

                            :

                            <div key={uuid()} className="clearfix" style={{width:'100%', marginBottom:'5px'}}>
                            <div className="float-right" style={{display:'flex', justifyContents:'center', flexDirection:'column', backgroundColor:'#ddd', borderRadius:'10px', maxWidth:'80%'}}>
                                    <i style={{fontSize:'9px', margin:'5px 0 0 5px'}}>{chatdate}</i>
                                    <i style={{fontSize:'9px', margin:'2px 0 0 5px'}}>{firstname}</i>
                                    {/* <img src={'storage/schimages/profile.png'} className="rounded-circle" width="50px" height="50px"/> */}
                                    <div style={{overflowWrap:'anywhere', margin:'5px'}}><i style={{fontStyle:'normal', fontSize:'12px'}}>{ message }</i> <i style={{flex:'1'}}></i><i style={{fontSize:'7px', fontStyle:'normal', margin:'0 10px 0 0'}}>{chattime}</i></div>
                                </div>
                                <br/>
                                {/* <small className="badge badge-danger float-left" style={{marginLeft:'5px'}}>{firstname}</small> */}
                            </div>

                        )

                    })
                    
                    
                    : 
                    
                    <MDBSpinner/>
                    }
          
                        

                    
                </div>
            </div>
                <form onSubmit={this.handleSubmit} style={{display:'flex', flexDirection:'row', margin:'5px 0 10px 0', alignItems:'center'}}>
                    <input onChange={this.handleChange} value={this.state.message} name="message" text="text" style={{outline: 'none'}} className="form-control" placeholder="type message here..."/>
                    <button onClick={this.handleSubmit} className="btn btn-info btn-sm">send</button>
                </form>
            </>
        )
    }
}

export default ChatSection;