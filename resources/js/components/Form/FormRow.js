import React from "react";
import classNames from "classnames";
import PropTypes from 'prop-types'

function FormRow({ endOfForm, children, ...otherProps }) {
  const formClass = classNames({
    "form-row": true,
    "form-row-end": endOfForm
  });

  return <div className={formClass} {...otherProps}>{children}</div>;
}

FormRow.propTypes = {
  endOfForm: PropTypes.bool,
  children: PropTypes.any
}

export default FormRow;
