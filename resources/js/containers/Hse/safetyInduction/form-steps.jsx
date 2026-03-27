import React, { useState, useEffect } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { useQuery, useMutation } from '@tanstack/react-query';
import { Formik, Form, Field } from 'formik'
import {
    getJobRolesFromDepartmentId,
    getEmployeeFromJobRoleId,
    createInduction
} from './services';
import { setModalActiveStep } from './slice'
import { stepsValidation } from './validation'

const selectStyles = {
    borderRight: '10px transparent solid'
}

const Step1 = ({ setFieldValue, errors, touched, values, isValid, validateForm }) => {

    const dispatch = useDispatch()
    const [roleId, setRoleId] = useState(0)

    let deptId = 3;
    const jobRoles = useQuery(['jobRoles', deptId], () => getJobRolesFromDepartmentId(deptId), {
        refetchOnWindowFocus: false,
    });

    const employees = useQuery(['employeeFromJobRole', parseInt(values.step1.jobRoles)],
        () => getEmployeeFromJobRoleId(values.step1.jobRoles), {
        refetchOnWindowFocus: false,
        enabled: parseInt(values.step1.jobRoles) > 0
    });

    return (
        <div>
            <h5 className='modal-title mb-4'>surat pengantar HRD</h5>
            <div className='row'>
                <div className="col-sm-6">
                    <Field name="step1.nomsurat">
                        {({ field, form, meta }) => (
                            <div className="form-group with-validation">
                                <label htmlFor="colFormLabel">Nomor Dokumen</label>
                                <input
                                    type="text"
                                    id="step1.nomsurat"
                                    name="step1.nomsurat"
                                    className={
                                        `form-control ${errors?.step1?.nomsurat && touched?.step1?.nomsurat ? 'is-invalid' : ''}
                                    `}
                                    {...field} />

                                <div className="invalid-feedback">
                                    {
                                        errors?.step1?.nomsurat && touched?.step1?.nomsurat
                                            ? errors?.step1?.nomsurat
                                            : ''
                                    }
                                </div>
                            </div>
                        )}
                    </Field>
                </div>
                <div className='col-sm-6'>
                    <Field name="step1.conductDate">
                        {({ field }) => (
                            <div className="form-group with-validation">
                                <label htmlFor="colFormLabel">Tanggal pelaksanaan induksi</label>
                                <input
                                    type="date"
                                    id="step1.conductDate"
                                    name="step1.conductDate"
                                    max={new Date().toISOString().substring(0,10)}
                                    className={
                                        `form-control ${errors?.step1?.conductDate && touched?.step1?.conductDate ? 'is-invalid' : ''}
                        `}
                                    {...field} />

                                <div className="invalid-feedback">
                                    {
                                        errors?.step1?.conductDate && touched?.step1?.conductDate
                                            ? errors?.step1?.conductDate
                                            : ''
                                    }
                                </div>
                            </div>
                        )}
                    </Field>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-6">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Job Roles</label>
                        <Field name="step1.jobRoles">
                            {({ field }) => (
                                <select
                                    className="form-control"
                                    style={selectStyles}
                                    value={roleId}
                                    onChange={(evt) => {
                                        setRoleId(evt.target.value, setRoleId)
                                    }}
                                    {...field}>
                                    <option value="0">{jobRoles?.isLoading ? 'Loading data ...' : ''}</option>
                                    {jobRoles?.data?.map(role => (
                                        <option key={role.id} value={role.id}>{role.nm_jabatan}</option>
                                    ))}
                                </select>
                            )}
                        </Field>
                        <div className="invalid-feedback"></div>
                    </div>
                </div>
                <div className="col-sm-6">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Employees</label>
                        <Field name="step1.employees">
                            {({ field }) => (
                                <select
                                    className={
                                        `form-control ${errors?.step1?.employees && touched?.step1?.employees ? 'is-invalid' : ''}
                                `}
                                    {...field}>
                                    <option value={0}>{employees?.isFetching ? 'Loading data ...' : ''}</option>
                                    {employees?.data?.map(employee => (
                                        <option key={employee.id} value={employee.id}>{employee.nm_lengkap}</option>
                                    ))}
                                </select>
                            )}
                        </Field>
                        <div className="invalid-feedback">
                            {
                                errors?.step1?.employees && touched?.step1?.employees
                                    ? errors?.step1?.employees
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Upload File</label>

                        <input
                            type="file"
                            id="step1.file"
                            name="step1.file"
                            onChange={evt => setFieldValue('step1.file', evt.currentTarget.files[0])}
                            className={`form-control ${errors?.step1?.file ? 'is-invalid' : ''}`} />

                        {/* <span>{values?.step1?.file.map(f => f.filename) ?? ''}</span> */}
                        {/* <span>{values?.step1?.file}</span> */}

                        <div className="invalid-feedback">
                            {
                                errors?.step1?.file || touched?.step1?.file
                                    ? errors?.step1?.file
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-12">
                    <button
                        type="button"
                        // disabled={!isValid}
                        onClick={() => dispatch(setModalActiveStep(1))}
                        className="btn btn-lg btn-next-step btn-block btn-primary">
                        Next
                    </button>
                </div>
            </div>
        </div>
    )
}
const Step2 = ({ setFieldValue, errors, touched }) => {
    const dispatch = useDispatch()
    console.log(errors)
    return (
        <div>
            <h4>Form safety induction</h4>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Nomor Dokumen</label>
                        <Field name="step2.nomsurat">
                            {({ field }) => (
                                <input
                                    type="text"
                                    name="step2.nomsurat"
                                    className={
                                        `form-control ${errors?.step2?.nomsurat && touched?.step2?.nomsurat ? 'is-invalid' : ''}
                                    `}
                                    {...field} />
                            )}
                        </Field>
                        <div className="invalid-feedback">
                            {
                                errors?.step2?.nomsurat && touched?.step2?.nomsurat
                                    ? errors?.step2?.nomsurat
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Upload File</label>
                        <input
                            type="file"
                            name="step2.file"
                            className={`form-control ${errors?.step2?.file || touched?.step2?.file ? 'is-invalid' : ''}`}
                            onChange={evt => setFieldValue('step2.file', evt.currentTarget.files[0])} />
                        <div className="invalid-feedback">
                            {
                                errors?.step2?.file || touched?.step2?.file
                                    ? errors?.step2?.file
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-12">
                    <button
                        type="button"
                        // disabled={!isValid}
                        onClick={() => dispatch(setModalActiveStep(2))}
                        className="btn btn-lg btn-next-step btn-block btn-primary">
                        Next
                    </button>
                </div>
            </div>
        </div>
    )
}

const Step3 = ({ setFieldValue, errors, touched }) => {
    const dispatch = useDispatch()
    return (
        <div>

            <h4>Job Safety Analysis</h4>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Nomor Dokumen</label>
                        <Field name="step3.nomsurat">
                            {({ field }) => (
                                <input
                                    type="text"
                                    name="step3.nomsurat"
                                    className={
                                        `form-control ${errors?.step3?.nomsurat && touched?.step3?.nomsurat ? 'is-invalid' : ''}
                                    `}
                                    {...field} />
                            )}
                        </Field>
                        <div className="invalid-feedback">
                            {
                                errors?.step3?.nomsurat && touched?.step3?.nomsurat
                                    ? errors?.step3?.nomsurat
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Upload File</label>
                        <input
                            type="file"
                            name="step3.file"
                            className={`form-control ${errors?.step3?.file || touched?.step3?.file ? 'is-invalid' : ''}`}
                            onChange={evt => setFieldValue('step3.file', evt.currentTarget.files[0])} />
                        <div className="invalid-feedback">
                            {
                                errors?.step3?.file || touched?.step3?.file
                                    ? errors?.step3?.file
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-12">
                    <button
                        type="button"

                        onClick={() => dispatch(setModalActiveStep(3))}
                        data-next="2"
                        className="btn btn-lg btn-next-step btn-block btn-primary">
                        Next
                    </button>
                </div>
            </div>
        </div>
    )
}

const Step4 = ({ setFieldValue, errors, touched, isValid }) => {
    // const dispatch = useDispatch()
    return (
        <div>
            <h4>Quesioner</h4>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Nomor Dokumen</label>
                        <Field name="step4.nomsurat">
                            {({ field }) => (
                                <input
                                    type="text"
                                    name="step4.nomsurat"
                                    className={
                                        `form-control ${errors?.step4?.nomsurat && touched?.step4?.nomsurat ? 'is-invalid' : ''}
                                    `}
                                    {...field} />
                            )}
                        </Field>
                        <div className="invalid-feedback">
                            {
                                errors?.step4?.nomsurat && touched?.step4?.nomsurat
                                    ? errors?.step4?.nomsurat
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-7">
                    <div className="form-group with-validation">
                        <label htmlFor="colFormLabel">Upload File</label>
                        <input
                            type="file"
                            name="step4.file"
                            className={`form-control ${errors?.step4?.file || touched?.step4?.file ? 'is-invalid' : ''}`}
                            onChange={evt => setFieldValue('step4.file', evt.currentTarget.files[0])} />
                        <div className="invalid-feedback">
                            {
                                errors?.step4?.file || touched?.step4?.file
                                    ? errors?.step4?.file
                                    : ''
                            }
                        </div>
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className="col-sm-12">
                    <button
                        type="submit"
                        disabled={!isValid}
                        className="btn btn-lg btn-next-step btn-block btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    )
}

const FormSteps = () => {
    const activeStep = useSelector((state) => state.safetySlice.modal.activeStep)
    const induction = useMutation(formData => {
        return createInduction(formData)
    })
    return (
        <Formik
            initialValues={{                
                step1: {
                    nomsurat: '',
                    jobRoles: '',
                    employees: '',
                    file: ''
                },
                step2: {
                    nomsurat: '',
                    file: ''
                },
                step3: {
                    nomsurat: '',
                    file: ''
                },
                step4: {
                    nomsurat: '',
                    file: ''
                }
            }}
            validationSchema={stepsValidation}
            onSubmit={values => {
                // same shape as initial values
                // console.log(values);
                
                // let data = new FormData();
                
                /*
                step1.nomsurat
                step1.conductDate
                step1.employees
                step1.file

                step2.nomsurat
                step2.file

                step3.nomsurat
                step3.file

                step4.nomsurat
                step4.file
                */
                
                // data.append('step1_nomsurat', values.step1.file)
                // data.append('step1_conductDate', values.step1.conductDate)
                // data.append('step1_file', values.step1.file)

                // data.append('step2_nomsurat', values.step2.file)                
                // data.append('step2_file', values.step2.file)
                
                // data.append('step3_nomsurat', values.step3.file)                
                // data.append('step3_file', values.step3.file)
                
                // data.append('step4_nomsurat', values.step4.file)                
                // data.append('step4_file', values.step4.file)
                
                induction.mutate(values);


            }}>
            {(props) => {
                // console.log(props.errors)
                return (
                    <Form onSubmit={props.handleSubmit}>                        
                        {activeStep == 0 && <Step1 {...props} />}
                        {activeStep == 1 && <Step2 {...props} />}
                        {activeStep == 2 && <Step3 {...props} />}
                        {activeStep == 3 && <Step4 {...props} />}
                    </Form>
                )
            }}
        </Formik>
    )
}

export default FormSteps;