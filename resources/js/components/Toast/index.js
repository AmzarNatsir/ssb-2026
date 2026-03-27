import React from "react";
export default function Toast({ type, message, visible }){
  
    const toastComp = visible ? 
    (
      <div 
        className={`flex w-screen justify-items-center mx-4 p-2 mb-2 ${type === "success" ? "bg-success" : "bg-danger"}`} 
        style={{
          position: 'absolute',
          top: 130,
          left:-25,
          zIndex:2000,
          width:"100vw",
          display: "flex",
          justifyItems:"center"
        }}>
          <svg className={`w-5 h-5 flex-shrink-0 ${type === "success" ? "text-white" : "text-white"} `} fill="currentColor" width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clipRule="evenodd"></path></svg>
          <div className={`ml-3 text-sm font-medium ${type === "success" ? "text-white" : "text-white"}`}>
            {message}
          </div>        
      </div>
    ) : null;
    return toastComp;
  
}