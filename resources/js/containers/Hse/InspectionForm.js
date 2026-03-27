import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import { useForm } from "react-hook-form";
import { yupResolver } from "@hookform/resolvers/yup";
import * as yup from "yup";
import classNames from "classnames";
import InspectionItem from "../../components/InspectionItem";
import {  
  Options,
  ErrorMessage,
  UploadComponent,
  UploadedFileComponent,
} from "../../components/Form";

import Toast from "../../components/Toast";

import {
  defaultOptions,
  defaultErrorMessage,
  allowedFileType,
  inspectionItems,
  // locations,
  // equipmentCategories,
  default_equipments,
  // operators,
} from "./constant";

import axios from "axios";
import _ from "lodash";

function Header(){
  return (
    <div className="row">
      <div className="col-sm-8">
        <h4 className="card-title text-primary">
          <span className="ri-chat-check-line pr-2"></span>Form P2H
        </h4>
      </div>
      <div className="col-sm-4 text-right"></div>
      
    </div>
  )
}

let schema;
const replaceSpace = str => str.replace(/\s/g , "_");
const defaultShape = {
  location: yup.string().min(1).required(),
  category: yup.string().min(1).required(),
  operator: yup.string().min(1).required(),
  equipment: yup.string().min(1).required(),
};

// const createValidationsSchema = async (inspectionItems) => {
  if (inspectionItems.length > 0) {
    inspectionItems.forEach((elem) => {
      if (elem.properties) {
        elem.properties.forEach((item) => {
          let key = `${elem.id}_${replaceSpace(item.name).toLowerCase()}`;
          if (item.mandatory) {
            if (item.input.type === "optionGroup") {
              defaultShape[key] = yup.string().required();
            } else {
              defaultShape[key] = yup.string().min(1).required();
            }
          }
        });
      }
  
      schema = yup.object().shape(defaultShape);
      // return schema;
    });
  } 
// }}

function InspectionForm(){
  const {
    register,
    handleSubmit,
    formState: { errors },
    getValues,
    setValue,
    watch,
  } = useForm({
    resolver: yupResolver(schema),
    defaultValues: {
      optGroup: "1",     
    },
  });

  let inputClass = classNames({
    // 
    "form-control": true
  });

  let inputErrorClass = classNames({    
    "form-control": true,
    "border border-2 border-danger": true
  });

  let optionClass = classNames({
    // "flex mt-2 mb-4 appearance-none border-2 border-black-500 bg-gray-50 px-4 h-10 w-full lg:w-full hover:border-gray-500 py-2 rounded leading-tight focus:outline-none focus:shadow-outline": true,
    "form-control": true
  });

  

  const [selectedLocation, setLocation] = useState("");
  const [file, setFile] = useState();
  const [fileValidationMessage, setFileValidationMessage] = useState("");
  const [eqObj, setEqobj] = useState({});
  const [equipments, setEquipments] = useState([]);
  const [toastVisible, toggleToastVisible] = useState(false);
  const [toastMessage, setToastMessage] = useState("");

  // JSON STATE

  // const [inspectionItems, putInspectionItems] = useState([]);
  const [locations, putLocations] = useState([]);
  const [equipmentCategories, putEquipmentCategories] = useState([]);
  const [operators, putOperators] = useState([]);

  // load Json
  useEffect(()=>{
    
    axios.get("/hse/locations").then( res => {        
      if(res.status === 200){
        putLocations(res.data)
      }}
    ).catch(err=>console.log(err))
    
    axios.get("/hse/equipment/categories").then(res=>{
      if(res.status === 200){
        putEquipmentCategories(res.data)
      }
    }).catch(err=>console.log(err))
    
    // axios.get("/hse/items").then(res=>{
    //   if(res.status === 200){
    //     putInspectionItems(res.data)
    //   }
    // }).catch(err=>console.log(err))
    
    axios.get("/hse/operators").then(res=>{
      if(res.status === 200){
        putOperators(res.data)
      }
    }).catch(err=>console.log(err))

    // createValidationsSchema(inspectionItems);

  },[]);

  const filterArray = (arr, eqc = "") =>
    arr.filter((item) => item["eqcid"] === eqc);

  const findInArray = (arr, needle = "") =>
    arr.find((obj) => obj.key === needle);

  // detect if equipment category updates
  useEffect(() => {
    if (watch("category")) {
      setEquipments(
        filterArray(default_equipments, parseInt(watch("category")))
      );
    } else {
      setEquipments(default_equipments);
    }
  }, [watch("category")]);

  useEffect(() => {
    if (watch("equipment")) {
      setEqobj(findInArray(default_equipments, parseInt(watch("equipment"))));
    } else {
      setEqobj({});
    }
  }, [watch("equipment")]);

  // console.log(errors)
  const onSubmit = (data) => {        
    // console.log("submit data: ", data);
    var mainObj = {}, obj0 = {}, obj1 = {}, obj2 = {}, obj3 = {}, obj4 = {}; 
    for (const [key, value] of Object.entries(data)) {
      if( !Number.isNaN(parseInt(key.substring(0,1))))
      {                
          if(parseInt(key.substring(0,1)) === 1){
            obj1[key.substring(2)] = value;
          } else if (parseInt(key.substring(0,1)) === 2){
            obj2[key.substring(2)] = value;
          } else if (parseInt(key.substring(0,1)) === 3){
            obj3[key.substring(2)] = value;
          } else if (parseInt(key.substring(0,1)) === 4){
            obj4[key.substring(2)] = value;
          }
      } else {
        // location, operator, equipment
        obj0[key] = value;
      }

      mainObj['0'] = obj0;
      mainObj['1'] = obj1;
      mainObj['2'] = obj2;
      mainObj['3'] = obj3;
      mainObj['4'] = obj4;
    }

    // console.log(mainObj);
    // https://tender.ssb.pro/create
    axios.post("/hse/store", {
      data: mainObj
    })
      .then(res=>{
        console.log(res)
        if(res.status === 200){                    
          toggleToastVisible(true);
          setToastMessage("Berhasil menyimpan Inspeksi P2h"); 
        }
      })
      .catch(err=>{
        console.log(err)
        toggleToastVisible(true);
        setToastMessage("Error! Terjadi kesalahan waktu menimpan Inspeksi P2h"); 
      });

    // dispatch(setToast({ visible:true, type:'success', message:'anda berhasil login' }));
    // history.push('/dashboard');
  };

  const onFileSelected = (event) => {
    if (!!event.target.files && !!event.target.files[0]) {
      let fileType = event.target.files[0].type;
      if (allowedFileType.indexOf(fileType) === -1) {
        setFileValidationMessage("file tidak didukung");
        return false;
      }
      setFileValidationMessage();
      setFile(URL.createObjectURL(event.target.files[0]));
    }
  };

  const onFileRemove = (event) => {
    event.preventDefault();
    setFile();
  };

  useEffect(()=>{
    let timer = setTimeout(
      () => 
        // dispatch(setToast({ visible:false, type:'success', message:'' }))
        {
          toggleToastVisible(false)
          setToastMessage("")
        }, 3000
    );
    return () => {
      clearTimeout(timer);
    }
  },[toastVisible]);

  return (
    <div className="iq-card">
      <div className="iq-card-body" style={{ padding:"1.5rem 3rem" }}>
        
        <Header />
        {toastVisible && <Toast type="success" visible={toastVisible} message={toastMessage} />}
        <form onSubmit={handleSubmit(onSubmit)} autoComplete="off" noValidate>
          <div className="form-row">            
            <div className="col-md-3 col-12">
              <div className="form-group">
                <label>No. Assignment</label>                
                <input type="text" name="assignmentNo" className="form-control" placeholder="nomor assignment"  />
              </div>
            </div>
          </div>

          <div className="form-group">
            <Options 
              label="lokasi" 
              data={locations} 
              value={selectedLocation}
              onChange={(e) => setLocation(e.target.value)}
              optionValue="key" 
              optionLabel="value" 
              className={errors.location ? inputErrorClass : optionClass}
              {...register("location")} />
              {errors.location && (
                  <ErrorMessage message={defaultErrorMessage} />
                )}
          </div>

          <div className="form-group">
            <Options 
              label="operator" 
              data={operators}
              optionValue="key" 
              optionLabel="value"
              className={errors.operator ? inputErrorClass : optionClass}
              {...register("operator")} />
              {errors.operator && (
                  <ErrorMessage message={defaultErrorMessage} />
                )}
          </div>

          {/* Equipment */}
          <div className="form-group">
            <Options 
              label="kategori" 
              data={equipmentCategories}
              optionValue="key" 
              optionLabel="value"
              className={errors.category ? inputErrorClass : optionClass}
              {...register("category")} />
              {errors.category && (
                  <ErrorMessage message={defaultErrorMessage} />
                )}
          </div>

          <div className="form-group">
            <Options 
              label="tipe" 
              data={equipments}
              optionValue="key" 
              optionLabel="value"
              className={errors.equipment ? inputErrorClass : optionClass}
              {...register("equipment")} />
              {errors.equipment && (
                  <ErrorMessage message={defaultErrorMessage} />
                )}
          </div>

          <div className="form-group">
            <label>Kode</label>
            <input 
              type="text" 
              name="kode" 
              className="form-control" 
              value={eqObj["eqcode"]}
              placeholder="kode" 
              readOnly />
          </div>
          <div className="form-group">
            <label>Nama</label>
            <input 
              type="text" 
              name="nama" 
              className="form-control" 
              value={eqObj["eqname"]}
              placeholder="nama" readOnly />
          </div>

          {/* TODO : loop inspection items */}
          {inspectionItems.length > 0 &&
            inspectionItems.map((inspection, index) => (
              <InspectionItem
                key={`inspection-${index}`}
                inspection={inspection}
                errors={errors}
                register={register}
                defaultChecked={getValues("optGroup")}
                defaultOptions={defaultOptions}
                item_id={inspection.id}
              />
            ))}
          {/* TODO : file upload  */}
          {/* tampilkan komponen upload jika belum ada file */}
        {!file && (
          <UploadComponent
            validationMessage={fileValidationMessage}
            onChange={onFileSelected}
          />
        )}

        {/* Tampilkan File */}
        {file && (
          <UploadedFileComponent file={file} onClickRemove={onFileRemove} />
        )}
          <button type="submit" className="btn btn-xl btn-block btn-primary">submit</button>
        </form>
      </div>
    </div>
  )
}

export default InspectionForm;

if(document.getElementById('inspection-form-dom')){  
  const element = document.getElementById('inspection-form-dom');
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(<InspectionForm {...props} />, document.getElementById('inspection-form-dom'));
}