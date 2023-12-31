import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { useEffect, useState } from 'react';
import { useAlert } from 'react-alert'

function Moto() {

    const [allClasses, setAllClasses] = useState([])
    const [section_sec, setSection_sec] = useState([])
    const [isLoading, setisLoading] = useState(false)
    const [selectedclass, setSelectedclass] = useState(0)
    const [selectedsection, setSelectedSection] = useState(0)
    const [studentlist, setstudentstudent] = useState([])
    const [motolist, setmotolist] = useState([])
    const [studentid, setstudentid] = useState(0)
    const [selectedmain, setselectedmain] = useState([])
    const [addedmoto, setaddedmoto] = useState([])
    const [takenarray, settakearray] = useState([])
    const [studentname, setstudentname] = useState('')
    const alert = useAlert()


    useEffect(() => {
        fetchPageDetails()
        return () => {
            // cleanup
        };
    }, []);

    function fetchPageDetails() {
        setisLoading(true)
        axios.get('/get_teacher_page_details_teachers').then(response => {
            console.log(response);
            // console.log(setJ)
            setisLoading(false)
            console.log('get assigned classes', response.data.formTeacherClasses);
            setAllClasses(response.data.formTeacherClasses)
            console.log('check assigned classes', allClasses);
            setSection_sec(response.data.addsection_sec)



        }).catch(e => {
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


    function handleChangeClass(e) {
        setSelectedclass(e.target.value)
    }

    function handleChangeSection(e) {
        setSelectedSection(e.target.value)
    }

    function getStudentList() {
        setisLoading(true)
        const data = new FormData()
        data.append("selectedclassmoto", selectedclass),
            data.append("selectedsectionmoto", selectedsection),
            axios.post("/moto/get_students_for_pyco", data, {
                headers: {
                    "Content-type": "application/json"
                }
            }).then(response => {
                setisLoading(false)
                console.log(response)

                if (response.status == 200) {
                    setstudentstudent(response.data.success)
                    setmotolist(response.data.motolist)
                    settakearray(response.data.atlist)
                } else {
                    console.log(response.data.error)
                }
            }).catch(e => {
                console.log(e)
                setisLoading(false)
            })
    }

    function setUserId(e, name) {
        setaddedmoto([])
        setselectedmain([])
        setstudentid(e)
        setstudentname(name)

        document.getElementById("moto_form").reset();

        // for (let index = 0; index < motolist.length; index++) {
        //     const element = motolist[index];



        // }
    }

    function addMoto(moto_id, valueId, userid) {
        var valuetoadd = setaddedmoto({
            moto_id: moto_id,
            valueSelected: valueId,
            userId: userid
        });

        for (let index = 0; index < selectedmain.length; index++) {
            const element = selectedmain[index];

            if (element["moto_id"] == moto_id) {
                selectedmain.splice(index, 1);
            }

        }

        setselectedmain(selectedmain => [...selectedmain, {
            moto_id: moto_id,
            valueSelected: valueId,
            userId: userid
        }]);

    }

    function submitMoto(e) { //
        e.preventDefault(); 
        setisLoading(true)
        console.log(selectedmain)
        axios.post("/moto/add_student_moto", selectedmain, {
            headers: {
                "Content-type": "application/json"
            }
        }).then(response => {
            console.log(response)
            setisLoading(false)
            if (response.data.response == "success") {
                myalert("Success", "success")
                getStudentList()
            } else {
                myalert("Ensure all felids are filled", "error")
            }

        }).catch(e => {
            console.log(e)
            setisLoading(false)
        })
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
            <button data-toggle="modal" data-target="#getstudents" className="btn btn-info btn-sm">Get Students</button>
            <hr />
            <div className="alert alert-warning">
                <i>Note: Psychomotor can be entered multiple times by clicking the Add/Completed button.</i>
            </div>
            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-header">
                            <h3 className="card-title">Student List</h3>
                            <div className="card-tools">
                                <div className="input-group input-group-sm" style={{ width: '150px' }}>
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
                                        <th>Admmission No.</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {studentlist.map(d => (
                                        <tr key={d.id + "mototable"}>
                                            <td>{d.admission_no}</td>
                                            <td>{d.firstname} {d.middlename} {d.lastname}</td>
                                            <td>{d.classname}{d.sectionname}</td>

                                            {takenarray.includes(d.id) ?
                                                <td><button className="btn btn-sm badge btn-success" data-toggle="modal" data-target="#addmotomain" onClick={() => setUserId(d.id, d.firstname + " " + d.middlename + " " + d.lastname)}>Completed</button></td> :
                                                <td><button className="btn btn-sm badge btn-info" data-toggle="modal" data-target="#addmotomain" onClick={() => setUserId(d.id, d.firstname + " " + d.middlename + " " + d.lastname)}>Add</button></td>}

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
            {/* /.row */}

            <div className="modal fade" id="getstudents" data-backdrop='false'>
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Get Student</h4>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <select name="" onChange={(e) => handleChangeClass(e)} id="" value={selectedclass} className="form-control form-control-sm">
                                        <option value="">Select a Class</option>
                                        {allClasses.map(d => (
                                            <option key={d.id + "motoclass"} value={d.id}>{d.classname}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-12 col-md-6">
                                    <select name="" onChange={(e) => handleChangeSection(e)} value={selectedsection} id="" className="form-control form-control-sm">
                                        <option value="">Select a Section</option>
                                        {allClasses.map(d => (
                                            <option key={d.id + "motosection"} value={d.sectionId} >{d.sectionname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div className="modal-footer justify-content-between">
                            <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            {isLoading ? <div className="spinner-border"></div> : <button type="button" onClick={getStudentList} className="btn btn-info btn-sm">Save changes</button>}

                        </div>
                    </div>
                </div>
            </div>


            <div className="modal fade" id="addmotomain" data-backdrop='false'>
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">{studentname}</h4>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <form id='moto_form'>
                                {motolist.length > 0 ? motolist.map(d => (
                                    <div key={d.id + "motoListMain"}>
                                        <div className="row">
                                            <div className="col-12 col-md-6">
                                                <i style={{ fontStyle: 'normal' }}>{d.name}</i>
                                            </div>
                                            <div className="col-12 col-md-6">
                                                <div className="row">
                                                    <div className="col-2 col-md-2">
                                                        <input type="radio" onClick={() => addMoto(d.id, 1, studentid, "myoption" + d.id)} name={"myoption" + d.id} value="1" id="" />
                                                    </div>
                                                    <div className="col-2 col-md-2">
                                                        <input type="radio" name={"myoption" + d.id} onClick={() => addMoto(d.id, 2, studentid)} value="2" id="" />
                                                    </div>
                                                    <div className="col-2 col-md-2">
                                                        <input type="radio" name={"myoption" + d.id} onClick={() => addMoto(d.id, 3, studentid)} value="3" id="" />
                                                    </div>
                                                    <div className="col-2 col-md-2">
                                                        <input type="radio" name={"myoption" + d.id} onClick={() => addMoto(d.id, 4, studentid)} value="4" id="" />
                                                    </div>
                                                    <div className="col-2 col-md-2">
                                                        <input type="radio" name={"myoption" + d.id} onClick={() => addMoto(d.id, 5, studentid)} value="5" id="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                    </div>

                                )) : ""}
                            </form>

                        </div>
                        <div className="modal-footer justify-content-between">
                            <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                            {isLoading ? <div className="spinner-border"></div> : <button type="button" onClick={submitMoto} className="btn btn-info btn-sm">Save changes</button>}

                        </div>
                    </div>
                </div>
            </div>



        </div>
    )

}

export default Moto