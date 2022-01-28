import React from 'react';
import ReactDOM from 'react-dom';
import Modal from 'react-modal';
import { useState, useEffect } from 'react';
import axios from 'axios';



function StudentDiscount() {

    const [studentlist, setStudentlist] = useState([]);
    const [studentlistFiltered, setStudentlistFiltered] = useState(studentlist);
    const [isLoading, setisLoading] = useState(true);

    useEffect(() => {
        getStudentsWithDiscount()
        return () => {
            // cleanup
        };
    }, []);

    function getStudentsWithDiscount() {

        setisLoading(true)

        axios.get('/gen/get_all_student_discount').then(response => {

            setisLoading(false)

            console.log(response)

            setStudentlist(response.data.response)
            setStudentlistFiltered(response.data.response)

        }).catch(e => {
            setisLoading(false)

            console.log(e)

        })

    }

    const handleSearch = (event) => {

        let value = event.target.value.toLowerCase();

        let result = [];

        console.log(value);

        result = studentlist.filter((data) => {
            return data.firstname.toLowerCase().search(value) != -1;
        });
        setStudentlistFiltered(result);

    }

    function discontinueDiscount(id) {
        setisLoading(true)

        axios.get('/gen/discontinue_discount/' + id).then(response => {

            getStudentsWithDiscount()

        }).catch(e => {
            setisLoading(false)

            console.log(e)

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
            <div>
                <div className="row">
                    <div className="col-12 col-md-4">
                        <div className="form-group">
                            <input type="text" placeholder="search by name" className="form-control form-control-sm" onChange={(event) => handleSearch(event)} />
                        </div>
                    </div>
                </div>
                <div className="alert alert-info">
                    <i>By clicking the Discontinue button, it imply you are removing the student from the list of student with discount. However, if the request was sent after invoice was generated, it means the effect will only be seen the next time another invoice is generated for the student.</i>

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
                                studentlistFiltered.map(d => (
                                    <tr key={d.id}>
                                        <td>{d.admission_no}</td>
                                        <td>{d.firstname} {d.lastname}</td>
                                        <td>{d.percent}%</td>
                                        <td><button type="button" className="btn btn-sm btn-danger badge" onClick={() => discontinueDiscount(d.id)}>Discontinue</button></td>
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