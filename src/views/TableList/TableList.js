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
import { API_URL } from "variables/config.js";
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
  return (
    <GridContainer>
      <GridItem xs={12} sm={12} md={12}>
        <Card>
          <CardHeader color="primary">
            <h4 className={classes.cardTitleWhite}>Thông tin xe</h4>
            <p className={classes.cardCategoryWhite}>
              tất cả các xe được khai báo ở đây
            </p>
            <NavLink
            to="/admin/addbus">
              <AddBox />
            </NavLink>
          </CardHeader>
          <CardBody>
            <Table
              tableHeaderColor="primary"
              tableHead={props.data.tableHead}
              tableData={props.data.tableData}
              editlink="/admin/editbus"
              del={(e)=>{props.onDel(e)}}
            />
          </CardBody>
        </Card>
      </GridItem>
    </GridContainer>
  );
}


export default class TableList extends Component {
  static propTypes = {
    prop: PropTypes
  }
  constructor(props) {
    super(props)
  
    this.state = {
      tableHead:["ID","Biển số xe", "Số ghế","Ghi chú",'Công cụ'],
      tableData:[],
      showDialog: true,
    }
  }
  componentDidMount(){
    Axios.get(API_URL+'/production/Car/getAll.php').then(data =>{
      console.log('res',data)
      this.setState({tableData:data.data})
    })
  }
  onDel = (id) =>{
    Axios.post(API_URL+'/production/Car/delCar.php',{
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
        <TableStyle data={this.state} onDel={(e)=>{this.submit(e)}} />
      </div>
    )
  }
}
