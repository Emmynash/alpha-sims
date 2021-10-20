import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'


function AddSubject() {

    const [classlist, setClasslist] = useState([])
    const [selectedclass, setselectedclass] = useState('')
    const [subjectName, setSubjectName] = useState('');
    const [subjectType, setSubjectType] = useState('');
    const [allsubjectcount, setsubjectcount] = useState(0)
    const [coresubjectcount, setCoreSubjects] = useState(0)
    const [electivesubjectscount, setelectivesubjectscount] = useState(0)
    const [allsubjects, setallsubjects] = useState([])
    const [schoolsection, setschoolsection] = useState([])
    const [subjectSectione, setSubjectSectione] = useState('')
    const [search, setSearch] = useState("");
    const [filteredSubjects, setFilteredSubjects] = useState([]);
    const [examsstatus, setexamsstatus] = useState(0)
    const [ca1status, setca1status] = useState(0)
    const [ca2status, setca2status] = useState(0)
    const [ca3status, setca3status] = useState(0)
    const alert = useAlert()

    useEffect(() => {

        fetchSchoolDetails()

        return () => {
            // cleanup
        };
    }, []);

    function fetchSchoolDetails() {

        axios.get('/get_all_subjects').then(response=> {
            console.log(response);
            // console.log(setJ)
            setClasslist(response.data.classesAll)
            setsubjectcount(response.data.allsubjects.length)
            setallsubjects(response.data.allsubjects)
            setCoreSubjects(response.data.coresubjects.length)
            setelectivesubjectscount(response.data.electivesubjects.length)
            setschoolsection(response.data.schoolsection)
            setexamsstatus(response.data.schoolDetails.exams)
            setca1status(response.data.schoolDetails.ca1)
            setca2status(response.data.schoolDetails.ca2)
            setca3status(response.data.schoolDetails.ca3)

        }).catch(e=>{
            console.log(e);
        });

    } 

    useEffect(() => {
        setFilteredSubjects(
          allsubjects.filter((subject) =>
            subject.subjectname.toLowerCase().includes(search.toLowerCase())
          )
        );
      }, [search, allsubjects]);

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

    function handleChangeClasslist(e) {
        setselectedclass(e.target.value);
    }

    function handleChangeSubjectName(e) {
        setSubjectName(e.target.value);
    }

    function handleChangeSubjectType(e) {
        setSubjectType(e.target.value);
    } 

    function handleChangeSection(e) {
        setSubjectSectione(e.target.value);
    }


    function addSubjectsMain(){

        if (selectedclass !="" && subjectName != "" && subjectType != "" && subjectSectione) {

            const data = new FormData()
            data.append("subjecttype_sec", subjectType)
            data.append("class_sec", selectedclass)
            data.append("subjectnamesec", subjectName)
            data.append('subjectsectione', subjectSectione)
            axios.post("/subjectprocess_sec", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)


                if (response.data.response == "fields") {
                    myalert('Some fields are empty', 'error');
                }else if(response.data.response == "duplicate"){
                    myalert('Subject already added', 'error');

                }else if(response.data.response == "success"){
                    setSubjectName('');
                    // setSubjectType('')
                    // setselectedclass('')
                    fetchSchoolDetails()
                    myalert('Process Successful', 'success');
                }else{
                    myalert('unknown error', 'error');
                }

            }).catch(e=>{
                console.log(e)
    
            })
            
        }else{

            myalert('All fields are required', 'error');

        }


    }

    return(
        <div className="container">
            <div>
                <button className="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default">Add subject</button>
            </div>
            <br/>
            <div className="row">
                <div className="col-12 col-md-4">
                    <div className="card" style={{ borderRadius:'0px', borderLeft:'5px solid green' }}>
                        <p style={{ margin:'0px 0px 0px 10px' }}>Total Subjects</p>
                        <i style={{ fontStyle:'normal', marginLeft:'10px', fontWeight:'bold' }}>{allsubjectcount}</i>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div className="card" style={{ borderRadius:'0px', borderLeft:'5px solid green' }}>
                        <p style={{ margin:'0px 0px 0px 10px' }}>Core Subjects</p>
                        <i style={{ fontStyle:'normal', marginLeft:'10px', fontWeight:'bold' }}>{coresubjectcount}</i>
                    </div>
                </div>
                <div className="col-12 col-md-4">
                    <div className="card" style={{ borderRadius:'0px', borderLeft:'5px solid green' }}>
                        <p style={{ margin:'0px 0px 0px 10px' }}>Electives Subjects</p>
                        <i style={{ fontStyle:'normal', marginLeft:'10px', fontWeight:'bold' }}>{electivesubjectscount}</i>
                    </div>
                </div>
            </div>

            <div>

                <div>
                    <div className="card">
                        <div className="row" style={{ margin:'10px' }}>
                            { examsstatus == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="Exams mark" className="form-control form-control-sm" />
                            </div>:""}
                            { ca1status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="CA1" className="form-control form-control-sm" />
                            </div>:""}
                            {ca2status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="CA2" className="form-control form-control-sm" />
                            </div>:""}
                            {ca3status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="CA3" className="form-control form-control-sm" />
                            </div>:""}
                        </div>
                        <div style={{ margin:'0px 0px 10px 10px' }}>
                            <button className="btn btn-sm btn-info badge">Save</button>
                        </div>
                    </div>
                </div>


            <div className="row">
                <div className="col-12">
                    <div className="card">
                    <div className="card-header">
                        <h3 className="card-title">Subjects</h3>
                        <div className="card-tools">
                        <div className="input-group input-group-sm" style={{width: '150px'}}>
                            <input type="text" name="table_search" className="form-control float-right" onChange={(e) => setSearch(e.target.value)} placeholder="Search" />
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
                                <th>Subject Name</th>
                                <th>Class</th>
                                <th>Subject Type</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filteredSubjects.length > 0 ? 
                            filteredSubjects.map(d => (
                                <tr>
                                    <td>{d.subjectname}</td>
                                    <td>{d.classname}</td>
                                    <td>{d.subjecttype == 2 ? "Core":"Elective"}</td>
                                    <td>{d.sectionname}</td>
                                    <td><span className="tag tag-success">Approved</span></td>
                                </tr>
                            ))
                            :
                            <tr></tr>
                            }
                        </tbody>
                        </table>
                    </div>
                  
                    </div>
                
                </div>
            </div>

                {/* <DataTablePage subjectdata={allsubjects}/> */}
               

            </div>

            <div className="modal fade" id="modal-default" data-backdrop="false">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Add Subject</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="">
                            <div className="row" style={{ margin:'10px' }}>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <select onChange={(e)=>handleChangeClasslist(e)} className="form-control form-control-sm">
                                            <option value="">Select a class</option>
                                            {classlist.length > 0 ? classlist.map(d => (
                                                <option key={d.id} value={d.id}>{d.classname}</option>
                                            ))
                                            :
                                            <option value=""></option>
                                            }
                                        </select>
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <input onChange={(e)=>handleChangeSubjectName(e)} value={subjectName} style={{ textTransform:'uppercase' }} className="form-control form-control-sm" placeholder="Enter subject name"/>
                                    </div>
                                </div>
                            </div>
                            <div className="row" style={{ margin:'10px' }}>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <select onChange={(e)=>handleChangeSubjectType(e)} className="form-control form-control-sm">
                                            <option value="">Subject type</option>
                                            <option value="1">Elective</option>
                                            <option value="2">Core</option>
                                        </select>
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <select onChange={(e)=>handleChangeSection(e)} className="form-control form-control-sm">
                                            <option value="">Select Arm</option>
                                            { schoolsection.map(d=>(
                                                <option value={d.id}>{d.sectionname}</option>
                                            ))}
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {/* <div style={{ margin:'10px' }}>
                                <button  className="btn btn-info btn-sm">Save</button>
                            </div> */}
                        </div>
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button onClick={addSubjectsMain} type="button" className="btn btn-info btn-sm">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>







        </div>
    );



}

export default AddSubject;