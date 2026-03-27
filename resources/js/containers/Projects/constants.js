export const BREADCRUMB = [
  {
    text: "Home",
    active: false
  },
  {
    text: "Project",
    active: false
  },
  {
    text: "Manajemen Tender",
    active: false
  },
  {
    text: "Registrasi Tender",
    active: true
  }
];

export const BREADCRUMB_DAFTAR_PROJECT = [
  {
    text: "Home",
    active: false
  },
  {
    text: "Project",
    active: false
  },
  {
    text: "Manajemen Tender",
    active: false
  },
  {
    text: "Daftar Tender",
    active: true
  }
];

export const BREADCRUMB_UPLOAD = [
  {
    text: "Home",
    active: false
  },
  {
    text: "Project",
    active: false
  },
  {
    text: "Manajemen Tender",
    active: false
  },
  {
    text: "Upload Dokumen",
    active: true
  }
];

export const CHANGE_INPUT = "Project/CHANGE_INPUT";
export const CHANGE_IS_SAVING_PROGRESS = "Project/CHANGE_IS_SAVING_PROGRESS";
export const SIMPAN_ACTION = "Project/SIMPAN_ACTION";
export const SIMPAN_SUCCESS = "Project/SIMPAN_SUCCESS";
export const SIMPAN_ERROR = "Project/SIMPAN_ERROR";
export const RESET = "Project/RESET";

export const initialState = {
  registration_no: "",
  project_category_id: 0,
  project_desc: "",
  project_source: "",
  project_status: 0,
  project_start_date: "",
  project_end_date: "",
  project_value: 0,
  project_target: 0,
  project_location: "",
  duration_in_month: 1,
  customer_id: "",
  is_tender: false,
  is_saving: false,
  save_success: false
};
