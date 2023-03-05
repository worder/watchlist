import React from 'react';
import { Provider } from 'react-redux';
import { hot } from 'react-hot-loader/root';

import store from '../store/store';

import { Routes, Route } from 'react-router-dom';
import LoginPage from './Page/Login/LoginPage';
import MainLayout from './MainLayout';
import AuthProvider from './Components/Auth/AuthContext';
import IndexPage from './Page/Index/IndexPage';
import ListViewPage from './Page/List/ListViewPage';
import { MantineProvider } from '@mantine/core';

const Root = () => (
    <Provider store={store}>
        <MantineProvider withGlobalStyles withNormalizeCSS>
            <AuthProvider>
                <Routes>
                    <Route path="/" element={<MainLayout />}>
                        <Route index element={<IndexPage />} />
                        <Route path="list/:listId" element={<ListViewPage />} />
                    </Route>
                    <Route path="/login" element={<LoginPage />} />
                </Routes>
            </AuthProvider>
        </MantineProvider>
    </Provider>
);

export default Root;
