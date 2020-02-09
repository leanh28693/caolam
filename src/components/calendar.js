import React, { Component } from 'react'
import Calendar from 'react-calendar';

export default class calendar extends Component {
    constructor(props) {
        super(props)
    
        this.state = {
            date: new Date(),
        }
    }
    onChange = date =>{
        //console.log('date',date)
        this.props.dates(date)
        this.setState({ date })
    }

    render() {
        return (
            <div>
            <Calendar
              onChange={this.onChange}
              value={this.state.date}
            />
          </div>
        )
    }
}
