import React from "react";
import classNames from "classnames";
import PropTypes from "prop-types";
// @material-ui/core components
import { makeStyles } from "@material-ui/core/styles";
import FormControl from "@material-ui/core/FormControl";
import InputLabel from "@material-ui/core/InputLabel";
import Input from "@material-ui/core/Input";
// @material-ui/icons
import Clear from "@material-ui/icons/Clear";
import Check from "@material-ui/icons/Check";
// core components
import styles from "assets/jss/material-dashboard-react/components/customInputStyle.js";
import 'date-fns';
import Grid from '@material-ui/core/Grid';
import DateFnsUtils from '@date-io/date-fns';
import {
  MuiPickersUtilsProvider,
  KeyboardTimePicker,
  KeyboardDatePicker,
} from '@material-ui/pickers';
const useStyles = makeStyles(styles);

export default function CustomInput(props) {
  const classes = useStyles();

  const {
    formControlProps,
    labelText,
    id,
    name,
    label,
    labelProps,
    inputProps,
    error,
    success,
    defaultValue
  } = props;
  
  const labelClasses = classNames({
    [" " + classes.labelRootError]: error,
    [" " + classes.labelRootSuccess]: success && !error
  });
  const underlineClasses = classNames({
    [classes.underlineError]: error,
    [classes.underlineSuccess]: success && !error,
    [classes.underline]: true
  });
  const marginTop = classNames({
    [classes.marginTop]: labelText === undefined
  });
  const [selectedDate, setSelectedDate] = React.useState(new Date((defaultValue === undefined)?'2014-08-18T01:00:00':'2014-08-18T'+defaultValue));

  const handleDateChange = date => {
    setSelectedDate(date);
  };
  return (
    <FormControl
      {...formControlProps}
      className={formControlProps.className + " " + classes.formControl}
    >
      <MuiPickersUtilsProvider utils={DateFnsUtils}>
        <KeyboardTimePicker
          classes={{
            root: marginTop,
            disabled: classes.disabled,
            underline: underlineClasses
          }}
            margin="normal"
            id={id}
            label={label}
            name={name}
            value={selectedDate}
            date = 'false'
            format = 'HH:mm'
            defaultValue = {defaultValue}
            onChange={handleDateChange}
            KeyboardButtonProps={{
              'aria-label': 'change time',
            }}
        />
      </MuiPickersUtilsProvider> 
      {error ? (+
        <Clear className={classes.feedback + " " + classes.labelRootError} />
      ) : success ? (
        <Check className={classes.feedback + " " + classes.labelRootSuccess} />
      ) : null}
    </FormControl>
  );
}

CustomInput.propTypes = {
  labelText: PropTypes.node,
  labelProps: PropTypes.object,
  id: PropTypes.string,
  inputProps: PropTypes.object,
  formControlProps: PropTypes.object,
  error: PropTypes.bool,
  success: PropTypes.bool
};
