import axios from 'axios';
import React, { useState } from 'react';
import { useEffect } from 'react';
import { useAlert } from 'react-alert'

function ReasignClass() {

    const [isLoading, setisLoading] = useState(false)
    const [classlist, setClasslist] = useState([])
    const [schoolsection, setschoolsection] = useState([])
    const [gottenStudentRecord, setStudentRecord] = useState({})
    const alert = useAlert()

    const [studentDetails, setUpStudentDetails] = useState({
        admissionno: '',
    })


    useEffect(() => {

        fetchSchoolDetails()

        return () => {
            // cleanup
        };
    }, []);

    function handleChange(evt) {

        setUpStudentDetails({
            ...studentDetails,
          [evt.target.name]: evt.target.value,
        });
        
    }

    function fetchSchoolDetails() {
        setisLoading(true)
        axios.get('/get_all_subjects').then(response=> {
            console.log(response);
            // console.log(setJ)
            setisLoading(false)
            setClasslist(response.data.classesAll)
            setschoolsection(response.data.schoolsection)


        }).catch(e=>{
            console.log(e);
            setisLoading(false)
        });

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

    function confirmAddmissionnumber() {

        setisLoading(true)

        axios.post('/confirm_admission_no', studentDetails, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{

            console.log(response)
            setisLoading(false)

            if(response.data.response == "success"){

                setStudentRecord(response.data.student)

            }else if(response.data.response == "doesnotexist"){
                myalert("does not exist", 'error')
            }else if(response.data.response == "noaddmissionno"){
                myalert("enter ad no", 'error')
            }else if(response.data.response == "duplicate"){
                myalert("duplicate no", 'error')
            }

        }).catch(e=>{
            setisLoading(false)
            myalert("unknown error", 'error')
        })
        
    }

    return(
        <div>

            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4', zIndex:'1000' }}>

            </div>:""}

            {isLoading ? <div className="text-center">
                <div className="spinner-border"></div>
            </div>:''}

            <br/>

            <div className="card">
                <i style={{ fontStyle:'normal', fontSize:'14px', padding:'10px' }}>Use the form below to reasign a class to a student</i>
            </div>
            <div>
                <div className="row">
                    <div className="col-12 col-md-6">
                        <div className="form-group">
                            <input type="text" className="form-control form-control-sm" name="admissionno" style={{ textTransform:'uppercase' }} value={studentDetails.admissionno} onChange={handleChange} placeholder="enter student addmission no." />
                        </div>
                        <div>
                            <button onClick={confirmAddmissionnumber} className="btn btn-sm btn-info">Query</button>
                        </div>
                        <br />
                        <div className="form-group" style={{ display:'flex', flexDirection:'column' }}>
                            <i style={{ fontStyle:'normal', fontSize:'14px' }}>{gottenStudentRecord.firstname} {gottenStudentRecord.middlename} {gottenStudentRecord.lastname}</i>
                            <i style={{ fontStyle:'normal', fontSize:'14px' }}>{gottenStudentRecord.classname}{gottenStudentRecord.sectionname}</i>
                        </div>
                        <div className="form-group">
                            <select name="" className="form-control form-control-sm" id="">
                                <option value="">Select class</option>
                                {
                                    classlist.map(d=>(
                                        <option key={d.id+"classreasign"} value={d.id}>{d.classname}</option>
                                    ))
                                }
                            </select>
                        </div>

                        <div className="form-group">
                            <select name="" className="form-control form-control-sm" id="">
                                <option value="">Select arm/section</option>
                                {
                                    schoolsection.map(d=>(
                                        <option key={d.id+"sectionreasign"} value={d.id}>{d.sectionname}</option>
                                    ))
                                }
                            </select>
                        </div>

                        <div className="form-group">
                            <button className="btn btn-sm btn-info">Confirm Reasign</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    )
    
}

export default ReasignClass;