import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

function AddFormMaster() {

    const [allClasses, setAllClasses] = useState([])
    const [section_sec, setSection_sec] = useState([])
    const [systemNumber, setSystemNumber] = useState('')
    const [teacherDetail, setTeacherdetails] = useState({})
    const [isloadingTeacher, setisloadingTeacher] = useState(false)
    const [verified, setverified] = useState(false)
    const [classid, setclassid] = useState(0)
    const [sectionmain, setSection] = useState('')
    const [getFormMasters, setgetFormMasters] = useState([])
    const [getFormMastersFiltered, setgetFormMastersFiltered] = useState(getFormMasters)
    const alert = useAlert()


    useEffect(() => {
        fetchPageDetails()
        return () => {
            // cleanup
        };
    }, []);


    function fetchPageDetails() {

        axios.get('/get_teacher_page_details').then(response=> {
            console.log(response);
            // console.log(setJ)
            setAllClasses(response.data.classesAll)
            setSection_sec(response.data.addsection_sec)
            setgetFormMasters(response.data.getFormMasters)
            setgetFormMastersFiltered(response.data.getFormMasters)

        }).catch(e=>{
            console.log(e);
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

    const handleSearch = (event) => {

        let value = event.target.value.toLowerCase();
        let result = [];
        console.log(value);

        result = getFormMasters.filter((data) => {
            return data.firstname.toLowerCase().search(value) != -1;
        });

        setgetFormMastersFiltered(result);

    }

    function handleChangeTeachersSystemNumber(e) {
        setSystemNumber(e.target.value);
    }

    function handleChangeClassid(e) {
        setclassid(e.target.value);
    }

    function handleChangeSection(e) {
        setSection(e.target.value);
    }

    function closeModal() {

        setSystemNumber('')
        setTeacherdetails([])
        setverified(false)
    }


    function confirmTeachersReg() {

        if (systemNumber !="") {
            setisloadingTeacher(true)
            setverified(false)
            const data = new FormData()
            data.append("mastersystemnumber", systemNumber)
            axios.post("/teacher_sec_confirm", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)

                if (response.data.response == "noaccount") {
                    myalert('no account was found', 'error');
                    setisloadingTeacher(false)
                    closeModal()
                }else{
                    myalert('Success', 'success');
                    setTeacherdetails(response.data.userdetailfetch)
                    setverified(true)
                    setisloadingTeacher(false)
                }

            }).catch(e=>{
                console.log(e)
                setisloadingTeacher(false)
                closeModal()
                
            })
            
        }else{

            myalert('All fields are required', 'error');

        }
        
    }

    function setUserDetails(systemnumset, classidset, sectionset) {

        console.log(systemnumset)

        setSystemNumber(systemnumset)
        setclassid(classidset)
        setSection(sectionset)
        
    }


    function asignFormMaster() {

        if (systemNumber !="" && classid !=0 && sectionmain !=0) {

            const data = new FormData()
            data.append("systemidformmaster", systemNumber)
            data.append("formteacherclass", classid)
            data.append("formsection", sectionmain)
            axios.post("/allocateformmaster", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)

                if (response.data.response == "done") {
                    myalert('Process was Successful', 'success');
                }else if(response.data.response == "exist"){
                    myalert('Teacher already a form master', 'error');
                }else if(response.data.response == "fields"){
                    myalert('Some fields are empyt', 'error');
                }else{
                    myalert('Status unknown', 'error');
                }

            }).catch(e=>{
                console.log(e)
                myalert('Status unknown', 'error');
                
            })
            
        }else{

            myalert('All fields are required', 'error');

        }
        
    }

    const formatter = new Intl.DateTimeFormat("en-GB", {
        year: "numeric",
        month: "long",
        day: "2-digit"
      });




      function unAsignFormTeachers() {

        const data = new FormData()
            data.append("systemidformmaster", systemNumber)
            data.append("formteacherclass", classid)
            data.append("formsection", sectionmain)
            axios.post("/unallocateformmaster", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)

                if (response.data.response == "done") {
                    myalert('Process was Successful', 'success');
                    fetchPageDetails()
                }else if(response.data.response == "exist"){
                    myalert('Teacher already a form master', 'error');
                }else if(response.data.response == "fields"){
                    myalert('Some fields are empyt', 'error');
                }else{
                    myalert('Status unknown', 'error');
                }

            }).catch(e=>{
                console.log(e)
                myalert('Status unknown', 'error');
                
            })

          
      }




    return(
        <div>
            <button className="btn btn-sm btn-info" data-toggle="modal" data-target="#addformmaster">Add Form Master</button>
            <hr />
            <div className="alert alert-info">
                <i>Each class should be asigned a form master...</i>
            </div>
            <div className="row">
                <div className="col-12">
                    <div className="card">
                    <div className="card-header">
                        <h3 className="card-title">Form Teachers</h3>
                        <div className="card-tools">
                        <div className="input-group input-group-sm" style={{width: '150px'}}>
                            <input type="text" name="table_search" className="form-control float-right" placeholder="Search" onChange={(event) => handleSearch(event)}/>
                            <div className="input-group-append">
                            <button type="submit" className="btn btn-default">
                                <i className="fas fa-search" />
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>
                    {/* /.card-header */}
                    <div className="card-body table-responsive p-0">
                        <table className="table table-hover text-nowrap">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>System No.</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Date Asigned</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            { getFormMastersFiltered.map(d=>(
                                <tr key={d.id+"formteachertable"}>
                                    <td>{d.firstname} {d.middlename} {d.lastname}</td>
                                    <td>{d.teacher_id}</td>
                                    <td>{d.classname}</td>
                                    <td>{d.sectionname}</td>
                                    <td>{formatter.format(Date.parse(d.created_at))}</td>
                                    <td><button className="btn btn-danger btn-sm badge" data-toggle="modal" data-target="#unasignaddformmaster" onClick={()=>setUserDetails(d.teacher_id, d.classid, d.sectionid)}>unasign</button></td>
                                </tr>
                            ))}

                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="addformmaster" data-backdrop='false'>
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Asign Form Master</h4>
                        <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <input type="number" onChange={(e)=>handleChangeTeachersSystemNumber(e)} value={systemNumber} className="form-control form-control-sm" placeholder="system number"/>
                                    {isloadingTeacher ? 
                                            <div className="spinner-border" style={{ height:'20px', width:'20px' }}></div>
                                        :
                                            <button onClick={confirmTeachersReg} className="btn btn-sm btn-info badge">Verify</button>
                                        }
                                </div>
                            </div>
                            {verified ? <div className="col-12 col-md-6">
                                <div className="card">
                                    <div className="row">
                                        <div className="col-md-4 col-6">
                                            <div style={{display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '5px'}}>
                                                <img id="passportconfirm_sec2" style={{}} src={teacherDetail.profileimg == null ? "https://gravatar.com/avatar/?s=200&d=retro" : teacherDetail.profileimg} className="img-circle elevation-2" alt="" width="70px" height="70px" />
                                            </div>
                                        </div>
                                        <div className="col-md-8 col-6">
                                            {/* {teacherDetail.map(d=>( */}
                                                <div className="text-center">
                                                    <p style={{ margin:'2px' }}>{teacherDetail.firstname}</p>
                                                    <p style={{ margin:'2px' }}>{teacherDetail.middlename}</p>
                                                    <p style={{ margin:'2px' }}>{teacherDetail.lastname}</p>
                                                </div>
                                            {/* ))} */}
                                        </div>
                                    </div>
                                </div>
                            </div>:""}
                        </div>
                        { verified ?  <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <select onChange={(e)=>handleChangeClassid(e)} name="" id="" className="form-control form-control-sm">
                                        <option value="">Select a class</option>
                                        {allClasses.map(d=>(
                                            <option key={d.id+"classformteachers"} value={d.id}>{d.classname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <select name="" onChange={(e)=>handleChangeSection(e)} id="" className="form-control form-control-sm">
                                        <option value="">Select a section</option>
                                        {section_sec.map(d=>(
                                            <option key={d.id+"sectionformmaster"} value={d.id}>{d.sectionname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                        </div>:""}
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button onClick={closeModal} type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" onClick={asignFormMaster} className="btn btn-info btn-sm">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

            {/* unasign form teachers */}

            <div className="modal fade" id="unasignaddformmaster" data-backdrop='false'>
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Remove form master</h4>
                        <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="alert alert-warning">
                            <i style={{ fontSize:'12px', fontStyle:'normal' }}>You are about to unasign this form teacher. Click proceed to confirm</i>
                        </div>

                    </div>
                    <div className="modal-footer justify-content-between">
                        <button onClick={closeModal} type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" onClick={unAsignFormTeachers} className="btn btn-info btn-sm">Proceed</button>
                    </div>
                    </div>
                </div>
            </div>


        </div>
    )
    
}

export default AddFormMaster