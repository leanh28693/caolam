import React, { Component } from 'react'
import PropTypes from 'prop-types'
import styles from "assets/jss/material-dashboard-react/views/dashboardStyle.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardBody from "components/Card/CardBody.js";
import CardFooter from "components/Card/CardFooter.js";
import AccessTime from "@material-ui/icons/AccessTime";
import HomeIcon from '@material-ui/icons/Home';
import AirlineSeatReclineNormalIcon from '@material-ui/icons/AirlineSeatReclineNormal';
import { withStyles } from "@material-ui/core/styles";
import Scrollbar from "react-scrollbars-custom";
import CloseIcon from '@material-ui/icons/Close';
class CustomerInfo extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
        this.myRef = React.createRef()
        this.state = {
            customer : []
        }
    }
    
    componentDidMount(){
        this.setState({customer:this.props.customer})
    }
    static getDerivedStateFromProps(props, state) {
        if (props.customer !== state.customer) {
            return {
                customer: props.customer
            }
        }
    }
    delcustomer = (params) =>{
        this.props.delcustomer(params)
    }
    render() {
        console.log('cusstomer',this.state.customer)
        const { classes } = this.props;
        const customer = this.state.customer.map((row,index) =>{

            return (row != null)?<div key={index}>
                    
                        <CardBody >
                        <div color="danger" className="d-flex justify-content-end">
                            <button type="button" class="btn btn-link" onClick={()=>this.delcustomer(row)}> <CloseIcon /></button>
                           
                        </div>
                            <h4 className={classes.cardTitle}>Họ Tên: {row[1]}</h4>
                            <h4 className={classes.cardTitle}>DT: {row[2]}</h4>
                            <p className={classes.cardCategory}> <AirlineSeatReclineNormalIcon /> {row[8]} ,  <HomeIcon /> {row[3]}</p>
                        </CardBody>
                        <CardFooter chart>
                            <div className={classes.stats}>
                        
                            </div>
                        </CardFooter>
                    </div>:""
        })
        return (
            <Card chart  >
                    <CardHeader color="danger">
                    <h3 className={classes.cardTitle}>Thông tin đặt vé</h3>
                    </CardHeader>
                    <Scrollbar style={{height: '100vh' }}>
                        {customer}
                    </Scrollbar>
                    
            </Card>
        )
    }
}
export default withStyles(styles)(CustomerInfo)