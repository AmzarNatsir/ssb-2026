import { useRef } from 'react'
import usePortal from 'react-useportal';

const useModal = ({ onOpen, onClose, ...config } = {}) => {
    const modal = useRef();
    const { isOpen, togglePortal, openPortal, closePortal, Portal } = usePortal({
        onOpen(args) {
            const { portal } = args;
            portal.current.style.cssText = `
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                z-index: 100;
            `;
            if (onOpen) onOpen(args)
        },
        onClose(event) {
        },
        onPortalClick({ target }) {

        },
        ...config
    });

    return {
        Modal: Portal,
        toggleModal: togglePortal,
        openModal: openPortal,
        closeModal: closePortal,
        isOpen
    }
}

export default useModal;