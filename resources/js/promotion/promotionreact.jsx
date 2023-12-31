import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

function Promotion() {

    const alert = useAlert()
    const [promotionAverage, setPromotionAverage] = useState(0)
    const [averagestatus, setAverageStatus] = useState(0)
    const [classlist, setClassList] = useState([])
    const [classsection, setClassSection] = useState([])
    const [schoolSession, setSchoolSession] = useState('')
    const [previousSessionmain, setpreviousSessionmain] = useState('')
    const [promotionFromClass, setPromotionClass] = useState(0)
    const [poromotionToClass, setPromotionToClass] = useState('')
    const [promotionFromSection, setPromotionSection] = useState(0)
    const [promotionToId, setPromotionToId] = useState('')
    const [addstudentSec, setaddstudent_sec] = useState([])
    const [isLoading, setisLoading] = useState(false)

    useEffect(() => {
        fetchSchoolDetails()
        return () => {
            // cleanup
        };
    }, []);

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


    function fetchSchoolDetails() {
        setisLoading(true);

        axios.get('/get_school_details').then(response=> {
            console.log(response);
            setisLoading(false)
            // console.log(setJ)
            setPromotionAverage(response.data.schoolDetails.promotionaverage)
            setAverageStatus(response.data.schoolDetails.averagestatus)
            setSchoolSession(response.data.schoolDetails.schoolsession)
            setClassList(response.data.classlist)
            setClassSection(response.data.classsection)
            setpreviousSessionmain(response.data.previousSessionmain)
            


        }).catch(e=>{
            setisLoading(false)
            console.log(e);
        });

    }

    function handleChangeFromClass(e) {
        setPromotionClass(e.target.value)
    }

    function handleChangeSection(e) {
        setPromotionSection(e.target.value)
    }

    function handleChangePromotionAverage(e) {
        setPromotionAverage(e.target.value)
    }
    function handleChangeAverageStatus(e) {
        

        if (e.target.checked) {
            console.log(e.target.checked)
            setAverageStatus(1)
            updatePromotionAverageStatus(1)
        }else{
            console.log(e.target.checked)
            setAverageStatus(0)
            updatePromotionAverageStatus(0)
        }
    }

    function getStudentForPromotion() {
        setisLoading(true)
        const data = new FormData()
        data.append("promofromclass", promotionFromClass),
        data.append("promofromsection", promotionFromSection),
        data.append("promofromsession", previousSessionmain),
        axios.post("/promotion_student_ftech_sec", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            setisLoading(false)
            console.log(response.data)
            if(response.data.success == "nopromo"){
                
                setPromotionToClass("GRAD")
                // setPromotionToId(response.data.success.classlist_secs[0].id)
                setaddstudent_sec(response.data.addstudent_sec)
            }else{
                setPromotionToClass(response.data.success.classlist_secs[0].classname)
                setPromotionToId(response.data.success.classlist_secs[0].id)
                setaddstudent_sec(response.data.success.addstudent_sec)
            }
        }).catch(e=>{
            setisLoading(false)
            console.log(e)

        })
    }

    function updatePromotionAverage() { //update_promotion_average


        if (promotionAverage == 0) {
            myalert("Must not be Zero", 'error')
        }else{

            setisLoading(true)

            const data = new FormData()
            data.append("average", promotionAverage),
            data.append('key', 'averageMark')
            axios.post("/update_promotion_average", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                setisLoading(false)
                if (response.data.response == "success") {
                    myalert("Promotion Average Updated Successfully", 'success')
                }else{
                    myalert("Unknown Error", 'error')
                }
    
            }).catch(e=>{
                setisLoading(false)
                console.log(e)
            })
        }
    }

    function updatePromotionAverageStatus(status) { //update_promotion_average

        if (promotionAverage == 0) {
            myalert("Must not be Zero", 'error')
        }else{
            setisLoading(true)
            const data = new FormData()
            data.append("average", status),
            data.append('key', '')
            axios.post("/update_promotion_average", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                setisLoading(false)
                if (response.data.response == "success") {
                    myalert("Promotion Status Updated Successfully", 'success')
                }else{
                    myalert("Unknown Error", 'error')
                }
            }).catch(e=>{
                setisLoading(false)
                console.log(e)
            })
        }
    }

    function promoteStudent() {
        setisLoading(true)
        const data = new FormData()
        data.append("classfrom", promotionFromClass),
        data.append("classto", promotionToId),
        data.append("promofromsection", promotionFromSection),
        data.append("previoussession", previousSessionmain),
        data.append("newsession", schoolSession),
        data.append("promotionaverage", promotionAverage),
        data.append("promotewithaverage", averagestatus),
        data.append("nextClassDisplayname", poromotionToClass)
        axios.post("/promotion_main_query", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisLoading(false)
            if (response.data.code == "200") {
                myalert(response.data.message, 'success')
                getStudentForPromotion();
            }else{
                myalert(response.data.message, 'error')
            }


        }).catch(e=>{
            console.log(e)
            setisLoading(false)
            myalert("Unknown Error", 'error')
        })
    }

    return(
        <div>
        {isLoading ? <div className="text-center">
                    <div class="spinner-border"></div>
            </div>:''}
            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', zIndex:'1000', background:'white', opacity:'0.4' }}>

            </div>:""}

            <div className="card">
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-6">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <select onChange={(e)=>handleChangeFromClass(e)} name="" id="" className="form-control form-control-sm">
                                        <option value="">Select a Class</option>
                                        {classlist.map(singleclass=>(
                                            <option key={singleclass.id+"promoclass"} value={singleclass.id} >{singleclass.classname}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="form-group">
                                    <select onChange={(e)=>handleChangeSection(e)} name="" id="" className="form-control form-control-sm">
                                        <option value="">Select a Section</option>
                                        {classsection.map(classsectionmain=>(
                                            <option key={classsectionmain.id+"promosection"} value={classsectionmain.id} >{classsectionmain.sectionname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <div className="col-12 col-md-6">
                                <input type="text" placeholder="Previous Session" value={previousSessionmain} className="form-control form-control-sm" readOnly/>
                            </div>
                        </div>
                        <div>
                            <button onClick={getStudentForPromotion} className="btn btn-sm btn-info">Query</button>
                        </div>
                    </div>
                    <div className="col-12 col-md-6">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <input type="text" value={schoolSession} className="form-control form-control-sm" placeholder="New Session" readOnly/>
                                </div>
                                <div className="form-group">
                                    <input type="text" value={poromotionToClass} className="form-control form-control-sm" readOnly/>
                                </div>
                            </div>
                        </div>
                        <div>
                        <button onClick={promoteStudent} className="btn btn-sm btn-info">Proceed</button>
                        </div>
                    </div>
                </div>
                <div>
                    <div style={{ margin:'0px 10px 10px 10px' }}>
                        <p style={{ margin:'0px' }}>Set Average for Promotion</p>
                    </div>

                    <div className="row" style={{ margin:'0px 10px 0px 10px' }}>
                        <div className="col-12 col-md-4">
                            <div className="form-group">
                                <input type="number" onChange={(e)=>handleChangePromotionAverage(e)} value={promotionAverage} className="form-control form-control-sm"/>
                            </div>

                            <div className="form-group">
                                    <button onClick={updatePromotionAverage} className="btn btn-sm btn-info badge">Save</button>
                            </div>

                        </div>
                        <div className="col-12 col-md-4">
                            <div className="alert alert-warning">
                                <i style={{ fontSize:'12px', fontStyle:'normal' }}>Enabling this means the average set will be ignored and all student will be promoted to next class.</i>
                            </div>
                            <div className="form-group">
                                <div className="custom-control custom-switch">
                                    <input onChange={(e)=>handleChangeAverageStatus(e)} type="checkbox" checked={averagestatus == 1 ? "checked":""} className="custom-control-input" id="customSwitch1" />
                                    <label className="custom-control-label" htmlFor="customSwitch1">Promote Ignoring Average</label>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    
                </div>
            </div>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                    <div className="card-header">
                        <h3 className="card-title">Student List</h3>
                        <div className="card-tools">
                        <div className="input-group input-group-sm" style={{width: '150px'}}>
                            <input type="text" name="table_search" className="form-control float-right" placeholder="Search" />
                            <div className="input-group-append">
                            <button type="submit" className="btn btn-default">
                                <i className="fas fa-search" />
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div className="card-body table-responsive p-0">
                        <table className="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Admission No.</th>
                                <th>Name</th>
                                <th>Average</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            {addstudentSec.map(d=>(
                                <tr key={d.id+"promotable"}>
                                    <td>{d.admission_no}</td>
                                    <td>{d.firstname} {d.middlename} {d.lastname}</td>
                                    <td>{d.promomarks}</td>
                                    <td><button className="btn btn-sm btn-info badge">Promote</button></td>
                                </tr>
                            ))}

                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    )
    
}

export default Promotion;