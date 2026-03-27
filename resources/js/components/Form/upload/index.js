import React from "react";

const UploadComponent = ({ validationMessage, onChange }) => {
  return (
    <div className="mt-1 flex w-80 lg:w-full bg-white justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
      <div className="space-y-1 text-center">
        {!!validationMessage && <span className="font-semibold text-red-500">Tipe File tidak didukung</span>}
        <svg width="48" height="48" className="mx-auto h-4 w-4 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
        </svg>
        <div className="flex text-sm text-gray-600 justify-center">
            <label htmlFor="file-upload" className="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <span className="text-center btn badge badge-primary">Upload Foto/Gambar</span>
            <input 
              id="file-upload" 
              name="file-upload" 
              type="file" 
              className="w-full sr-only" 
              onChange={onChange} />
          </label>                
        </div>
        <p className="text-xs text-center text-gray-500">
          PNG, JPG ukuran Maksimal 3MB
        </p>
      </div>        
    </div>
  )
}

export default UploadComponent;