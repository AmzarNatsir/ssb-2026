import React from "react";
export default function ErrorMessage({ message }){
  return <span className="flex items-center font-medium tracking-wide text-danger text-xs mt-1 mb-2 ml-1">{message}</span>
}