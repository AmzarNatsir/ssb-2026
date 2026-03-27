import React from "react";
export const replaceSpace = str => str.replace(/\s/g , "_");

const OptionGroup = ({ name, options, defaultChecked, register }, ref) => {  
  return options.map((item,i) => {    
        return (
          <React.Fragment>
            <div key={`index-${i}`} className="form-check form-check-inline">
              <input
                ref={ref}              
                className="form-check-input" 
                type="radio"               
                name={name} 
                value={item.value}
                defaultChecked={defaultChecked === item.value}
                {...register(replaceSpace(name).toLowerCase())} />
              <label className="form-check-label" htmlFor="inlineRadio1">{item.label}</label>
            </div>        
          </React.Fragment>
        );
    })    
}

export default OptionGroup;