import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import NumberFormat from "react-number-format";

import BreadCrumb from "../components/BreadCrumb";
import Label from "../components/Label";
import Select from "../components/Select";
import CustomerSection from "../components/Customer";
import UploadSection from "../components/Upload";

export const BREADCRUMB = [{
  text:'Home',
  active:false
},{
  text:'Project',
  active:false
},{
  text:'Manage Project',
  active:false
},{
  text:'Create Tender Project',
  active:true
}];

class CreateProject extends React.Component {
  constructor(props){
    super(props);
    this.handleInputChange = this.handleInputChange.bind(this);
    this.simpanProyek = this.simpanProyek.bind(this);
    this.resetState = this.resetState.bind(this);
    this.state = {
      kategori_proyek:0,
      status_project:0,
      target_tender:0,
      tender_no:"",
      tender_source:"",
      tender_desc:"",
      tender_date:"",
      tender_end_date:"",
      tender_value:0,
      jenis_tender:"",
      project_location:"",
      existing_customer_id:"",
      customer_no:"",
      customer_name:"",
      indikator_simpan:false,
      simpan_berhasil:false
    }    
  }
  
  resetState(){
    this.setState({
      kategori_proyek:0,
      status_project:0,
      target_tender:0,
      tender_no:"",
      tender_source:"",
      tender_desc:"",
      tender_date:"",
      tender_end_date:"",
      tender_value:0,
      jenis_tender:"",
      project_location:"",
      existing_customer_id:"",
      customer_no:"",
      customer_name:"",
      indikator_simpan:false,
      //simpan_berhasil:false
    })
  }

  handleInputChange(evt, name){    
    this.setState({
      [name]:evt.target.value
    })
  }

  simpanProyek(evt){
    evt.preventDefault();
    let data = {...this.state};
    try {
      this.setState({ indikator_simpan:true });
      axios.post('/project/simpanProyek', data)
      .then(res => {        
        if(res.data === "sukses"){
          this.setState({
            indikator_simpan:false,
            simpan_berhasil:true
          })
        }
      }).then(()=>{
        this.resetState();
      });
    } catch(err){
      this.setState({
        indikator_simpan:false,
        simpan_berhasil:false
      })
      console.log(err);
    }    
  }

  render(){
    const { tender_no, tender_source, tender_desc, tender_date, tender_end_date, tender_value, project_location, jenis_tender } = this.state;
    return (
        <React.Fragment>
            <div className="row">
                <div className="col-sm-12 col-lg-12">                    
                    <BreadCrumb breadcrumb={BREADCRUMB} />                    
                    <div className="iq-card">
                        <div className="iq-card-header d-flex justify-content-between">
                            <div className="iq-header-title">
                                <h5 className="card-title">Create Projects</h5>                                
                            </div>
                        </div>
                        <div className="iq-card-body">
                            <div className="form-row">
                                <div className="col-sm-6">
                                  {
                                    this.state.simpan_berhasil && 
                                    <div className="alert text-white bg-success" role="alert">
                                      <div className="iq-alert-text">&nbsp;&nbsp;Data Proyek <b>berhasil disimpan</b></div>
                                      <button type="button" className="close" data-dismiss="alert" aria-label="Close">
                                        <i className="ri-close-line"></i>
                                      </button>
                                    </div>                                                                        
                                  }
                                </div>
                              </div>
                            <div className="section">
                                <h5>Informasi Umum Proyek</h5>                                
                            </div>
                            <form autoComplete="off">
                                <div className="form-row">
                                  <div className="col-sm-3">
                                    <Label title="Kategori" />
                                    <Select name="kategori_proyek"
                                    items={JSON.parse(this.props.opsi_kategori_proyek)}
                                    onChange={this.handleInputChange} />
                                  </div>
                                </div>
                                <div className="form-row">
                                    <div className="col-sm-3">
                                        <Label title="status proyek" />
                                        <Select 
                                          name="status_project"
                                          items={JSON.parse(this.props.opsi_status_project)} 
                                          onChange={this.handleInputChange} />
                                    </div>
                                    <div className="col-sm-3">
                                        <Label title="target tender" />
                                        <Select 
                                          name="target_tender"
                                          items={JSON.parse(this.props.opsi_target_tender)} 
                                          onChange={this.handleInputChange} />
                                    </div>
                                    <div className="col-sm-3">
                                        <label className="label">Jenis Tender</label>                                        
                                        <Select 
                                          name="jenis_tender" 
                                          items={JSON.parse(this.props.opsi_jenis_tender)} 
                                          onChange={this.handleInputChange} />
                                    </div>
                                </div>

                                <div className="form-row">
                                  <div className="col-sm-3">
                                    <input 
                                      type="text" 
                                      id="tender_no" 
                                      name="tender_no" 
                                      className="form-control form-control-sm" 
                                      placeholder="Nomor Tender"
                                      value={tender_no}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />
                                  </div>              
                                  <div className="col-sm-3">
                                    <input 
                                      type="text" 
                                      id="tender_source" 
                                      name="tender_source" 
                                      className="form-control form-control-sm" 
                                      placeholder="Sumber Tender"
                                      value={tender_source}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />
                                  </div>              
                                </div>
                                <div className="form-row">
                                  <div className="col-sm-6">
                                    <textarea 
                                      name="tender_desc" 
                                      className="form-control form-control-sm" 
                                      rows="2" 
                                      placeholder="Keterangan Tender"
                                      value={tender_desc}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />                                      
                                  </div>
                                </div>
                        
                                <div className="form-row">
                                  <div className="col-sm-2">
                                    <Label title="Tanggal Mulai Tender" />
                                    <input 
                                      type="date" 
                                      name="tender_date" 
                                      className="form-control form-control-sm"
                                      value={tender_date}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />
                                  </div>
                                  <div className="col-sm-2">
                                    <Label title="Tanggal Akhir Tender" />
                                    <input 
                                      type="date" 
                                      name="tender_end_date" 
                                      className="form-control form-control-sm"
                                      value={tender_end_date}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />
                                  </div>
                                </div>

                                <div className="form-row form-row-end">
                                  <div className="col-sm-2">                                    
                                    <Label title="Nilai Tender" />
                                    {/* <input 
                                      type="number" 
                                      name="tender_value" 
                                      className="form-control form-control-sm"
                                      value={tender_value}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} /> */}
                                      <NumberFormat 
                                        dir="rtl" 
                                        className="form-control form-control-sm" 
                                        thousandSeparator 
                                        value={tender_value}
                                        
                                        placeholder="Nilai Tender"
                                        onChange={evt => this.handleInputChange(evt, 'tender_value')} />
                                  </div>
                                  <div className="col-sm-4">
                                    <Label title="Lokasi Project" />
                                    <input 
                                      type="text" 
                                      name="project_location" 
                                      className="form-control form-control-sm"
                                      value={project_location}
                                      onChange={evt => this.handleInputChange(evt, evt.target.name)} />
                                  </div>
                                </div>
                                
                                <CustomerSection 
                                  handleInputChange={this.handleInputChange}
                                  customer_id={this.state.existing_customer_id}
                                  customer_no={this.state.customer_no}
                                  customer_name={this.state.customer_name} />
                                
                                <br/>
                                <UploadSection />
                                
                                <hr/>
                                <div className="form-row form-row-end">
                                  <div className="col-sm-2">
                                    <button 
                                      className="btn btn-sm btn-block btn-primary"
                                      onClick={this.simpanProyek}
                                      disabled={this.state.indikator_simpan}>
                                        {this.state.indikator_simpan && <i className="fa fa-spinner"></i>}
                                        Simpan Proyek</button>
                                  </div>
                                  <div className="col-sm-2"></div>
                                </div>

                                


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
  }
}

export default CreateProject;
if (document.getElementById("project-container")) {
  const element = document.getElementById("project-container");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(<CreateProject {...props} />, document.getElementById("project-container"));
}
