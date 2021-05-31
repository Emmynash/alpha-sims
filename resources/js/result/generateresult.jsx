import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

function GenerateResult() {

    const [getReadyResults, setgetReadyResults] = useState([])
    const [isLoading, setisLoading] = useState(false)

    useEffect(() => {
        getReadyResult()
        return () => {
            // cleanup
        };
    }, []);

    function getReadyResult() {
        setisLoading(true)
        axios.get('/sec/result/get_result_ready_section').then(response=>{
            console.log(response)
            setisLoading(false)
            setgetReadyResults(response.data.getReadyResults)
        }).catch(e=>{
            console.log(e)
            setisLoading(false)
        })
    }

    return(
        <div>

            {isLoading ? <div class="text-center">
                    <div class="spinner-border"></div>
            </div>:''}
            {isLoading ? <div style={{ position:'absolute', top:'0', bottom:'0', left:'0', right:'0', zIndex:'1000', background:'white', opacity:'0.4' }}>

            </div>:""}

            <div className="card">
                <div style={{ margin:'10px' }}>
                    <div className="alert alert-info">
                        <i>Result Generation is done per section. Below are list of available results for final processing if there is none means none is ready.</i>
                    </div>
                    <div>
                        <p>List of available results for further Processing</p>
                    </div>
                    <div>
                        {getReadyResults.map(d=>(
                            <div key={d.id+"resultready"} className="card" style={{ display:'flex', flexDirection:'row', alignItems:'center'}}>
                                <div style={{ display:'flex', flexDirection:'column', marginLeft:'10px', flex:'1' }}>
                                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>Class: {d.classname}{d.sectionname}</i>
                                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>Status: {d.status == 0 ? "Pending":"Completed"}</i>
                                    <i style={{ fontStyle:'normal', fontSize:'13px' }}>Date Generated: {d.status != 0 ? d.created_at:"Not Generated"}</i>
                                </div>
                                <div className="form-group" style={{ marginRight:'10px' }}>
                                    <button className="btn btn-sm btn-success badge">Generate</button>
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