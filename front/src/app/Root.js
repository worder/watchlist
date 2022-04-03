import React from 'react';
import { Provider } from 'react-redux';
import { hot } from 'react-hot-loader/root';

import store from '../store/store';

import { Routes, Route } from 'react-router-dom';
import LoginPage from './Page/Login/LoginPage';
import MainLayout from './MainLayout';
import AuthProvider from './Auth/AuthContext';

// import

const Root = () => (
    <Provider store={store}>
        <AuthProvider>
            <Routes>
                <Route path="/" element={<MainLayout />} />
                <Route path="/login" element={<LoginPage />} />
            </Routes>
        </AuthProvider>
    </Provider>
);

export default hot(Root);
