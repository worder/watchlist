import React, { useEffect, useState, useContext } from 'react';

import { useLoginMutation, useGetInfoQuery } from '../../api/user/userApi';

const AuthContext = React.createContext(null);

const AuthProvider = ({ children }) => {
    const [doLogin, { isLoading: isLoginLoading }] = useLoginMutation();

    const {
        data: user,
        isLoading: isUserLoading,
        isError,
        refetch,
    } = useGetInfoQuery();

    const signin = (login, password) => {
        doLogin({
            login,
            password,
        }).then(refetch);
    };

    // TODO
    const signout = () => {};

    const isLoading = isUserLoading || isLoginLoading;

    const value = { user, isLoading, isError, signin };

    return (
        <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
    );
};

const useAuth = () => {
    return useContext(AuthContext);
};

export default AuthProvider;
export { useAuth };
