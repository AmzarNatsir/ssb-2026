import React from "react";

function Label({ title }){
  return (    
    <label className="label" style={{ color:'#878787'}}>{title}</label>
  );
}

export default Label;