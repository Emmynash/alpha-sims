import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import FullCalendar from '@fullcalendar/react'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from "@fullcalendar/timegrid";
import { MDBContainer, MDBBtn, MDBModal, MDBModalBody, MDBModalHeader, MDBModalFooter } from 'mdbreact';


function Calender() {

    const [allevents, setAllEvents] = useState([])
    const [eventsmodel, seteventsmodel] = useState([])
    const [isLoading, setisLoading] = useState(false)
    const [usercanpost, setUsercanpost] = useState(false)
    const [modal, setmodal] = useState(false)
    const alert = useAlert();

    const [eventValue, setEventValue] = useState({
        pickedColor:'#722222',
        title:'',
        startdate:'',
        starttime:'',
        enddate:'',
        endtime:''
    })

    useEffect(() => {
        getAllEvents()
        return () => {
            // cleanup
        };
    }, []);

    function handleChange(evt) {
        const value = evt.target.value;
        setEventValue({
            ...eventValue,
          [evt.target.name]: value
        });
      }

    function postAnEvent() {
        setisLoading(true)
        axios.post('/gen/post_event', eventValue, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisLoading(false)
            if (response.data.response == "success") {
                setEventValue({
                    pickedColor:'#722222',
                    title:'',
                    startdate:'',
                    starttime:'',
                    enddate:'',
                    endtime:''
                })
                myalert('success', 'success')
                setAllEvents([])
                getAllEvents()
            }

        }).catch(e=>{
            setisLoading(false)
            console.log(e)

        })
    }

    function toggle(){
        setmodal(!modal);
    }

    function myalert(msg, type) {
        alert.show(msg, {
            timeout: 2000, // custom timeout just for this one alert
            type: type,
            onOpen: () => {
              console.log('hey')
            }, // callback that will be executed after this alert open
            onClose: () => {
              console.log('closed')
            } // callback that will be executed after this alert is removed
          })
    }

    function getAllEvents() {
        setisLoading(true)
        axios.get('get_all_posts')
        .then(response=>{
            console.log(response)
            // setAllEvents(response.data.getAllEvent)
            setisLoading(false)
            var eventsArray = response.data.getAllEvent

    
            for (let index = 0; index < eventsArray.length; index++) {
                const element = eventsArray[index];

                setAllEvents(allevents => [...allevents, {
                    title: element.title,
                    date: element.starttime != null ? element.startdate+"T"+element.starttime:element.startdate,
                    end: element.endtime != null ? element.enddate+"T"+element.enddate:element.enddate,
                    color: element.color
                  }]);
                
            }

            setUsercanpost(response.data.getPermission)

        }).catch(e=>{
            setisLoading(false)
            console.log(e)

        })
    }



    return (
        <div>

            {isLoading ? <div style={{ zIndex:'1000', position:'absolute', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4' }}>
                {/* <div style={{ zIndex:'3000' }}>
                    <div className="spinner-border" role="status">
                        <span className="sr-only">Loading...</span>
                    </div>
                </div> */}

            </div>:""}
            {/* {isLoading ? 
            <div>
                <div className="spinner-border" role="status">
                    <span className="sr-only">Loading...</span>
                </div>
            </div>
            :""} */}

            {/* <button onClick={toggle}>toggle</button> */}

            <div className="row">
                <div className="col-12 col-md-3">
                    {usercanpost ? <button className="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default">Add Event</button>:""}
                    
                    {allevents.map(d=>(
                        <div key={d.date+d.title} className="card" style={{ margin:'5px', background:d.color }}>
                            <i style={{ margin:'10px', fontStyle:'normal', color:'white' }}>{d.title}</i>
                        </div>
                    ))}
                    
                    
                </div>
                <div className="col-12 col-md-9">
                <FullCalendar
                displayEventTime='true'
                allDayText="false"
                    timeZone='UTC'
                    plugins={[ dayGridPlugin, timeGridPlugin ]}
                    initialView="dayGridMonth"
                    weekends={true}
                    events={allevents}
                />
                </div>
            </div>

            <div className="modal fade" id="modal-default" data-backdrop='false'>
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Create an Event</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div>
                        <i style={{ fontStyle:'normal', fontSize:'12px' }}>Please ignore the color of the text it will adjust to fit the color</i>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    
                                    <div className="card" style={{ backgroundColor:eventValue.pickedColor }}>
                                        <i style={{ padding:'5px' }}>{eventValue.title}</i>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <label htmlFor="">Title</label>
                                    <input type="text" name="title" value={eventValue.title} onChange={handleChange} id="" className="form-control form-control-sm" placeholder="event title" />
                                </div>
                            </div>
                            <hr />
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Date</label>
                                        <input type="date" name="startdate" value={eventValue.startdate} onChange={handleChange} className="form-control form-control-sm" id="" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Time(optional)</label>
                                        <input type="time" className="form-control form-control-sm" name="starttime" value={eventValue.starttime} onChange={handleChange} id="" />
                                    </div>
                                </div>
                            </div>

                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">End(optional)</label>
                                        <input type="date" className="form-control form-control-sm" name="enddate" value={eventValue.enddate} onChange={handleChange} id="" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Time(optional)</label>
                                        <input type="time" className="form-control form-control-sm" name="endtime" value={eventValue.endtime} onChange={handleChange} id="" />
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label for="favcolor">Select a display color(optional):</label>
                                        <input type="color" id="favcolor" onChange={handleChange} value={eventValue.pickedColor} name="pickedColor"></input>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        {isLoading ? <div className="spinner-border"></div>:<button type="button" onClick={postAnEvent} className="btn btn-info btn-sm" data-dismiss="modal">Save changes</button>}
                        
                    </div>
                    </div>
                </div>
            </div>

            <br />
        </div>
    )
    
}

export default Calender