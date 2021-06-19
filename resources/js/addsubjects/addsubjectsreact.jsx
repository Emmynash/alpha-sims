import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import DataTable from 'react-data-table-component';
// import Modal from 'react-modal';
import { Button, Modal, Footer, Header } from 'react-bootstrap';

const customStyles = {
    content: {
      top: '25%',
      left: '50%',
      right: 'auto',
      bottom: 'auto',
      marginRight: '-50%',
      transform: 'translate(-50%, -50%)',
    },
  };
  


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
    const [examsmark, setExamsMark] = useState(0)
    const [ca1mark, setCa1Mark] = useState(0)
    const [ca2mark, setCa2Mark] = useState(0)
    const [ca3mark, setCa3Mark] = useState(0)
    const [classElectives, setClassElectives] = useState(0)
    const [sectionElectives, setSectionElectives] = useState(0)
    const [numberElectives, setNumberElectives] = useState(0)
    const [getElectivesSettingNumber, setgetElectivesSettingNumber] = useState([])
    const [isLoading, setisLoading] = useState(false)
    const [modalIsOpen, setIsOpen] = React.useState(false);
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    let subtitle;

    const [updatesubject, setUpdatesubject] = useState({
        subjectname: '',
        classid: '',
        subjecttype:'',
        sectionid:'',
        subjectid:''
    })
    
    const alert = useAlert()


    const columns = [
        {
            name: 'Subject Name',
            selector: 'subjectname',
            sortable: true,
        },
        {
            name: 'Class.',
            selector: 'classname',
            sortable: true,
            right: true,
        },
        {
            name: 'Subject Type',
            selector: 'subjecttype',
            sortable: true,
            right: true,
        },
        {
            name: 'Section.',
            selector: 'sectionname',
            sortable: true,
            right: true,
        },
        {
            name: 'Action',
            selector: '',
            sortable: true,
            right: true,
        },
    ];
















    useEffect(() => {

        fetchSchoolDetails()

        return () => {
            // cleanup
        };
    }, []);

    function fetchSchoolDetails() {
        setisLoading(true)
        axios.get('/get_all_subjects').then(response=> {
            console.log(response.data.subjectScores);
            // console.log(setJ)
            setisLoading(false)
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
            setgetElectivesSettingNumber(response.data.getElectivesSettingNumber)

            if (response.data.subjectScores == null) {
                setExamsMark(0)
                setCa1Mark(0)
                setCa2Mark(0)
                setCa3Mark(0)
            }else{
                setExamsMark(response.data.subjectScores.examsfull)
                setCa1Mark(response.data.subjectScores.ca1full)
                setCa2Mark(response.data.subjectScores.ca2full)
                setCa3Mark(response.data.subjectScores.ca3full)
            }

        }).catch(e=>{
            console.log(e);
            setisLoading(false)
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

    function handleChangeExamsFull(e){
        setExamsMark(e.target.value)
    }

    function handleChangeCa1Full(e){
        setCa1Mark(e.target.value)
    }

    function handleChangeCa2Full(e){
        setCa2Mark(e.target.value)
    }

    function handleChangeCa3Full(e){
        setCa3Mark(e.target.value)
    }

    function handleClassChangeEllectives(e) {
        setClassElectives(e.target.value)
    }

    function handleSectionChangeEllectives(e) {
        setSectionElectives(e.target.value)
    }

    function handleNumberEllectivesChangeEllectives(e) {
        setNumberElectives(e.target.value)
    }


    function addSubjectsMain(){

        if (selectedclass !="" && subjectName != "" && subjectType != "" && subjectSectione) {
            setisLoading(true)
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
                setisLoading(false)
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
                setisLoading(false)
    
            })
            
        }else{

            myalert('All fields are required', 'error');

        }
    }

    function updateScoresOrAdd() {
        setisLoading(true)
        const data = new FormData()
        data.append("examsfull", examsmark)
        data.append("ca1full", ca1mark)
        data.append("ca2full", ca2mark)
        data.append('ca3full', ca3mark)
        axios.post("/add_subject_score_update", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisLoading(false)


            if(response.data.response == "success"){
                setSubjectName('');
                // setSubjectType('')
                // setselectedclass('')
                fetchSchoolDetails()
                myalert('Process Successful', 'success');
            }else if(response.data.response == "invalid"){
                myalert('Invalid scores entered', 'error');
            }
            else{
                myalert('unknown error', 'error');
            }

        }).catch(e=>{
            console.log(e)
            setisLoading(false)

        })
        
    }

    function addNumberOfEllectives() {
        setisLoading(true)
        const data = new FormData()
        data.append("classid", classElectives)
        data.append("sectionid", sectionElectives)
        data.append("number_ellectives", numberElectives)
        axios.post("/add_number_of_ellectives", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisLoading(false)

            if(response.data.response == "success"){

                fetchSchoolDetails()
                myalert('Process Successful', 'success');
            }else if(response.data.response == "updated"){
                fetchSchoolDetails()
                myalert('Updated successfully', 'success');
            }
            
            else{
                myalert('unknown error', 'error');
            }

        }).catch(e=>{
            console.log(e)
            setisLoading(false)
        })
        
    }

    function afterOpenModal() {
        // references are now sync'd and can be accessed.
        // subtitle.style.color = '#f00';
    }

    function closeModal() {
        setIsOpen(false);
    }

    const handleShow = (evt) => {

        console.log(evt)

        setUpdatesubject({
            ...updatesubject,
          subjectname: evt.subjectname,
          classid: evt.classid,
          subjecttype: evt.subjecttype,
          sectionid:evt.sectionid,
          subjectid:evt.id
        });

        setShow(true);
    }

    function handleChangeUpdateSubject(evt) {
        setUpdatesubject({
            ...updatesubject,
          [evt.target.name]: evt.target.value,
        });
    }

    function updateSubjectCommand() {
        setShow(false);
        setisLoading(true)
        axios.post('/editsubject_sec', updatesubject, {
            headers:{
                "Content-type": "application/json"
            }
        } ).then(response=>{
            if (response.status == 200) {
                myalert('Subject updated successfully', 'success');
                fetchSchoolDetails()
            }
            console.log(response)
        }).catch(e=>{
            console.log(e)
            myalert('Unknown Error', 'error');
            setisLoading(false)
        })
    }

    function deleteSubjectCommand() {
        setShow(false);
        setisLoading(true)
        axios.post('/deletesubject_sec', updatesubject, {
            headers:{
                "Content-type": "application/json"
            }
        } ).then(response=>{
            if (response.status == 200) {
                myalert('Subject deleted successfully', 'success');
                fetchSchoolDetails()
            }
            console.log(response)
        }).catch(e=>{
            console.log(e)
            myalert('Unknown Error', 'error');
            setisLoading(false)
        })
    }

    return(
        <div className="">

            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4', zIndex:'1000' }}>

            </div>:""}

            <div>
                <div className='alert alert-info'>
                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>Add subjects for each class and section. Click on settings to set the number of electives allowed for each class</i>
                </div>
                <button className="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-default">Add subject</button>
                <button style={{ marginLeft:'5px' }} className="btn btn-sm btn-warning" data-toggle="modal" data-target="#addelectivesmodal">Settings</button>
            </div>

            {isLoading ? <div className="text-center">
                <div className="spinner-border"></div>
            </div>:''}

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
                                <input type="number" onChange={(e)=>handleChangeExamsFull(e)} value={examsmark} placeholder="Exams mark" className="form-control form-control-sm" />
                            </div>:""}
                            { ca1status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" onChange={(e)=>handleChangeCa1Full(e)} value={ca1mark} placeholder="CA1" className="form-control form-control-sm" />
                            </div>:""}
                            {ca2status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="CA2" onChange={(e)=>handleChangeCa2Full(e)} value={ca2mark} className="form-control form-control-sm" />
                            </div>:""}
                            {ca3status == 1 ? <div className="col-12 col-md-3">
                                <input type="number" placeholder="CA3" onChange={(e)=>handleChangeCa3Full(e)} value={ca3mark} className="form-control form-control-sm" />
                            </div>:""}
                        </div>
                        <div style={{ margin:'0px 0px 10px 10px' }}>
                            <button onClick={updateScoresOrAdd} className="btn btn-sm btn-info badge">Save</button>
                        </div>
                    </div>
                </div>


            <div>
                {/* <div className="col-12"> */}
                    {/* <div className="card"> */}
                    {/* <div className="card-header">
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
                    </div> */}
                    <br />
                    <div className="alert alert-warning">
                        <i>Note: subject type 2 core, 1 elective</i>
                    </div>
                    <div className="row">
                        <div className="col-12 col-md-4">
                            <div className="form-group">
                                <input type="text" placeholder="Search subjects" onChange={(e) => setSearch(e.target.value)} className="form-control form-control-sm" />
                            </div>
                        </div>
                    </div>

                    <DataTable
                        title="Subject List"
                        columns={columns}
                        data={filteredSubjects}
                        paginationTotalRows={filteredSubjects.length}
                        pagination={true}
                        Clicked
                        onRowClicked={handleShow}
                    />  

                    <br />
                    
                    {/* <div className="card-body table-responsive p-0"> */}
                        {/* <table className="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Class</th>
                                <th>Subject Type</th>
                                <th>Section</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody> */}
                            {/* {filteredSubjects.length > 0 ? 
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
                            } */}

            


                        {/* </tbody>
                        </table> */}
                    {/* </div> */}
                  
                    {/* </div> */}
                
                {/* </div> */}
            </div>

                {/* <DataTablePage subjectdata={allsubjects}/> */}
               

            </div>

            {/* <div className="container">
                <Modal
                    ariaHideApp={false}
                    isOpen={modalIsOpen}
                    onAfterOpen={afterOpenModal}
                    onRequestClose={closeModal}
                    style={customStyles}
                    contentLabel="Example Modal">
                    
                    <form action="">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <label htmlFor="">Subject name</label>
                                    <input type="text" name="subjectname" value={setUpdatesubject.subjectname} className="form-control form-control-sm" />
                                </div>
                            </div>
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <label htmlFor="">Section/Arm</label>
                                    <select onChange={handleChangeSection} className="form-control form-control-sm">
                                        <option value="">Select Arm</option>
                                        { schoolsection.map(d=>(
                                            <option value={d.id}>{d.sectionname}</option>
                                        ))}
                                        <option value="General">General</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="form-group">
                                    <label htmlFor="">Class</label>
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
                                    <label htmlFor="">Subject Type</label>
                                    <select onChange={(e)=>handleChangeSubjectType(e)} className="form-control form-control-sm">
                                        <option value="">Subject type</option>
                                        <option value="1">Elective</option>
                                        <option value="2">Core</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button className="btn btn-sm btn-danger" style={{ borderRadius:'0px' }}>Delete</button>
                            <button className="btn btn-sm btn-info" style={{ borderRadius:'0px' }}>Update</button>
                        </div>
                    </form>

                </Modal>
            </div> */}


            <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                <Modal.Title>Update Subject</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="alert alert-info">
                        <i style={{ fontStyle:'normal', fontSize:'13px' }}>Note: Subject name can be edited at all times, however, other details can't be edited once student record for the subject has been recorded.</i>
                    </div>
                    <div>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Subject name</label>
                                        <input type="text" name="subjectname" onChange={handleChangeUpdateSubject} defaultValue={updatesubject.subjectname} className="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Section/Arm</label>
                                        <select onChange={handleChangeUpdateSubject} defaultValue={updatesubject.sectionid} className="form-control form-control-sm">
                                            <option value="">Select Arm</option>
                                            { schoolsection.map(d=>(
                                                <option value={d.id}>{d.sectionname}</option>
                                            ))}
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Class</label>
                                        <select onChange={handleChangeUpdateSubject} name="classid" defaultValue={updatesubject.classid} className="form-control form-control-sm">
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
                                <input type="hidden" name="subjectid" defaultValue={updatesubject.subjectid} />
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="">Subject Type</label>
                                        <select onChange={handleChangeUpdateSubject} name="subjectype" defaultValue={updatesubject.subjecttype} className="form-control form-control-sm">
                                            <option value="">Subject type</option>
                                            <option value="1">Elective</option>
                                            <option value="2">Core</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                <Button variant="secondary" className="btn-sm" onClick={handleClose}>
                    Close
                </Button>
                <Button variant="primary" className="btn-sm btn-info" onClick={updateSubjectCommand}>
                    Update Changes
                </Button>
                <Button variant="primary" className="btn-sm btn-danger" onClick={deleteSubjectCommand}>
                    Delete
                </Button>
                </Modal.Footer>
            </Modal>


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
                        <button onClick={addSubjectsMain} type="button" data-dismiss="modal" className="btn btn-info btn-sm">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="addelectivesmodal" data-backdrop="false">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Set No. of Electives</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <select onChange={(e)=>handleClassChangeEllectives(e)} name="" id="" className="form-control form-control-sm">
                                            <option value="">Select a Class</option>
                                            {classlist.length > 0 ? classlist.map(d => (
                                                <option key={d.id+"classlistellectives"} value={d.id}>{d.classname}</option>
                                            ))
                                            :
                                            <option value=""></option>
                                            }
                                        </select>
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <select onChange={(e)=>handleSectionChangeEllectives(e)} name="" id="" className="form-control form-control-sm">
                                            <option value="">Select a Select</option>
                                            { schoolsection.map(d=>(
                                                <option key={d.id+"electivessection"} value={d.id}>{d.sectionname}</option>
                                            ))}
                                        </select>
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="" style={{ fontSize:'10px' }}>No. of allowed ellectives</label>
                                        <input onChange={(e)=>handleNumberEllectivesChangeEllectives(e)} type="number" className="form-control form-control-sm" placeholder="No. of allowed ellectives"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="" style={{ height:'300px', overflowY:'scroll' }}>
                            {getElectivesSettingNumber.map(d=>(
                                <div  className="card" style={{ width:'95%', margin:'5px' }}>
                                    <i style={{ marginLeft:'5px', fontStyle:'normal', }}>{d.classname}{d.sectionname}</i><i style={{ marginLeft:'5px', fontStyle:'normal', }}>No. of allowed electives ({d.number_ellectives})</i>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button onClick={addNumberOfEllectives} type="button" className="btn btn-info btn-sm">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>






        </div>
    );



}

export default AddSubject;