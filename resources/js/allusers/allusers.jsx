import React from "react"
import reactDom from "react-dom"
import { MDBDataTableV5 } from 'mdbreact';
import axios from "axios";
import {useEffect, useState} from 'react';
import DataTable from 'react-data-table-component';

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
            console.log("dffffdsf")
        })
          
      }

      function handleClick(e) {
          console.log()
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
                />
                </div>
            </div>
        </div>
    )
}

export default AllUsers