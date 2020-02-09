
import React, { Component } from 'react'
import PropTypes from 'prop-types'
import axios from 'axios';
import { API_URL } from "variables/config.js";
export default class Login extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
    
        this.state = {
             id:"",
             password:""
        }
    }
    
      handleChangePass = event => {
        this.setState({ password: event.target.value });
      }
      handleChangeID = event => {
        this.setState({ id: event.target.value });
      }
      handleSubmit = event => {
        event.preventDefault();
    
        axios.post(API_URL+'/production/login.php', {
             "username":this.state.id,
             "password":this.state.password
            })
          .then(res => {
              if(res.data.message == 1){
                localStorage.setItem('user',res.data)
                window.location.reload();
              }else{
                  alert("tài khoản hoạc mật khẩu không chính xác. xin vui lòng thử lại")
              }
            
          })
      }
    render() {
        return (
            <div class="container " style={{height:'500px'}}>
                <div class="card card-login mx-auto text-center bg-success p-5">
                    <div class="card-header mx-auto bg-success text-white">
                    <h1>Nhà Xe Cao Lâm</h1>
                        <span class="logo_title mt-5"> Login Page</span>

                    </div>
                    <div class="card-body">
                        <form onSubmit={this.handleSubmit}>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">tài khoản</span>
                                </div>
                                <input type="text" name="id" id="id" value={this.state.id} onChange={this.handleChangeID} class="form-control" placeholder="Username"/>
                            </div>

                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Mật Khẩu</span>
                                </div>
                                <input type="password" name="password" id="id" value={this.state.password} onChange={this.handleChangePass} class="form-control" placeholder="Password"/>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="btn" value="Login" class="btn btn-outline-danger float-right login_btn"/>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        )
    }
}
