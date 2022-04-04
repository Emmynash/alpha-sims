import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'
import moment from 'moment';

function GenerateResult() {

    const [getReadyResults, setgetReadyResults] = useState([])
    const [isLoading, setisLoading] = useState(false)
    const alert = useAlert()

    useEffect(() => {
        getReadyResult()
        return () => {
            // cleanup
        };
    }, []);

    function myalert(msg, type) {
        alert.show(msg, {
            timeout: 2000, // custom timeout just for this one alert
            type: type,
            onOpen: () => {
              console.log('open')
            }, // callback that will be executed after this alert open
            onClose: () => {
              console.log('closed')
            } // callback that will be executed after this alert is removed
          })
    }

    function getReadyResult() {
        setisLoading(true)
        axios.get('/sec/result/get_result_ready_section').then(response=>{
            // console.log(response)
            setisLoading(false)
            setgetReadyResults(response.data.getReadyResults)
        }).catch(e=>{
            console.log(e)
            setisLoading(false)
        })
    }

    function generateResultMain(classidMain, sectionidMain, notif_id) {
        setisLoading(true)
        const data = new FormData()
        data.append("classid", classidMain)
        data.append('section_id', sectionidMain)
        data.append('notif_id', notif_id)
        axios.post("/sec/result/generate_result_main", data, {
            headers:{
                "Content-type": "application/json"
            }
        }).then(response=>{
            console.log(response)
            // window.location.reload();
            setisLoading(false)

            if (response.status == 200) {
                myalert('Success', 'success')
            }else{
                myalert('failed', 'error')
            }

        }).catch(e=>{
            console.log(e)
            setisLoading(false)
            myalert('failed', 'error')

        })
    }

    return(
        <div>

            {isLoading ? <div className="text-center">
                    <div className="spinner-border"></div>
            </div>:''}
            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', zIndex:'1000', background:'white', opacity:'0.4' }}>

            </div>:""}

            <div className="card">
                <div style={{ margin:'10px' }}>
                    <div className="alert alert-info">
                        <i>Results can be generated multiple times per section by clicking on the Generate/Regenerate button.<br></br>
                            See lists of available results for final processing below.
                        </i>
                    </div>
                    <div>
                        <span style={{ fontSize: '14px', color: 'red' }}>
                            Note: if the list is empty, it means no result has been submitted by form masters/mistresses for processing.
                        </span>
                    </div>
                    <div>
                        {getReadyResults.map(d=>(
                            <div key={d.id+"resultready"} className="card" style={{ display:'flex', flexDirection:'row', alignItems:'center'}}>
                                <div style={{ display:'flex', flexDirection:'column', marginLeft:'10px', flex:'1' }}>
                                    <i style={{ fontStyle: 'normal', fontSize: '13px' }}>
                                        <span style={{ color: "black", fontWeight: 'bold' }}>Class</span>: {d.classname}{d.sectionname}
                                    </i>
                                    <i style={{ fontStyle: 'normal', fontSize: '13px' }}>
                                        <span style={{ color: "black", fontWeight: 'bold' }}>Status</span>: {d.status == 0 ? <span style={{ color: "yellow", fontWeight: 'bold' }}>Pending</span> :
                                                <span style={{ color: "green", fontWeight: 'bold' }}>Completed</span>}</i>
                                    <i style={{ fontStyle: 'normal', fontSize: '13px' }}>
                                        <span style={{ color: "black", fontWeight: 'bold' }}>Generated</span>  :
                                        {d.status != 0 ? moment(d.updated_at).fromNow() : <span style={{ color: "red", fontWeight: 'bold' }}>Not Generated</span>}
                                    </i>
                                </div>
                                <div className="form-group" style={{ marginRight:'10px' }}>
                                    <button onClick={()=>generateResultMain(d.classid, d.sectionid, d.id)} className= {d.status != 0 ? "btn btn-sm btn-warning badge":"btn btn-sm btn-success badge"}> {d.status != 0 ? "Regenerate":"Generate"}</button>
                                </div>
                            </div>
                        )) }
                    </div>
                </div>
            </div>
        </div>
    )
    
}

export default GenerateResult