import React from 'react'; 

const PageHeader = ({ title }) => {
    return (
      <div className="row">
        <div className="col-sm-8">
          <h4 className="card-title text-primary">
            <span className="ri-chat-check-line pr-2"></span>{title}
          </h4>
        </div>
        <div className="col-sm-4 text-right"></div>        
      </div>
    )
  }
export default PageHeader;