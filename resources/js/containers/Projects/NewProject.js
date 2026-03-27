import React from "react";
import ReactDOM from "react-dom";
import { StateInspector, useState, useReducer } from "reinspect";
import axios from "axios";
import numeral from "numeral";
import _ from "lodash";
import { useForm } from "react-hook-form";
import classNames from "classnames";

import Container from "../../components/Layout/Container";
import Card from "../../components/Layout/Card";
import Section from "../../components/Layout/Section";
import BreadCrumb from "../../components/BreadCrumb";

import FormRow from "../../components/Form/FormRow";
import FormCol from "../../components/Form/FormCol";
import Label from "../../components/Label";
import Select from "../../components/Select";
import ResultPage from "../../containers/Result";

// constants
import {
  BREADCRUMB,
  // CHANGE_INPUT,
  // CHANGE_IS_SAVING_PROGRESS,
  // SIMPAN_ACTION,
  // SIMPAN_SUCCESS,
  // SIMPAN_ERROR,
  // RESET,
  initialState
} from "./constants";
import reducer from "./reducer";

// import UploadComponent from "../../components/Upload/NewUpload";

function resetState(initialState) {
  return initialState;
}

function NewProject({
  opsi_kategori_proyek,
  opsi_status_project,
  opsi_target_tender,
  opsi_customer
}) {
  const [state, dispatch] = useReducer(
    reducer,
    initialState,
    resetState,
    "projectReducer"
  );

  const { register, errors, handleSubmit } = useForm();
  // console.log(_.isEmpty(opsi_customer));

  const inputClass = classNames({
    "form-control": true,
    "form-control-sm": true
    // 'invalid-form': _.isEmpty(errors) ? false : true
  });

  const onSubmit = data => {
    try {
      dispatch({ type: "SIMPAN_ACTION" });
      axios
        .post("/project/simpanProyek", data)
        .then(res => {
          console.log(res.status);
          if (res.status === 200) {
            // if(res.data === 'sukses'){
            changeSavingProgress(false);
            dispatch({ type: "SIMPAN_SUCCESS" });
          }
        })
        .catch(() => {
          changeSavingProgress(false);
          dispatch({
            type: "RESET",
            payload: state
          });
        });
    } catch (err) {
      dispatch({
        type: "RESET",
        payload: state
      });
    }
  };

  const ChangeInput = (evt, actionType) =>
    dispatch({
      type: actionType,
      payload: {
        name: evt.target.name,
        value: evt.target.value
      }
    });

  const changeSavingProgress = progressBool =>
    dispatch({
      type: "CHANGE_IS_SAVING_PROGRESS",
      payload: progressBool
    });

  return (
    <StateInspector name="Project">
      <Container>
        <BreadCrumb breadcrumb={BREADCRUMB} />
        <Card title="Registrasi Tender">
          {state.save_success === true ? (
            <ResultPage message="Data Proyek Berhasil disimpan!" />
          ) : (
            <React.Fragment>
              <Section title="Informasi Umum" description="" />
              <br />
              <form autoComplete="off" onSubmit={handleSubmit(onSubmit)}>
                <FormRow>
                  <FormCol sm="3">
                    <Label title="Nomor Registrasi Tender (opsional)" />
                    <input
                      ref={register}
                      type="text"
                      name="registration_no"
                      className={inputClass}
                      placeholder="-"
                      value={state.registration_no}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {/*errors.registration_no && <div style={{ color:'red',fontSize:11 }}>Nomor Registrasi project tidak boleh kosong!</div>*/}
                  </FormCol>
                </FormRow>

                <FormRow>
                  <FormCol sm="3">
                    <Label title="Kategori Tender" />
                    <Select
                      ref={register({ required: true })}
                      name="project_category_id"
                      items={JSON.parse(opsi_kategori_proyek)}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_category_id) === true
                          ? ""
                          : " invalid-form"
                      ]}
                    />
                    {errors.project_category_id && (
                      <div className="error-feedback">
                        kategori project tidak boleh kosong!
                      </div>
                    )}
                  </FormCol>
                </FormRow>

                <FormRow>
                  <FormCol sm="6">
                    <textarea
                      ref={register({ required: true })}
                      name="project_desc"
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_desc) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      rows="2"
                      placeholder="Keterangan"
                      value={state.project_desc}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_desc && (
                      <div className="error-feedback">wajib diisi.</div>
                    )}
                  </FormCol>
                </FormRow>

                <FormRow>
                  <FormCol sm="2">
                    <Label title="Sumber Tender" />
                    <input
                      ref={register}
                      type="text"
                      name="project_source"
                      className={inputClass}
                      placeholder="Sumber Project/Tender"
                      value={state.project_source}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                  </FormCol>
                  <FormCol sm="2">
                    <Label title="Nilai Kontrak" />
                    <input
                      ref={register({
                        required: true,
                        min: 1000000
                      })}
                      type="text"
                      dir="rtl"
                      name="project_value"
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_value) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      value={numeral(state.project_value).format("0,0")}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_value && (
                      <div className="error-feedback">
                        Nilai project tidak boleh kosong!
                      </div>
                    )}
                  </FormCol>
                  <FormCol sm="2">
                    <Label title="Lokasi" />
                    <input
                      ref={register({ required: true })}
                      type="text"
                      name="project_location"
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_location) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      value={state.project_location}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_location && (
                      <div className="error-feedback">
                        wajib diisi diperlukan pada saat survey.
                      </div>
                    )}
                  </FormCol>
                </FormRow>

                <FormRow>
                  <FormCol sm="2">
                    <Label title="Target Tender" />
                    <Select
                      ref={register({ required: true })}
                      name="project_target"
                      items={JSON.parse(opsi_target_tender)}
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_target) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_target && (
                      <div className="error-feedback">wajib diisi.</div>
                    )}
                  </FormCol>
                  <FormCol sm="2">
                    <Label title="Tanggal Mulai Pengerjaan" />
                    <input
                      ref={register({ required: true })}
                      type="date"
                      name="project_start_date"
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_start_date) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      value={state.project_start_date}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_start_date && (
                      <div className="error-feedback">
                        diperlukan. dapat diisi dengan tanggal estimasi jika
                        belum ada data
                      </div>
                    )}
                  </FormCol>
                  <FormCol sm="2">
                    <Label title="Batas Akhir Pengerjaan" />
                    <input
                      ref={register({ required: true })}
                      type="date"
                      name="project_end_date"
                      className={[
                        inputClass,
                        _.isEmpty(errors.project_end_date) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      value={state.project_end_date}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.project_end_date && (
                      <div className="error-feedback">
                        diperlukan. dapat diisi dengan tanggal estimasi jika
                        belum ada data
                      </div>
                    )}
                  </FormCol>
                  <FormCol sm="2">
                    <Label title="Durasi Pekerjaan (bulan)" />
                    <input
                      ref={register({
                        required: true,
                        maxLength: 2
                      })}
                      dir="rtl"
                      type="number"
                      name="duration_in_month"
                      className={[
                        inputClass,
                        (_.isEmpty(errors.duration_in_month) ||
                          errors.duration_in_month.length > 2) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      value={state.duration_in_month}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                    {errors.duration_in_month &&
                      errors.duration_in_month.type === "required" && (
                        <div className="error-feedback">
                          Durasi/Lama Pengerjaan Project tidak boleh kosong!
                        </div>
                      )}
                    {errors.duration_in_month &&
                      errors.duration_in_month.type === "maxLength" && (
                        <div className="error-feedback">
                          Maximal Panjang Durasi tidak boleh lebih dari 99
                          Bulan!
                        </div>
                      )}
                  </FormCol>
                </FormRow>

                <Section
                  title="Customer"
                  description=""
                  style={{ marginTop: "35px" }}
                />

                <FormRow>
                  <FormCol sm="2">
                    <Label title="Pilih Customer" />
                    <select
                      ref={register({ required: true })}
                      className={[
                        inputClass,
                        _.isEmpty(errors.customer_id) === true
                          ? ""
                          : " invalid-form"
                      ]}
                      name="customer_id"
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                      value={state.customer_id}
                    >
                      {JSON.parse(opsi_customer).map((option, i) => {
                        return (
                          <option key={i} value={option.id}>
                            {option.customer_name}
                          </option>
                        );
                      })}
                    </select>
                  </FormCol>
                </FormRow>

                <Section
                  title="Status Project"
                  description=""
                  style={{ marginTop: "35px" }}
                />

                <FormRow>
                  <FormCol sm="4">
                    <Select
                      ref={register}
                      name="project_status"
                      items={JSON.parse(opsi_status_project)}
                      className={inputClass}
                      onChange={evt => ChangeInput(evt, "CHANGE_INPUT")}
                    />
                  </FormCol>
                </FormRow>

                {/* <Section
                  title="Dokumen"
                  description="Upload Dokumen dan Pengumuman Lelang"
                  style={{ marginTop: "35px" }}
                /> */}

                {/* <UploadComponent /> */}

                <br />
                <hr />
                <FormRow endOfForm>
                  <FormCol sm="2">
                    <button
                      type="submit"
                      className="btn btn-sm btn-block btn-primary"
                      disabled={state.is_saving}
                    >
                      {state.is_saving && <i className="fa fa-spinner"></i>}
                      &nbsp;&nbsp;
                      <strong>Simpan Project</strong>
                    </button>
                  </FormCol>
                </FormRow>
              </form>
            </React.Fragment>
          )}
        </Card>
      </Container>
    </StateInspector>
  );
}

export default NewProject;
if (document.getElementById("project-container")) {
  const element = document.getElementById("project-container");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <NewProject {...props} />,
    document.getElementById("project-container")
  );
}
