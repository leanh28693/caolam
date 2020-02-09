import React, { Component } from 'react'
import PropTypes from 'prop-types'
// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
import InputLabel from "@material-ui/core/InputLabel";
// core components
import GridItem from "components/Grid/GridItem.js";
import GridContainer from "components/Grid/GridContainer.js";
import CustomInput from "components/CustomInput/CustomInput.js";
import Button from "components/CustomButtons/Button.js";
import Card from "components/Card/Card.js";
import CardHeader from "components/Card/CardHeader.js";
import CardAvatar from "components/Card/CardAvatar.js";
import CardBody from "components/Card/CardBody.js";
import CardFooter from "components/Card/CardFooter.js";
import axios from 'axios';
import avatar from "assets/img/faces/marc.jpg";
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

function Addbuslayout() {
  const classes = useStyles();
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
                <GridItem xs={12} sm={12} md={5}>
                  <CustomInput
                    labelText="id chuyến xe"
                    id="id_chuyenxe"
                    name="id_chuyenxe"
                    formControlProps={{
                      fullWidth: true
                    }}
                  />
                </GridItem>
                <GridItem xs={12} sm={12} md={3}>
                  <CustomInput
                    labelText="biển số"
                    id="license_plates"
                    name="license_plates"
                    formControlProps={{
                      fullWidth: true
                    }}
                  />
                </GridItem>
                <GridItem xs={12} sm={12} md={4}>
                  <CustomInput
                    labelText="số ghế"
                    id="number_of_seats"
                    name="number_of_seats"
                    formControlProps={{
                      fullWidth: true
                    }}
                  />
                </GridItem>
              </GridContainer>
              
              
            </CardBody>
            <CardFooter>
              <Button color="primary" type="submit">Thêm Xe</Button>
            </CardFooter>
          </Card>
        </GridItem>
        
      </GridContainer>
    </div>
  );
}


export default class AddBus extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
             
        }
    }
    handleChange = event => {
        this.setState({ id: event.target.value });
    }
    handleSubmit = event => {
        event.preventDefault();
        axios.post(API_URL+'/production/Car/addCar.php', {
             "id_chuyen":event.target.id_chuyenxe.value,
             "license_plates":event.target.license_plates.value,
             "number_of_seats":event.target.number_of_seats.value
            })
          .then(res => {
            console.log(res);
            console.log(res.data);
            if(res.data.message == 1){
                alert('thêm thành công! bấm ok để quay về trang danh sách xe')
                window.location.assign('/admin/table')
            }else{
                alert('thêm không thành công! vui lòng kiểm tra lại thông tin')
            }
            
          })
      }
    render() {
        return (
            <div>
                <form onSubmit={this.handleSubmit}>
                    <Addbuslayout />
                </form>
            </div>
        )
    }
}
