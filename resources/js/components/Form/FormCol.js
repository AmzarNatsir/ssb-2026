import React from "react";
import PropTypes from 'prop-types';

function FormCol({ sm, className, children, style }) {
  return (
    <div className={`col-sm-${sm}`} {...className} style={style}>
      {children}
    </div>
  );
}

FormCol.propTypes = {
  sm: PropTypes.string,
  className: PropTypes.string,
  children: PropTypes.any,
  style: PropTypes.object
}

export default FormCol;
