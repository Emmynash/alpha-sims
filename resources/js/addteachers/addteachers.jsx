import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

const AddTeachers=()=>{

    const [allClasses, setAllClasses] = useState([])
    const [allsubjects, setallsubjects] = useState([])
    const [section_sec, setSection_sec] = useState([])
    const [allTeachersWithSubject, setAllTeachersWithSubject] = useState([])
    const [systemNumber, setSystemNumber] = useState('')
    const [teacherDetail, setTeacherdetails] = useState({})
    const [verified, setverified] = useState(false)
    const [isloadingTeacher, setisloadingTeacher] = useState(false)
    const [classid, setclassid] = useState(0)
    const [subjectid, setSubjectId] = useState(0)
    const [sectionmain, setSection] = useState('')
    const [isLoading, setisLoading] = useState(false)
    const [teacherList, setTeacherList] = useState([])
    const [teacherListfiltered, setTeacherListfiltered] = useState(teacherList)
    const [isUnasigning, setUnasigning] = useState(false)
    const alert = useAlert()

    useEffect(() => {

        fetchPageDetails()

        return () => {
            // cleanup
        };
    }, []);

    function fetchPageDetails() {
        setisLoading(true)
        axios.get('/get_teacher_page_details').then(response=> {
            console.log(response);
            // console.log(setJ)
            setisLoading(false)
            setAllClasses(response.data.classesAll)
            // setallsubjects(response.data.addsubject_sec)
            setSection_sec(response.data.addsection_sec)
            // setAllTeachersWithSubject(response.data.getAllTeachersWithSubject)
            setTeacherList(response.data.getAllTeachers)
            setTeacherListfiltered(response.data.getAllTeachers)
            


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

    function handleChangeTeachersSystemNumber(e) {
        setSystemNumber(e.target.value);
    }

    function handleChangeClassid(e) {
        setclassid(e.target.value);
    }

    function handleChangeSubjectId(e) {
        setSubjectId(e.target.value);
    }

    function handleChangeSection(e) {
        setSection(e.target.value);
        getSubject4SelectedClass(e.target.value)
        console.log(e.target.value)
    }

    function getSubject4SelectedClass(sectionidt) {

        axios.get('/fetch_students_marks/'+classid+"/"+sectionidt).then(response=> {
            console.log(response);
            // console.log(setJ)
            // setClasslist(response.data.classlist)
            // seIsLoading(false)
            setallsubjects(response.data.subjectlist)

        }).catch(e=>{
            console.log(e);
            seIsLoading(false)
        });
        
    }

    function confirmTeachersReg() {

        if (systemNumber !="") {
            setisLoading(true)
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
                setisLoading(false)
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
                setisLoading(false)
                
            })
            
        }else{

            myalert('All fields are required', 'error');

        }
        
    }

    function closeModal() {

        setSystemNumber('')
        setTeacherdetails([])
        setverified(false)
    } // un_asign_a_subject

    function asignSubjectToTeacher() {

        if (systemNumber !="" && subjectid != 0 && systemNumber !=0 && classid !=0) {
            setisLoading(true)
            const data = new FormData()
            data.append("subject_id", subjectid)
            data.append("user_id", systemNumber)
            data.append("section", sectionmain)
            data.append("allocatedclass", classid)
            axios.post("/allocatesubjectteacher", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                setisLoading(false)
                if (response.data.response == "fields") {
                    myalert('All fields are required', 'error');

                }else if(response.data.response == "exist"){
                    myalert('Subject already alocated to this teacher', 'error');
                }
                else if(response.data.response == "success"){
                    myalert('Success', 'success');

                    fetchPageDetails()

                }

            }).catch(e=>{
                console.log(e)
                setisLoading(false)
            })
            
        }else{

            myalert('All fields are required', 'error');

        }
        
    }

    const handleSearch = (event) => {

        let value = event.target.value.toLowerCase();

        let result = [];

        console.log(value);

        result = teacherList.filter((data) => {
            return data.firstname.toLowerCase().search(value) != -1;
        });
        setTeacherListfiltered(result);

    }

    function unasignSubjectToTeacher(tableid) {

        // if (systemNumber !="" && subjectid != 0 && systemNumber !=0 && classid !=0) {
            setisLoading(true)
            const data = new FormData()
            data.append("tableid", tableid)
            axios.post("/un_asign_a_subject", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                setisLoading(false)
                if (response.data.response == "success") {
                    fetchPageDetails()
                    myalert('Subject success fully unasigned', 'success');

                }else if(response.data.response == "error"){
                    myalert('Unknown Error', 'error');
                }
                else if(response.data.response == "success"){
                    myalert('Unknown Error', 'error');

                    

                }

            }).catch(e=>{
                console.log(e)
                setisLoading(false)
            })
            
        // }else{

        //     myalert('All fields are required', 'error');

        // }
        
    }


     const formatter = new Intl.DateTimeFormat("en-GB", {
          year: "numeric",
          month: "long",
          day: "2-digit"
        });

        function fetch_teacher_subjects(selectedteacher) {

            setUnasigning(true)

            axios.get('/fetch_teacher_subjects/'+selectedteacher).then(response=>{

                console.log(response)

                setUnasigning(false)

                setAllTeachersWithSubject(response.data.response)

            }).catch(e=>{
                setUnasigning(false)

                console.log(e)

            })
            
        }


    return(
        <div className="">

        {isLoading ? <div className="text-center">
                <div className="spinner-border"></div>
        </div>:""}

            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4', zIndex:'1000' }}>

            </div>:""}

            <div>
                <button className="btn btn-sm btn-info" data-toggle="modal" data-target="#asign-subject">Add Teacher</button>
            </div>
            <br/>
            <div>
            <div className="row">
                <div className="col-12">
                <div className="card">
                    <div className="card-header">
                    <h3 className="card-title">Teachers</h3>
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
                            <th>Teacher's name</th>
                            <th>Sys No.</th>
                            <th>Date assigned</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            { teacherListfiltered.map(teachers=>(

                                    <tr key={teachers.id}>
                                        <td>{teachers.firstname} {teachers.middlename} {teachers.lastname}</td>
                                        <td>{teachers.systemid}</td>
                                        <td>{formatter.format(Date.parse(teachers.created_at))}</td>
                                        <td>
                                            <button data-toggle="modal" onClick={()=>fetch_teacher_subjects(teachers.systemid)} data-target="#viewsubject" className="btn btn-sm btn-info badge">view</button>
                                        </td>
                                    </tr>

                                ))

                            }
                        </tbody>
                    </table>
                    </div>
                    {/* /.card-body */}
                </div>
                {/* /.card */}
                </div>
                </div>
                {/* /.row */}

                <div className="modal fade" id="asign-subject" data-backdrop="false">
                    <div className="modal-dialog">
                        <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Asign Subject</h4>
                            <button type="button" onClick={closeModal} className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <input type="number" value={systemNumber} className="form-control form-control-sm" onChange={(e)=>handleChangeTeachersSystemNumber(e)} placeholder="system number"/>

                                        {isloadingTeacher ? 
                                            <div className="spinner-border" style={{ height:'20px', width:'20px' }}></div>
                                        :
                                            <button onClick={confirmTeachersReg} className="btn btn-sm btn-info badge">Confirm</button>
                                        }
                                        
                                        
                                    </div>
                                </div>
                                {verified ? 
                                
                                <div className="col-12 col-md-6">

                                    <div className="card" >
                                        <div className="row">
                                            <div className="col-md-4">
                                                <div style={{display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '5px'}}>
                                                    <img id="passportconfirm_sec2" style={{}} src="storage/schimages/profile.png" className="img-circle elevation-2" alt="" width="70px" height="70px" />
                                                </div>
                                            </div>
                                            <div className="col-md-8 text-center">
                                                {teacherDetail == null ? <></>:
                                                    <div>
                                                        <p style={{ margin:'2px' }}>{teacherDetail.firstname}</p>
                                                        <p style={{ margin:'2px' }}>{teacherDetail.middlename}</p>
                                                        <p style={{ margin:'2px' }}>{teacherDetail.lastname}</p>
                                                    </div>
                                                }
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                :""}

                            </div>

                            {verified ? 
                              
                                <div className="row">
                                    <div className="col-12 col-md-12">
                                        <div className="form-group">
                                            <select onChange={(e)=>handleChangeClassid(e)} className="form-control-sm form-control">
                                                <option value="">Select a Class</option>
                                                {allClasses.map(singleclass=>(
                                                    <option key={singleclass.id} value={singleclass.id}>{singleclass.classname}</option>
                                                ))}
                                            </select>
                                        </div>

                                        <div className="form-group">
                                            <select onChange={(e)=>handleChangeSection(e)} className="form-control-sm form-control">
                                                    <option value="">Select a section</option>
                                                    {section_sec.map(singlesection=>(
                                                        <option key={singlesection.id} value={singlesection.id}>{singlesection.sectionname}</option>
                                                    ))}
                                                    {/* <option value="General">General</option> */}
                                            </select>
                                        </div>

                                        <div className="form-group">
                                            <select onChange={(e)=>handleChangeSubjectId(e)} className="form-control-sm form-control">
                                                <option value="">Select a Subject</option>
                                                {allsubjects.map(singlesubject=>(
                                                    <option key={singlesubject.id} value={singlesubject.id}>{singlesubject.subjectname}/{singlesubject.classname}/{singlesubject.sectionname == null ? "General":singlesubject.sectionname == 1 ? "Elective":"Core"}/</option>
                                                ))}
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-12">
                                        <div className="form-group">

                                        </div>
                                    </div>
                                </div>

                              :""
                        
                            }

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button type="button" className="btn btn-default btn-sm" onClick={closeModal} data-dismiss="modal">Close</button>
                            <button type="button" onClick={asignSubjectToTeacher} className="btn btn-info btn-sm">Save changes</button>
                        </div>
                        </div>
                        {/* /.modal-content */}
                    </div>
                    {/* /.modal-dialog */}
                </div>
                {/* /.modal */}


                <div className="modal fade" id="viewsubject">

                    <div className="modal-dialog">
                        <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Teachers Subject</h4>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">

                        {isUnasigning ?
                            <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', zIndex:'1000', display:'flex', alignItems:'center', justifyContent:'center' }}>
                                <div className="spinner-border"></div>
                            </div>:""
                        }

                            {
                                allTeachersWithSubject.length > 0 ? allTeachersWithSubject.map(d=>(

                                    <div className="card">
                                        <div style={{ display:'flex', padding:'10px' }}>
                                            <i style={{ fontStyle:'normal', fontSize:'14px' }}>{d.subjectname}</i>
                                            <div style={{ flex:0.5 }}></div>
                                            <i style={{ fontStyle:'normal', fontSize:'14px' }}>{d.classname}{d.sectionname}</i>
                                            <div style={{ flex:1 }}></div>
                                            <button onClick={()=>unasignSubjectToTeacher(d.id)} className="btn btn-sm badge btn-danger">Unasign</button>
                                        </div>
                                    </div>

                                )):""
                            }
                            

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            {/* <button type="button" onClick={()=>fetch_teacher_subjects(d.systemid)} className="btn btn-info btn-sm">Refresh</button> */}
                        </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>
    );

}

export default AddTeachers;