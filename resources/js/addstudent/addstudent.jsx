import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import NaijaStates from 'naija-state-local-government';

function AddStudents() {

    const alert = useAlert()
    const [studentHasReg, setStudentHasReg] = useState('')
    const [statesNigeria, setStatesNigeria] = useState([])
    const [lgaStates, setLgaStates] = useState([])
    const [allClasses, setAllClasses] = useState([])
    const [section_sec, setSection_sec] = useState([])
    const [houses, setHouses] = useState([])
    const [clubs, setClubs] = useState([])
    const [userdetailfetch, setuserdetailfetch] = useState([])
    const [isVerifying, setIsverifying] = useState(false)
    const [regForm, setRegForm] = useState({
        studentclassallocated:'',
        schoolsession: '',
        studentsectionallocated: '',
        studenttype: '',
        studentsystemnumber: '',
        admissionname: '',
        firstname: '',
        middlename: '',
        lastname:'',
        isRegistered: '',
        email: '',
    })

    useEffect(() => {
        setStatesData()
        fetchPageDetails()
        return () => {
            // cleanup
        };
    }, []);

    function handleChange(evt) {
        const value = evt.target.value;
        setRegForm({
            ...regForm,
          [evt.target.name]: value
        });
      }

    function setStatesData() {
        setStatesNigeria(NaijaStates.states())
        
    }

    function handleChangeStudentRegStatus(e) {
        setStudentHasReg(e.target.value)
        setRegForm({
            ...regForm,
            [e.target.name]:e.target.value
        })
        
    }

    function handleChangeStates(e) {
        setLgaStates(NaijaStates.lgas(e.target.value).lgas)

        setRegForm({
            ...regForm,
            [e.target.name]:e.target.value
        })
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


    function fetchPageDetails() {
        setIsverifying(true)
        axios.get('/get_teacher_page_details').then(response=> {
            console.log(response);
            // console.log(setJ)
            setAllClasses(response.data.classesAll)
            setSection_sec(response.data.addsection_sec)
            setHouses(response.data.houses)
            setClubs(response.data.clubs)
            setIsverifying(false)

        }).catch(e=>{
            console.log(e);
            setIsverifying(false)
        });

    } 

    function addStudentMain(event) {
        event.preventDefault();


        if(regForm.isRegistered != ''){
            setIsverifying(true)
            axios.post("/student_sec_add", regForm, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                setIsverifying(false)
                if (response.data.response == "exist") {
                    myalert('Account already exist', 'error')
                }else if(response.data.response == "admission"){
                    myalert('Admission number already taken', 'error')
                }else if(response.data.response == "exist"){
                    myalert('Already added', 'error')
                }else if(response.data.response == "erroremail"){
                    myalert('An error occured. Invalid email', 'error')
                }
                else if(response.data.response == "success"){

                    setRegForm({
                        studentclassallocated:'',
                        schoolsession: '',
                        studentsectionallocated: '',
                        studenttype: '',
                        studentsystemnumber: '',
                        studentgender: '',
                        studentreligion: '',
                        fathersname: '',
                        fathersphonenumber: '',
                        mothersname: '',
                        mothersphonenumber: '',
                        dateofbirth: '',
                        bloodgroup: '',
                        studenthouse: '',
                        nationality: '',
                        studentclub: '',
                        studentaddress_sec: '',
                        admissionname: '',
                        firstname: '',
                        middlename: '',
                        lastname:'',
                        isRegistered: '',
                        phonenumber: '',
                        email: '',
                        states: '',
                        lga:'',
                        hometown:'',
                        admissiondate:''
                    })
                    setuserdetailfetch([])
                    myalert('account Created successfully', 'success')
                }
    
    
            }).catch(e=>{
                console.log(e)
                setIsverifying(false)
                myalert('Ensure all fields are filled', 'error')
            })
        }else{
            myalert('Select if the student has registered or not', 'error')
        }

         console.log(regForm)
    }

    function verifyStudentRegistration() {

        setIsverifying(true)
        setuserdetailfetch([])
        const data = new FormData()
        data.append("systemnumber", regForm.studentsystemnumber)
        axios.post("/student_sec_confirm", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            setIsverifying(false)
            console.log(response)
            if (response.data.response == "success") {
                setuserdetailfetch(response.data.userdetailfetch)
            }


        }).catch(e=>{
            console.log(e)
            setIsverifying(false)
            myalert('Status unknown', 'error');
            
        })

    }

    

    return(
        <div>
            {isVerifying ? <div className="text-center">
                <div className="spinner-border"></div>
            </div>:""}
            {isVerifying ? <div style={{ position:'absolute', zIndex:'1000', top:'0', bottom:'0', left:'0', right:'0', background:'white', opacity:'0.4' }}>
                
            </div>:""}


            <form onSubmit={addStudentMain}>
            <div className="card">
                <div className="alert alert-info" style={{ margin:'10px' }}>
                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>*Valid email addresses, as this is important... credentials will be sent... haven't created*</i>   
                </div>
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-4">
                        <div className="card">
                            <div style={{ margin:'10px' }}>
                                <div className="alert alert-info">
                                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>*For students who have registered, their system number..*</i>
                                </div>
                                <select onChange={(e)=>handleChangeStudentRegStatus(e)} value={regForm.isRegistered} name="isRegistered" id="" className="form-control form-control-sm">
                                    <option value="">Select an option to proceed</option>
                                    <option value="1">Student hasn't resgistered</option>
                                    <option value="2">Student has registered</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    {studentHasReg == 2 ? <div className="col-12 col-md-8">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="alert alert-warning">
                                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>Enter the system number on the evidence of registration.</i>
                                </div>
                                <div className="form-group">
                                    <input type="number" name="studentsystemnumber" value={regForm.studentsystemnumber} onChange={handleChange} className="form-control form-control-sm" placeholder='system number'/>
                                    <button type="button" onClick={verifyStudentRegistration} className="btn btn-sm btn-info badge">Verify</button>
                                </div>
                            </div>
                            <div className="col-12 col-md-6">
                                <div className="row">
                                    {userdetailfetch.length > 0 ?<div className="col-md-4">
                                        <div style={{display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '5px'}}>
                                            <img id="passportconfirm_sec2" style={{}} src="storage/schimages/profile.png" className="img-circle elevation-2" alt="" width="70px" height="70px" />
                                        </div>
                                    </div>:""}
                                    <div className="col-md-8 text-center">

                                        {userdetailfetch.map(d=>(
                                            <div key={d.id+"verified"}>
                                                <p style={{ margin:'2px' }}>{d.firstname}</p>
                                                <p style={{ margin:'2px' }}>{d.middlename}</p>
                                                <p style={{ margin:'2px' }}>{d.lastname}</p>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>:""}

                    {studentHasReg == 1 ? <div className="col-12 col-md-8">
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <div className="row">
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="text" name="firstname" onChange={handleChange} value={regForm.firstname} className="form-control form-control-sm" placeholder='firstname'/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="text" name="middlename" onChange={handleChange} value={regForm.middlename} className="form-control form-control-sm" placeholder='middlename'/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="text" name="lastname" onChange={handleChange} value={regForm.lastname} className="form-control form-control-sm" placeholder='lastname'/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="text" name="email" onChange={handleChange} value={regForm.email} className="form-control form-control-sm" placeholder='email'/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="text" name="phonenumber" onChange={handleChange} value={regForm.phonenumber} className="form-control form-control-sm" placeholder='phone number'/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>:""}
                </div>
                <div style={{ margin:'10px' }}>
                    <div className="card">
                        <div className="row" style={{ margin:'10px' }}>
                            <div className="col-12 col-md-3">
                                <div className="form-group">
                                    <select name="studentclassallocated" id="" value={regForm.studentclassallocated} onChange={handleChange} className="form-control form-control-sm">
                                        <option value="">Select a Class</option>
                                        {allClasses.map(d=>(
                                            <option key={d.id+"addstudentclasses"} value={d.id}>{d.classname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <div className="col-12 col-md-3">
                                <div className="form-group">
                                    <select name="studentsectionallocated" id="" onChange={handleChange} value={regForm.studentsectionallocated} className="form-control form-control-sm">
                                        <option value="">Select a Section</option>
                                        {section_sec.map(d=>(
                                            <option key={d.id+"addstudentsection"} value={d.id}>{d.sectionname}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <div className="col-12 col-md-3">
                                <div className="form-group">
                                    <select name="studenttype" id="" value={regForm.studenttype} onChange={handleChange} className="form-control form-control-sm">
                                        <option value="">Student Type</option>
                                        <option value="Boarding">Boarding</option>
                                        <option value="Day">Day</option>
                                    </select>
                                </div>
                            </div>
                            <div className="col-12 col-md-3">
                                <div className="form-group">
                                    <input type="text" name="admissionname" onChange={handleChange} value={regForm.admissionname} className="form-control form-control-sm" placeholder="Admission number"/>
                                </div>
                            </div>
                            <div className="col-12 col-md-3">
                                <div className="form-group">
                                    <label htmlFor="">Admission Date</label>
                                    <input type="text" name="admissiondate" onChange={handleChange} value={regForm.admissiondate} className="form-control form-control-sm" placeholder="2020/2021"/>
                                </div>
                            </div>
                        </div>
                        <div style={{ margin:'10px' }}>
                            <hr />
                            {/* <i>Student Details</i> */}
                            {/* <div className="row">
                                <div className="col-12 col-md-4">
                                    <select onChange={(e)=>handleChangeStates(e)} name="states" value={regForm.states} id="" className="form-control form-control-sm">
                                        <option value="">Select State</option>
                                        {statesNigeria.map(d=>(
                                            <option key={d+"states"} value={d}>{d}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-12 col-md-4">
                                    <select name="lga" onChange={handleChange} id="" value={regForm.lga} className="form-control form-control-sm">
                                        <option value="">Select LGA</option>
                                        {lgaStates.map(d=>(
                                            <option key={d+"lgas"} value={d}>{d}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-12 col-md-4">
                                    <input type="text" name="hometown" onChange={handleChange} value={regForm.hometown} className="form-control form-control-sm" placeholder="Home Town"/>
                                </div>
                            </div> */}
                            <br />
                            {/* <div className="row">
                                <div className="col-12 col-md-4">
                                    <select name="studentgender" value={regForm.studentgender} id="" onChange={handleChange} className="form-control form-control-sm">
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div className="col-12 col-md-4">
                                    <select name="studentreligion" value={regForm.studentreligion} id="" onChange={handleChange} className="form-control form-control-sm">
                                        <option value="">Select Religion</option>
                                        <option value="Christan">Christan</option>
                                        <option value="Islam">Islam</option>
                                    </select>
                                </div>
                                <div className="col-12 col-md-4">
                                    <select name="studenthouse" value={regForm.studenthouse} id="" onChange={handleChange} className="form-control form-control-sm">
                                        <option value="">Select House</option>
                                        {houses.map(d=>(
                                            <option key={d.id+houses} value={d.id}>{d.housename}</option>
                                        ))}
                                    </select>
                                </div>
                            </div> */}
                            {/* <br />
                            <div className="row">
                                <div className="col-12 col-md-4">
                                    <div className="form-group">
                                        <label htmlFor="">Date of Birth</label>
                                        <input type="date" name="dateofbirth" onChange={handleChange} className="form-control form-control-sm" value={regForm.dateofbirth}/>
                                    </div>
                                </div>
                            </div>
                            <hr /> */}
                            {/* <i>Clubs and society</i>
                            <div>
                                <div className="row">
                                    <div className="col-12 col-md-6">
                                        <select name="studentclub" value={regForm.studentclub} id="" onChange={handleChange} className="form-control form-control-sm">
                                            <option value="">Select a Club</option>
                                            {clubs.map(d=>(
                                                <option key={d.id+"clubs"} value={d.id}>{d.clubname}</option>
                                            ))}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr /> */}
                            {/* <i>Guaduan Detials</i>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <input type="text" name="fathersname" onChange={handleChange} value={regForm.fathersname} className="form-control form-control-sm" placeholder="Father's name"/>
                                    </div>
                                    <div className="form-group">
                                        <input type="number" name="fathersphonenumber" onChange={handleChange} value={regForm.fathersphonenumber} onChange={handleChange} className="form-control form-control-sm" placeholder="Father's phone"/>
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <input type="text" name="mothersname" onChange={handleChange} value={regForm.mothersname} className="form-control form-control-sm" placeholder="Mother's name"/>
                                    </div>
                                    <div className="form-group">
                                        <input type="number" name="mothersphonenumber" onChange={handleChange} value={regForm.mothersphonenumber} className="form-control form-control-sm" placeholder="Mother's phone"/>
                                    </div>
                                </div>
                            </div> */}
                            {/* <hr />
                            <i>Address</i>
                            <div className="row">
                                <div className="col-12 col-md-6">
                                    <div className="form-group">
                                        <textarea name="studentaddress_sec" id="" onChange={handleChange} value={regForm.studentaddress_sec} cols="30" rows="5" className="form-control form-control-sm"></textarea>
                                    </div>
                                </div>
                            </div> */}
                            <button onClick={addStudentMain} className="btn btn-sm btn-info">Submit</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            </form>
        </div>
    )


}

export default AddStudents;