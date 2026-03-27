import React, { Fragment } from "react";
import Label from "../Label";
import classNames from "classnames";

export const CUSTOMER_TYPE = [{
  title:'Customer Baru',
  value:1
},{
  title:'Existing Customer',
  value:2
}];

class CustomerSection extends React.Component {
  constructor(props){
    super(props);
    this.onInputChange = this.onInputChange.bind(this);
    this.state = {
      customer_type:2
    }
  }

  onInputChange(evt){
    let name = evt.target.name;
    this.setState({
      [name]:evt.target.value
    })
  }
  render(){
    const { customer_type } = this.state
    return (
      <Fragment>
        <div className="section">
          <h5>Customer Info</h5>
        </div>
        <div className="form-row" style={{ marginBottom: 20 }}>
          {CUSTOMER_TYPE.map((section,i)=>
            <div key={`cust-type-${i}`} className="form-check form-check-inline">
              <input 
                className="form-check-input" 
                type="radio" 
                name="customer_type" 
                value={section.value} 
                onChange={this.onInputChange}
                checked={ customer_type == section.value ? true : false } />
              <Label title={section.title} />          
            </div>
          )}          
        </div>
        <div className={classNames({ collapse: customer_type == 1 ? true : false })}>
          <div className="form-row d-flex flex-column align-items-start">          
            <Label title="Pilih Existing Customer" />
            <div className="col-sm-3 d-flex flex-row justify-content-center">
              <input 
                type="text" 
                name="existing_customer_id" 
                className="form-control form-control-sm" 
                placeholder="Customer ID" 
                readOnly={customer_type == 1 ? true : false }
                value={this.props.customer_id} />
              <button name="customer_lookup_button" className="btn btn-info mb-3" 
                data-toggle="tooltip" data-placement="top" title="cari customer berdasarkan ID"  
                style={{ marginTop:5,marginLeft:5 }}>
                <i className="ri-search-fill"></i>
              </button>
            </div>                    
          </div>
        </div>
        
        <div className={classNames({ collapse: customer_type == 2 ? true : false })}>
          <div className="form-row">
            <div className="col-sm-3">              
              <Label title="Diisi jika Customer Baru" />
              <input 
                type="text" 
                name="customer_no" 
                className="form-control form-control-sm" 
                placeholder="Customer No"
                value={this.props.customer_no}
                onChange={(evt) => this.props.handleInputChange(evt, evt.target.name)} />
            </div>              
            <div className="col-sm-3">              
              <label className="label">&nbsp;</label>
              <input 
                type="text" 
                name="customer_name" 
                className="form-control form-control-sm" 
                placeholder="Customer Name"
                value={this.props.customer_name}
                onChange={(evt) => this.props.handleInputChange(evt, evt.target.name)} />
            </div>              
          </div>
        </div>        

        {/* Modal */}
        <div className="modal fade">
          <div className="modal-dialog modal-dialog-centered">
            <div className="modal-content">
              <div className="modal-header">
                header
              </div>
            </div>
          </div>
        </div>

      </Fragment>
    );
  }
}

export default CustomerSection;