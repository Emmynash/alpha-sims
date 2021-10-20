import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import DataTable from 'react-data-table-component';


function DataTablePage(subjectdata) {

    const data = subjectdata.array;
    const columns = [
    {
        name: 'Subject Name',
        selector: 'subjectname',
        sortable: true,
    },
    {
        name: 'Class',
        selector: 'classname',
        sortable: true,
    },
    {
        name: 'Section',
        selector: 'sectionname',
        sortable: true,

    },
    {
        name: 'Subject Type',
        selector: 'subjecttype',
        sortable: true,

    },
    ];




    return(
        <div>
            <DataTable
        title="Subjects"
        columns={columns}
        data={data}
      />
        </div>
    );

}

export default DataTablePage;