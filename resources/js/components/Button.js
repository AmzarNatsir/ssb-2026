import React from "react";
import classNames from "classnames";
import PropTypes from 'prop-types';

function Button({ sm, success, children, ...otherProps }) {
  
  const buttonClass = classNames({
    btn: true,
    "btn-sm": sm ? true : false,
    "btn-success": success ? true : false
  });

  return (
    <button className={buttonClass} {...otherProps}>
      {children}
    </button>
  );
}

Button.propTypes = {
  sm: PropTypes.bool,
  success: PropTypes.bool,
  children: PropTypes.array,
}

export default Button;
