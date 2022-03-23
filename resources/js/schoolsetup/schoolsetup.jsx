import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import { DragDropContext, Draggable, Droppable } from 'react-beautiful-dnd';


function SchoolSetUp() {

    const [schooldetails, setSchooldetails] = useState({})
    const [schooltype, setSchoolType] = useState('')
    const [classlist, setClasslist] = useState([])
    const [houselist, sethouselist] = useState([])
    const [classsection, setclasssection] = useState([])
    const [clubs, setclubs] = useState([])
    const [schoolinitials, setSchoolInitials] = useState('')
    const [schoolsessioninput, setschoolsessioninput] = useState('')
    const [term, setterm] = useState('')
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
    const [selectedclassid, setSelectedClassId] = useState('')
    const [selectedclassListType, setSelectedClassListType] = useState(0)
    const [assessment, setAssessment] = useState([])
    const [subasscategory, setSubasscategory] = useState([])
    const [assessmentSetUp, setassessmentSetUp] = useState({
        name:'',
        maxmarks:'',
        order:''
    })
    const [subassessmentSetUp, setSubassessmentSetUp] = useState({
        catid:'',
        subname:'',
        submaxmarks:'',
    })
    const alert = useAlert()

    const [sessiondata, setsessiondata] = useState({
        session:'',
        firsttermstarts:'',
        firsttermends:'',
        secondtermstarts:'',
        secondtermends:'',
        thirdtermstarts:'',
        thirdtermends:''
    })

    const [classSetup, setClassSetup] = useState({
        classname:'',
        classtype:'',
        classindex:''
    })

    const [switchPosition, setId] = useState({
        sourceId:"",
        destinationId:""
    })

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
            setSchoolType(response.data.schoolDetails.schooltype)
            setAssessment(response.data.assessment)
            setSubasscategory(response.data.subasscategory)

            setsessiondata({
                ...sessiondata, session:response.data.schoolDetails.schoolsession,
                firsttermstarts:response.data.schoolDetails.firsttermstarts,
                firsttermends:response.data.schoolDetails.firsttermends,
                secondtermstarts:response.data.schoolDetails.secondtermstarts,
                secondtermends:response.data.schoolDetails.secondtermends,
                thirdtermstarts:response.data.schoolDetails.thirdtermstarts,
                thirdtermends:response.data.schoolDetails.thirdtermends
            })

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

    function handleChangeClassName(evt) {
        const value = evt.target.value;
        setClassSetup({
            ...classSetup,
          [evt.target.name]: value
        });
    }

    function handleChangeHouses(e) {
        setHouses(e.target.value);
    }

    function handleChangeClassArms(e) {
        setClassArms(e.target.value);
    }

    function handleChangeSchoolClubs(e) {
        setschoolclubs(e.target.value);
    }

    function handleChange(evt) {
        const value = evt.target.value;
        setsessiondata({
            ...sessiondata,
          [evt.target.name]: value
        });
    }

    function handleAssessmentSetup(evt) {
        const value = evt.target.value;
        setassessmentSetUp({
            ...assessmentSetUp,
          [evt.target.name]: value
        });
    }

    function handleSubAssessmentSetup(evt) {
        const value = evt.target.value;
        setSubassessmentSetUp({
            ...subassessmentSetUp,
          [evt.target.name]: value
        });
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
            
            // if ( schooldetails.schoolsession != schoolsessioninput) {

                axios.post("/sec/setting/addschoolsession", sessiondata, {
                    headers:{
                        "Content-type": "application/json"
                    }
                }).then(response=>{
                    console.log(response)
                    // fetchSchoolDetails()
                    myalert('Process Successful', 'success');
                
                }).catch(e=>{
                    console.log(e)

                })
            // }else{
            //     myalert('Noting was changed', 'warning');
            // }
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


            if(classSetup.classindex != "" && classSetup.classname !="" && classSetup.classtype != ""){

                console.log(classSetup)

                axios.post("/sec/setting/addclasses_sec", classSetup, {
                    headers:{
                        "Content-type": "application/json"
                    }
                }).then(response=>{
                    
                    console.log(response)
                    setClassnamesch('')
                    if(response.data.code == 200){
                        myalert(response.data.msg, 'success');
                    }
                    if(response.data.code == 409){
                        myalert(response.data.msg, 'error');
                    }

                    if(response.data.code == 401){
                        myalert(response.data.msg, 'error');
                    }
                    fetchSchoolDetails()
                    
                }).catch(e=>{
                    console.log(e)
                    myalert('Process failed', 'error');
        
                })

            }else{
                myalert('Process failed', 'error');
            }

    
    }

    function addSchoolClassListPri() {

        if (selectedclassListType == 0) {
            myalert('Select a ClassList Style', 'error');
        }else{
            const data = new FormData()
            data.append("classListType", selectedclassListType),
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

    function setUpAssessment() {


        axios.post("/sec/setting/setupassesment", assessmentSetUp, { //update_assessment_position
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            
            if(response.data.code == 200){
                myalert(response.data.response, 'success');
                fetchSchoolDetails()
            }else{
                myalert(response.data.response, 'error');
            }
            
            
        }).catch(e=>{
            console.log(e)
            myalert('Unknown error', 'error');
        })
    }

    function subSetUpAssessment() {


        axios.post("/sec/setting/subsetupassesment", subassessmentSetUp, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            if(response.data.code == 200){
                myalert(response.data.response, 'success');
                fetchSchoolDetails()
            }else{
                myalert(response.data.response, 'error');
            }
        }).catch(e=>{
            console.log(e)
            myalert('Unknown error', 'error');
        })
    }


    function deleteClass(classid) {

        setSelectedClassId(classid)

        axios.get('/sec/setting/classstatus/'+classid).then(response=>{

            if (response.data.code == 200) {
                fetchSchoolDetails()
                myalert(response.data.msg, 'success');
            }else{
                myalert(response.data.msg, 'error');
            }

        }).catch(e=>{
            myalert('Unknown error', 'error');
        })

        console.log(classid)
        
    }

    function handleOndragEnds(result){

        if(!result.destination) return;

        const items = Array.from(assessment)

        let sourceAssessmentId = ''
        let destinationAssessmentId = ''

        for (let index = 0; index < assessment.length; index++) {
            const element = assessment[index];

            if(index == result.source.index){
                
                sourceAssessmentId = element.id

                setId({
                    ...switchPosition,
                  sourceId: element.id
                });

                console.log(sourceAssessmentId)
            }

            if(index == result.destination.index){
                
                destinationAssessmentId = element.id

                setId({
                    ...switchPosition,
                  destinationId: element.id
                });

                console.log(switchPosition)
            }

        }

        

        const [orderedItems] = items.splice(result.source.index, 1)
        items.splice(result.destination.index, 0, orderedItems)

        setAssessment(items)

        const data = new FormData()
        data.append("sourceId", sourceAssessmentId),
        data.append("destinationId", destinationAssessmentId),

        axios.post("/sec/setting/update_assessment_position", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response.data)
            fetchSchoolDetails()
            // if(response.data.code == 200){
            //     myalert(response.data.response, 'success');
                
            // }else{
            //     myalert(response.data.response, 'error');
            // }
            
            
        }).catch(e=>{
            console.log(e)
            // myalert('Unknown error', 'error');
        })
        console.log(result)
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
                            <input className="form-control form-control-sm" name="session" value={sessiondata.session} onChange={handleChange} placeholder="School Session"/>
                            {/* first term */}
                            <div className="row"> 
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>1st term begins</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.firsttermstarts} name="firsttermstarts" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>1st term ends</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.firsttermends} name="firsttermends" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                            </div>
                            {/* second term */}
                            <div className="row"> 
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>2nd term begins</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.secondtermstarts} name="secondtermstarts" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>2nd term ends</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.secondtermends} name="secondtermends" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                            </div>
                            {/* third term */}
                            <div className="row"> 
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>3rd term begins</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.thirdtermstarts} name="thirdtermstarts" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div className="col-12 col-md-6">
                                    <div className="form-group" style={{ margin:'5px' }}>
                                        <i style={{ fontStyle:'normal', fontSize:'10px' }}>3rd term ends</i>
                                        <input type="date" onChange={handleChange} value={sessiondata.thirdtermends} name="thirdtermends" id="" className="form-control form-control-sm" />
                                    </div>
                                </div>
                            </div>
                            <button className="btn btn-sm btn-info badge" onClick={updateSchoolSession}>Save</button>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            {/* <input className="form-control form-control-sm" value={schooldetails.term} placeholder="School term"/> */}
                            <select className="form-control form-control-sm" value={term} onChange={(e)=>handleChangeSchoolTerm(e)}>
                                <option value="">Select a term</option>
                                <option value="1">1(first)</option>
                                <option value="2">2(Second)</option>
                                <option value="3">3(Third)</option>
                            </select>
                            <button onClick={updateSchoolTerm} className="btn btn-sm btn-info badge">Save</button>
                        </div>
                    </div>

                </div>

                <hr/>
                    <div>
                        <p style={{ paddingLeft:'10px' }}>SetUp Continous Assessment(e.g Exams, CA1, CA2 etc)</p>
                        <div className="row" style={{ margin:'10px' }}>
                            <div className="col-12 col-md-6">
                                <div className="row">
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" value={assessmentSetUp.name} onChange={handleAssessmentSetup} className="form-control form-control-sm"/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <label>Max Marks</label>
                                            <input type="number" name="maxmarks" value={assessmentSetUp.maxmarks} onChange={handleAssessmentSetup} className="form-control form-control-sm"/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <label>Order</label>
                                            <input type="number" name="order" value={assessmentSetUp.order} onChange={handleAssessmentSetup} className="form-control form-control-sm"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <button type="submit" className="btn btn-sm btn-info badge" onClick={setUpAssessment}>Save</button>
                                </div>
                                <div className='alert alert-info'>
                                    Drag and drop to order assessment
                                </div>  
                                <DragDropContext onDragEnd={handleOndragEnds}>
                                <Droppable droppableId='assessments'>
                                {(provided)=>(
                                    <div className="assessments" {...provided.droppableProps} ref={provided.innerRef}>
                                    {
                                    
                                        assessment.map((d, index)=>(
                                            <Draggable key={d.id+"asessments"} draggableId={d.id+"asessments"} index={index}>
                                            {(provided)=>(
                                                <div  className="card" {...provided.draggableProps} {...provided.dragHandleProps} ref={provided.innerRef}>
                                                <div className="">
                                                    <div style={{ display:'flex', alignItems:'center' }} >
                                                        <i style={{ fontStyle:'normal', fontSize:'10px', padding:'5px' }}> {d.name} ({d.maxmark})</i> <div style={{ flex:'1' }}></div>
                                                    </div>
                                                </div>
                                            </div>
                                            )}
                                            
                                            </Draggable>
                                        ))
                                    }
                                    {provided.placeholder}
                                    </div>
                                )}
                                
                                </Droppable>
                                </DragDropContext>
                                
                            </div>
                            <div className="col-12 col-md-6">
                                <div style={{ border:'1px solid black' }}>
                                    <p style={{ padding:'5px' }}>Continous Assessment Sub-category</p>
                                    <div className="row" style={{ margin:'5px' }}>
                                        <div className="col-12 col-md-6">
                                            <div className="form-group">
                                                <label>Select a Category</label>
                                                <select className="form-control form-control-sm" name="catid" value={subassessmentSetUp.catid} onChange={handleSubAssessmentSetup}>
                                                    <option value="">Select a category</option>
                                                    {
                                                        assessment.map(d=>(
                                                            <option key={d.id+"cacat"} value={d.id}>{d.name}</option>
                                                        ))
                                                    }
                                                </select>
                                            </div>
                                        </div>
                                        <div className="col-12 col-md-6">
                                            <div className="form-group">
                                                <label>Sub Name</label>
                                                <input type="text" name="subname" value={subassessmentSetUp.subname} onChange={handleSubAssessmentSetup} className="form-control form-control-sm"/>
                                            </div>
                                            <div className="form-group">
                                                <label>Max Marks</label>
                                                <input type="number" name="submaxmarks" value={subassessmentSetUp.submaxmarks} onChange={handleSubAssessmentSetup} className="form-control form-control-sm"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="form-group" style={{ marginLeft:'10px' }}>
                                        <button type="submit" className="btn btn-sm btn-info badge" onClick={subSetUpAssessment}>Save</button>
                                    </div>

                                    {
                                        subasscategory.map(d=>(
                                            <div key={d.id+"subcat"} className="card" style={{ margin:'5px 5px 5px 5px' }}>
                                                <div className="">
                                                    <div style={{ display:'flex', alignItems:'center' }} >
                                                        <i style={{ fontStyle:'normal', fontSize:'10px', padding:'5px' }}>{d.subname+" "+(d.name)+":"+(d.maxmarks)}</i> <div style={{ flex:'1' }}></div>

                                                        {/* <div className="form-group">
                                                            <div className="custom-control custom-switch">
                                                                <input type="checkbox" defaultChecked={true} className="custom-control-input" id="" />
                                                                <label className="custom-control-label" htmlFor="jkj"></label>
                                                            </div>
                                                        </div> */}

                                                    </div>
                                                </div>
                                            </div>
                                        ))
                                    }

                                    

                                </div>
                            </div>
                           
                        </div>

                    </div>
                <hr/>
                <div className="row" style={{ margin:'10px' }}>
                    <div className="col-12 col-md-6">
                        <div className="alert alert-warning">
                            <i style={{ fontSize:'13px' }}>Use the form below to add classes to your school. You are expected to fill in the CLASS INDEXS. Indexs are assigned from the bottom(i.e the lowest class should have the lowest index and they are numeric).</i>
                        </div>


                            <div>
                                <div className="row">
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input className="form-control form-control-sm" name="classname" onChange={handleChangeClassName} placeholder="Classname"/>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <select className="form-control form-control-sm" name="classtype" onChange={handleChangeClassName}>
                                                <option value="">select classtype</option>
                                                <option value="1" disabled={schooltype == "Secondary" ? true:false}>Primary Section</option>
                                                <option value="1">Junior Secondary {schooltype}</option>
                                                <option value="2">Senior Secondary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-6">
                                        <div className="form-group">
                                            <input type="number" className="form-control form-control-sm" name="classindex" onChange={handleChangeClassName} placeholder="class index"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <button onClick={addSchoolClassList} className="btn btn-sm btn-info badge">Add</button>
                            </div>




                        
                        <br/>
                        {/* <div className="classlist" {...provided.droppableProps} ref={provided.innerRef}> */}
                        {classlist.map(d => (
                        
                            
                            <div key={d.id+"classlist"} className="card radius-15">
                                <div className="">
                                    <div style={{ display:'flex', alignItems:'center' }} >
                                        <i style={{ fontStyle:'normal', fontSize:'10px', padding:'5px' }}> {d.classname} </i> <div style={{ flex:'1' }}></div>

                                        <div className="form-group">
                                            {/* <div className="custom-control custom-switch">
                                                <input type="checkbox" defaultChecked={d.status == 1 ? true:false} className="custom-control-input" onClick={()=>handleClickClass(d.id)} id={"customSwitchclasses"+d.id} />
                                                <label className="custom-control-label" htmlFor={"customSwitchclasses"+d.id}></label>
                                            </div> */}
                                            <button className="btn btn-sm badge badge-danger" onClick={()=>deleteClass(d.id)}>Remove</button>
                                            <i style={{ fontStyle:'normal', fontSize:'10px', padding:'5px' }}> {d.index} </i>
                                        </div>

                                    </div>
                                </div>
                                
                            </div>
                                
                        ))}


                    </div>
                    <div className="col-12 col-md-6">
                        <input className="form-control form-control-sm" onChange={handleChangeHouses} value={houses} placeholder="Enter House name"/>
                        <button onClick={addSchoolHouses} className="btn btn-sm btn-info badge">Save</button>
                        {
                            houselist.length > 0 ? 
                            houselist.map(d => (
                                <div key={d.id+"housesid"} className="card radius-15">
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
                                <div key={d.id+"classsecid"} className="card radius-15">
                                    <div className="card-body">
                                        <div style={{ display:'flex', alignItems:'center' }} >
                                            <i style={{ fontStyle:'normal', fontSize:'10px' }}> {d.sectionname} </i> <div style={{ flex:'1' }}></div> 
                                            {/* <button className="btn btn-sm btn-danger badge">Remove</button> */}
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
                                <div key={d.id+"clubid"} className="card radius-15">
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


            <div className="modal fade" id="updateclassstatus">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Toggle Class Status</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        {/* <p>You are about to disable {selectedclassname}, click proceed to continue </p> */}
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" className="btn btn-info btn-sm">Proceed</button>
                    </div>
                    </div>
                </div>
            </div>


        </div>
    );

}

export default SchoolSetUp;