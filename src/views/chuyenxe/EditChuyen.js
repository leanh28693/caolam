import React, { Component } from 'react'
import PropTypes from 'prop-types'
// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
import InputLabel from "@material-ui/core/InputLabel";
// core components
import GridItem from "components/Grid/GridItem.js";
import GridContainer from "components/Grid/GridContainer.js";
import CustomInput from "components/CustomInput/CustomInput2.js";
import CustomDatePicker from "components/CustomDatePicker/CustomDatePicker";
import Button from "components/CustomButtons/Button.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardAvatar from "components/Card/CardAvatar.js";
import CardBody from "components/Card/CardBody.js";
import CardFooter from "components/Card/CardFooter.js";
import axios from 'axios';
import avatar from "assets/img/faces/marc.jpg";
import CustomSelect from "components/CustomSelect/CustomSelect.js";
import { API_URL } from "variables/config.js";
const styles = {
  cardCategoryWhite: {
    color: "rgba(255,255,255,.62)",
    margin: "0",
    fontSize: "14px",
    marginTop: "0",
    marginBottom: "0"
  },
  cardTitleWhite: {
    color: "#FFFFFF",
    marginTop: "0px",
    minHeight: "auto",
    fontWeight: "300",
    fontFamily: "'Roboto', 'Helvetica', 'Arial', sans-serif",
    marginBottom: "3px",
    textDecoration: "none"
  }
};

const useStyles = makeStyles(styles);

function Editbuslayout(props) {
  const classes = useStyles();
  console.log('props.data',props.data)
  return (
    <div>
      <GridContainer>
        <GridItem xs={12} sm={12} md={12}>
          <Card>
            <CardHeader color="primary">
              <h4 className={classes.cardTitleWhite}>Thêm Xe</h4>
              <p className={classes.cardCategoryWhite}>thêm xe mới vào hệ thống</p>
            </CardHeader>
            <CardBody>
              <GridContainer>
              <GridItem xs={12} sm={12} md={4}>
                    <CustomDatePicker
                    label="Giờ khởi hành"
                    id="start_time"
                    name="start_time"
                    defaultValue = {props.data[0].start_time}
                    formControlProps={{
                      fullWidth: true
                    }}
                    />
                </GridItem>
                <GridItem xs={12} sm={12} md={5}>
                  <CustomSelect
                    labelText="Tuyến xe"
                    id="id_tuyen"
                    name="id_tuyen"
                    defaultValue = {props.data[0].id_tuyen}
                    options ={props.tuyen}
                    formControlProps={{
                      fullWidth: true
                    }}
                  />
                </GridItem>
                <GridItem xs={12} sm={12} md={3}>
                  <CustomSelect
                    labelText="Xe"
                    id="id_xe"
                    name="id_xe"
                    defaultValue = {props.data[0].id_xe}
                    options ={props.xe}
                    formControlProps={{
                      fullWidth: true
                    }}
                  />
                </GridItem>
              </GridContainer>
              
              
            </CardBody>
            <CardFooter>
              <Button color="primary" type="submit">Lưu Thông Tin</Button>
            </CardFooter>
          </Card>
        </GridItem>
        
      </GridContainer>
    </div>
  );
}


export default class EditChuyen extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
             id:this.props.match.params.urlID,
             data:null,
             tuyen:[],
             xe:[]
        }
    }
    componentDidMount(){
      axios.get(API_URL+'/production/TuyenXe/getAll.php').then(res =>{
        //console.log(res.data)
        this.setState({tuyen:res.data})
        axios.get(API_URL+'/production/Car/getAll.php').then(res =>{
          //console.log(res.data)
          this.setState({xe:res.data})
          axios.post(API_URL+'/production/ChuyenXe/edit.php',{
            "id":this.state.id
          }).then(res =>{
            console.log('get edit',res.data);
            this.setState({data:res.data})
          })
        })
      })
      
    }
    handleChange = event => {
        this.setState({ id: event.target.value });
    }
    handleSubmit = event => {
        event.preventDefault();
        axios.post(API_URL+'/production/ChuyenXe/update.php', {
             "id":this.state.id,
             "id_tuyen":event.target.id_tuyen.value,
             "id_xe":event.target.id_xe.value,
             "start_time":event.target.start_time.value
            })
          .then(res => {
            console.log(res);
            console.log(res.data);
            if(res.data.message == 1){
                alert('chỉnh sửa thành công! bấm ok để quay về trang danh sách xe')
                window.location.assign('/admin/chuyen-xe')
            }else{
                alert('chỉnh sửa không thành công! vui lòng kiểm tra lại thông tin')
            }
            
          })
      }
    render() {
      console.log('this.state.data',this.state.data)
        return (
          (this.state.data == null)?"":
            <div>
                <form onSubmit={this.handleSubmit}>
                    <Editbuslayout data={this.state.data}  tuyen={this.state.tuyen} xe={this.state.xe}/>
                </form>
            </div>
        )
    }
}
