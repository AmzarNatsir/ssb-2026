import React from 'react';
import ReactDOM from 'react-dom';
import { formik } from 'formik';
import PageHeader from '../../components/PageHeader';
import BreadCrumb from '../../components/BreadCrumb';
// import useModal from '../../hooks/useModal';
// import ModalDialog from '../../components/Modal';

const BREADCRUMBS_ITEMS = [{
    text:'Dashboard',
    active:false
},{
    text:'HSE',
    active:true
},{
    text:'Safety Induction',
    active:true
}]

const CSinduction = () => {
    // const { openModal, closeModal, isOpen, Modal } = useModal()
    return (
        <>
        <BreadCrumb breadcrumb={BREADCRUMBS_ITEMS} />
        <div className='iq-card'>
            <div className="iq-card-body">
                <PageHeader title="my page title" />
                <form>

                </form>
            </div>            
        </div>
        </>
    )
}

export default CSinduction;

if (document.getElementById('create-sinduction-dom')) {
    const elem = document.getElementById('create-sinduction-dom')
    ReactDOM.render(<CSinduction />, elem);
}