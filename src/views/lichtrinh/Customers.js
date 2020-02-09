import React, { Component } from 'react'
import PropTypes from 'prop-types'
import Axios from 'axios';
import AirlineSeatReclineNormalIcon from '@material-ui/icons/AirlineSeatReclineNormal';
import { API_URL } from "variables/config.js";
import Board from '@lourenci/react-kanban'
import ReactToPrint from 'react-to-print';
import PrintIcon from '@material-ui/icons/Print';
export default class Customers extends Component {
    static propTypes = {
        prop: PropTypes
    }
    constructor(props) {
        super(props)
        this.state = {
            customer_list:[],
            
        }
    }
    componentDidMount(){
        Axios.post(API_URL+'/production/customer/get.php',{
            id_tuyen:this.props.match.params.id_tuyen,
            id_chuyen:this.props.match.params.id_chuyen,
            start_time:this.props.match.params.start_time
        }).then(data =>{
            console.log('data',data)
            this.setState({customer_list:data.data})
        });
        
    }
    LaneAdder = (addLane ) => {
        return (
          <div onClick={()=> addLane({id: 3, title: 'Title', cards:[]})}>
            Add lane
          </div>
        )
      }
    render() {
        let card = []
        this.state.customer_list.map((row,index) =>{
        let tam = {id:index+1,title:row[1],description:<p>{"ĐT : "+row[2]}<br></br>{"Địa Chỉ : "+row[3]}<br></br>{"Ghế : "+row[8]}</p>}
            card.push(tam)
        })
        console.log('card',card)
        const board = {
            lanes: [
              {
                id: 1,
                title: 'Hàng chờ',
                cards: card
              },
              {
                id: 2,
                title: 'Xe 1',
                cards: [
                 
                ]
              },{
                id: 3,
                title: 'Xe 2',
                cards: [
                 
                ]
              },{
                id: 4,
                title: 'Xe 3',
                cards: [
                 
                ]
              },{
                id: 5,
                title: 'Xe 4',
                cards: [
                 
                ]
              }
              
            ]
          }
        
        return (
            
            <div className="row">
               <div className="col-12"> <ReactToPrint
                trigger={() => <a href="#"><PrintIcon /></a>}
                content={() => this.componentRef}
                ></ReactToPrint></div>
                <div className="col-12" ref={el => (this.componentRef = el)}>
                    <h1>Sắp xếp xe rước</h1>
                    {card.length ==0?"":<Board 
                    allowRenameLane
                    onLaneRename={console.log}
                    initialBoard={board}
                    
                    />}
                </div>
                
            </div>
        )
    }
}
