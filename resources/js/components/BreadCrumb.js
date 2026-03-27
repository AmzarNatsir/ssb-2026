import React from "react";
import classNames from "classnames";

function BreadCrumb({ breadcrumb }){
  return (
    <div className="navbar-breadcrumb">
        <nav aria-label="breadcrumb">
            <ul className="breadcrumb">
                {breadcrumb.map((item,i)=> 
                  <li key={`breadcrum-${i}`} className={classNames({
                    'breadcrumb-item':true,
                    active: item.active ? true : false
                  })}>
                    {item.active === true ? item.text : <a href="#">{item.text}</a>}                    
                  </li>
                )}                
            </ul>
        </nav>
    </div>
  )
}

export default BreadCrumb;