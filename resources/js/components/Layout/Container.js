import React from "react";

function Container(props){
  return (
    <div className="row">
      <div className="col-sm-12 col-lg-12">
      {props.children}        
      </div>
    </div>
  )
}

export default Container;