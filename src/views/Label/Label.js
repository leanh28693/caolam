import React,{ Component } from 'react'
import Store from "@material-ui/icons/Store";
import { makeStyles } from "@material-ui/core/styles";
import PropTypes from 'prop-types'
import GridItem from "components/Grid/GridItem.js";
import GridContainer from "components/Grid/GridContainer.js";
import Danger from "components/Typography/Danger.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardIcon from "components/Card/CardIcon.js";
import CardBody from "components/Card/CardBody.js";
import CardFooter from "components/Card/CardFooter.js";
import { Button, Form, FormGroup, Label, Input, TabContent, TabPane, Nav, NavItem, NavLink, CardTitle, CardText, Row, Col,Modal, ModalHeader, ModalBody, ModalFooter } from 'reactstrap';
import Seat from "../../assets/img/Group.png";
import Seat1 from "../../assets/img/Group-1.png";
import Seat2 from "../../assets/img/Group-2.png";
import classnames from 'classnames';
import styles from "assets/jss/material-dashboard-react/views/dashboardStyle.js";
import { withStyles } from "@material-ui/core/styles";
import Axios from 'axios';
import { API_URL } from "variables/config.js";
class Labels extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
            activeTab: '1',
            tang_tren:[],
            tang_duoi:[],
            label:[]
        }
    }
    toggle = tab => {
        if(this.state.activeTab !== tab){
            this.setState({activeTab :  tab})
        }
    }
    componentDidMount(){
      Axios.get(API_URL+'/production/Label/getAll.php').then(data =>{
        let tren = []
        let duoi = []
            if(data.data.length > 0){
              data.data.map((row,index) =>{
                    if(index < 23){
                        duoi.push(row)
                    }else{
                        tren.push(row)
                    }
                })
            } 
        this.setState({label:data.data,tang_tren:tren,tang_duoi:duoi})
      })
    }
    hancleChange = (e) =>{
      console.log(e.target.id)
      let label = [...this.state.label]
      let tren = [...this.state.tang_tren]
      let duoi = [...this.state.tang_duoi]
      label[e.target.id-1][1] = e.target.value
      if(e.target.id > 23){
        tren[e.target.id - 24][1] = e.target.value
      }else{
        duoi[e.target.id - 1][1] = e.target.value
      }
      this.setState({label,tang_tren:tren,tang_duoi:duoi})
    }

    handleSubmit = event =>{
        Axios.post(API_URL+'/production/Label/update.php',{
            'params':this.state.label,
        }).then(data =>{
          if(data.data.message == 1){
              alert('update thành công')
              window.location.assign('/admin/control-label')
          }else{
            alert('update không thành công! vui long kiểm tra lại thông tin hoạc lên hệ admin để được giải quyết')
          }
        })
        event.preventDefault();

    }
    render() {
        const { classes } = this.props
        const downstairs = this.state.tang_duoi.map((row,index) =>{
            return  <div key={index} className={(index >18?"col-2 mt-5 text-center":"col-2 offset-2 mt-5 text-center")}>
                        <div className="btn  text-center">
                            <img src={Seat} />
                            
                        </div>
                        <div className="form-group">
                            <input className="col-6" id={row[0]} value={row[1]} onChange={(e)=>this.hancleChange(e)}/>
                        </div>
                        
                        
                    </div>
                    
        })
        const upstairs = this.state.tang_tren.map((row,index) =>{
            return  <div key={index} className={(index >18?"col-2 mt-5 text-center":"col-2 offset-2 mt-5 text-center")}>
                        <div className="btn  text-center">
                            <img src={Seat} />
                            
                        </div>
                        <div className="form-group">
                            <input className="col-6" id={row[0]} value={row[1]} onChange={(e)=>this.hancleChange(e)}/>
                        </div>
                        
                    </div>
                    
        })
        return (    
            <form onSubmit={(e)=>this.handleSubmit(e)}>
                <Card chart>
                <CardHeader color="success">
                <h3 className={classes.cardTitle}>Chọn ghế ngồi</h3>
                </CardHeader>
                <CardBody>
                <div className="row">
                <div className="col-10">
                    <Nav tabs >
                    <NavItem>
                        <NavLink
                        className={classnames({ active: this.state.activeTab === '1' })}
                        onClick={() => { this.toggle('1'); }}
                        >
                        Tầng Dưới
                        </NavLink>
                    </NavItem>
                    <NavItem>
                        <NavLink
                        className={classnames({ active: this.state.activeTab === '2' })}
                        onClick={() => { this.toggle('2'); }}
                        >
                        Tầng Trên
                        </NavLink>
                    </NavItem>
                    </Nav>
                    <TabContent activeTab={this.state.activeTab} className="pt-4">
                    <TabPane tabId="1">
                        <Row>
                        <Col sm="12">
                        <div className="row mb-4">
                            {downstairs}       
                        </div>
                        </Col>
                        </Row>
                    </TabPane>
                    <TabPane tabId="2">
                        <Row>
                        <Col sm="12">
                            <div className="row mb-4">
                                {upstairs}
                            </div>
                        </Col>
                        </Row>
                    </TabPane>
                    </TabContent>
                </div>
                
                </div>    
                </CardBody>
                <CardFooter chart className="d-flex justify-content-end">
                    <Button type="submit" color="primary" >Update</Button>
                </CardFooter>
            </Card>
            </form>
        )
    }
}


export default withStyles(styles)(Labels)

