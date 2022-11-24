import styled from 'styled-components';
import React from 'react';

interface DialogProps {
    children: any;
    isVisible: boolean;
}

const DialogPlaceholder = styled.div<Partial<DialogProps>>`
    display: ${(p) => (p.isVisible ? 'flex' : 'none')};
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
`;

const DialogBody = styled.div`
    border: 1px solid #000;
    background: #fff;
    width: 500px;
    z-index: 1001;
`;

const Dialog = ({ children, isVisible }: DialogProps) => {
    return (
        <DialogPlaceholder isVisible={isVisible}>
            <DialogBody>{children}</DialogBody>
        </DialogPlaceholder>
    );
};

export default Dialog;
