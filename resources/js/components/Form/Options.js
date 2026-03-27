import React from "react";
import _ from "lodash";

const Options = React.forwardRef(
  (
    { 
      label = "", 
      data = [], 
      onChange, 
      value, 
      readOnly = false, 
      optionValue = "id", 
      optionLabel = "name",
      disableArrowDown = false,
      ...otherProps
    }, ref
  ) => (    
    <React.Fragment>
      {label && <label>{label}</label>}
      <select
        ref={ref}         
        className="form-control" 
        onChange={onChange}        
        readOnly={readOnly}
        style={{ borderRight: '10px transparent solid', borderBottom: '15px' }}
        {...otherProps}>
        <option value="">Pilih Opsi</option>
        {data.length > 0 && data.map((option,id)=>(
          <option key={`option-${id}`} value={option[optionValue]}>{_.capitalize(option[optionLabel])}</option>
        ))}
      </select>
    </React.Fragment>
  )
);

export default Options;