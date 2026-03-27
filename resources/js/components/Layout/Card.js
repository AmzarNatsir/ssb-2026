import React from "react";
function Card({ title, children}){
  return (
    <div className="iq-card">
      <div className="iq-card-header d-flex justify-content-between">
          <div className="iq-header-title">
              <h4 className="card-title">{title}</h4>                                
          </div>
      </div>
      <div className="iq-card-body">
        {children}
      </div>
    </div>
  )
}

export default Card;