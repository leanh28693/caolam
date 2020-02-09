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
class Booking extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
            activeTab: '1',
            tang_tren:[],
            tang_duoi:[],
            cui_ve:[],
            seat_choosing:[],
            modal:false
        }
    }
    toggle = tab => {
        if(this.state.activeTab !== tab){
            this.setState({activeTab :  tab})
        }
    }
    toggle2 = () => this.setState({modal:!this.state.modal})
    componentDidMount(){
        
        this.setState({cui_ve:this.props.cui_ve})
    }
    static getDerivedStateFromProps(props, state) {
        if (props.cui_ve !== state.cui_ve) {
            let tren = []
            let duoi = []
            if(props.cui_ve.length > 0){
                props.cui_ve.map((row,index) =>{
                    if(index < 23){
                        duoi.push(row)
                    }else{
                        tren.push(row)
                    }
                })
            } 
          return {
            cui_ve: props.cui_ve,
            tang_tren:tren,
            tang_duoi:duoi
          };
        }
    
        // Return null if the state hasn't changed
        return null;
      }
    choosing = (row) =>{
        console.log(row)
        if(row.status !== '1'){
            let newarray = [...this.state.seat_choosing]
            let posion = newarray.indexOf(row)
            if(posion != -1){
                newarray.splice(posion,1)
            }else{
                newarray.push(row)
            }
            
            this.setState({seat_choosing:newarray})
        }
        
    }
    handleSubmit = event =>{
        event.preventDefault();
        let value ={
            name:event.target.name.value,
            phone:event.target.phone.value,
            address:event.target.address.value,
            seat_choosing:this.state.seat_choosing
        }
        this.props.addInfo(value)
        this.setState({seat_choosing:[]})
    }
    render() {
        const { classes } = this.props
        const downstairs = this.state.tang_duoi.map((row,index) =>{
            return  <div key={index} className={(index >18?"col-2 mt-5 text-center":"col-2 offset-2 mt-5 text-center")}>
                        <div className="btn  text-center" onClick={()=>this.choosing(row)}>
                            <img src={(this.state.seat_choosing.indexOf(row) != -1)?Seat1:(row.status == '0')?Seat:Seat2} />
                            
                        </div>
                        <p>{row.label}</p>
                        
                    </div>
                    
        })
        const upstairs = this.state.tang_tren.map((row,index) =>{
            return  <div key={index} className={(index >18?"col-2 mt-5 text-center":"col-2 offset-2 mt-5 text-center")}>
                        <div className="btn  text-center" onClick={()=>this.choosing(row)}>
                            <img src={(this.state.seat_choosing.indexOf(row) != -1)?Seat1:(row.status == '0')?Seat:Seat2} />
                            
                        </div>
                        <p>{row.label}</p>
                        
                    </div>
                    
        })
        return (
            <div>
                <Card chart>
                <CardHeader color="success">
                <h3 className={classes.cardTitle}>Chọn ghế ngồi</h3>
                </CardHeader>
                <CardBody>
                <div className="row">
                <div className="col-6">
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
                <div className="col-6 d-flex justify-content-center align-items-center bd-highlight mb-3">
                    <div className="row">
                    <div className="col-12 mb-4">
                        <div className="row">
                        <div className="col-6 text-right">
                            <img src={Seat2} />
                        </div>
                        <div className="col-6">
                            <h4>Ghế đã có khách</h4>
                        </div>
                        </div>  
                    </div>
                    <div className="col-12 mb-4">
                        <div className="row">
                        <div className="col-6 text-right">
                            <img src={Seat} />
                        </div>
                        <div className="col-6">
                            <h4>Ghế chưa có khách</h4>
                        </div>
                        </div>  
                    </div>
                    <div className="col-12">
                        <div className="row">
                        <div className="col-6 text-right">
                            <img src={Seat1} />
                        </div>
                        <div className="col-6">
                            <h4>Ghế đang chọn</h4>
                        </div>
                        </div>  
                    </div>
                    </div>

                </div>
                </div>    
                </CardBody>
                <CardFooter chart className="d-flex justify-content-end">
                <Modal isOpen={this.state.modal} >
                    <ModalHeader >Thông Tin Khách Hàng</ModalHeader>
                        <form onSubmit={this.handleSubmit}>
                            <ModalBody>
                            <FormGroup>
                                <Label for="exampleEmail">Họ Tên</Label>
                                <Input type="text" name="name" id="name" placeholder="Nguyen Văn A" />
                            </FormGroup>
                            <FormGroup>
                                <Label for="exampleEmail">Số Điện Thoại</Label>
                                <Input type="text" name="phone" id="phone" placeholder="0352 000 000" />
                            </FormGroup>
                            <FormGroup>
                                <Label for="exampleEmail">Điểm Đón</Label>
                                <Input type="text" name="address" id="address" placeholder="Phan thiết" />
                            </FormGroup>
                            </ModalBody>
                            <ModalFooter>
                                <Button type="submit" color="primary" onClick={()=>this.toggle2()}>Đồng Ý</Button>{' '}
                                <Button color="secondary" onClick={()=>this.toggle2()}>Hủy Bỏ</Button>
                            </ModalFooter>
                        </form>
                </Modal>
                    {/* <AccessTime /> updated 4 minutes ago */}
                    <Button color="primary" onClick={()=>this.toggle2()}>Đặt Vé</Button>
                </CardFooter>
            </Card>
            </div>
        )
    }
}


export default withStyles(styles)(Booking)

