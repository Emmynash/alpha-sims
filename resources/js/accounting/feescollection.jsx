import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import { v4 as uuidv4 } from 'uuid';
// import ReactToPrint from 'react-to-print';
// import { ComponentToPrint } from './ComponentToPrint';
import { Document, Page, Text, View, StyleSheet } from '@react-pdf/renderer';
import { PDFViewer } from '@react-pdf/renderer';
import MyDocument from './printslip'

// Create styles
const styles = StyleSheet.create({
  page: {
    flexDirection: 'row',
    backgroundColor: '#E4E4E4'
  },
  section: {
    margin: 10,
    padding: 10,
    flexGrow: 1
  }
});




function FeesCollection() {

    const [classlist, setclasslist] = useState([])
    const [addsection_sec, setaddsection_sec] = useState([])
    const [identity, setidentity] = useState('')
    const [studentDetails, setStudentDetails] = useState({})
    const [paymentamount, setpaymentamount] = useState([])
    const [totalfees, settotalfees] = useState('')
    const [singleStudent, setSingleStudent] = useState(false)
    const [entireclass, setEntireClass] = useState(false)
    const [classSelected, setClassSelected] = useState('')
    const [selectedSection, setSelectedSection] = useState('')
    const [studentList, setStudentList] = useState([])
    const [partamount, setpartamount] = useState(0)
    const [paymentRecord, setPaymentRecord] = useState([])
    const [totalamount, setTotalAmount] = useState(0)
    const alert = useAlert()
    


    useEffect(() => {
        fetchPageDetails()
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



    function fetchPageDetails() {

        axios.get('/get_teacher_page_details').then(response=> {
            console.log(response);
            // console.log(setJ)
            setclasslist(response.data.classesAll)
            // setallsubjects(response.data.addsubject_sec)
            setaddsection_sec(response.data.addsection_sec)
            // setAllTeachersWithSubject(response.data.getAllTeachersWithSubject)
            


        }).catch(e=>{
            console.log(e);
        });

    } 

    function handleIdentityChange(e) {
        setidentity(e.target.value)
    }

    function handleChangeClass(e) {
        setClassSelected(e.target.value)
    }

    function handleChangeSection(e) {
        setSelectedSection(e.target.value)
    }

    function handlePartPaymentAmount(e) {
        setpartamount(e.target.value)
    }

    function viewSingleStudent(studentregno) {
        console.log(studentregno)
        setidentity(studentregno)
        getStudent(studentregno)
    }

    function getStudent(identityno) {
        setSingleStudent(false)
        setEntireClass(false)
        const data = new FormData()
        data.append("identity", identityno)
        axios.post("/gen/fetchstudentdataforfee", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            
            setStudentDetails(response.data.data)
            setpaymentamount(response.data.feesummary)
            settotalfees(response.data.totalfees)
            setTotalAmount(response.data.totalfees)
            setPaymentRecord(response.data.paymentRecord)
            setSingleStudent(true)



        }).catch(e=>{
            console.log(e)

            
        })
    }

    function getStudentByClass() {
       
            setEntireClass(false)
            axios.get('/gen/get_student_list_fees/'+classSelected+"/"+selectedSection).then(response=> {
                console.log(response);

                setStudentList(response.data.data)

                setEntireClass(true)
    
                // setStaffList(response.data.stafflist)
                // setrole(response.data.role)
                
    
    
            }).catch(e=>{
                console.log(e);
            });
    }

    function partPayment(regno) {

        const data = new FormData()
        data.append("regno", regno)
        data.append("amount", partamount)
        data.append("total_amount", totalamount)
        axios.post("/gen/fees_part_payment", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            if (response.data.data == "over charge") {
                myalert("Over charge","error")
            }else if(response.data.data == "payment done"){
                myalert("Student fees paid in full","error")
            }
            
            else if(response.data.data == "success"){
                myalert("Payment Successfull","success")
                refresh(regno)
            }
            
        }).catch(e=>{
            console.log(e)
            myalert("Unknown Error. Try again later","error")
        })
    }

    function refresh(regno) {
        const data = new FormData()
        data.append("identity", regno)
        axios.post("/gen/fetchstudentdataforfee", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            
            setStudentDetails(response.data.data)
            setpaymentamount(response.data.feesummary)
            settotalfees(response.data.totalfees)
            setTotalAmount(response.data.totalfees)
            setPaymentRecord(response.data.paymentRecord)
            // setSingleStudent(true)



        }).catch(e=>{
            console.log(e)

            
        })
    }

    return(
        <div>
            
            <div className="container">
                <div className="alert alert-info">
                    <p style={{ margin:'0px' }}>Get student using either addmission number or by querying the entireclass</p>
                </div>
                <div className="card">
                    <div className="row" style={{ margin:'10px' }}>
                        <div className="col-12 col-md-6">
                            <div className="form-group">
                                <input type="text" onChange={(e)=>handleIdentityChange(e)} className="form-control form-control-sm" placeholder="addmission no."/>
                            </div>
                            <div className="form-group">
                                <button onClick={()=>getStudent(identity)} className="btn btn-sm btn-info">Query</button>
                            </div>
                        </div>
                        <div className="col-12 col-md-6">
                            <div className="form-group">
                                <select onChange={(e)=>handleChangeClass(e)} name="" id="" className="form-control form-control-sm">
                                    <option value="">Select a class</option>
                                    {
                                        classlist.map(classmain=>(
                                            <option key={classmain.id+"classmain"} value={classmain.id}>{classmain.classname}</option>
                                        ))
                                    }
                                </select>
                            </div>
                            <div className="form-group">
                                <select onChange={(e)=>handleChangeSection(e)} name="" id="" className="form-control form-control-sm">
                                    <option value="">Select a section</option>
                                    {
                                        addsection_sec.map(sec=>(
                                            <option key={sec.id+"sec"} value={sec.id}>{sec.sectionname}</option>
                                        ))
                                    }
                                </select>
                            </div>
                            <div className="form-group">
                                <button onClick={getStudentByClass} className="btn btn-sm btn-info">Query</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* table for entire class query */}

                {entireclass ? <div>
                <div className="row">
                    <div className="col-12">
                        <div className="card">
                        <div className="card-header">
                            <h3 className="card-title">Student List</h3>
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

                        <div className="card-body table-responsive p-0">
                            <table className="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                <th>Admission No.</th>
                                <th>Full name</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                { studentList.map(student=>(
                                    <tr key={student.id+"studentList"}>
                                        <td>{student.admission_no}</td>
                                        <td>{student.firstname} {student.middlename} {student.lastname}</td>
                                        <td><button onClick={()=>viewSingleStudent(student.id)} className="btn btn-sm btn-info badge">View</button></td>
                                    </tr>
                                )) }
                            </tbody>
                            </table>
                        </div>
                        
                        </div>
                        
                    </div>
                </div>
            </div>:""}

            {/* single user details*/}
            {singleStudent ? <div>
                <div className="card">
                    <div className="row">
                        <div className="col-12 col-md-4">
                            <div className="text-center" style={{ margin:'10px', height:'100px' }}>
                                <img id="profileimgmainpix" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" className="img-circle elevation-2" alt="User Image" height="100px"/>
                            </div>
                        </div>
                        <div className="col-12 col-md-8">
                            <div className="card" style={{ margin:'10px' }}>
                               <div style={{ margin:'10px' }}>
                                    <p>{studentDetails.firstname} {studentDetails.middlename} {studentDetails.lastname}</p>
                                    <p>{studentDetails.classname}{studentDetails.sectionname}</p>
                                    <p>Guadian No. {studentDetails.studentfathernumber}, {studentDetails.studentmothersnumber}</p>
                                    <p>Admission No. {studentDetails.admission_no}</p>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div style={{ margin:'10px' }}>
                        {/* <p>Payment Details</p> */}
                        <div className="row">
                            <div className="col-12 col-md-6">
                                <p>Payment Details</p>
                                <div style={{ height:'300px', overflowY:'scroll' }}>
                                    {paymentamount.map(payment=>(
                                        <div key={payment.id+"payment"} className="card" style={{ margin:'5px' }}>
                                            <i style={{ padding:'5px', fontStyle:'normal' }}>{payment.categoryname} (N{payment.amount})</i>
                                        </div>
                                    ))}
                                </div>
                                <div className="card">
                                    <i style={{ padding:'5px', fontStyle:'normal' }}>Total Fees (N{totalfees})</i>  
                                </div>
                            </div>
                            <div className="col-12 col-md-6">
                                <p>Payment Record</p>
                                <button className="btn btn-sm btn-info badge" data-toggle="modal" data-target="#modal-xl">View all and print</button>
                                <div style={{ height:'300px', overflowY:'scroll' }}>
                               
                                    {paymentRecord.map(record=>(
                                        
                                        <div key={record.id+"record"} className="card" style={{ margin:'5px' }}>
                                            <div style={{ display:'flex', flexDirection:'column', margin:'5px' }}>
                                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Amount Paid: N{record.amount_paid}</i>
                                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Amount Rem: N{record.amount_rem}</i>
                                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Session: {record.session}</i>
                                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Date: {record.created_at}</i>
                                                
                                            </div>
                                        </div>
                                        
                                    )) }
                                    
                                    {/* <PDFViewer>
                                        <MyDocument />
                                    </PDFViewer> */}
                                </div>
                                <div className="card">
                                    <i style={{ padding:'5px', fontStyle:'normal' }}>Total Fees (N{totalfees})</i>  
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style={{ margin:'10px' }}>
                        <button className="btn btn-sm btn-info">Confirm Full Payment</button> 
                        <button className="btn btn-sm btn-warning" data-toggle="modal" data-target="#partpayment">Part Payment</button>
                    </div>



                    <div className="modal fade" id="partpayment" data-backdrop="false">
                        <div className="modal-dialog">
                            <div className="modal-content">
                            <div className="modal-header">
                                <h4 className="modal-title">Patial Payment</h4>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <div className="form-group">
                                    <label htmlFor="">Enter Amount</label>
                                    <input onChange={(e)=>handlePartPaymentAmount(e)} type="number" className="form-control form-control-sm" />
                                </div>
                            </div>
                            <div className="modal-footer justify-content-between">
                                <button type="button" className="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                <button onClick={()=>partPayment(studentDetails.id)} type="button" className="btn btn-info btn-sm">Confirm</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>:""}




        </div>
    )
    
}

export default FeesCollection;