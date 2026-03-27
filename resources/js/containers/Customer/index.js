import React from "react";
import ReactDOM from "react-dom";
import produce from "immer";
import axios from "axios";
import { useForm, Controller } from "react-hook-form";
import classNames from "classnames";
import Container from "../../components/Layout/Container";
import Card from "../../components/Layout/Card";
import Section from "../../components/Layout/Section";
import Label from "../../components/Label";
import NumberFormat from "react-number-format";

const initialState = {
  customer_no:"",
  customer_name:"",
  customer_address:"",
  contact_person_name:"",
  contact_person_number:"",
  is_saving:false,
  save_success:false
}

const reducer = (state, action) => produce(state, draft => {
  switch(action.type){
    case 'CHANGE_INPUT':
      let { name, value } = action.payload;      
      draft[name] = value;
      return draft;
    case 'CUSTOMER_ACTION':
    return draft;
    case 'SIMPAN_ACTION':
      draft.is_saving = true;
      return draft;
    case 'SIMPAN_SUCCESS':
      draft.is_saving = false;
      draft.save_success = true;
      return draft;
    case 'SIMPAN_ERROR':
      draft.is_saving = false;
      return draft;
    default:
      return draft;
  }
});

function Customer(){
  const { register, control, setValue, errors, handleSubmit } = useForm();
  const [state, dispatch] = React.useReducer(reducer, initialState);
  const ChangeInput = (evt, actionType) => dispatch({
    type:actionType,
    payload:{
      name: evt.target.name,
      value: evt.target.value
    }
  });
  const onSubmit = data => {
    console.log(data);
    try {
      dispatch({ type:'SIMPAN_ACTION' });
      axios.post('/customer/simpanCustomer', data).then(res=>{
        console.log('axios post', res);
        if(res.data === 'sukses'){
          dispatch({ type:'SIMPAN_SUCCESS' });
        }
      }).catch(()=>{
        console.log('axios catch!');
        // dispatch()
      })
    } catch(err){
      console.log('axios err', err);
    }
  };
  const inputClass = classNames({
    'form-control': true,
    'form-control-sm': true,    
  });
  return (
    <Container>
      <Card title="Registrasi Customer">
        <React.Fragment>
          <form autoComplete="off" onSubmit={handleSubmit(onSubmit)}>
            {/* <div className="form-row">
              <div className="col-sm-2">
                <Label title="No Customer"/>
                <input 
                  ref={register}
                  type="text" 
                  name="customer_no"                 
                  className={inputClass} 
                  placeholder="-" 
                  value={state.customer_no}
                  onChange={evt=> ChangeInput(evt, 'CHANGE_INPUT')} />                
              </div>
            </div> */}
            <div className="form-row">
              <div className="col-sm-3">
                <Label title="Nama Customer"/>
                <input 
                  ref={register({ required:true })}
                  type="text" 
                  name="customer_name"                 
                  className={inputClass} 
                  placeholder="-" 
                  value={state.customer_name}
                  onChange={evt=> ChangeInput(evt, 'CHANGE_INPUT')} />
                {errors.customer_name && <div style={{ color:'red',fontSize:11 }}>Nama Customer tidak boleh kosong!</div>}
              </div>
            </div>
            <div className="form-row">
              <div className="col-sm-4">
                <Label title="Alamat Customer"/>
                <input 
                  ref={register}
                  type="text" 
                  name="customer_address"                 
                  className={inputClass} 
                  placeholder="-" 
                  value={state.customer_address}
                  onChange={evt=> ChangeInput(evt, 'CHANGE_INPUT')} />
                {errors.customer_address && <div style={{ color:'red',fontSize:11 }}>Nomor Registrasi project tidak boleh kosong!</div>}
              </div>
            </div>
            <div className="form-row">
              <div className="col-sm-3">
                <Label title="Nama Kontak Person"/>
                <input 
                  ref={register({ required:true })}
                  type="text" 
                  name="contact_person_name"                 
                  className={inputClass} 
                  placeholder="-" 
                  value={state.contact_person_name}
                  onChange={evt=> ChangeInput(evt, 'CHANGE_INPUT')} />
                {errors.contact_person_name && <div style={{ color:'red',fontSize:11 }}>Nomor Registrasi project tidak boleh kosong!</div>}
              </div>
            </div>
            <div className="form-row">
              <div className="col-sm-2">
                <Label title="Nomor Kontak Person (HP)"/>
                <Controller 
                  name="contact_person_number" 
                  control={control} 
                  render={({ ChangeInput, state, name })}
                  rules={{ required:true }}
                  as={
                  <NumberFormat                                       
                    name={name}
                    format="0### #### ####" 
                    allowEmptyFormatting                    
                    mask="_"
                    className={inputClass}
                    onChange={ evt => ChangeInput(evt, 'CHANGE_INPUT') }
                    value={state.contact_person_number} />
                } />                
                {errors.contact_person_number && <div style={{ color:'red',fontSize:11 }}>Nomor Registrasi project tidak boleh kosong!</div>}
                {/*JSON.stringify(errors.contact_person_number)*/}
              </div>
            </div>
            <br/>
            <hr/>
            <div className="form-row form-row-end">
              <div className="col-sm-2">
                <button 
                  type="submit" 
                  className="btn btn-sm btn-primary"
                  disabled={state.is_saving}>
                    {state.is_saving && <i className="fa fa-spinner"></i>}&nbsp;&nbsp;
                    <strong>Simpan Customer</strong>
                </button>
              </div>
            </div>
          </form>
        </React.Fragment>
      </Card>      
    </Container>
  )
}

export default Customer;
if (document.getElementById("customer-container")) {
  const element = document.getElementById("customer-container");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(<Customer {...props} />, document.getElementById("customer-container"));
}