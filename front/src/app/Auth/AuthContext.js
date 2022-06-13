import React, { useEffect, useState, useContext } from 'react';

import userApi, {
    useSigninMutation,
    useGetInfoQuery,
    useSignoutMutation,
} from '../../api/user/userApi';

const AuthContext = React.createContext(null);

const AuthProvider = ({ children }) => {
    const [
        doLogin,
        {
            isFetching: isSigninLoading,
            isError: isSigninError,
            error: signinError,
        },
    ] = useSigninMutation();

    const [signout, { isFetching: isSignoutLoading }] = useSignoutMutation();

    const {
        data: response,
        isFetching: isUserLoading,
        isError: isUserError,
        error: userError,
    } = useGetInfoQuery();

    const signin = (login, password) => {
        doLogin({
            login,
            password,
        });
    };

    const isLoading = isUserLoading || isSigninLoading || isSignoutLoading;
    const user = response;

    const value = {
        user,
        isLoading,
        isUserError,
        userError,
        isSigninError,
        signinError,
        signin,
        signout,
    };

    return (
        <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
    );
};

const useAuth = () => {
    return useContext(AuthContext);
};

export default AuthProvider;
export { useAuth };
