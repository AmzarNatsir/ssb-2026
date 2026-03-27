import React from 'react';
import { useSelector } from 'react-redux'

const Indicator = ({ activeIndicatorId, items }) => items.map((item, id) => (
    <div key={`item-${id}`} className="col-3">
        <div className={`indicator-step ${activeIndicatorId === id ? 'active' : ''}`}></div>
    </div>))

const StepsIndicator = () => {
    const activeStep = useSelector((state) => state.safetySlice.modal.activeStep)
    return <Indicator items={[0,1,2,3]} activeIndicatorId={activeStep} />
}

export default StepsIndicator;