import React, { useState, useEffect, useRef } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import Viewer from "react-viewer";
import Container from "../../components/Layout/Container";
import BreadCrumb from "../../components/BreadCrumb";
import Card from "../../components/Layout/Card";
import FormRow from "../../components/Form/FormRow";
import FormCol from "../../components/Form/FormCol";
import Label from "../../components/Label";
import Button from "../../components/Button";

import { BREADCRUMB_UPLOAD } from "./constants";
// upload-form
function UploadForm({ project_id }) {
  const [opsiUploadKategori, setOpsiUploadKategori] = useState([]);
  const [files, setFiles] = useState([]);
  const [fileFetchLoader, setFileFetchLoader] = useState(false);
  const [uploadKategori, setUploadKategori] = useState(1);
  const [uploaded, setUploaded] = useState([]);
  const [documentName, setDocumentname] = useState("");
  const [viewer, setViewer] = useState(false);
  const [progress, setProgress] = useState(0);

  useEffect(() => {
    const fetchOpsiUploadKategori = async () => {
      const result = await axios("/project/getUploadKategori");
      setOpsiUploadKategori(result.data);
    };
    fetchOpsiUploadKategori();
  }, []);

  useEffect(() => {
    // setFileFetchLoader(true);
    const fetchFiles = async () => {
      const result = await axios(`/project/files/${project_id}`);
      setFiles(result.data);
    };
    fetchFiles();
    setFileFetchLoader(false);
  }, [fileFetchLoader]);

  const handleUploadKategori = event => {
    setUploadKategori(event.target.value);
  };

  const handleDocumentNameChange = event => {
    setDocumentname(event.target.value);
    // let upl = uploaded;
    // upl[0].name = documentName;
    // setUploaded(upl);
  };

  const prevDocumentNameRef = useRef();
  useEffect(() => {
    prevDocumentNameRef.current = documentName;
  });

  const prevDocumentName = prevDocumentNameRef.current;

  const handleDocumentChange = event => {
    const fileReader = new FileReader();
    fileReader.onload = e => {
      setUploaded([
        {
          name: documentName,
          src: e.target.result
        }
      ]);
    };
    fileReader.readAsDataURL(event.target.files[0]);
  };

  const handleUpload = event => {
    event.preventDefault();
    let currentFile = uploaded[0].src;
    let formData = new FormData();
    formData.append("file", currentFile);
    formData.append("nama_file", documentName);
    formData.append("project_file_id", uploadKategori);
    formData.append("tender_id", project_id);
    axios
      .post("../uploadFile", formData, {
        headers: {
          "Content-Type": "multipart/form-data"
        }
      })
      .then(response => console.log(response));

    // reset

    setUploaded([]);
    setUploadKategori(1);
    setFileFetchLoader(true);
    // console.log(currentFile);
  };

  return (
    <Container>
      <BreadCrumb breadcrumb={BREADCRUMB_UPLOAD} />
      <Card title="Upload Dokumen">
        <form autoComplete="off">
          <FormRow>
            <FormCol sm="3">
              <Label title="Kategori Dokumen" />
            </FormCol>
          </FormRow>
          <FormRow>
            <FormCol sm="6">
              {opsiUploadKategori.map((option, idx) => (
                <div className="form-check form-check-inline" key={`uk-${idx}`}>
                  <input
                    type="radio"
                    name="UploadOptions"
                    value={option.id}
                    className="form-check-input"
                    checked={option.id == uploadKategori ? true : false}
                    onChange={handleUploadKategori}
                  />
                  <label className="form-check-label" htmlFor="uploadKategori">
                    {option.keterangan}
                  </label>
                </div>
              ))}
            </FormCol>
          </FormRow>
          {uploaded.length > 0
            ? uploaded.map((item, i) => (
                <React.Fragment key={`img-${i}`}>
                  <FormRow>
                    <FormCol sm="1">
                      <img
                        src={item.src}
                        className="rounded mr-3"
                        style={{ width: 36, height: 36 }}
                        onClick={() => setViewer(true)}
                      />
                    </FormCol>
                    <FormCol sm="1">
                      <Button
                        sm
                        success
                        disabled={documentName === "" ? true : false}
                        onClick={handleUpload}
                      >
                        Upload File
                      </Button>
                    </FormCol>
                  </FormRow>
                  <Viewer
                    visible={viewer}
                    images={uploaded}
                    onClose={() => setViewer(false)}
                    noToolbar
                  />
                </React.Fragment>
              ))
            : null}
          <div id="files_container">
            <FormRow>
              <FormCol sm="6" style={{ textAlign: "left" }}>
                {/* <button className="btn btn-sm btn-primary">
                  <i className="ri-add-fill pr-0"></i>add file
                </button> */}
              </FormCol>
            </FormRow>
            <FormRow>
              <FormCol sm="2">
                <Label title="nama file" />
                <input
                  type="text"
                  name="nama_file"
                  value={documentName}
                  className="form-control form-control-sm file-input"
                  onChange={handleDocumentNameChange}
                />
              </FormCol>
              <FormCol sm="3" style={{ marginTop: "32px" }}>
                <input
                  type="file"
                  name="document"
                  multiple
                  accept=".jpg, .jpeg, .png"
                  className="custom-file-input"
                  onChange={handleDocumentChange}
                />
                <label className="custom-file-label" htmlFor="customFile">
                  Pilih File Upload anda
                </label>
              </FormCol>
              {uploaded.length > 0 ? (
                <FormCol sm="2" style={{ marginTop: "32px" }}>
                  {/* <button className="btn btn-sm btn-primary">
                    <i className="ri-add-fill pr-0"></i>add file
                  </button> */}
                </FormCol>
              ) : null}
              {/* <FormCol sm="3">{JSON.stringify(files)}</FormCol> */}
            </FormRow>
          </div>
        </form>
      </Card>
      <Card title="Daftar Dokumen">
        <ul className="list-unstyled">
          {files.map((item, i) => (
            <li className="media">
              <img
                className="rounded mr-3"
                src={`../../assets/images/upload/${item.file}`}
                style={{ width: 36, height: 36 }}
              />
              <div className="media-body">
                <h6 className="mt-0 mb-0">{item.file}</h6>
              </div>
            </li>
          ))}
        </ul>
      </Card>
    </Container>
  );
}

export default UploadForm;
if (document.getElementById("upload-form")) {
  const element = document.getElementById("upload-form");
  const props = Object.assign({}, element.dataset);
  ReactDOM.render(
    <UploadForm {...props} />,
    document.getElementById("upload-form")
  );
}
