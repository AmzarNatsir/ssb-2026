import React from "react";

const Modal = ({ handleClose, show, children }) => {
  const showHideClassName = show ? "modal-custom display-block" : "modal-custom display-none";
  return (
    <div className={showHideClassName}>
      <section className="modal-main">
        {children}
        <button onClick={handleClose} className="btn btn-sm btn-success">close</button>
      </section>
    </div>
  )
}

export default Modal;