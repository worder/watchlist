import styled from "styled-components";

interface ModalProps {
    isVisible: boolean;
    zIndex?: number;
}

const BlockerOverlay = styled.div<ModalProps>`
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.1;
    z-index: ${p => p.zIndex ?? 1000};
    ${p => !p.isVisible && 'display: none;'}
`;

export default BlockerOverlay;