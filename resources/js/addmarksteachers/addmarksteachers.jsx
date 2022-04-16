import Axios from 'axios';
import React, { useState } from 'react';
import { useEffect } from 'react';
import { Button, Modal, Footer, Header } from 'react-bootstrap';
import './style.css';
import { useAlert } from 'react-alert'


function AddMarksTeachers() {

    const [show, setShow] = useState(false);
    const [studentlist, setStudentList] = useState([])
    const [subjectlist, setSubject] = useState([])
    const alert = useAlert()
    const [isLoading, seIsLoading] = useState(false)
    const [examsscore, setexamsscore] = useState(0)
    const [ca1score, setca1score] = useState(0)
    const [ca2score, setca2score] = useState(0)
    const [ca3score, setca3score] = useState(0)
    const [assessment, setSchoolAssessments] = useState([])
    const [fetchingSubassessment, setfetchingSubassessment] = useState(false);
    const [subassessment, setSchoolSubAssessments] = useState([])

    const [studentId, setStudentId] = useState('')
    const [recordArray, setRecordArray] = useState([])
    const [marksUpdated, setMarksUpdated] = useState(false);
    

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
    const [loadingRecords, setLoadingEnteredRecords] = useState(true);
    const [recordentered, setRecordEntered] = useState([])
    const [assessmentRecord, setAssessmentRecord] = useState({
        student_id: '',
        scrores: '',
        subjectid: '',
        section_id: '',
        class_id: '',
        assesment_id: '',
        subassessment_id: ''
    })

    const handleClose = () => setShow(false);

    useEffect(() => {
        if (!marksUpdated) {

            fetchSchoolDetails();
            
        } else {
            fetchAllStudentInClass(selectedScoreObject);
        }
        setMarksUpdated(false);

        return () => {
            // cleanup
        };
    }, [marksUpdated, selectedScoreObject]);


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

    function fetchAllStudentInClass(evt) {
        // seIsLoading(true)
        setAssessmentRecord({
            ...assessmentRecord,
            ['subjectid']: evt.subject_id,
            ['section_id']: evt.section_id,
            ['class_id']: evt.classid
        });

        const data = new FormData()
        data.append("selected_class", evt.classid)
        data.append("selected_subject", evt.subject_id)
        data.append("selected_term", evt.term)
        data.append('currentsession', evt.schoolsession)
        data.append('selected_section', evt.section_id)


        axios.post("/fetch_subject_student_details", data, {
            headers: {
                "Content-type": "application/json"
            }
        }).then(response => {
            console.log(response)
            // seIsLoading(false)
            if (response.data.response == "felids") {
                // myalert('All fields required', 'error')
            } else {
                // myalert('success', 'success')
                setStudentList(response.data.studentlist)
            }


        }).catch(e => {
            console.log(e)
            // seIsLoading(false)
        })
    }

    function fetchTeachersSubject() {

        axios.get('/sec/teacher/get_teacher_subject').then(response => {

            console.log(response)

            setSubject(response.data.response)

        }).catch(e => {

            console.log(response)

        })

    }

    function closeModal() {
        setexamsscore(0)
        setca1score(0)
        setca2score(0)
        setca3score(0)
    }


    function fetchSchoolDetails() {
        seIsLoading(true)
        axios.get('/get_school_basic_details').then(response => {
            console.log("dsdsdsdsdsd " + response);

            // console.log(setJ)
            seIsLoading(false)
            // setClasslist(response.data.classlist)
            // setSubjects(response.data.subjects)
            setschoolsection(response.data.schoolsection)
            setschoolsession(response.data.schooldetails.schoolsession)
            setschoolterm(response.data.schooldetails.term)
            setSchoolAssessments(response.data.assessment)
            fetchTeachersSubject()

        }).catch(e => {
            console.log("error fetching " + e);
            seIsLoading(false)
        });

    }

    function clearScoreField() {

        setAssessmentRecord({
            ...assessmentRecord,
            ['scrores']: '',
        });

    }

    function handleChangeScrores(e) {

        setAssessmentRecord({
            ...assessmentRecord,
            ['scrores']: e.target.value,
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

    function addStudentMarksModal(studentId) {
        setAssessmentRecord({
            ...assessmentRecord,
            ['student_id']: studentId, 
        });
    }

    function getSubAssessmentCat(student_id) {

        document.getElementById("scores_form").reset();

        setfetchingSubassessment(true)

        setStudentId(student_id)
        setRecordArray([])

        axios.get('/fetchsubassessment/' + student_id + '/' + selectedsubject).then(response => {

            console.log(response.data)

            setfetchingSubassessment(false)

            setSchoolSubAssessments(response.data.subassessment)

        }).catch(e => {
            console.log(e)
            setfetchingSubassessment(false)
        })

    }

    function addmarksModal(subcat) {

        setAssessmentRecord({
            ...assessmentRecord,
            ['subassessment_id']: subcat,
        });

    }

    function addStudentScore() {

        axios.post("/add_student_scores", recordArray, {
            headers: {
                "Content-type": "application/json"
            }
        }).then(response => {

            console.log(response)

            if (response.data.code == 409) {
                myalert(response.data.response, 'error')
            } else if (response.data.code == 200) {
                setMarksUpdated(true)
                myalert(response.data.response, 'success')
            }

        }).catch(error => {
            console.log(error)
        })

    }

    function getScoreRecord(userid) {

        setLoadingEnteredRecords(true);

        const data = new FormData()
        data.append("selected_class", selectedClass)
        data.append("selected_subject", selectedsubject)
        data.append("selected_term", schoolterm)
        data.append('currentsession', schoolschool)
        data.append('selected_section', selectedsection)
        data.append('userid', userid)
        axios.post("/get_student_scores", data, {
            headers: {
                "Content-type": "application/json"
            }
        }).then(response => {
            console.log(response.data.code)

            setLoadingEnteredRecords(false);

            if (response.data.code == 200) {
                setRecordEntered(response.data.response)
            }

        }).catch(e => {
            console.log(e)
            seIsLoading(false)
            setLoadingEnteredRecords(false);
        })

    }

    const onChangeScores = (fieldId, data, markMax) => {

        let studentRecord = {
            "subAssId": fieldId,
            "score": data,
            "classId": selectedClass,
            "subjectId": selectedsubject,
            "studentId": studentId,
            "sectionId": selectedsection
        }

        for (let index = 0; index < recordArray.length; index++) {
            const element = recordArray[index];

            console.log(element)

            if (element.subAssId == fieldId) {

                recordArray.splice(index, 1);

            }

            if (element.score == '') {
                recordArray.splice(index, 1);
            }
        }

        console.log(markMax)

        // if(parseInt(studentRecord.score) <= parseInt(markMax)){
        if (studentRecord.score != '') {
            recordArray.push(studentRecord)
            setRecordArray(recordArray)
            console.log(recordArray)
        }
        // }
    }

    const removePoints = (score) => {

        if (score != null) {
            const scoreArray = score.split(".");
            if (parseInt(scoreArray[1]) > 0) {
                return score;
            } else {
                return scoreArray[0];
            }
        } else {
            return ""
        }

    }

    return (
        <div>

            {isLoading ? <div style={{ zIndex: '1000', position: 'absolute', top: '0', bottom: '0', left: '0', right: '0', background: 'white', opacity: '0.4' }}>

            </div> : ""}
            {isLoading ? <div>
                <div className="text-center">
                    <div className="spinner-border"></div>
                </div>
            </div> : ""}

            <div className="card">
                <i style={{ fontStyle: 'normal', fontSize: '14px', padding: '10px' }}>List of assigned classes.</i>
            </div>
            {
                subjectlist.map(d => (

                    <div key={d.id + "subj"} className="card">
                        <div className="card-body">
                            <i style={{ fontStyle: 'normal', fontSize: '14px', padding: '5px' }}>{d.subjectname}</i>
                            <i style={{ fontStyle: 'normal', fontSize: '14px', padding: '5px' }}>{d.classname}{d.sectionname}</i>
                        </div>
                        <div className="card-footer">
                            <button className="btn btn-sm btn-info" onClick={() => getStudentForMarks(d)} data-toggle="modal" data-target="#modal-addmarks">Click to add Scores</button>
                        </div>
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
                    </div> : ""}

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
                                    <th>Total</th>
                                    <th>Position</th>
                                    <th>Grade</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>

                                {
                                    filteredUsers.map(d => (
                                        d != null ?
                                            <tr key={d.id + "subjectsstudents"}>
                                                <td>{capitalize(d.firstname + " " + d.middlename + " " + d.lastname)}</td>
                                                <td>{d.admission_no}</td>
                                                <td>{removePoints(d.totals)}</td>
                                                <td>{d.position}</td>
                                                <td>{d.grade}</td>
                                                <td><button onClick={() => addStudentMarksModal(d.id)} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button></td>
                                            </tr>
                                            : ""
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
                            </div> : ""}

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
                                            <th>Total</th>
                                            <th>Position</th>
                                            <th>Grade</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {
                                            filteredUsers.map(d => (
                                                <tr key={d.id + "subjectsstudentss"}>
                                                    <td>{capitalize(d.firstname + " " + d.middlename + " " + d.lastname)}</td>
                                                    <td>{d.admission_no}</td>
                                                    <td>{removePoints(d.totals)}</td>
                                                    <td>{d.position}</td>
                                                    <td>{d.grade}</td>
                                                    <td><button onClick={() => getSubAssessmentCat(d.id)} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button> <button onClick={() => getScoreRecord(d.id)} className="btn btn-sm btn-warning" data-toggle="modal" data-target="#view_single_student_result"><i className="fas fa-eye"></i></button></td>
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






            <div className="modal fade" id="add_student_marks" data-backdrop="false">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Enter student marks</h4>
                            <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <form id='scores_form'>
                                <div className="row">

                                    {
                                        subassessment.map(d => (
                                            <div key={d.assessment.id + "subassessment"} className="col-12 col-md-12">
                                                <div>
                                                    <div className="card" onClick={() => getSubAssessmentCat(d.id)}>
                                                        <i style={{ fontStyle: 'normal', fontSize: '13px', padding: '5px' }}>{d.assessment.name}({d.assessment.maxmark})</i>
                                                    </div>

                                                    {
                                                        d.subassessment.map((ass) =>
                                                            <div key={ass.id + "subass"} className='form-group'>
                                                                <input className='form-control form-control-sm' type='number' step=".01" onChange={(e) => onChangeScores(ass.id, e.target.value, ass.maxmark)} name={ass.subname} placeholder={ass.scrores ?? ass.subname} max={ass.maxmarks} />
                                                            </div>)
                                                    }


                                                </div>
                                            </div>

                                        ))
                                    }

                                </div>
                            </form>

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button onClick={closeModal} type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                            <button onClick={addStudentScore} type="button" className="btn btn-default" data-dismiss="modal">Save</button>
                        </div>
                    </div>
                </div>
            </div>



            <div className="modal fade" id="add_student_marks_sub_main" data-backdrop="false">
                <div className="modal-dialog modal-sm">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Enter Student Scores</h4>
                            <button onClick={clearScoreField} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">

                            <div className="form-group">
                                <input className="form-control form-control-sm" name="scrores" value={assessmentRecord.scrores} onChange={handleChangeScrores} placeholder="Enter score" />
                            </div>
                            <div className="form-group">
                                <button className="btn badge badge-info" onClick={addStudentScore}>Save</button>
                            </div>

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button onClick={closeModal} type="button" onClick={clearScoreField} className="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="view_single_student_result" data-backdrop="false">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Result recorded</h4>
                            <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">

                            <div className="card-body table-responsive p-0">
                                <table className="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Assessment</th>
                                            <th>Sub-Assessment</th>
                                            <th>Marks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {
                                            loadingRecords ? <tr><td>Loading...</td></tr> : recordentered.map(d => (
                                                <tr key={d.id + 'record'}>
                                                    <td>{d.name}</td>
                                                    <td>{d.subname}</td>
                                                    <td>{d.scrores}</td>
                                                </tr>
                                            ))
                                        }

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button onClick={closeModal} type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    )

}

export default AddMarksTeachers