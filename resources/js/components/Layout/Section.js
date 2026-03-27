import React from "react";
import PropTypes from 'prop-types'

function Section({ title, description = "", style }) {
  return (
    <div className="section" style={style}>
      <h5>{title}</h5>
      <small>{description}</small>
    </div>
  );
}

Section.propTypes = {
  title: PropTypes.string,
  description: PropTypes.string,
  style: PropTypes.object
}

export default Section;
