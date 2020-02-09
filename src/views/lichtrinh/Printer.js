import React, { Component } from 'react'
import PropTypes from 'prop-types'
import Axios from 'axios';
import AirlineSeatReclineNormalIcon from '@material-ui/icons/AirlineSeatReclineNormal';
import { API_URL } from "variables/config.js";
import ReactToPrint from 'react-to-print';
import PrintIcon from '@material-ui/icons/Print';
export default class Printer extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
            tang_tren:[],
            tang_duoi:[],
            cui_ve:[],
            info:null
        }
    }
    componentDidMount(){
        let tren = []
        let duoi = []
        Axios.post(API_URL+'/production/LichTrinh/get.php',{
            id:this.props.match.params.id
        }).then(data =>{
        if(data.data.message == 0){
            alert("có lổi")
        }else{
            let info = data.data
            Axios.post(API_URL+'/production/Booking/get.php',{
                id_tuyen:data.data[0].id_tuyen,
                id_chuyen:data.data[0].id_chuyen,
                start_time: data.data[0].start_time
              }).then(data =>{
                if(data.data.message == 0){
                    alert("có lổi")
                }else{
                    if(data.data.length > 0){
                        let dem = 0
                        let arr = []
                        data.data.map((row,index) =>{
                            if(index < 23){
                                if(index > 17){
                                    if(index == 22){
                                        arr.push(row)
                                        duoi.push(arr)
                                        dem = 0
                                        arr = []
                                    }else{
                                        arr.push(row)
                                    }
                                        
                                }else{
                                    if(dem < 2){
                                        dem = dem + 1
                                        arr.push(row)
                                        arr.push({})
                                    }else{
                                        arr.push(row)
                                        duoi.push(arr)
                                        arr = []
                                        dem = 0
                                    }
                                }
                                
                                
                            }else{
                                // if(index > 41){
                                //     if(index == 41){
                                //         arr.push(row)
                                //         tren.push(arr)
                                //         dem = 0
                                //         arr = []
                                //     }else{
                                //         arr.push(row)
                                //     }
                                        
                                // }else{
                                    if(dem < 2){
                                        dem = dem + 1
                                        arr.push(row)
                                        arr.push({})
                                    }else{
                                        arr.push(row)
                                        tren.push(arr)
                                        dem = 0
                                        arr = []
                                        
                                    }
                                //}
                                
                            }
                        })
                    } 
                    this.setState({cui_ve:data.data,tang_duoi:duoi,tang_tren:tren,info})
                }
                
            })
        }
        });
        
    }
    render() {
        //console.log(this.state)
        const downstairs = (this.state.tang_duoi.length > 0)?this.state.tang_duoi.map((row,index) =>{
            return  <tr key={index} className="row">
                        {row.map((row2,index)=>{
                            let name = ""
                            let phone = ""
                            let address = ""
                            if(Object.entries(row2).length === 0 && row2.constructor === Object){
                                return <td key={index} className="col-2"></td>
                            }else{
                                if(row2.customer_info != null){
                                    name = row2.customer_info.name
                                    phone = row2.customer_info.phone
                                    address = row2.customer_info.address
                                    return <td key={index} className="col-2"><strong>Ghế:{row2.label}</strong><br></br>{name} <br></br>{phone} <br></br>{address} <br></br></td>
                                }else{
                                return <td key={index} className="col-2"><strong>Ghế:{row2.label}</strong></td>
                                }
                            }
                        
                                
                        })}
                    </tr>
                    
        }):""
        const upstairs = (this.state.tang_tren.length > 0)?this.state.tang_tren.map((row,index) =>{
            return  <tr key={index} className="row">
                        {row.map((row2,index)=>{
                            let name = ""
                            let phone = ""
                            let address = ""
                            if(Object.entries(row2).length === 0 && row2.constructor === Object){
                                return <td key={index} className="col-2"></td>
                            }else{
                                if(row2.customer_info != null){
                                    name = row2.customer_info.name
                                    phone = row2.customer_info.phone
                                    address = row2.customer_info.address
                                    return <td key={index} className="col-2"><strong>Ghế:{row2.label}</strong><br></br>{name} <br></br>{phone} <br></br>{address} <br></br></td>
                                }else{
                                return <td key={index} className="col-2"><strong >Ghế:{row2.label}</strong></td>
                                }
                            }
                        
                                
                        })}
                    </tr>
        }):""
        return (
            <div>
                <div className="row"> 
                    <div className="col-12"> <ReactToPrint
                    trigger={() => <a href="#"><PrintIcon /></a>}
                    content={() => this.componentRef}
                    ></ReactToPrint>
                    </div>
                </div>
                <div className="row" ref={el => (this.componentRef = el)}>
                    
                    <div className="col-12">
                    <h1>{(this.state.info != null)?this.state.info[0].tuyen+", "+this.state.info[0].date+", "+this.state.info[0].gio+", "+this.state.info[0].license_plates:""}</h1>
                        <table className="table table-striped">
                            <thead>
                            <th colspan="5"><h1>Tầng Dưới</h1></th>
                            </thead>
                            <tbody>
                        
                            {downstairs}
                            </tbody>
                        </table>
                    </div>
                    <div className="col-12">
                        <table className="table table-striped">
                            <thead>
                            <th colspan="5"><h1>Tâng Trên</h1></th>
                            
                            </thead>
                            <tbody>
                            {upstairs}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        )
    }
}
