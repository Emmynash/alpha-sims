import React from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-modal';
import { useState, useEffect } from 'react';
import axios from 'axios';



function StudentDiscount() {

    const [studentlist, setStudentlist] = useState([]);

    useEffect(() => {
        getStudentsWithElectives()
        return () => {
            // cleanup
        };
    }, []);

    function getStudentsWithElectives() {

        axios.get('/gen/get_all_student_discount').then(response=>{

            console.log(response)

            setStudentlist(response.data.response)

        }).catch(e=>{

            console.log(e)

        })
        
    }

    return(
        <div>
            {/* <button type="button" className="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal">Add Discount</button> */}
            {/* <hr /> */}
            <div>
                <div className="row">
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input type="text" placeholder="search by name" className="form-control form-control-sm" />
                        </div>
                    </div>
                </div>
            </div>
            <div className="card">
                <div className="card-body table-responsive p-0">
                    <table className="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Admission No.</th>
                            <th>Full name</th>
                            <th>Discount Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {
                            studentlist.map(d=>(
                                <tr>
                                    <td>{d.admission_no}</td>
                                    <td>{d.firstname} {d.middlename} {d.lastname}</td>
                                    <td>{d.percent}%</td>
                                    <td><button type="button" className="btn btn-sm btn-danger badge">Discontinue</button> <button type="button" className="btn btn-sm btn-info badge">View</button></td>
                                </tr>
                            ))
                        }
                
                    </tbody>
                    </table>
                </div>
            </div>

            
            {/* The Modal */}
            <div className="modal" id="myModal">
                <div className="modal-dialog">
                    <div className="modal-content">
                    {/* Modal Header */}
                    <div className="modal-header">
                        <h4 className="modal-title">Modal Heading</h4>
                        <button type="button" className="close" data-dismiss="modal">×</button>
                    </div>
                    {/* Modal body */}
                    <div className="modal-body">
                        Modal body..
                    </div>
                    {/* Modal footer */}
                    <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>



        </div>
    )
    
}

export default StudentDiscount;