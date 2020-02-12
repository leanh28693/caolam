import React,{useState,Component} from 'react'
import PropTypes from 'prop-types'
import { withStyles } from "@material-ui/core/styles";
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
import { ClipLoader } from "react-spinners";
import styles from "assets/jss/material-dashboard-react/views/dashboardStyle.js";
class ChooseOption extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
             date: new Date(),
             active:false
        }
    }
    
    checked = (e) =>{
        this.props.checked(e.target.value)
        //toggleloading(false)
        this.setState({active:false})
      }
    actived = () =>{
        this.setState({active:false})
    } 
    handleSubmit = event =>{
        event.preventDefault();
        console.log(event.target.radio1)
        console.log(event.target.radio2)
        console.log(this.state.date)
        if(event.target.radio1 == undefined || event.target.radio1.value == '' || event.target.radio2 == undefined || this.state.date == undefined){
            alert("bạn chưa chọn tuyến hoạc giờ đi")
        }else{
            this.props.chooseOption([event.target.radio2.value,event.target.radio1.value,this.state.date])
        }
        this.setState({active:true})
       
    }
    onChange = (date) =>{
        this.setState({date,active:false})
    }  
    render() {
        const { classes } = this.props;
        let start_time_col = this.props.chuyen_xe.map((row,index) =>{
            return  (row[3] != "")?<div className="col-6" key={index}>
                    <FormGroup check>
                      <Label check>
                        <Input type="radio" name="radio1" id="radio1" defaultChecked={false} value={row[0]} onChange={(e)=>this.actived()}/>{' '}
                          {row[3]}
                      </Label>
                    </FormGroup>
                  </div>:<ClipLoader loading={true}  key={0}/>
          })
          const tuyen_col = this.props.tuyen_xe.map((row,index) =>{
            return (row[1] != "")?<FormGroup check key={index}>
                    <Label check>
                      <Input type="radio" name="radio2" id="radio2"  value={row[0]} onChange={(e)=>this.checked(e)}/>{' '}
                      {row[1]}
                    </Label>
                  </FormGroup>:""
          })
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="row">
                    <div className="col-8">
                        <GridContainer>
                        <GridItem xs={12} sm={6} md={6}>
                        <Card>
                            <CardHeader color="warning" stats icon>
                            <h3 className={classes.cardTitle}>
                                Chọn Tuyến
                            </h3>
                            </CardHeader>
                            <CardBody>
                                <div className="row">
                                <div className="col">
                                    {tuyen_col}
                                </div>
                                </div>
                            </CardBody>
                            <CardFooter stats>
                            <div className={classes.stats}>
                                <Danger>
                                <Warning />
                                </Danger>
                                <a href="#pablo" onClick={e => e.preventDefault()}>
                                Get more space
                                </a>
                            </div>
                            </CardFooter>
                        </Card>
                        </GridItem>
                        <GridItem xs={12} sm={6} md={6}>
                        <Card>
                            <CardHeader color="success" stats icon>
                            <h3 className={classes.cardTitle}>Chọn Giờ Đi</h3>
                            </CardHeader>
                            <CardBody>
                                <div className="row">
                                {start_time_col}
                                </div>
                                

                            </CardBody>
                            <CardFooter stats>
                            <div className={classes.stats}>
                                <DateRange />
                                Last 24 Hours
                            </div>
                            </CardFooter>
                        </Card>
                        
                        </GridItem>
                        <Button color="primary" className="col align-self-end" type="submit" disabled={this.state.active}>Tìm Kiếm</Button>
                    </GridContainer>
                    
                    </div>
                    <div className="col-4">
                    <GridContainer>
                        <GridItem xs={12} sm={6} md={12}>
                        <Card>
                            <CardHeader color="danger" stats icon>
                            <h3 className={classes.cardTitle}>Chọn Ngày Đi</h3>
                            </CardHeader>
                            <CardBody>
                            <Carlendar name="carlendar" dates={(e)=>this.onChange(e)}/>
                            </CardBody>
                            
                        </Card>
                        </GridItem>
                        
                    </GridContainer>
                    </div>
                    
                </div>
               
            </form>
            
        )
    }
}
export default withStyles(styles)(ChooseOption)

