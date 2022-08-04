import React from 'react';
import { connect } from 'react-redux';
import styled from 'styled-components';
import {hot} from 'react-hot-loader';

import { getIsVisible, hide } from './userListCreateDialogSlice';

interface Props {
    isVisible: boolean;
    onHide: () => void;
}

const DialogPlaceholder = styled.div<Partial<Props>>`
    display: ${(p) => (p.isVisible ? 'flex' : 'none')};
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
`;

const ModalOverlay = styled.div`
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    height: 100%;
    background: #000;
    opacity: 0.1;
    z-index: 1000;
`;

const DialogContainer = styled.div`
    border: 1px solid #000;
    background: #fff;
    width: 500px;
    z-index: 1001;
`;

const DialogHeader = styled.div`
    height: 20px;
    display: flex;
`;

const DialogTitle = styled.div`
    height: 20px;
`;

const DialogCloseButton = styled.div`
    width: 20px;
`;

const DialogContentContainer = styled.div``;



const UserListCreateDialog = ({ isVisible, onHide }: Props) => {
    return (
        <DialogPlaceholder isVisible={isVisible}>
            <ModalOverlay />
            <DialogContainer>
                <DialogHeader>
                    <DialogTitle>List creation dialog</DialogTitle>
                    <DialogCloseButton onClick={onHide}>X</DialogCloseButton>
                </DialogHeader>
                <DialogContentContainer>dialog content</DialogContentContainer>
            </DialogContainer>
        </DialogPlaceholder>
    );
};

export default connect(
    (state) => ({
        isVisible: getIsVisible(state),
    }),
    (dispatch) => ({
        onHide: () => dispatch(hide()),
    })
)(UserListCreateDialog);
