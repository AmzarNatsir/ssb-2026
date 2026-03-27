import React, { Component, Fragment} from "react";
import axios from "axios";
import _ from "lodash";
import update from 'immutability-helper';
import Label from "../Label";
import styled from 'styled-components';

const StyledInput = styled.input`
  /* width: 0.1px;
  height: 0.1px; */
  opacity: 1;
  overflow: hidden;
  position: absolute;
  z-index: -1;  
`;

const StyledLabelInput = styled.label`
  /* font-size: 1.25em; */
  font-weight: 500;
  color: #5e5e60;
  background-color: #F9F9FB;
  display: inline-block;
  margin-top:5px;
  padding:5px 15px 5px 15px;
  &:focus {
  }
  &:hover {
    background-color:#CCCCCC;
  }
`;

const InputFile = ({ label, otherProps }) => {
  return (
    <React.Fragment>
      <StyledInput type="file" name="file" {...otherProps} />
      <StyledLabelInput><i className="fa fa-upload"></i>&nbsp;&nbsp;{label}</StyledLabelInput>
    </React.Fragment>
  )
}


class UploadSection extends Component {
  constructor(props){
    super(props);
    
    this.getUploadFilesInput = this.getUploadFilesInput.bind(this);
    this.onUploadKategoriChange = this.onUploadKategoriChange.bind(this);
    // this.selectFile = this.selectFile.bind(this);
    // this.uploadFiles = this.uploadFiles.bind(this);
    // this.uploadService = this.uploadService.bind(this);

    // #region event handler upload yang working
    this.onUploadChange = this.onUploadChange.bind(this);  
    this.fileUpload = this.fileUpload.bind(this);  
    this.testUpload = this.testUpload.bind(this); 
    this.changeFileName = this.changeFileName.bind(this);

    this.onUserAddFileUpload = this.onUserAddFileUpload.bind(this);
    this.extractFileInfo = this.extractFileInfo.bind(this);
    // #endregion

    this.state = {
      opsi_upload_kategori:[],
      upload_kategori:1,
      max_upload:4,
      selectedFiles:[],
      progressInfos:[],
      image:"https://via.placeholder.com/42x42.svg?text=File",
      nama_file:"",
      uploaded_files:[{
        name:"",
        file:"",
        kategori:1
      }],
      uploaded_files_name:[]
    }
  }
  
  componentDidMount() {
    axios.get(`/project/getUploadKategori`)
    .then( response => {       
      this.setState({
        opsi_upload_kategori:response.data
      }) 
    })
    .catch( error => console.log(error));    
  }

  componentDidUpdate(prevProps,prevState){
    if(prevState.upload_kategori !== this.state.upload_kategori){
      this.getUploadFilesInput();
    }
  }

  // #region dsakjf
  getUploadFilesInput(){
    const { opsi_upload_kategori, upload_kategori } = this.state;
    
    if(opsi_upload_kategori.filter(opsi => opsi.id == upload_kategori).length === 0){
      console.log('print upload 4x!');
    } else {
      const max_upload = opsi_upload_kategori.filter(opsi => opsi.id == upload_kategori)[0]['maximum_upload'];
      // console.log(max_upload);
      this.setState({
        max_upload
      })
    }

    // axios.get(`/project/getMaxUploadPerKategori/${upload_kategori}`)
    // .then( response => { 
    //   console.log(response.data)
    //   this.setState({
    //     max_upload:response.data
    //   })
    //   response.data } )
    // .catch(error => console.log(error))
  }
  // #endregion

  onUploadKategoriChange(event){
    let name = event.target.name;    
    this.setState({
      [name]:event.target.value
    })    
  }
  
  onUploadKategoriItemChange(event, index){
    // let name = event.target.name;
    let value = event.target.value;
    console.log(value);
    let newState = update(this.state,{
      uploaded_files:{
        [index]: {
          kategori: { $set: value }          
        }
      }
    });
    this.setState(newState);
    console.log(newState.uploaded_files);

    // this.setState({
    //   [name]:event.target.value
    // })    
  }
  
  // coba versi simple
  onUploadChange(event,index){
    let files = event.target.files;
    // console.log(event.target.files[0].name);    
    this.createImage(files[0], index, event.target.files[0].name);
  }

  createImage(file, index, name){    
    let reader = new FileReader();    
    reader.onload = (e) => {
      // this.setState({
      //   image:e.target.result,
      //   uploaded_files:uploaded_files[index].file
      // })
      
      let newState = update(this.state,{
        uploaded_files:{
          [index]: {
            name: { $set: name },
            file: { $set: e.target.result }
          }
        }
      } );
      this.setState(newState);      
      // this.setState(update(this.state.uploaded_files[index], { name: { $set:'nama' } }));      
    }
    reader.readAsDataURL(file);
  }

  fileUpload(image){    
    let data = { 
      nama_file:this.state.nama_file,
      file: this.state.image,
    };
    axios.post('/project/uploadFile', data).then( res => { console.log(res)});
  }

  testUpload(event){
    event.preventDefault();
    this.fileUpload(this.state.image);
  }

  changeFileName(event){
    let nama_file = event.target.name;
    this.setState({
      [nama_file]:event.target.value
    })
  }

  // user menambah file upload
  onUserAddFileUpload(){    
    const { max_upload, uploaded_files } = this.state;
    if(uploaded_files.length < max_upload === true){      
      this.setState({
        uploaded_files:[...this.state.uploaded_files, {
            name:"",
            file:""
          }]
      })
    }
  }
  
  // #region extract file size   
  extractFileInfo(base64File){    
    let nama_file = base64File ? base64File.split(';')[0].split('/')[1] : '';
    let ukuran = base64File ? atob(base64File.split(',')[1]).length/1024 : '0';
    let sizeInKb = Math.round((ukuran + Number.EPSILON) * 100) / 100;
    
    return `Tipe file ${nama_file} ukuran ${sizeInKb} Kb`;
  }
  // #endregion

  render(){
    const { 
      opsi_upload_kategori, 
      upload_kategori, 
      max_upload, 
      selectedFiles, 
      uploaded_files
    } = this.state;
    return (
        <Fragment>
          <div>            
            {/* Upload Options */}
            {/* <div className="form-row" style={{ marginBottom: 20, backdropFilter: blur('6px') }}>              
                {opsi_upload_kategori.map((option, index) => (
                    <div key={`upload-kategori-${index}`} className="form-check form-check-inline">
                        <input
                            className="form-check-input"
                            type="radio"
                            name="upload_kategori"
                            value={option.id}
                            checked={option.id == upload_kategori ? true : false}
                            onChange={this.onUploadKategoriChange}
                        />
                        <label className="form-check-label" htmlFor="upload_kategori">
                          {option.keterangan}
                        </label>
                        <input type="hidden" name={`max_upload[${option.id}]`} value={option.maximum_upload} />
                    </div>
                ))}
            </div> */}

            {/* <div id="files_preview">
                <div className="form-row d-flex align-items-center">
                    <ul className="list-unstyled">
                      {uploaded_files.length > 0 ? uploaded_files.map((item,i)=>(
                        <li key={`image-${i}`} className="media">                          
                            <img src={item.file ? item.file : this.state.image } className="rounded mr-3" style={{ width: 36, height: 36 }} />
                            <div className="media-body">
                                <h6 className="mt-0 mb-0">dokumen 1</h6>                                
                                <small>{this.extractFileInfo(item.file)}</small>
                            </div>
                        </li>
                      )) : null}
                    </ul>                    
                </div>
            </div> */}

            {/* Files Container */}
            {/*JSON.stringify(this.state.uploaded_files)*/}
            <div className="form-row">
              <div className="ml-3">
                  <button type="button" className="btn btn-info mb-3" onClick={this.onUserAddFileUpload}>
                      <i className="ri-add-fill pr-0"></i>Tambah Berkas
                  </button>
              </div>
            </div>
            <div id="files_container">
              {uploaded_files.map((upload,idx) => (
                <div key={`files-${idx}`} className="form-row d-flex align-items-center">
                    
                    <div className="col-sm-4">
                        {idx === 0  && <Label title="keterangan [*Jenis File yang diperbolehkan PDF dan Image]" /> }
                        <input
                            type="text"
                            name={`nama_file${idx}`}
                            className="form-control form-control-sm file-input"
                            placeholder={`Dokumen [${idx+1}]`}
                            onChange={this.changeFileName}
                        />
                    </div>
                    <div className="col-sm-3" style={{ marginTop: idx === 0 ? 32 : 0 }}>                      
                        <input
                            type="file"
                            name={`file[${idx}]`}
                            multiple
                            onChange={evt => this.onUploadChange(evt, idx)}
                            accept=".jpg, .jpeg, .png"
                            className="custom-file-input" />
                        <label className="custom-file-label" htmlFor="customFile">{ upload.name || `file_upload`}</label>                       
                    </div>
                    
                    <div className="col-sm-2" style={{ marginTop: idx === 0 ? 32 : 0 }}>
                      <span className="media">
                        <img src={upload.file ? upload.file : this.state.image } className="rounded mr-3" style={{ width: 36, height: 36 }} />
                          <div className="media-body"><small>{this.extractFileInfo(upload.file)}</small></div>
                      </span>
                        {/* <button
                            className="btn btn-success"
                            disabled={!selectedFiles}
                            onClick={this.testUpload}>
                            Upload
                        </button> */}
                    </div>
                    {/* <div className="col-sm-3"  style={{ marginTop: idx === 0 ? 32 : 0 }}>
                    {opsi_upload_kategori.map((option, index) => (
                    <div key={`upload-kategori-${index}`} className="form-check form-check-inline">
                      {JSON.stringify(upload)}
                        <input
                            className="form-check-input"
                            type="radio"
                            name="upload_kategori"
                            value={upload.kategori}
                            checked={option.id === upload.kategori ? true : false}
                            onChange={evt => this.onUploadKategoriItemChange(evt, idx)}
                        />
                        <label className="form-check-label" htmlFor="upload_kategori">
                          {option.keterangan}
                        </label>
                        <input type="hidden" name={`max_upload[${option.id}]`} value={option.maximum_upload} />
                    </div>                    
                    ))}
                  </div> */}
                </div>
              ))}
            </div>
            </div>
        </Fragment>
    );
  }
}

export default UploadSection;