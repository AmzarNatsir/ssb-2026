import axios from 'axios';
// import axios from '../../../utils';

// ambil data karyawan berdasarkan departemen proyek (fixed) dan jabatan (jobRole)
const getEmployeeFromJobRoleId = async (jobRoleId) => {

    let response = await axios.get(`/safetyInduction/employeesFromJobRoleId/${jobRoleId}`)
    return response.data;
}

const getJobRolesFromDepartmentId = async (departmentId) => {
    let response = await axios.get(`/safetyInduction/jobRoles/${departmentId}`)
    return response.data;
}

const getInductions = async () => {
    let response = await axios.get('/safetyInduction/inductions');
    return response.data;
}


const createInduction = async (formData) => {
    let response = await axios.post('/safetyInduction/induction', formData , {
        headers:{
            ContentType: 'application/json'
        }
    });
    // '/safetyInduction/induction'
    // multipart/form-data
    return response.data;
}
export {
    getJobRolesFromDepartmentId,
    getEmployeeFromJobRoleId,
    getInductions,
    createInduction
}
