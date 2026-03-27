import React from 'react';
const TableFilter = () => {
    return (
        <div className='row mt-4 mb-4 d-flex justify-content-center border-bottom'>
            <form>
                <div className='form-row'>
                    <div className='form-group pr-2'>
                        <label>Periode</label>
                        <input type="date" className='form-control' max={new Date().toISOString().substring(0,10)} />
                    </div>
                    <div className='form-group pr-2'>
                        <label>&nbsp;</label>
                        <input type="date" className='form-control' max={new Date().toISOString().substring(0,10)} />
                    </div>                    
                    <div className='form-group pr-2'>
                        <label>&nbsp;</label>
                        <button id="btn-filter-project" type="button" className="btn btn-lg btn-block btn-primary px-6 position-relative" style={{ height: '45px' }}>
                            <i className="ri-filter-line pr-1"></i><strong>Filter</strong>
                            <span className="badge bg-light ml-2 position-absolute top-0 start-100 rounded-circle text-dark translate-middle d-none">4</span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    )
}

const TableActions = ({ isShow }) => {
    return isShow ? (
        <div id="action-tags" className='col-md-3 text-center d-flex align-items-center justify-content-start'>
            <button
                id="action-tag-view"
                data-id=""
                className="tag mr-2">
                <i className="fa fa-eye pt-2 h5" aria-hidden="true" />
            </button>
        </div>
    ) : null
}

const TableSearch = () => {
    return (
        <div className='col-md-3'>
            <div className='form-group'>
                <input id='searchFilter' className='form-control form-control-sm pl-3' type="text" placeholder="Filter" />
            </div>
        </div>
    )
}

export {
    TableFilter,
    TableActions,
    TableSearch
}