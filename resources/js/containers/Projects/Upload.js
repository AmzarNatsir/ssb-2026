import React from "react";
import ReactDOM from "react-dom";

import Container from "../../components/Layout/Container";
import BreadCrumb from "../../components/BreadCrumb";
import Card from "../../components/Layout/Card";
import Label from "../../components/Label";
import { BREADCRUMB_UPLOAD } from "./constants";
import DataTable from "react-data-table-component";
import axios from "axios";
import Modal from "../../components/Modal";
import UploadComponent from "../../components/Upload"; 
import _ from "lodash";
import _d from 'datedash';

export function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

export function formatDate(date){
  if(_.isEmpty(date)) return "";  
  const cdate = new Date(date);
  return _d.date(cdate, '/');
  // return `${cdate.getDate()}/${cdate.getMonth()}/${cdate.getFullYear()}`;
}

const columns = [{
  name:'JENIS DOKUMEN',
  selector:'keterangan',
  sortable:false
},
{
  name:'ACTION',
  selector:'',
  sortable:false,
  right:true
}];

const project_columns = [  
  {
    name:'NO REG',
    selector:'registration_no',
    sortable:true
  },{
    name:'KETERANGAN',
    selector:'project_desc',
    sortable:true
  },{
    name:'SUMBER_PROYEK',
    selector:'project_source',
    sortable:true
  },{
    name:'TANGGAL_MULAI_PROYEK',
    selector:'project_start_date',
    cell: row => formatDate(row.project_start_date),
    sortable:true
  },{
    name:'TANGGAL_AKHIR_PROYEK',
    selector:'project_end_date',
    cell: row => formatDate(row.project_end_date),
    sortable:true
  },{
    name:'NILAI_PROYEK',
    selector:'project_value',
    cell: row => formatNumber(row.project_value),
    sortable:true,
    right:true
  }
];

class ProjectUpload extends React.Component {
  constructor(props){
    super(props);
    this.state = {
      opsi_upload_kategori:[],
      projects:[],
      picked_project:null,
      visible:false
    }
    this.fetchUploadKategori = this.fetchUploadKategori.bind(this);
    this.hideModal = this.hideModal.bind(this);
    this.handlePickProject = this.handlePickProject.bind(this);
    this.fetchProjects = this.fetchProjects.bind(this);
    this.handleOnSelectProject = this.handleOnSelectProject.bind(this);
  }

  componentDidMount() {    
    this.fetchUploadKategori();
    this.fetchProjects();
  }

  fetchUploadKategori(){
    axios.get('getUploadKategori')
    .then( res => 
      {
        // console.log(res);
        this.setState({
          opsi_upload_kategori:res.data
        })
      } ).catch(err=>console.log(err));
  }
  
  fetchProjects(){
    axios.get('daftar_project')
    .then( res => {
        // console.log('projects: ', res);
        this.setState({
          projects:res.data
        })
      } ).catch(err=>console.log(err));
  }

  hideModal(e){
    e.preventDefault();
    this.setState({
      visible:false
    })
  }

  handlePickProject(e){
    e.preventDefault();
    this.setState({
      visible:true
    })
    // alert(this.state.visible);
  }

  handleOnSelectProject(project_id){    
    this.setState({
      picked_project:project_id
    })
  }

  render(){
    const { opsi_upload_kategori, visible, projects } = this.state;
    return (
      <Container>
        {/* <BreadCrumb breadcrumb={BREADCRUMB_UPLOAD} /> */}
        {/* <Card title="Upload Dokumen"> */}
          {/* Jenis Upload  */}
          {/* <form className="form">
            <div className="form-row">
              <small>Jenis Dokumen belum ada ? silahkan klik tombol dibawah</small>
            </div>
            <div className="form-row">
              <div className="col-sm-2">
                <h6>Jenis Upload Dokumen</h6>
              </div>              
              <div className="col-sm-2">                
                <button type="submit" className="btn btn-sm btn-block btn-primary">
                  <strong>Tambah Jenis Dokumen</strong>
                </button>
              </div>
            </div>
          </form>
          <hr/> */}
          {/* PIlih Project */}
          
          <form>
            <div className="form-row">              
              {/* <div className="col-sm-1">
                <button 
                  onClick={this.handlePickProject} 
                  className="btn btn-md btn-block btn-primary">Pilih Project</button>
              </div>  
              <Modal show={visible} handleClose={this.hideModal}>
                <h5>Pilih Project</h5>
                { projects && 
                  <DataTable           
                    columns={project_columns}
                    data={projects}
                    striped
                    responsive
                    onRowClicked={ row => {
                      console.log(row)
                      // alert(row.id);
                      this.handleOnSelectProject(row.id);
                    } }          
                    pagination />}
              </Modal>
              {JSON.stringify(this.state.picked_project)} */}
            </div>
          </form>
          <hr/>
          {/* Form Jenis Upload */}
          {/* <form>
            <div className="form-row">
              <div className="col-sm-2">
                <Label title="jenis dokumen" />
                <select name="jenis" className="form-control form-control-sm">
                  {opsi_upload_kategori && opsi_upload_kategori.map(item=><option value="">{item.keterangan}</option>)}
                </select>
              </div>
              <div className="col-sm-2">
                <input type="file" className="form-control" />
              </div>
            </div>
          </form> */}
          <UploadComponent />
          
        {/* </Card> */}
      </Container>
    )
  }
}

export default ProjectUpload;
if (document.getElementById("project-upload")) {
  const element = document.getElementById("project-upload");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(<ProjectUpload {...props} />, document.getElementById("project-upload"));
}