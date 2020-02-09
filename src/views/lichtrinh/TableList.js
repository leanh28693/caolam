import React, { Component } from 'react'
import PropTypes from 'prop-types'
// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
// core components
import GridItem from "components/Grid/GridItem.js";
import GridContainer from "components/Grid/GridContainer.js";
import Table from "components/Table/Table.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardBody from "components/Card/CardBody.js";
import Axios from 'axios';
import routes from "routes.js";
import { NavLink } from "react-router-dom";
import Icon from "@material-ui/core/Icon";
import AddBox from "@material-ui/icons/AddBox";
import ReactConfirmAlert, { confirmAlert } from 'react-confirm-alert'; // Import
import 'react-confirm-alert/src/react-confirm-alert.css' // Import css
import ReactTable  from "react-table-6";
import 'react-table-6/react-table.css'
import moment from "moment";
import PrintIcon from '@material-ui/icons/Print';
import GroupIcon from '@material-ui/icons/Group';
import { API_URL } from "variables/config.js";
import {
  Link
} from "react-router-dom";
const styles = {
  cardCategoryWhite: {
    "&,& a,& a:hover,& a:focus": {
      color: "rgba(255,255,255,.62)",
      margin: "0",
      fontSize: "14px",
      marginTop: "0",
      marginBottom: "0"
    },
    "& a,& a:hover,& a:focus": {
      color: "#FFFFFF"
    }
  },
  cardTitleWhite: {
    color: "#FFFFFF",
    marginTop: "0px",
    minHeight: "auto",
    fontWeight: "300",
    fontFamily: "'Roboto', 'Helvetica', 'Arial', sans-serif",
    marginBottom: "3px",
    textDecoration: "none",
    "& small": {
      color: "#777",
      fontSize: "65%",
      fontWeight: "400",
      lineHeight: "1"
    }
  }
};

const useStyles = makeStyles(styles);

function TableStyle(props) {
  const classes = useStyles();
    const data = props.data
    console.log(props.data)
    const columns = [{
      Header: 'ID',
      accessor: 'id' // String-based value accessors!
    },{
      Header: 'Ngày',
      accessor: 'start_time', // String-based value accessors!
      Cell: props =>  <span className='number'>{moment(new Date(parseFloat(props.value))).format("DD/MM/YYYY").toString()}</span>
    }, {
      Header: 'Tuyến Đường', // Required because our accessor is not a string
      accessor: 'tuyen'
    },{
      Header: 'Giờ',
      accessor: 'gio'
    }, {
      Header: 'Biển Số', // Required because our accessor is not a string
      accessor: 'license_plates'
    }, {
      Header: 'Print',
      accessor: "",
      width:70,
      Cell: props =><Link to={"print/"+props.value.id}><PrintIcon  /></Link>
    }, {
      Header: 'Danh sách khách',
      accessor: "",
      width:70,
      Cell: props =><Link to={"customer/"+props.value.id_tuyen+"/"+props.value.id_chuyen+"/"+props.value.start_time}><GroupIcon  /></Link>
    }]
  return (
    <ReactTable
    data={data}
    columns={columns}
    filterable={true}
  />
  );
}


export default class TableList extends Component {
  static propTypes = {
    prop: PropTypes
  }
  constructor(props) {
    super(props)
  
    this.state = {
      tableData:[],
      showDialog: true,
    }
  }
  componentDidMount(){
    Axios.get(API_URL+'/production/LichTrinh/getAll.php').then(data =>{
      console.log('res',data)
      this.setState({tableData:data.data})
    })
  }
  onDel = (id) =>{
    Axios.post(API_URL+'/production/LichTrinh/delCar.php',{
        'id':id,
        'token':localStorage.getItem('user')
    }).then(data =>{
      window.location.assign('/admin/table')
      
    })
  }
  submit = (id) => {
    confirmAlert({
      title: 'Thông Báo',                        // Title dialog
      message: 'Bạn chắt chắn muốn xóa.',  
      buttons: [
        {
          label: 'Đồng Ý',
          onClick: () => this.onDel(id)
        },
        {
          label: 'Hủy Bỏ',
          onClick: () => alert('Action after Cancel')
        }
      ], 
      //childrenElement: () => <div>Custom UI</div>,       // Custom UI or Component
     
    })
  };
  render() {
    return (
      <div>
        <TableStyle data={this.state.tableData} onDel={(e)=>{this.submit(e)}} />
      </div>
    )
  }
}
