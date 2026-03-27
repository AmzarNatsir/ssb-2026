import React, { useEffect, useState, useRef, useMemo } from 'react';
import {
    createColumnHelper,
    getCoreRowModel,
    getFilteredRowModel,
    useReactTable,
    flexRender,
} from '@tanstack/react-table';

import { rankItem } from '@tanstack/match-sorter-utils'

import { useQuery } from '@tanstack/react-query';
import { useSelector, useDispatch } from 'react-redux'
import { loadPage, setUiAction, setModalActiveStep } from './slice'

// components
import Container from '@/components/Layout/Container';
import Card from '@/components/Layout/Card';
import { FormRow, FormCol } from '@/components/Form';
import Button from '@/components/Button';
import {
    TableActions,
    TableFilter,
} from '@/components/Table';
import DebounceInput from '@/components/Form/DebounceInput';
import FormSteps from './form-steps';
import StepsIndicator from './step-indicator';

import { getInductions } from './services'

const defaultData = [
    {
        id: '1',
        tanggal: '20/08/2022',
        karyawan: 'Denny R',
        dokumen: 'surat pengantar | kuesioner | JSA',
        approval: 'HSE manager'
    },
    {
        id: '2',
        tanggal: '20/08/2022',
        karyawan: 'Amzar N',
        dokumen: 'surat pengantar | kuesioner | JSA',
        approval: 'HSE manager'
    }
]

const columnHelper = createColumnHelper();

const fuzzyFilter = (row, columnId, value, addMeta) => {
    const itemRank = rankItem(row.getValue(columnId), value)
    addMeta({ itemRank })
    return itemRank.passed
}

// table specific components
const Checkbox = ({ indeterminate, ...otherProps }) => {
    const ref = useRef(null);
    useEffect(() => {
        if (typeof indeterminate === 'boolean') {
            ref.current.indeterminate = !otherProps.checked && indeterminate
        }
    }, [ref, indeterminate])

    return <input ref={ref} type="checkbox" {...otherProps} />;
}

// test modal
const ModalDialog = ({ children }) => {
    return (
        <div className="modal fade" id="createProjectModal" tabIndex="-1" role="dialog" aria-labelledby="createProjectModal" aria-modal="true">
            <div className="modal-dialog w600" role="document">
                <div className="modal-content">
                    <div className="modal-body">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    )
}

const ModalBody = () => {
    const dispatch = useDispatch();
    const activeStep = useSelector((state) => state.safetySlice.modal.activeStep)
    return (
        <>
            <div className="row mb-4">
                <StepsIndicator />
            </div>
            <button type="button" className="absolute-close" data-dismiss="modal" aria-label="Close">
                <i className="ri-close-line"></i>
            </button>
            {
                activeStep > 0 && (
                    <button                        
                        className="btn-prev-step"                        
                        onClick={(evt) => {
                            evt.preventDefault();
                            dispatch(setModalActiveStep(activeStep-1))
                        }}>
                        <i className="ri-arrow-left-line"></i>
                    </button>
                )
            }
            <FormSteps />
        </>
    )
}

const IndexPage = () => {

    const dispatch = useDispatch()
    const isPageLoaded = useSelector((state) => state.safetySlice.isInductionPageLoaded)

    const inductions = useQuery(['jobRoles'], getInductions);

    // console.log(inductions);

    const columns = useMemo(() => [
        columnHelper.display({
            id: 'actions',
            header: 'actions',
            cell: ({ row }) => (
                <Checkbox {...{
                    checked: row.getIsSelected(),
                    indeterminate: row.getIsSomeSelected(),
                    onChange: row.getToggleSelectedHandler()
                }} />
            )
        }),
        columnHelper.accessor('tanggal', {
            cell: info => info.getValue()
        }),
        columnHelper.accessor('karyawan', {
            cell: info => info.getValue()
        }),
        columnHelper.accessor('dokumen', {
            cell: info => info.getValue()
        }),
        columnHelper.accessor(row => row.approval, {
            id: 'approval',
            cell: info => <i>{info.getValue()}</i>
        })
    ], [])

    const [data, setData] = useState(() => [...defaultData]);
    const [activeIndicatorId, setActiveIndicatorId] = useState(0)
    const [rowSelection, setRowSelection] = useState({})
    const [globalFilter, setGlobalFilter] = useState('');

    const table = useReactTable({
        data,
        columns,
        state: {
            globalFilter,
            rowSelection
        },
        enableMultiRowSelection: false,
        onRowSelectionChange: setRowSelection,
        onGlobalFilterChange: setGlobalFilter,
        globalFilterFn: fuzzyFilter,
        getCoreRowModel: getCoreRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
    })

    useEffect(() => {
        dispatch(loadPage());
    }, [])

    return (
        <Container>
            <ModalDialog>
                <ModalBody />
            </ModalDialog>
            <Card title="Report Safety Induction">
                <FormRow>
                    <FormCol sm="6">
                        <Button
                            success
                            onClick={() => dispatch(setUiAction('create_new_report'))}
                            data-toggle="modal"
                            data-backdrop="static"
                            data-target="#createProjectModal">
                            <i className="las la-plus"></i>Create New Report</Button>
                    </FormCol>
                </FormRow>
                <FormRow style={{ marginTop: '2rem' }}>
                    <FormCol sm="12">
                        {isPageLoaded}
                        <TableFilter />
                        <div className='row'>
                            <TableActions
                                isShow={Object.keys(rowSelection)[0] ?? 0}
                            />
                            <div className='flex-grow-1' />
                            <div className='col-md-3'>
                                <div className='form-group'>
                                    <DebounceInput
                                        className='form-control form-control-sm pl-3'
                                        value={globalFilter ?? ''}
                                        onChange={value => setGlobalFilter(String(value))}
                                        type="text"
                                        placeholder="Filter" />
                                </div>
                            </div>
                        </div>
                        <div className="row mt-2">
                            <div className='col-12'>
                                <table className='table table-data nowrap w-100'>
                                    <thead>
                                        {table.getHeaderGroups().map(headerGroup => (
                                            <tr className="tr-shadow" key={headerGroup.id}>
                                                {headerGroup.headers.map(header => (
                                                    <th key={header.id}>
                                                        {flexRender(
                                                            header.column.columnDef.header,
                                                            header.getContext()
                                                        )}
                                                    </th>
                                                ))}
                                            </tr>
                                        ))}
                                    </thead>
                                    <tbody>
                                        {table.getRowModel().rows.map(row => (
                                            <tr key={row.id}>
                                                {row.getVisibleCells().map(cell => (
                                                    <td key={cell.id}>
                                                        {flexRender(
                                                            cell.column.columnDef.cell,
                                                            cell.getContext()
                                                        )}
                                                    </td>
                                                ))}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </FormCol>
                </FormRow>
            </Card>
        </Container>
    )
}

IndexPage.propTypes = {

}

export default IndexPage;