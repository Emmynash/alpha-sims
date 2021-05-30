import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'


function AddMarks() {


    const [classlist, setClasslist] = useState([])
    const [subjects, setSubjects] = useState([])
    const [schoolsection, setschoolsection] = useState([])
    const [schoolschool, setschoolsession] = useState('')
    const [schoolterm, setschoolterm] = useState(0)
    const [selectedClass, setSelectedClass] = useState('')
    const [selectedsubject, setselectedsubject] = useState('')
    const [selectedsection, setselectedsection] = useState('')
    const [studentlist, setStudentList] = useState([])
    const alert = useAlert()
    
    const [examsscore, setexamsscore] = useState(0)
    const [ca1score, setca1score] = useState(0)
    const [ca2score, setca2score] = useState(0)
    const [ca3score, setca3score] = useState(0)

    const [studentId, setStudentId] = useState('')
    const [markid, setmarkid] = useState('')

    const [examsstatus, setexamsstatus] = useState(0)
    const [ca1status, setca1status] = useState(0)
    const [ca2status, setca2status] = useState(0)
    const [ca3status, setca3status] = useState(0)

    const [examsmark, setExamsMark] = useState(0)
    const [ca1mark, setCa1Mark] = useState(0)
    const [ca2mark, setCa2Mark] = useState(0)
    const [ca3mark, setCa3Mark] = useState(0)


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

        axios.get('/get_school_basic_details').then(response=> {
            console.log(response);
            // console.log(setJ)
            setClasslist(response.data.classlist)
            // setSubjects(response.data.subjects)
            // setschoolsection(response.data.schoolsection)
            setschoolsession(response.data.schooldetails.schoolsession)
            setschoolterm(response.data.schooldetails.term)

            setexamsstatus(response.data.schooldetails.exams)
            setca1status(response.data.schooldetails.ca1)
            setca2status(response.data.schooldetails.ca2)
            setca3status(response.data.schooldetails.ca3)

            if (response.data.subjectScore == null) {
                setExamsMark(0)
                setCa1Mark(0)
                setCa2Mark(0)
                setCa3Mark(0)
            }else{
                setExamsMark(response.data.subjectScore.examsfull)
                setCa1Mark(response.data.subjectScore.ca1full)
                setCa2Mark(response.data.subjectScore.ca2full)
                setCa3Mark(response.data.subjectScore.ca3full)
            }


        }).catch(e=>{
            console.log(e);
        });

    } 

    function fetchSubjectForClass(e){
        setSelectedClass(e.target.value)
        getSubjectForClass(e.target.value)
    }

    function handleChangeSubject(e) {
        setselectedsubject(e.target.value)
        getSection(e.target.value)
    }

    function handleChangeSection(e) {
        setselectedsection(e.target.value)
    }

    function handleChangeTerm(e) {
        setschoolterm(e.target.value)
    }

    function handleChangeSession(e) {
        setschoolsession(e.target.value)
    }

    function getSubjectForClass(classid){
        setSubjects([])
        axios.get('/fetch_students_marks/'+classid).then(response=> {
            console.log(response);
            // console.log(setJ)
            // setClasslist(response.data.classlist)
            setSubjects(response.data.subjectlist)

        }).catch(e=>{
            console.log(e);
        });

    }

    function getSection(subjectid){
        setschoolsection([])
        axios.get('/fetch_student_sections/'+subjectid).then(response=> {
            console.log(response);
            // console.log(setJ)
            // setClasslist(response.data.classlist)
            if (response.data.schoolsection == "notallocatedtoyou") {
                myalert('Subject not allocated to you', 'error')
            }else{
                setschoolsection(response.data.schoolsection)
            }
            


        }).catch(e=>{
            console.log(e);
        });

    }

    function fetchAllStudentInClass(){
        const data = new FormData()
        data.append("selected_class", selectedClass)
        data.append("selected_subject", selectedsubject)
        data.append("selected_term", schoolterm)
        data.append('currentsession', schoolschool)
        data.append('selected_section', selectedsection)
        axios.post("/fetch_subject_student_details", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setStudentList(response.data.studentlist)


        }).catch(e=>{
            console.log(e)

        })
    }

    function addStudentMarksModal(exams, ca1, ca2, ca3, studentId, markid) {

        if(exams == null){
            setexamsscore(0)
        }else{
            setexamsscore(exams)
        }

        if(ca1 == null){
            setca1score(0)
        }else{
            setca1score(ca1)
        }

        if(ca2 == null){
            setca2score(0)
        }else{
            setca2score(ca2)
        }

        if(ca3 == null){
            setca3score(0)
        }else{
            setca3score(ca3)
        }
        
        setStudentId(studentId)
        setmarkid(markid)
        
    }

    function closeModal() {
        setexamsscore(0)
        setca1score(0)
        setca2score(0)
        setca3score(0)
    }


    function handleChangeExams(e) {

        if (e.target.value > examsmark) {
            setexamsscore(0)
        }else{
            setexamsscore(e.target.value)
        }
    }

    function handleChangeCa1(e) {

        if (e.target.value > ca1mark) {
            setca1score(0)
        }else{
            setca1score(e.target.value)
        }
    }

    function handleChangeCa2(e) {

        if (e.target.value > ca2mark) {
            setca2score(0)
        }else{
            setca2score(e.target.value)
        }

    }

    function handleChangeCa3(e) {

        if (e.target.value > ca3mark) {
            setca3score(0)
        }else{
            setca3score(e.target.value)
        }
    }


    function addStudentMarks(){
        const data = new FormData()
        data.append("classidmain", selectedClass)
        data.append("currentsessionform", schoolschool)
        data.append("currentterm", schoolterm)
        data.append('studentregno', studentId)
        data.append('subjectid', selectedsubject)
        data.append("examsmarksentered", examsscore)
        data.append("ca1marksentered", ca1score)
        data.append("ca2marksentered", ca2score)
        data.append('ca3marksentered', ca3score)
        data.append('markidstudent', markid)
        data.append('studentsection', selectedsection)
        axios.post("/add_marks_main", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            // setStudentList(response.data.studentlist)
            fetchAllStudentInClass()


        }).catch(e=>{
            console.log(e)

        })
    }


    return(
        <div>
            <div className="card">
                <div className="row" style={{ margin:'10px' }}> 
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e)=>fetchSubjectForClass(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Class</option>
                                {classlist.map(classlistsingle=>(
                                    <option key={classlistsingle.id} value={classlistsingle.id}>{classlistsingle.classname}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e)=>handleChangeSubject(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Subject</option>
                                    {subjects.map(subject=>(
                                        <option key={subject.id} value={subject.id}>{subject.subjectname}</option>
                                    ))}
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e)=>handleChangeTerm(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Term</option>
                                <option value="1" selected={schoolterm == 1 ? "selected":""}>First</option>
                                <option value="2" selected={schoolterm == 2 ? "selected":""}>Second</option>
                                <option value="3" selected={schoolterm == 3 ? "selected":""}>Third</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e)=>handleChangeSection(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Section</option>
                                { schoolsection.length > 0 ?  schoolsection.map(sectionsingle=>(
                                    <option key={sectionsingle.id} value={sectionsingle.id}>{sectionsingle.sectionname}</option>
                                )):""}
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input type="text" onChange={(e)=>handleChangeSession(e)} value={schoolschool} className="form-control form-control-sm" placeholder="Session"/>
                        </div>
                    </div>
                </div>
                <div style={{ margin:'0px 0px 10px 10px' }}>
                    <button onClick={fetchAllStudentInClass} className="btn btn-sm btn-info">Submit</button>
                </div>
            </div>

           {studentlist.length > 0 ? <div>
                    <button onClick={fetchAllStudentInClass} className="btn btn-info btn-sm">Click to refresh Student List</button>
                    <div className="row">
                        <div className="col-12">
                            <div className="card">
                            <div className="card-header">
                                <h3 className="card-title">Students {examsstatus}</h3>
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
                            {/* /.card-header */}
                            <div className="card-body table-responsive p-0">
                                <table className="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                    <th>Name</th>
                                    <th>Admission No</th>
                                    <th>Roll No</th>
                                    <th>Exams</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>CA3</th>
                                    <th>Total</th>
                                    <th>Position</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {studentlist.map(student=>(
                                        <tr key={student.id+"addmarks"}>
                                            <td>{student.firstname} {student.middlename} {student.lastname}</td>
                                            <td>{student.admission_no}</td>
                                            <td>{student.renumberschoolnew}</td>
                                            <td>{student.exams == 0 ? "---":student.exams}</td>
                                            <td>{student.ca1 == 0 ? "---":student.ca1}</td>
                                            <td>{student.ca2 == 0 ? "---":student.ca2}</td>
                                            <td>{student.ca3 == 0 ? "---":student.ca3}</td>
                                            <td>{student.totalmarks}</td>
                                            <td>{student.position}</td>
                                            <td>{student.grades}</td>
                                            <td>
                                                <button onClick={()=>addStudentMarksModal(student.exams, student.ca1, student.ca2, student.ca3, student.id, student.markid)} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    ))}
                                    

                                </tbody>
                                </table>
                            </div>
                            {/* /.card-body */}
                            </div>
                            {/* /.card */}
                        </div>
                    </div>

                    <div className="modal fade" id="add_student_marks" data-backdrop="false">
                        <div className="modal-dialog">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h4 className="modal-title">Enter Student Scores</h4>
                                    <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div className="row">
                                            {examsstatus == 1 ? <div className="col-12 col-md-6">
                                                <label htmlFor="">Exams Fullmark({examsmark})</label>
                                                <input type="number" onChange={(e)=>handleChangeExams(e)} className="form-control form-control-sm" value={examsscore} placeholder="exams scrore" />
                                            </div>:""}
                                            {ca1status == 1 ? <div className="col-12 col-md-6">
                                                <label htmlFor="">Ca1 Fullmark({ca1mark})</label>
                                                <input type="number" onChange={(e)=>handleChangeCa1(e)} className="form-control form-control-sm" value={ca1score} placeholder="ca1" />
                                            </div>:""}
                                    </div>
                                    <br/>
                                    <div className="row">
                                        {ca2status == 1 ? <div className="col-12 col-md-6">
                                            <label htmlFor="">Ca2 Fullmark({ca2mark})</label>
                                            <input type="number" onChange={(e)=>handleChangeCa2(e)} className="form-control form-control-sm" value={ca2score} placeholder="ca2" />
                                        </div>:""}
                                        {ca3status == 1 ? <div className="col-12 col-md-6">
                                            <label htmlFor="">Ca3 Fullmark({ca3mark})</label>
                                            <input type="number" onChange={(e)=>handleChangeCa3(e)} className="form-control form-control-sm" value={ca3score} placeholder="ca3" />
                                        </div>:""}
                                    </div>
                                </div>
                                <div className="modal-footer justify-content-between">
                                    <button onClick={closeModal} type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                                    <button onClick={addStudentMarks} type="button" className="btn btn-info btn-sm">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        
          
            </div>:<div className="card">
                        <div className="text-center">
                            <p>Nothing to show</p>
                        </div>
                </div>}
        </div>
    )
    
}

export default AddMarks;