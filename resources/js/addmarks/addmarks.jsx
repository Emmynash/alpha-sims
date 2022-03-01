import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { useEffect, useState } from 'react';
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
    const [studentListfiltered, setStudentListFiltered] = useState(studentlist)
    const [isLoading, seIsLoading] = useState(false)
    const alert = useAlert()
    const [assessment, setSchoolAssessments] = useState([])
    const [subassessment, setSchoolSubAssessments] = useState([])
    const [fetchingSubassessment, setfetchingSubassessment] = useState(false);

    const [examsscore, setexamsscore] = useState(0)
    const [ca1score, setca1score] = useState(0)
    const [ca2score, setca2score] = useState(0)
    const [ca3score, setca3score] = useState(0)

    const [studentScoreMain, setStudentScoreMain] = useState([])
    const [recordArray, setRecordArray] = useState([])

    const [studentId, setStudentId] = useState('')
    const [ca1mark, setCa1Mark] = useState(0)
    const [ca2mark, setCa2Mark] = useState(0)
    const [recordentered, setRecordEntered] = useState([])
    const [loadingRecords, setLoadingEnteredRecords] = useState(true);

    const [assessmentRecord, setAssessmentRecord] = useState({
        student_id: '',
        scrores: '',
        subjectid: '',
        section_id: '',
        class_id: '',
        assesment_id: '',
        subassessment_id: ''
    })


    useEffect(() => {

        fetchSchoolDetails()

        return () => {
            // cleanup
        };
    }, []);

    const handleSearch = (event) => {

        let value = event.target.value.toLowerCase();
        let result = [];
        console.log(value);

        result = studentlist.filter((data) => {
            return data.firstname.toLowerCase().search(value) != -1;
        });

        setStudentListFiltered(result);

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

    function fetchSchoolDetails() {
        seIsLoading(true)
        axios.get('/get_school_basic_details').then(response => {
            console.log(response);
            // console.log(setJ)
            seIsLoading(false)
            setClasslist(response.data.classlist)
            // setSubjects(response.data.subjects)
            setschoolsection(response.data.schoolsection)
            setschoolsession(response.data.schooldetails.schoolsession)
            setschoolterm(response.data.schooldetails.term)
            setSchoolAssessments(response.data.assessment)

            setexamsstatus(response.data.schooldetails.exams)
            setca1status(response.data.schooldetails.ca1)
            setca2status(response.data.schooldetails.ca2)
            setca3status(response.data.schooldetails.ca3)

            if (response.data.subjectScore == null) {
                setExamsMark(0)
                setCa1Mark(0)
                setCa2Mark(0)
                setCa3Mark(0)
            } else {
                setExamsMark(response.data.subjectScore.examsfull)
                setCa1Mark(response.data.subjectScore.ca1full)
                setCa2Mark(response.data.subjectScore.ca2full)
                setCa3Mark(response.data.subjectScore.ca3full)
            }


        }).catch(e => {
            console.log(e);
            seIsLoading(false)
        });

    }

    function fetchSubjectForClass(e) {
        setStudentList([])
        setSubjects([])
        setSelectedClass(e.target.value)
        setselectedsection('')

        setAssessmentRecord({
            ...assessmentRecord,
            ['class_id']: e.target.value,
        });
    }

    function handleChangeSubject(e) {
        setselectedsubject(e.target.value)
        setStudentList([])
        // getSection(e.target.value)
    }

    function handleChangeSection(e) {

        setStudentList([])
        setSubjects([])
        setselectedsection(e.target.value)
        getSubjectForClass(e.target.value)
        setAssessmentRecord({
            ...assessmentRecord,
            ['section_id']: e.target.value,
        });
    }

    function handleChangeTerm(e) {
        setschoolterm(e.target.value)
    }

    function handleChangeSession(e) {
        setschoolsession(e.target.value)
    }

    function getSubjectForClass(sectionid) {
        setSubjects([])
        seIsLoading(true)

        axios.get('/fetch_students_marks/' + selectedClass + "/" + sectionid).then(response => {
            console.log("marks" + response);
            // console.log(setJ)
            // setClasslist(response.data.classlist)
            seIsLoading(false)
            setSubjects(response.data.subjectlist)

        }).catch(e => {
            console.log(e);
            seIsLoading(false)
        });

    }

    function getSection(subjectid) {
        setschoolsection([])
        seIsLoading(true)
        setNotAllocated(true)
        axios.get('/fetch_student_sections/' + subjectid).then(response => {
            console.log(response);
            // console.log(setJ)
            // setClasslist(response.data.classlist)
            seIsLoading(false)
            if (response.data.schoolsection == "notallocatedtoyou") {
                setNotAllocated(true)
                myalert('Subject not allocated to you', 'error')
            } else {
                setNotAllocated(false)
                setschoolsection(response.data.schoolsection)
            }

        }).catch(e => {
            console.log(e);
            seIsLoading(false)
        });

    }

    function fetchAllStudentInClass() {
        seIsLoading(true)

        setAssessmentRecord({
            ...assessmentRecord,
            ['subjectid']: selectedsubject,
        });

        const data = new FormData()
        data.append("selected_class", selectedClass)
        data.append("selected_subject", selectedsubject)
        data.append("selected_term", schoolterm)
        data.append('currentsession', schoolschool)
        data.append('selected_section', selectedsection)
        axios.post("/fetch_subject_student_details", data, {
            headers: {
                "Content-type": "application/json"
            }
        }).then(response => {
            console.log(response.data)
            seIsLoading(false)
            if (response.data.response == "feilds") {
                myalert('All fields required', 'error')
            } else {
                myalert('success', 'success')
                setStudentList(response.data.studentlist)
                setStudentListFiltered(response.data.studentlist)
            }


        }).catch(e => {
            console.log(e)
            seIsLoading(false)
        })
    }

    function addStudentMarksModal(studentId) {
        setAssessmentRecord({
            ...assessmentRecord,
            ['student_id']: studentId,
        });
    }

    function closeModal() {
        setexamsscore(0)
        setca1score(0)
        setca2score(0)
        setca3score(0)
    }


    function handleChangeScrores(e) {

        setAssessmentRecord({
            ...assessmentRecord,
            ['scrores']: e.target.value,
        });
    }

    function handleChangeCa1(e) {

        if (e.target.value > ca1mark) {
            setca1score(0)
        } else {
            setca1score(e.target.value)
        }
    }

    function handleChangeCa2(e) {

        if (e.target.value > ca2mark) {
            setca2score(0)
        } else {
            setca2score(e.target.value)
        }

    }

    function clearScoreField() {

        setAssessmentRecord({
            ...assessmentRecord,
            ['scrores']: '',
        });

    }


    function getSubAssessmentCat(student_id) {

        setfetchingSubassessment(true)

        setStudentId(student_id)
        setRecordArray([])

        axios.get('/fetchsubassessment/' + student_id).then(response => {

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

    // let recordArray = []

    const onChangeScores = (fieldId, data, markMax) => {



        let studentRecord = {
            "subAssId": fieldId,
            "score": data,
            "classId":selectedClass,
            "subjectId":selectedsubject,
            "studentId":studentId,
            "sectionId":selectedsection

        }

        for (let index = 0; index < recordArray.length; index++) {
            const element = recordArray[index];

            console.log(element)

            if (element.subAssId == fieldId) {

                recordArray.splice(index, 1);

                // recordArray.push(studentRecord)

            }

        }

        // if(studentRecord.score > markMax){
        //     myalert("error", 'error')
        // }else{
            recordArray.push(studentRecord)
            setRecordArray(recordArray)
            console.log(recordArray)
        // }

        
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
                <div className="row" style={{ margin: '10px' }}>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e) => fetchSubjectForClass(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Class</option>
                                {classlist.map(classlistsingle => (
                                    <option key={classlistsingle.id} value={classlistsingle.id}>{classlistsingle.classname}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e) => handleChangeSection(e)} name="" value={selectedsection} className="form-control form-control-sm" id="">
                                <option value="">Select a Section</option>
                                {selectedClass != "" ? schoolsection.length > 0 ? schoolsection.map(sectionsingle => (
                                    <option key={sectionsingle.id} value={sectionsingle.id}>{sectionsingle.sectionname}</option>
                                )) : "" : ""}
                                <option value="General">General</option>
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e) => handleChangeSubject(e)} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Subject</option>
                                {subjects.map(subject => (
                                    <option key={subject.id} value={subject.id}>{subject.subjectname}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <select onChange={(e) => handleChangeTerm(e)} value={schoolterm} name="" className="form-control form-control-sm" id="">
                                <option value="">Select a Term</option>
                                <option value="1" >First</option>
                                <option value="2" >Second</option>
                                <option value="3" >Third</option>
                            </select>
                        </div>
                    </div>

                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input type="text" onChange={(e) => handleChangeSession(e)} value={schoolschool} className="form-control form-control-sm" placeholder="Session" />
                        </div>
                    </div>
                </div>
                <div style={{ margin: '0px 0px 10px 10px' }}>
                    <button onClick={fetchAllStudentInClass} className="btn btn-sm btn-info">Submit</button>
                </div>
            </div>

            <div>
                <div className="row">
                    {
                        assessment.map(d => (
                            <div key={d.id + "assessment"} className="col-12 col-md-3">
                                <div className="card">
                                    <i style={{ padding: '5px', fontStyle: 'normal', fontSize: '13px' }}>{d.name}({d.maxmark})</i>
                                </div>
                            </div>
                        ))
                    }

                </div>
            </div>

            {studentlist.length > 0 ? <div>
                <button onClick={fetchAllStudentInClass} className="btn btn-info btn-sm">Click to refresh Student List</button>
                <div className="row">
                    <div className="col-12">
                        <div className="card">
                            <div className="card-header">
                                <h3 className="card-title">Students ({studentlist.length})</h3>
                                <div className="card-tools">
                                    <div className="input-group input-group-sm" style={{ width: '150px' }}>
                                        <input type="text" name="table_search" className="form-control float-right" placeholder="Search" onChange={(event) => handleSearch(event)} />
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
                                            {/* <th>Roll No</th> */}
                                            {/* <th>Exams</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>CA3</th> */}
                                            <th>Total</th>
                                            <th>Position</th>
                                            <th>Grade</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {studentListfiltered.map(student => (
                                            <tr key={student.id + "addmarks"}>
                                                <td>{student.firstname} {student.middlename} {student.lastname}</td>
                                                <td>{student.admission_no}</td>
                                                {/* <td>{student.renumberschoolnew}</td> */}
                                                {/* <td>{student.exams == 0 ? "---":student.exams}</td>
                                            <td>{student.ca1 == 0 ? "---":student.ca1}</td>
                                            <td>{student.ca2 == 0 ? "---":student.ca2}</td>
                                            <td>{student.ca3 == 0 ? "---":student.ca3}</td> */}
                                                <td>{student.totals}</td>
                                                <td>{student.position}</td>
                                                <td>{student.grade}</td>
                                                <td>
                                                    <button onClick={() => getSubAssessmentCat(student.id)} style={{ marginRight: '5px' }} className="btn btn-sm btn-info" data-toggle="modal" data-target="#add_student_marks"><i className="fas fa-plus"></i></button>

                                                    <button onClick={() => getScoreRecord(student.id)} className="btn btn-sm btn-warning" data-toggle="modal" data-target="#view_single_student_result"><i className="fas fa-eye"></i></button>
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
                    <div className="modal-dialog modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">Select score type</h4>
                                <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div className="modal-body">

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
                                                                <input className='form-control form-control-sm' onChange={(e) => onChangeScores(ass.id, e.target.value, ass.maxmark)} name={ass.subname} placeholder={ass.subname} max={ass.maxmarks}/>
                                                            </div>)
                                                    }

                                                </div>
                                            </div>

                                        ))
                                    }
                                </div>

                            </div>
                            <div className="modal-footer justify-content-between">
                                <button onClick={closeModal} type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                                <button onClick={addStudentScore} type="button" className="btn btn-default" data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>



                <div className="modal fade" id="add_student_marks_sub" data-backdrop="false">
                    <div className="modal-dialog modal-sm">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">Enter subject scores</h4>
                                <button onClick={closeModal} type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div className="modal-body">

                                {/* {
                                    fetchingSubassessment ? <p>Loading...</p> : <div className="row">
                                        {
                                            subassessment.map(d => (
                                                <div key={d.id + "subassessment2"} className="col-12 col-md-12">
                                                    <div className="card" data-toggle="modal" onClick={() => addmarksModal(d.id)} data-target="#add_student_marks_sub_main">
                                                        <i style={{ fontStyle: 'normal', fontSize: '13px', padding: '5px' }}>{d.subname}({d.maxmarks})</i>
                                                    </div>
                                                </div>
                                            ))
                                        }
                                    </div>
                                } */}



                            </div>
                            <div className="modal-footer justify-content-between">
                                <button onClick={closeModal} type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="modal fade" id="add_student_marks_sub_main" data-backdrop="false">
                    <div className="modal-dialog modal-sm">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">Enter subject scores</h4>
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
                                                loadingRecords ? <p>Loading...</p> : recordentered.map(d => (
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
                :

                <div className="card">
                    <div className="text-center">
                        <p>No Record found</p>
                    </div>
                </div>
            }
        </div>
    )

}

export default AddMarks;