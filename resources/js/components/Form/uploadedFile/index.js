import React from "react";

const UploadedFileComponent = ({ file, onClickRemove }) => {
  return (
    <div className="mt-2 flex w-80 lg:w-full justify-center px-6 pt-2 pb-3 border-2 border-gray-300 border-dashed rounded-md"
    style={{
      display: "flex",
      width:"100%",
      justifyContent:"center",
      border:"dashed 2px #FAFAFA" 
    }}>
      <div className="relative" style={{ position:"relative" }}>
        <div className="absolute -right-5 -top-2" style={{
          position: "absolute",
          top:'-2',
          right:"-5",
        }}>                
          <a className="text-red-600 hover:text-red-500" style={{
            color:"red",            
          }} href="#" onClick={onClickRemove}>
            <svg width="12" height="12" className="h-4 w-4 fill-current stroke-1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" enableBackground="new 0 0 252 252" version="1.1" viewBox="0 0 252 252" xmlSpace="preserve">
              <path d="M126 0C56.523 0 0 56.523 0 126s56.523 126 126 126 126-56.523 126-126S195.477 0 126 0zm0 234c-59.551 0-108-48.449-108-108S66.449 18 126 18s108 48.449 108 108-48.449 108-108 108z"></path>
              <path d="M164.612 87.388a9 9 0 00-12.728 0L126 113.272l-25.885-25.885a9 9 0 00-12.728 0 9 9 0 000 12.728L113.272 126l-25.885 25.885a9 9 0 006.364 15.364 8.975 8.975 0 006.364-2.636L126 138.728l25.885 25.885c1.757 1.757 4.061 2.636 6.364 2.636s4.606-.879 6.364-2.636a9 9 0 000-12.728L138.728 126l25.885-25.885a9 9 0 00-.001-12.727z"></path>
            </svg>
          </a>
        </div>
        <img src={file} width="100" height="100" />
      </div>
    </div>
  );
}

export default UploadedFileComponent;