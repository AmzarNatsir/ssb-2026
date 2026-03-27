import React, { useState, useEffect, } from 'react';

const DebounceInput = ({ value: initialValue, onChange, debounce = 500, ...otherProps }) => {

    const [value, setValue] = useState(initialValue);

    useEffect(() => {
        setValue(initialValue)
    }, [initialValue]);

    useEffect(() => {
        const timeout = setTimeout(() => {
            onChange(value)
        }, debounce)
        return () => clearTimeout(timeout)
    }, [value]);

    return (
        <input value={value} onChange={evt => setValue(evt.target.value)} {...otherProps} />
    )
}

export default DebounceInput;