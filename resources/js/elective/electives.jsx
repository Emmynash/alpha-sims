import axios from 'axios';
import React from 'react';
import { useState } from 'react';
import { useEffect } from 'react';
import { useAlert } from 'react-alert'
import Multiselect from 'multiselect-react-dropdown';

function Electives() {

    const [classlist, setClasslist] = useState([])
    const [electives, setElectives] = useState([])
    const alert = useAlert()
    const [isLoading, setisLoading] = useState(false)
    const [state, setState] = useState({
        options: [{name: 'Option 1️⃣', id: 1},{name: 'Option 2️⃣', id: 2}]
    })
    const [studentList, setStudentList] = useState({
        options: [],
    })

    const [dataToProcess, setDataToProcess] = useState({
        options: [],
        classid:'',
        subjectid:''
    })


    useEffect(() => {
        fetchTeacherClass()
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


    function fetchTeacherClass() {

        setisLoading(true)
        
        axios.get('/fetch_form_teacher_class').then(response=>{

            setisLoading(false)

            setClasslist(response.data.classlist)

            console.log(response)
        }).catch(e=>{
            setisLoading(false)
            console.log(e)
        })
    }

    function fetch_student_list(classSection) {


        setDataToProcess({
            ...dataToProcess,
            classid: classSection.target.value,
        });

        setisLoading(true)

        console.log(classSection.target.value)
        const data = new FormData()
        data.append("classSection", classSection.target.value)
        axios.post('/fetch_student_list', data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{

            console.log(response.data)

            setisLoading(false)

            setStudentList({
                ...studentList,
              options: response.data.getStudentList,
            });

            setElectives(response.data.subjects);

        }).catch(e=>{

            setisLoading(false)

            console.log(e)

        })
        
    }

    function onSelect(selectedList, selectedItem) {

        console.log(selectedList)

        setDataToProcess({
            ...dataToProcess,
          options: selectedList,
        });
        
    }
    
    function onRemove(selectedList, removedItem) {

        console.log(selectedList)

        setDataToProcess({
            ...dataToProcess,
          options: selectedList,
        });
        
    }

    function handleSubjectChange(e) {

        console.log(e.target.value)

        setDataToProcess({
            ...dataToProcess,
          subjectid: e.target.value,
        });
        
    }

    function asignSubjectElectivesMain() {

        setisLoading(true)

        axios.post('/asign_subject_main', dataToProcess, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{

            setisLoading(false)

            console.log(response)

            if(response.data.response == "success"){
                myalert("Success", "success")
            }else{
                myalert("Unknown Error", "error")
            }

            
        }).catch(e=>{

            setisLoading(false)

            console.log(e)

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

            <div className="alert alert-info">
                <i style={{ fontStyle:'normal' }}>Asign elective(s) to each student base on the students choice.</i>
            </div>
            <div>
                <div className="row">
                    <div className="col-12 col-md-6">
                        <div className="form-group">
                            <select name="" id="" onChange={(e)=>fetch_student_list(e)} className="form-control form-control-sm">
                                    <option value="">Select an option</option>
                                    {
                                        classlist.map(d=>(
                                            <option key={d.id+"sectionaddelectives"} value={d.class_id+"-"+d.sectionid}>{d.classname}{d.sectionname}</option>
                                        ))
                                    }
                            </select>
                        </div>
                        <div className="form-group">
                            <select name="" id="" onChange={(e)=>handleSubjectChange(e)} className="form-control form-control-sm">
                                <option value="">Select an Elective</option>
                                {
                                    electives.map(d=>(
                                        <option key={d.id+"electivessubjects"} value={d.subjectid}>{d.subjectname}</option>
                                    ))
                                }
                            </select>
                        </div>
                        <div className="form-group">

                            <Multiselect
                                options={studentList.options} // Options to display in the dropdown
                                selectedValues={studentList.selectedValue} // Preselected value to persist in dropdown
                                onSelect={onSelect} // Function will trigger on select event
                                onRemove={onRemove} // Function will trigger on remove event
                                displayValue="admission_no" // Property name to display in the dropdown options
                                placeholder="Select student(s)"
                            />

                        </div>
                        <div className="form-group">
                            <button className="btn btn-info btn-sm" onClick={asignSubjectElectivesMain}>Query</button>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div>
                <div className="row">
                    <div className="col-12">
                        <div className="card">
                        <div className="card-header">
                            <h3 className="card-title">Student List</h3>
                            <div className="card-tools">
                            <div className="input-group input-group-sm" style={{width: '150px'}}>
                                {/* <input type="text" name="table_search" className="form-control float-right" placeholder="Search" /> */}
                                <div className="input-group-append">
                                {/* <button type="submit" className="btn btn-default">
                                    <i className="fas fa-search" />
                                </button> */}
                                </div>
                            </div>
                            </div>
                        </div>
                        {/* /.card-header */}
                        <div className="card-body table-responsive p-0">
                            <table className="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                <th>Admission No.</th>
                                <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>

                                {
                                    studentList.options.map(d=>(

                                        <tr>
                                            <td>{d.admission_no}</td>
                                            <td>{d.firstname} {d.middlename} {d.lastname}</td>
                                        </tr>

                                    ))
                                }

                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    )
    
}

export default Electives