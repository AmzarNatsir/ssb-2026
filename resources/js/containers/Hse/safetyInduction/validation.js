import * as Yup from 'yup';

const getExtension = (filename) => {

    if (typeof filename !== 'undefined') {
        return filename.split('.').pop();
    }

}

export const stepsValidation = Yup.object().shape({    
    step1: Yup.object().shape({
        nomsurat: Yup.string().required('nomor dokumen wajib diisi!'),
        conductDate: Yup.string().required('Tanggal pelaksanaan induksi wajib diisi'),
        employees: Yup.string().min(1).required('wajib mengisi nama karyawan yang akan diinduksi'),
        file: Yup.mixed()
            .test({
                message: 'upload dokumen wajib diisi',
                test: (file, context) => {
                    const isValid = typeof file !== 'undefined'
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'type file yang disupport hanya png, pdf',
                test: (file, context) => {
                    const isValid = ['pdf', 'png'].includes(getExtension(file?.name));
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'ukuran maksimal 1 MB',
                test: file => {
                    // console.log('file size in MB ', file?.size / 1024 / 1024)
                    const isValid = file?.size / 1024 / 1024 < 1;
                    return isValid;
                }
            })

    }),
    step2: Yup.object().shape({
        nomsurat: Yup.string().required('nomor dokumen wajib diisi!'),
        file: Yup.mixed()
            .test({
                message: 'upload dokumen wajib diisi',
                test: (file, context) => {
                    const isValid = typeof file !== 'undefined'
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'type file yang disupport hanya png, pdf',
                test: (file, context) => {
                    const isValid = ['pdf', 'png'].includes(getExtension(file?.name));
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'ukuran maksimal 1 MB',
                test: file => {
                    console.log('file size in MB ', file?.size / 1024 / 1024)
                    const isValid = file?.size / 1024 / 1024 < 1;
                    return isValid;
                }
            })

    }),
    step3: Yup.object().shape({
        nomsurat: Yup.string().required('nomor dokumen wajib diisi!'),
        file: Yup.mixed()
            .test({
                message: 'upload dokumen wajib diisi',
                test: (file, context) => {
                    const isValid = typeof file !== 'undefined'
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'type file yang disupport hanya png, pdf',
                test: (file, context) => {
                    const isValid = ['pdf', 'png'].includes(getExtension(file?.name));
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'ukuran maksimal 1 MB',
                test: file => {
                    console.log('file size in MB ', file?.size / 1024 / 1024)
                    const isValid = file?.size / 1024 / 1024 < 1;
                    return isValid;
                }
            })

    }),
    step4: Yup.object().shape({
        nomsurat: Yup.string().required('nomor dokumen wajib diisi!'),
        file: Yup.mixed()
            .test({
                message: 'upload dokumen wajib diisi',
                test: (file, context) => {
                    const isValid = typeof file !== 'undefined'
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'type file yang disupport hanya png, pdf',
                test: (file, context) => {
                    const isValid = ['pdf', 'png'].includes(getExtension(file?.name));
                    if (!isValid) context?.createError();
                    return isValid;
                }
            })
            .test({
                message: 'ukuran maksimal 1 MB',
                test: file => {
                    console.log('file size in MB ', file?.size / 1024 / 1024)
                    const isValid = file?.size / 1024 / 1024 < 1;
                    return isValid;
                }
            })

    }),
})