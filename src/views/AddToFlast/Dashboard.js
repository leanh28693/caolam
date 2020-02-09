import React, { Component,useState } from 'react'
import PropTypes, { arrayOf } from 'prop-types'
// react plugin for creating charts
import ChartistGraph from "react-chartist";
// @material-ui/core
import { makeStyles } from "@material-ui/core/styles";
// @material-ui/icons
import Store from "@material-ui/icons/Store";
import Warning from "@material-ui/icons/Warning";
import DateRange from "@material-ui/icons/DateRange";
import LocalOffer from "@material-ui/icons/LocalOffer";
import ArrowUpward from "@material-ui/icons/ArrowUpward";
import AccessTime from "@material-ui/icons/AccessTime";
// core components
import GridItem from "components/Grid/GridItem.js";
import GridContainer from "components/Grid/GridContainer.js";
import Danger from "components/Typography/Danger.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardIcon from "components/Card/CardIcon.js";
import CardBody from "components/Card/CardBody.js";
import CardFooter from "components/Card/CardFooter.js";
import Carlendar from "components/calendar";
import { Button, Form, FormGroup, Label, Input, TabContent, TabPane, Nav, NavItem, NavLink, CardTitle, CardText, Row, Col } from 'reactstrap';
import styles from "assets/jss/material-dashboard-react/views/dashboardStyle.js";
import Seat from "../../assets/img/Group.png";
import classnames from 'classnames';
import Axios from 'axios';
import { ClipLoader } from "react-spinners";
import Booking from "./Booking";
import ChooseOption from "./ChooseOption";
import { check } from 'prettier';
import moment from "moment";
import ReactConfirmAlert, { confirmAlert } from 'react-confirm-alert';
import CustomerInfo from "./customerInfo";
import { API_URL } from "variables/config.js";
const useStyles = makeStyles(styles);

function DashboardLayout(props) {
  const classes = useStyles();
  const checked = (e) =>{
    props.onChangeTuyen(e)
    //toggleloading(false)
  }
  const chooseOption =(state) =>{
    props.option_value(state)
  }
  return (
    <div>
        <ChooseOption chuyen_xe={props.chuyen_xe} tuyen_xe={props.tuyen_xe} checked={(e)=>checked(e)} chooseOption={(v)=>chooseOption(v)}/>
        <div className="row">
            <div className="col-8">
              <GridContainer>
                <GridItem xs={12} sm={12} md={12}>
                   {(props.cui_ve.length == 0)?"":<Booking cui_ve={props.cui_ve} addInfo={(value)=>props.addInfo(value)} />} 
                </GridItem>
              </GridContainer>
            </div>
            <div className="col-4">
              <GridContainer>
                <GridItem xs={12} sm={12} md={12}>
                {(props.cui_ve.length == 0)?"":<CustomerInfo delcustomer={(params) => props.delcustomer(params)} customer={props.customer} />}
                </GridItem>
              </GridContainer>
            </div>
        </div>
    </div>
  );
}
export default class Dashboard extends Component {
  constructor(props) {
    super(props)
  
    this.state = {
      chuyen_xe:[["", "", "", ""]],
      tuyen_xe:[["", "", null]],
      cui_ve:[],
      option:null,
      customer:[]
    }
  }
  
  componentDidMount(){
    // Axios.get(API_URL+'/production/ChuyenXe/getAll.php').then(data =>{
    //   console.log('res',data)
    //   this.setState({chuyen_xe:data.data})
    // })
    Axios.get(API_URL+'/production/TuyenXe/getAll.php').then(data =>{
      console.log('res',data)
      this.setState({tuyen_xe:data.data})
    })
  }
  onChangeTuyen = (value) =>{
    Axios.post(API_URL+'/production/ChuyenXe/get.php',{
      id_tuyen:value
    }).then(data =>{
      console.log('res',data)
      this.setState({chuyen_xe:data.data})
    })
  }
  onSearch = (option) =>{
    
    Axios.post(API_URL+'/production/Booking/get.php',{
      id_tuyen:option[0],
      id_chuyen:option[1],
      start_time: new Date(moment(option[2]).format('YYYY-MM-DD')).getTime()
    }).then(data =>{
      if(data.data.message == 0){
        confirmAlert({
          title: 'Thông Báo',                        // Title dialog
          message: 'Chưa có Lịch Trình. bấm ok để tạo Lịch Trình',  
          buttons: [
            {
              label: 'Đồng Ý',
              onClick: () => this.createLichTrinh(option)
            },
            {
              label: 'Hủy Bỏ',
              onClick: () =>console.log('không đồng ý')
            }
          ], 
          //childrenElement: () => <div>Custom UI</div>,       // Custom UI or Component
         
        })
      }else{
        Axios.post(API_URL+'/production/customer/get.php',
        {
          id_tuyen:option[0],
          id_chuyen:option[1],
          start_time: new Date(moment(option[2]).format('YYYY-MM-DD')).getTime()
        }).then(data =>{
          this.setState({customer:data.data})
        })
        if(typeof data.data === 'object'){
          this.setState({cui_ve:data.data,option})
        }
      }
      
    })
  }
  createLichTrinh = (option) =>{
    Axios.post(API_URL+'/production/Booking/addBooking.php',{
      id_tuyen:option[0],
      id_chuyen:option[1],
      start_time: new Date(moment(option[2]).format('YYYY-MM-DD')).getTime()
    }).then(data =>{
      if(data.data.message == 1){
        this.onSearch(option)
      }else{
        alert('Có lổi sãy ra')
      }
      
    })
  }
  addInfo = (value) =>{
    value['id_tuyen'] = this.state.option[0]
    value['id_chuyen'] = this.state.option[1]
    value['start_time'] = new Date(moment(this.state.option[2]).format('YYYY-MM-DD')).getTime()
    console.log('=>',this.state.option)
  Axios.post(API_URL+'/production/CuiVe/update.php',value).then(data =>{
      if(data.data.message == 1){
        alert(data.data.value)
        this.onSearch(this.state.option)
      }else{
        alert(data.data.value)
      }
      
    })
  }
  alertcustomerdel = (params) =>{
    confirmAlert({
      title: 'Thông Báo',                        // Title dialog
      message: 'bạn chắc chắn muốn xóa khách hàng',  
      buttons: [
        {
          label: 'Đồng Ý',
          onClick: () => this.delCustomer(params)
        },
        {
          label: 'Hủy Bỏ',
          onClick: () =>console.log('không đồng ý')
        }
      ], 
      //childrenElement: () => <div>Custom UI</div>,       // Custom UI or Component
     
    })
  }
  delCustomer = (params) =>{
    
    Axios.post(API_URL+'/production/CuiVe/del.php',{
      id:params[0],
      titket_id:params[7].split(",")
    }).then(data =>{
      if(data.data.message == 0){
        alert(data.data.value)
        this.onSearch(this.state.option)
      }else{
        alert(data.data.value)
      }
      
    })
  }
  render() {
    return (
      (this.state.chuyen_xe != null && this.state.tuyen_xe != null)?
      <div>
        <DashboardLayout delcustomer ={(params)=>this.alertcustomerdel(params)} customer ={this.state.customer} chuyen_xe={this.state.chuyen_xe} tuyen_xe={this.state.tuyen_xe} onChangeTuyen={(value)=>this.onChangeTuyen(value)} option_value ={(v) =>this.onSearch(v)} cui_ve={this.state.cui_ve} addInfo={(value)=>this.addInfo(value)}/>
      </div>
      :<div></div>
    )
  }
}
