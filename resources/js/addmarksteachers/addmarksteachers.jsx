import Axios from 'axios';
import React, {useState} from 'react';
import { useEffect } from 'react';
import { Button, Modal, Footer, Header } from 'react-bootstrap';
import './style.css';


function AddMarksTeachers() {

    const [show, setShow] = useState(false);
    const [studentlist, setStudentList] = useState([])
    const [subjectlist, setSubject] = useState([])
    const [examsstatus, setexamsstatus] = useState(0)
    const [ca1status, setca1status] = useState(0)
    const [ca2status, setca2status] = useState(0)
    const [ca3status, setca3status] = useState(0)

    const [studentId, setStudentId] = useState('')
    const [markid, setmarkid] = useState('')

    const [examsmark, setExamsMark] = useState(0)
    const [ca1mark, setCa1Mark] = useState(0)
    const [ca2mark, setCa2Mark] = useState(0)
    const [ca3mark, setCa3Mark] = useState(0)
    const [isLoading, seIsLoading] = useState(false)
    const [examsscore, setexamsscore] = useState(0)
    const [ca1score, setca1score] = useState(0)
    const [ca2score, setca2score] = useState(0)
    const [ca3score, setca3score] = useState(0)

    const [schoolsection, setschoolsection] = useState([])
    const [schoolschool, setschoolsession] = useState('')
    const [schoolterm, setschoolterm] = useState(0)
    const [selectedClass, setSelectedClass] = useState('')
    const [selectedsubject, setselectedsubject] = useState('')
    const [selectedsection, setselectedsection] = useState('')
    const [selectedScoreObject, setselectedScoreObject] = useState({})
    const [filteredUsers, setFilteredUsers] = useState([]);
    const [search, setSearch] = useState("");
    const [enteringfor, setenteringfor] = useState('')

    const handleClose = () => setShow(false);

    useEffect(() => {
        fetchSchoolDetails()
        return () => {
            // cleanup
        };
    }, []);

    useEffect(() => {
        setFilteredUsers(
            studentlist.filter((users) =>
          users.firstname.toLowerCase().includes(search.toLowerCase())
          )
        );
      }, [search, studentlist]);

    function getStudentForMarks(evt) {
        
        setFilteredUsers([])

        setselectedsubject(evt.subject_id)
        setSelectedClass(evt.classid)
        setselectedsection(evt.section_id)
        setselectedScoreObject(evt)
        // setShow(true);

        console.log(evt.classid)

        fetchAllStudentInClass(evt)
    }

    function fetchAllStudentInClass(evt){
        // seIsLoading(true)


        const data = new FormData()
        data.append("selected_class", evt.classid)
        data.append("selected_subject", evt.subject_id)
        data.append("selected_term", evt.term)
        data.append('currentsession', evt.schoolsession)
        data.append('selected_section', evt.section_id)

        
        axios.post("/fetch_subject_student_details", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            // seIsLoading(false)
            if (response.data.response == "feilds") {
                // myalert('All fields required', 'error')
            }else{
                // myalert('success', 'success')
                setStudentList(response.data.studentlist)
            }


        }).catch(e=>{
            console.log(e)
            // seIsLoading(false)
        })
    }

    function fetchTeachersSubject() {

        axios.get('/sec/teacher/get_teacher_subject').then(response=>{

            console.log(response)

            setSubject(response.data.response)

        }).catch(e=>{

            console.log(response)

        })
        
    }

    function addStudentMarksModal(exams, ca1, ca2, ca3, studentId, markid, name) {

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
        setenteringfor(name)
        
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
        seIsLoading(true)
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
            seIsLoading(false)
            getStudentForMarks(selectedScoreObject)


        }).catch(e=>{
            console.log(e)
            seIsLoading(false)
        })
    }

    function fetchSchoolDetails() {
        seIsLoading(true)
        axios.get('/get_school_basic_details').then(response=> {
            console.log("dsdsdsdsdsd "+response);
            
            // console.log(setJ)
            seIsLoading(false)
            // setClasslist(response.data.classlist)
            // setSubjects(response.data.subjects)
            setschoolsection(response.data.schoolsection)
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
            fetchTeachersSubject()

        }).catch(e=>{
            console.log("dsdsdsdsdsd "+e);
            seIsLoading(false)
        });

    } 

    const convertFirstCharacterToUppercase = (stringToConvert) => {
        var firstCharacter = stringToConvert.substring(0, 1);
        var restString = stringToConvert.substring(1);
      
        return firstCharacter.toUpperCase() + restString;
      }

    const capitalize = (s) => {
        var name = s.split(' ')
        var index = name.indexOf('null')

        if (index > -1) {
            name.splice(index, 1);
         }

        const convertedWordsArray = name.map(word => {
            return convertFirstCharacterToUppercase(word);
        });

        return convertedWordsArray.join(' ');
    }

    return(
        <div>

            {isLoading ? <div style={{ zIndex:'1000', position:'absolute', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4' }}>

            </div>:""}
            {isLoading ? <div>
                <div class="text-center">
                    <div class="spinner-border"></div>
                </div>
            </div>:""}

            <div className="card">
                <i style={{ fontStyle:'normal', fontSize:'14px', padding:'10px' }}>List of classes asigned to you. Click on any to add scrores.</i>
            </div>
            {
                subjectlist.map(d=>(

                    <div className="card" onClick={()=>getStudentForMarks(d)} data-toggle="modal" data-target="#modal-addmarks">
                        <i style={{ fontStyle:'normal', fontSize:'14px', padding:'5px' }}>{d.subjectname}</i>
                        <i style={{ fontStyle:'normal', fontSize:'14px', padding:'5px' }}>{d.classname}{d.sectionname}</i>
                    </div>

                ))
            }

            <Modal show={show} onHide={handleClose} size="xl" style={{ overflow: 'auto !important' }}>
                <Modal.Header closeButton>
                <Modal.Title>Enter Student Scores</Modal.Title>
                </Modal.Header>
                <Modal.Body>

                {isLoading ? <div>
                <div className="text-center">
                    <div className="spinner-border"></div>
                    </div>
                </div>:""}

                <div className="row">
                    <div className="col-12 col-md-3">
                        <input type="text" placeholder="Search by name" onChange={(e) => setSearch(e.target.value)} className="form-control form-control-sm" />
                    </div>
                </div>
                <div className="card-body table-responsive p-0">
                    <table className="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Admission No</th>
                        <th>Ca3</th>
                        <th>Ca2</th>
                        <th>Ca1</th>
                        <th>Exams</th>
                        <th>Total</th>
                        <th>Position</th>
                        <th>Grade</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {
                            filteredUsers.map(d=>(
                                d != null ? 
                                    <tr key={d.id+"subjectsstudents"}>
                                    <td>{capitalize(d.firstname+" "+d.middlename+" "+d.lastname)}</td>
                                    <td>{d.admission_no}</td>
                                    <td>{d.ca3 == 0 ? "---":d.ca3}</td>
                                    <td>{d.ca2}</td>
                                    <td>{d.ca1}</td>
                                    <td>{d.exams}</td>
                                    <td>{d.totalmarks}</td>
                                    <td>{d.position}</td>
                                    <td>{d.grades}</td>
                                    <td><button onClick={()=>addStudentMarksModal(d.exams, d.ca1, d.ca2, d.ca3, d.id, d.markid)} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button></td>
                                </tr>
                                :""
                            ))
                        }

                    </tbody>
                    </table>
                </div>




                </Modal.Body>
                <Modal.Footer>
                <Button variant="secondary" className="btn-sm" onClick={handleClose}>
                    Close
                </Button>
                {/* <Button variant="primary" className="btn-sm btn-info" onClick={updateSubjectCommand}>
                    Update Changes
                </Button> */}
                {/* <Button variant="primary" className="btn-sm btn-danger" onClick={deleteSubjectCommand}>
                    Delete
                </Button> */}
                </Modal.Footer>
            </Modal>


            <div className="modal fade" id="modal-addmarks" style={{ overflow: 'auto !important' }}>
            <div className="modal-dialog modal-xl">
                <div className="modal-content">
                <div className="modal-header">
                    <h4 className="modal-title">Enter Student Scores</h4>
                    <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div className="modal-body">
                    
                {isLoading ? <div>
                <div className="text-center">
                    <div className="spinner-border"></div>
                    </div>
                </div>:""}

                <div className="row">
                    <div className="col-12 col-md-3">
                        <input type="text" placeholder="Search by name" onChange={(e) => setSearch(e.target.value)} className="form-control form-control-sm" />
                    </div>
                </div>
                <div className="card-body table-responsive p-0">
                    <table className="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th>Name</th>
                        <th>Admission No</th>
                        <th>Ca3</th>
                        <th>Ca2</th>
                        <th>Ca1</th>
                        <th>Exams</th>
                        <th>Total</th>
                        <th>Position</th>
                        <th>Grade</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {
                            filteredUsers.map(d=>(
                                <tr key={d.id+"subjectsstudents"}>
                                    <td>{capitalize(d.firstname+" "+d.middlename+" "+d.lastname)}</td>
                                    <td>{d.admission_no}</td>
                                    <td>{d.ca3 == 0 ? "---":d.ca3}</td>
                                    <td>{d.ca2}</td>
                                    <td>{d.ca1}</td>
                                    <td>{d.exams}</td>
                                    <td>{d.totalmarks}</td>
                                    <td>{d.position}</td>
                                    <td>{d.grades}</td>
                                    <td><button onClick={()=>addStudentMarksModal(d.exams, d.ca1, d.ca2, d.ca3, d.id, d.markid, capitalize(d.firstname+" "+d.middlename+" "+d.lastname))} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button></td>
                                </tr>
                            ))
                        }

                    </tbody>
                    </table>
                </div>


                </div>
                <div className="modal-footer justify-content-between">
                    <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    {/* <button type="button" className="btn btn-primary">Save changes</button> */}
                </div>
                </div>
                {/* /.modal-content */}
            </div>
            {/* /.modal-dialog */}
            </div>
            {/* /.modal */}






            <div className="modal fade" id="add_student_marks" data-backdrop="false" style={{ zIndex:'8000', overflow: 'auto !important' }}>
                        <div className="modal-dialog">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h4 className="modal-title">Enter Student Scores</h4>
                                    <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    <div>
                                        <i style={{ fontSize:'14px', fontStyle:'normal' }}>{enteringfor}</i>
                                    </div>
                                    <br />
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
                                    <button onClick={closeModal} type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                    <button onClick={addStudentMarks} type="button" className="btn btn-info btn-sm">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>






        </div>
    )
    
}

export default AddMarksTeachers