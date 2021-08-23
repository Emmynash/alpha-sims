import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

function ManageStaff() {

    const [stafList, setStaffList] = useState([])
    const [systemnumber, setSystemNumber] = useState(0)
    const [stafverify, setstafverify] = useState([])
    const [isverifying, setisverifying] = useState(false)
    const [role, setrole] = useState([])
    const [selectedrole, setselectedrole] = useState('')
    const [viewStaffres, setViewStaffres] = useState({})
    const [isLoadingStaff, setIsLoadingStaff] = useState(true)
    const alert = useAlert()



    useEffect(() => {

        fetchStaffDetails()

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

    function verifyUser() {

        setisverifying(true)
        setstafverify([])
        const data = new FormData()
        data.append("staffregnorole", systemnumber)
        axios.post("/allocate_role_sec", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)

            if (response.data.none == "none") {
                setisverifying(false)
                myalert('No record found', 'error');
            }else{
                setisverifying(false)

                setstafverify(response.data.userdetails)
            }

        }).catch(e=>{
            console.log(e)
            
        })
        
        
    }

    function handleChangeSystemNumber(e) {
        setSystemNumber(e.target.value)
    }

    function handleChangeRole(e) {
        setselectedrole(e.target.value)
    }

    function fetchStaffDetails() {

        axios.get('/manage_saff_sec_alloc').then(response=> {
            console.log(response);

            setStaffList(response.data.stafflist)
            setrole(response.data.role)
            


        }).catch(e=>{
            console.log(e);
        });

    } 

    function addUserToASchool() {
        const data = new FormData()
        data.append("systemnumberrole", systemnumber)
        data.append("roleselect", selectedrole)
        axios.post("/allocate_role_sec_main", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)

            if (response.data.notallow == "notallow") {
                
                myalert('Role already allocated', 'error');
            }else{
                myalert('Role allocated successfully', 'success');
            }

        }).catch(e=>{
            console.log(e)
            
        })
    }

    function viewStaff(staffSystemNumber) {

        setIsLoadingStaff(true);

        axios.get('/pri/viewstaff/'+staffSystemNumber).then(response=> {
            console.log(response.data);
            
            setViewStaffres(response.data)

            setIsLoadingStaff(false)

            


        }).catch(e=>{
            console.log(e);
            setIsLoadingStaff(false)
        });
        
    }

    return(
        <div>
            <div>
                <button data-toggle="modal" data-target="#addstaff" className="btn btn-sm btn-info">Add Staff</button>
            </div>
            <br />
            <div className="row">
                <div className="col-12">
                    <div className="card">
                    <div className="card-header">
                        <h3 className="card-title">Staff List</h3>
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
                                <th>system No.</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {stafList.map(staff=>(
                                <tr>
                                    <td>{staff.name}</td>
                                    <td>{staff.systemno}</td>
                                    <td>{staff.role}</td>
                                    <td>
                                    <button className="btn btn-sm btn-success badge" data-toggle="modal" data-target="#viewstaff" onClick={()=>viewStaff(staff.systemno)}>View</button>
                                    {/* {
                                        staff.role == "HeadOfSchool" ? "":<button className="btn btn-sm btn-danger badge">Remove</button>
                                    } */}
                                        
                                    </td>
                                </tr>
                            ))}

                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="addstaff" data-backdrop="false">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Add Staff</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <div className="form-group">
                            <input type="number" onChange={(e)=>handleChangeSystemNumber(e)} className="form-control form-control-sm" placeholder="System No."/>
                            {isverifying ?  <div className="spinner-border"></div>:<button onClick={verifyUser} className="btn btn-sm btn-info badge">verify</button>}
                        </div>
                        <div className="">
                        {stafverify.length >0 ? <div className="card" >
                                        <div className="row">
                                            <div className="col-md-4">
                                                <div style={{display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '5px'}}>
                                                    <img id="passportconfirm_sec2" style={{}} src="storage/schimages/profile.png" className="img-circle elevation-2" alt="" width="70px" height="70px" />
                                                </div>
                                            </div>
                                            <div className="col-md-8 text-center">
                                                { stafverify.map(details=>(
                                                    <div>
                                                        <p style={{ margin:'2px' }}>{details.firstname}</p>
                                                        <p style={{ margin:'2px' }}>{details.middlename}</p>
                                                        <p style={{ margin:'2px' }}>{details.lastname}</p>
                                                    </div>
                                                ))}
                                                
                                            </div>
                                        </div>
                                        <div className="form-group" style={{ margin:'10px' }}>
                                            <select onChange={(e)=>handleChangeRole(e)} name="" className="form-control-sm form-control" id="">
                                                <option value="">Select a role</option>
                                                {role.length > 0 ? role.map(rolemain=>(
                                                    rolemain.name !="Teacher" && rolemain.name != "Student" ? <option value={rolemain.id}>{rolemain.name}</option>:""
                                                )):""}
                                            </select>
                                        </div>
                                    </div>:""}
                        </div>
                    </div>
                    <div className="modal-footer justify-content-between">
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button onClick={addUserToASchool} type="button" className="btn btn-info btn-sm">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

            <div className="modal fade" id="viewstaff" data-backdrop="false">
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">View Staff</h4>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div className="modal-body">

                        <div className="row">
                            {/* <div className="col-md-12">
                                <div style={{display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '5px'}}>
                                    <img id="passportconfirm_sec2" style={{}} src="storage/schimages/profile.png" className="img-circle elevation-2" alt="" width="100px" height="100px" />
                                </div>
                            </div> */}
                        </div>
                        <br/>
                        <div className="row">
                            <div className="col-md-12">
                                <div className="card text-center" style={{ display:'flex', flexDirection:'column' }}>
                                    <i style={{ fontStyle:'normal', fontSize:'13px', padding:'2px' }}>{ isLoadingStaff ? "": viewStaffres.detUserDetails.firstname +" "+viewStaffres.detUserDetails.middlename}</i>
                                    {/* <i style={{ fontStyle:'normal', fontSize:'13px', padding:'2px' }}>Form Class Section</i> */}
                                    {/* <i style={{ fontStyle:'normal', fontSize:'13px', padding:'2px' }}>firstname middlename lastname</i> */}
                                </div>
                            </div>
                            <div className="col-md-12">

                                <div className="card">
                                    <i style={{ fontStyle:'normal', fontSize:'13px', padding:'2px', fontWeight:'bold' }}>Form Classes</i>
                               </div>
                               <div style={{ maxHeight:'200px', overflowY:'scroll' }}>

                                    {
                                        isLoadingStaff ? 
                                        ""
                                        :

                                        viewStaffres.formClasses.length > 0 ? viewStaffres.formClasses.map(d=>(
                                            <div>{d.classname+" "+d.sectionname}</div>
                                        )): <div>Not a Form Teacher</div>
                                    }

                               </div>

                            </div>
                            <div className="col-md-12">

                               <div className="card">
                                    <i style={{ fontStyle:'normal', fontSize:'13px', padding:'2px', fontWeight:'bold' }}>Teachers Subjects</i>
                               </div>
                               <div style={{ maxHeight:'200px', overflowY:'scroll' }}>
                                    {
                                        isLoadingStaff ? 
                                        ""
                                        :
                                        viewStaffres.teachersSubject.length > 0 ? viewStaffres.teachersSubject.map(d=>(
                                            <div>{d.subjectname}({d.classname+""+d.sectionname})</div>
                                        )):<div>You are not a teacher</div>
                                    }

                               </div>

                            </div>
                        </div>
                        <br/>
                        <div className="alert alert-warning">
                            <i style={{ fontStyle:'normal', fontSize:'12px' }}>Deleting a user from here means the user is no longer a staff in the school. Delete with caution!</i>
                        </div>
                       
                    </div>
                    <div className="modal-footer">
                        
                        <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" className="btn btn-danger btn-sm">Delete Staff</button>
                    </div>
                    </div>
                </div>
            </div>



        </div>
    )
    
}

export default ManageStaff;