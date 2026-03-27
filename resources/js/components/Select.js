import React from "react";

const Select = React.forwardRef(({ name, items, onChange, className }, ref) => (    
    <>
    <select
        ref={ref} 
        name={name}        
        onChange={evt => onChange(evt, evt.target.name)}
        className={className}>
        <option value="">-</option>
        {items.map((option, i) => (
            <option key={`opt-${i}`} value={option.id}>
                {option.keterangan}
            </option>
        ))}
    </select>
    {/* {className} */}
    </>
));
  
export default Select;