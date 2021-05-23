import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'


function SchoolSetUp() {

    const [schooldetails, setSchooldetails] = useState({})
    const [classlist, setClasslist] = useState([])
    const [houselist, sethouselist] = useState([])
    const [classsection, setclasssection] = useState([])
    const [clubs, setclubs] = useState([])
    const [schoolinitials, setSchoolInitials] = useState('')
    const [schoolsessioninput, setschoolsessioninput] = useState('')
    const [term, setterm] = useState(0)
    const [classnamesch, setClassnamesch] = useState('')
    const [typesch, setTypesch] = useState(0)
    const [houses, setHouses] = useState('')
    const [classArms, setClassArms] = useState('')
    const [schoolclubs, setschoolclubs] = useState('')
    const [examscheck, setexamscheck] = useState(Boolean)
    const [isupdatingexams, setisupdatingexams] = useState(false)
    const [isupdatingca1, setisupdatingca1] = useState(false)
    const [ca1check, setca1check] = useState(Boolean)
    const [ca2check, setca2check] = useState(Boolean)
    const [isupdatingca2, setisupdatingca2] = useState(false)
    const [ca3check, setca3check] = useState(Boolean)
    const [isupdatingca3, setisupdatingca3] = useState(false)
    const alert = useAlert()

    useEffect(() => {

        fetchSchoolDetails()

        return () => {
            // cleanup
        };
    }, []);

    function fetchSchoolDetails() {

        axios.get('/sec/setting/fetchschooldata').then(response=> {
            console.log(response);
            // console.log(setJ)
            setSchooldetails(response.data.schoolDetails);
            setClasslist(response.data.classlist)
            sethouselist(response.data.houselist)
            setclasssection(response.data.classsection)
            setclubs(response.data.clubs)
            setSchoolInitials(response.data.schoolDetails.shoolinitial)
            setschoolsessioninput(response.data.schoolDetails.schoolsession)

            if (response.data.schoolDetails.exams ==1) {
                setexamscheck(true)
            }else{
                setexamscheck(false)
            }

            
            setca1check(response.data.schoolDetails.ca1)
            setca2check(response.data.schoolDetails.ca2)
            setca3check(response.data.schoolDetails.ca3)
            setterm(response.data.schoolDetails.term)

        }).catch(e=>{
            console.log(e);
        });

    } //scholsessioninput

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

    function handleChangeSchoolInitial(e) {
        setSchoolInitials(e.target.value);
    }

    function handleChangeSchoolSchoolsession(e) {
        setschoolsessioninput(e.target.value);
    }

    function handleChangeSchoolTerm(e) {
        setterm(e.target.value);
    }

    function handleChangeClassName(e) {
        setClassnamesch(e.target.value);
    }

    function handleChangeHouses(e) {
        setHouses(e.target.value);
    }

    function handleChangeClassType(e) {
        setTypesch(e.target.value);
    }

    function handleChangeClassArms(e) {
        setClassArms(e.target.value);
    }

    function handleChangeSchoolClubs(e) {
        setschoolclubs(e.target.value);
    }
    
    function handleExamChange(e) {
        console.log(e.target.value)

        if (e.target.checked) {
            console.log(e.target.checked)
            setisupdatingexams(true)
            setexamscheck(true)
            updateExams(1)
        }else{
            console.log(e.target.checked)
            setisupdatingexams(true)
            setexamscheck(false)
            updateExams(0)
        }
    }

    function handleCa1Change(e) {

        if (e.target.checked) {
            console.log(e.target.checked)
            setisupdatingca1(true)
            setca1check(true)
            updateCa1(1)
        }else{
            console.log(e.target.checked)
            setisupdatingca1(true)
            setca1check(false)
            updateCa1(0)
        }
        
    }

    function handleCa2Change(e) {

        if (e.target.checked) {
            console.log(e.target.checked)
            setisupdatingca2(true)
            setca2check(true)
            updateCa2(1)
        }else{
            console.log(e.target.checked)
            setisupdatingca2(true)
            setca2check(false)
            updateCa2(0)
        }
    }

    function handleCa3Change(e) {

        if (e.target.checked) {
            console.log(e.target.checked)
            setisupdatingca3(true)
            setca3check(true)
            updateCa3(1)
        }else{
            console.log(e.target.checked)
            setisupdatingca3(true)
            setca3check(false)
            updateCa3(0)
        }
        
    }

    function updateSchoolInitials() {


        if (schoolinitials !="") {

            if (schooldetails.shoolinitial != schoolinitials) {

                const data = new FormData()
                data.append("schoolinitialsinput", schoolinitials)
                axios.post("/sec/setting/addschoolinitials", data, {
                    headers:{
                        "Content-type": "application/json"
                    }
                }).then(response=>{
                    console.log(response)
                    
                    myalert('Process Successful', 'success');
                    fetchSchoolDetails()
                }).catch(e=>{
                    console.log(e)
        
                })
            }else{
                myalert('Noting was changed', 'warning'); 
            }
        }
    }

    function updateSchoolSession() { //


        if (schoolsessioninput !="") {
            
            if ( schooldetails.schoolsession != schoolsessioninput) {
                const data = new FormData()
                data.append("schoolsessioninput", schoolsessioninput)
                axios.post("/sec/setting/addschoolsession", data, {
                    headers:{
                        "Content-type": "application/json"
                    }
                }).then(response=>{
                    console.log(response)
                    fetchSchoolDetails()
                    myalert('Process Successful', 'success');
                
                }).catch(e=>{
                    console.log(e)

                })
            }else{
                myalert('Noting was changed', 'warning');
            }
        }
    } 

    function updateSchoolTerm() {

        if (term !=0 && term !="") {

            if (schooldetails.term != term) {

                const data = new FormData()
                data.append("term", term)
                axios.post("/sec/setting/update_term", data, {
                    headers:{
                        "Content-type": "application/json"
                    }
                }).then(response=>{
                    console.log(response)
                    fetchSchoolDetails()
                    myalert('Process Successful', 'success');
                   
                }).catch(e=>{
                    console.log(e)
        
                })
                
            }else{
                myalert('Noting was changed', 'warning');
            }

        }
    }

    function addSchoolClassList() {

        if (classnamesch !="" && typesch !=0) {
            const data = new FormData()
            data.append("classname", classnamesch),
            data.append("type", typesch)
            axios.post("/sec/setting/addclasses_sec", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                fetchSchoolDetails()
                setClassnamesch('')
                myalert('Process Successful', 'success');
                
            }).catch(e=>{
                console.log(e)
    
            })
        }
    }


    function addSchoolHouses() {

        if (houses !="") {
            const data = new FormData()
            data.append("addhouses_input", houses),
            axios.post("/sec/setting/addhouses_sec", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                fetchSchoolDetails()
                setHouses('')
                myalert('Process Successful', 'success');
                
            }).catch(e=>{
                console.log(e)
    
            })
        }
    }

    function addSchoolClassArms() {

        if (classArms !="") {
            const data = new FormData()
            data.append("addsection_input", classArms),
            axios.post("/sec/setting/addsection_sec", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                fetchSchoolDetails()
                setClassArms('')
                myalert('Process Successful', 'success');
                
            }).catch(e=>{
                console.log(e)
    
            })
        }
    }

    function addSchoolCLubs() { //
        if (schoolclubs !="") {
            const data = new FormData()
            data.append("addclub_input", schoolclubs),
            axios.post("/sec/setting/addclub_sec", data, {
                headers:{
                    "Content-type": "application/json"
                }
            }).then(response=>{
                console.log(response)
                fetchSchoolDetails()
                setschoolclubs('')
                myalert('Process Successful', 'success');
                
            }).catch(e=>{
                console.log(e)
    
            })
        }
    }


    function updateExams(status) {

        const data = new FormData()
        data.append("examsstatus", status)
        axios.post("/sec/setting/update_exams_status", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisupdatingexams(false)
            
            myalert('Process Successful', 'success');
            fetchSchoolDetails()
        }).catch(e=>{
            console.log(e)

        })
    }

    function updateCa1(status) {

        const data = new FormData()
        data.append("ca1status", status)
        axios.post("/sec/setting/update_ca1_status", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisupdatingca1(false)
            
            myalert('Process Successful', 'success');
            fetchSchoolDetails()
        }).catch(e=>{
            console.log(e)

        })
    }

    function updateCa2(status) {

        const data = new FormData()
        data.append("ca2status", status)
        axios.post("/sec/setting/update_ca2_status", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisupdatingca2(false)
            
            myalert('Process Successful', 'success');
            fetchSchoolDetails()
        }).catch(e=>{
            console.log(e)

        })
    }

    function updateCa3(status) {

        const data = new FormData()
        data.append("ca3status", status)
        axios.post("/sec/setting/update_ca3_status", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            setisupdatingca3(false)
            
            myalert('Process Successful', 'success');
            fetchSchoolDetails()
        }).catch(e=>{
            console.log(e)

        })
    }




    return(
        <div className="container">
            <div className="card">
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input className="form-control form-control-sm" value={schoolinitials} onChange={(e)=>handleChangeSchoolInitial(e)} placeholder="School initials"/>
                            <button className="btn btn-sm btn-info badge" onClick={updateSchoolInitials}>Save</button>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input className="form-control form-control-sm" value={schoolsessioninput} onChange={(e)=>handleChangeSchoolSchoolsession(e)} placeholder="School Session"/>
                            <button className="btn btn-sm btn-info badge" onClick={updateSchoolSession}>Save</button>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            {/* <input className="form-control form-control-sm" value={schooldetails.term} placeholder="School term"/> */}
                            <select className="form-control form-control-sm" onChange={(e)=>handleChangeSchoolTerm(e)}>
                                <option value="">Select a term</option>
                                <option value="1" selected={term == 1 ? "selected":""}>1(first)</option>
                                <option value="2" selected={term == 2 ? "selected":""}>2(Second)</option>
                                <option value="3" selected={term == 3 ? "selected":""}>3(Third)</option>
                            </select>
                            <button onClick={updateSchoolTerm} className="btn btn-sm btn-info badge">Save</button>
                        </div>
                    </div>

                </div>
                <hr/>
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-3">
                        {isupdatingexams ? <div className="spinner-border"></div>: <div className="form-group">
                            <div className="custom-control custom-switch">
                                <input type="checkbox" onChange={(e)=>handleExamChange(e)} checked={examscheck ? "checked":""} className="custom-control-input" id="customSwitch1" />
                                <label className="custom-control-label" htmlFor="customSwitch1">Exams</label>
                            </div>
                        </div>}

                    </div>
                    <div className="col-12 col-md-3">
                    <div className="form-group">
                            {isupdatingca1 ? <div className="spinner-border"></div>:<div className="custom-control custom-switch">
                                <input type="checkbox" onChange={(e)=>handleCa1Change(e)} checked={ca1check ? "checked":""} className="custom-control-input" id="customSwitch2" />
                                <label className="custom-control-label" htmlFor="customSwitch2">CA1</label>
                            </div>}
                        </div>
                    </div>
                    <div className="col-12 col-md-3">
                    <div className="form-group">
                            {isupdatingca2 ? <div className="spinner-border"></div>:<div className="custom-control custom-switch">
                                <input type="checkbox" onChange={(e)=>handleCa2Change(e)} checked={ca2check == true ? "checked":""} className="custom-control-input" id="customSwitch3" />
                                <label className="custom-control-label" htmlFor="customSwitch3">CA2</label>
                            </div>}
                        </div>
                    </div>
                    <div className="col-12 col-md-3">
                    <div className="form-group">
                            {isupdatingca3 ? <div className="spinner-border"></div>:<div className="custom-control custom-switch">
                                <input type="checkbox" onChange={(e)=>handleCa3Change(e)} checked={ca3check == true ? "checked":""} className="custom-control-input" id="customSwitch4" />
                                <label className="custom-control-label" htmlFor="customSwitch4">CA3</label>
                            </div>}
                        </div>
                    </div>


                </div>
                <hr/>
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-6">
                        <div className="alert alert-warning">
                            <i style={{ fontSize:'13px' }}>Classes school be entered in ascending order(From the lowest to highest)</i>
                        </div>
                        <div className="form-group">
                            <select className="form-control-sm form-control" onChange={(e)=>handleChangeClassType(e)}>
                                <option value="">Select Level</option>
                                <option value="1" selected={typesch == 1 ? "selected":""} >Junior Secondary</option>
                                <option value="2" selected={typesch == 2 ? "selected":""}>Senior Secondary</option>
                            </select>
                        </div>
                        <div className="form-group">
                            <input onChange={(e)=>handleChangeClassName(e)} value={classnamesch} className="form-control form-control-sm" placeholder="Enter Class name in ascending Order"/>
                        </div>
                        <button onClick={addSchoolClassList} className="btn btn-sm btn-info badge">Save</button>
                        <br/>

                        {
                            classlist.length > 0 ? 
                            classlist.map(d => (
                                <div className="card radius-15">
                                    <div className="card-body">
                                        <div style={{ display:'flex', alignItems:'center' }} >
                                            <i style={{ fontStyle:'normal', fontSize:'10px' }}> {d.classname} </i> <div style={{ flex:'1' }}></div> <button className="btn btn-sm btn-danger badge">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            ))
                            
                            :

                            <div className="card radius-15">
                                <div className="card-body">
                                    <div style={{ display:'flex', alignItems:'center', justifyContent:'center' }} >
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}> Setup classlist </i>
                                    </div>
                                </div>
                            </div>

                        }


                    </div>
                    <div className="col-12 col-md-6">
                        <input className="form-control form-control-sm" onChange={handleChangeHouses} value={houses} placeholder="Enter House name"/>
                        <button onClick={addSchoolHouses} className="btn btn-sm btn-info badge">Save</button>
                        {
                            houselist.length > 0 ? 
                            houselist.map(d => (
                                <div className="card radius-15">
                                    <div className="card-body">
                                        <div style={{ display:'flex', alignItems:'center' }} >
                                            <i style={{ fontStyle:'normal', fontSize:'10px' }}> {d.housename} </i> <div style={{ flex:'1' }}></div> <button className="btn btn-sm btn-danger badge">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            ))
                            
                            :

                            <div className="card radius-15">
                                <div className="card-body">
                                    <div style={{ display:'flex', alignItems:'center', justifyContent:'center' }} >
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}> Setup houselist </i>
                                    </div>
                                </div>
                            </div>

                        }
                    </div>
                </div>
                
                <hr/>
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-6">
                        <div className="form-group">
                            <input className="form-control form-control-sm" onChange={handleChangeClassArms} value={classArms} placeholder="Arms"/>
                        </div>
                        <button onClick={addSchoolClassArms} className="btn btn-sm btn-info badge">Save</button>

                        {
                            classsection.length > 0 ? 
                            classsection.map(d => (
                                <div className="card radius-15">
                                    <div className="card-body">
                                        <div style={{ display:'flex', alignItems:'center' }} >
                                            <i style={{ fontStyle:'normal', fontSize:'10px' }}> {d.sectionname} </i> <div style={{ flex:'1' }}></div> <button className="btn btn-sm btn-danger badge">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            ))
                            
                            :

                            <div className="card radius-15">
                                <div className="card-body">
                                    <div style={{ display:'flex', alignItems:'center', justifyContent:'center' }} >
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}> Setup class arms </i>
                                    </div>
                                </div>
                            </div>

                        }
                    </div>
                    <div className="col-12 col-md-6">
                        <input className="form-control form-control-sm" onChange={handleChangeSchoolClubs} value={schoolclubs} placeholder="Enter Club name"/>
                        <button onClick={addSchoolCLubs} className="btn btn-sm btn-info badge">Save</button>

                        {
                            clubs.length > 0 ? 
                            clubs.map(d => (
                                <div className="card radius-15">
                                    <div className="card-body">
                                        <div style={{ display:'flex', alignItems:'center' }} >
                                            <i style={{ fontStyle:'normal', fontSize:'10px' }}> {d.clubname} </i> <div style={{ flex:'1' }}></div> <button className="btn btn-sm btn-danger badge">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            ))
                            
                            :

                            <div className="card radius-15">
                                <div className="card-body">
                                    <div style={{ display:'flex', alignItems:'center', justifyContent:'center' }} >
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}> Setup clubs </i>
                                    </div>
                                </div>
                            </div>

                        }
                    </div>
                </div>
            </div>
        </div>
    );

}

export default SchoolSetUp;