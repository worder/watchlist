import styled from 'styled-components';
import React from 'react';

const SDialogCloseButton = styled.div`
    padding: 10px;
    cursor: pointer;
`;

const DialogCloseButton = ({ onClick }) => {
    return <SDialogCloseButton onClick={onClick}>X</SDialogCloseButton>;
};

export default DialogCloseButton;
