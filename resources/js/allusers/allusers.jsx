import React from "react"
import reactDom from "react-dom"
import { MDBDataTableV5 } from 'mdbreact';
import axios from "axios";
import {useEffect, useState} from 'react';
import DataTable from 'react-data-table-component';
import { Button, Modal, Footer, Header } from 'react-bootstrap';

function AllUsers() {

    useEffect(() => {
        fetch_all_student()
        return () => {
            // cleanup
        };
    }, []);



    const [datamain, setDatamain] = useState([]);
    const [search, setSearch] = useState("");
    const [filteredUsers, setFilteredUsers] = useState([]);
    const [show, setShow] = useState(false);
    const handleClose = () => setShow(false);
    const [gottenStudentRecord, setStudentRecord] = useState({})

    const [datatable, setDatatable] = React.useState({
        columns: [
          {
            label: 'name',
            field: 'name',
            width: 150,
            attributes: {
              'aria-controls': 'DataTable',
              'aria-label': 'Name',
            },
          },
          {
            label: 'System No.',
            field: 'id',
            width: 270,
          },
          {
            label: 'Role',
            field: 'role',
            width: 200,
          },
          {
            label: 'Phone Number',
            field: 'phonenumber',
            sort: 'asc',
            width: 100,
          },
          {
            label: 'Email',
            field: 'email',
            sort: 'disabled',
            width: 150,
          },
          {
            label: 'Action',
            field: '',
            sort: 'disabled',
            width: 100,
          },
        ],
        
        rows: [],
      });

      const data = datamain;
        const columns = [
            {
                name: 'Name',
                selector: 'name',
                sortable: true,
            },
            {
                name: 'Email.',
                selector: 'email',
                sortable: true,
                right: true,
            },
            {
                name: 'System No.',
                selector: 'id',
                sortable: true,
                right: true,
            },
            {
                name: 'Admission No.',
                selector: 'addmins',
                sortable: true, //addmins
                right: true,
            },
            {
                name: 'Role.',
                selector: 'role',
                sortable: true,
                right: true,
            },
            {
                name: 'Phone Number.',
                selector: 'phonenumber',
                sortable: true,
                right: true,
            },
        ];


        useEffect(() => {
          setFilteredUsers(
            datamain.filter((users) =>
            users.name.toLowerCase().includes(search.toLowerCase())
            )
          );
        }, [search, datamain]);


      function fetch_all_student() {

        axios.get('/sec/setting/fetch_all_student').then(response=>{

            setDatamain(response.data.allusers)

            // setDatatable.rows(response.data.allusers)

            setDatatable({
                ...datatable,
              rows: response.data.allusers
            });

            console.log(response.data.allusers)

        }).catch(e=>{
            console.log(e)
        })
          
      }

      function handleClick(e) {
          console.log(e.addmins)
      }

      function confirmAddmissionnumber(e) {

        // setisLoading(true)
        // setStudentRecord({})\
        setShow(true)
        const data = new FormData()
        data.append("admissionno", e.addmins)
        axios.post('/confirm_admission_no', data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{

            console.log(response)
            // setisLoading(false)

            if(response.data.response == "success"){

                setStudentRecord(response.data.student)

            }else if(response.data.response == "doesnotexist"){
                // myalert("does not exist", 'error')
            }else if(response.data.response == "noaddmissionno"){
                // myalert("enter ad no", 'error')
            }else if(response.data.response == "duplicate"){
                // myalert("duplicate no", 'error')
            }

        }).catch(e=>{
            // setisLoading(false)
            // myalert("unknown error", 'error')
        })
        
    }

    return(
        <div>
            <div className="card">
                <div style={{ margin:'10px' }}>
                <div className="row">
                  <div className="col-12 col-md-4">
                    <div className="form-group">
                      <input type="text" className="form-control form-control-sm" onChange={(e) => setSearch(e.target.value)} placeholder="Search student name"/>
                    </div>
                  </div>
                </div>

                <DataTable
                    columns={columns}
                    data={filteredUsers}
                    paginationTotalRows={filteredUsers.length}
                    pagination={true}
                    Clicked
                    onRowClicked={confirmAddmissionnumber}
                />

                </div>
            </div>


            <Modal show={show} onHide={handleClose} size="sm">
                <Modal.Header closeButton>
                <Modal.Title style={{ fontSize:'15px', fontStyle:'bold' }}>User Details</Modal.Title>
                </Modal.Header>
                <Modal.Body>

                  <div>
                    <div>{gottenStudentRecord.firstname} {gottenStudentRecord.middlename} {gottenStudentRecord.lastname}</div>
                    <div>{gottenStudentRecord.classname}{gottenStudentRecord.sectionname}</div>
                  </div>


                </Modal.Body>
                <Modal.Footer>
                {/* <Button variant="secondary" className="btn-sm" onClick={handleClose}>
                    Close
                </Button>
                <Button variant="primary" className="btn-sm btn-info" onClick={updateSubjectCommand}>
                    Update Changes
                </Button>
                <Button variant="primary" className="btn-sm btn-danger" onClick={deleteSubjectCommand}>
                    Delete
                </Button> */}
                </Modal.Footer>
            </Modal>

        </div>
    )
}

export default AllUsers