import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import {useEffect, useState} from 'react';
import { useAlert } from 'react-alert'

function GenerateResult() {

    return(
        <div>
            <div className="card">
                <div style={{ margin:'10px' }}>
                    <div className="alert alert-info">
                        <i>Result Generation is done per section. Below are list of available results for final processing if there is none means none is ready.</i>
                    </div>
                    <div>
                        <p>List of available results for further Processing</p>
                    </div>
                    <div>
                        <div className="card" style={{ display:'flex', flexDirection:'row', alignItems:'center'}}>
                            <div style={{ display:'flex', flexDirection:'column', marginLeft:'10px', flex:'1' }}>
                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Class: SSS1A</i>
                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Status:Pending</i>
                                <i style={{ fontStyle:'normal', fontSize:'13px' }}>Date Generated: </i>
                            </div>
                            <div className="form-group" style={{ marginRight:'10px' }}>
                                <button className="btn btn-sm btn-success badge">Generate</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
    
}

export default GenerateResult