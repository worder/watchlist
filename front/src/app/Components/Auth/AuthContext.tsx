import React, { useEffect, useState, useContext } from 'react';

import userApi, {
    useSigninMutation,
    useGetInfoQuery,
    useSignoutMutation,
} from '../../../api/user/userApi';

import { User, UserInfoResponse } from '../../../api/user/userTypes';


interface AuthContext {
    user: UserInfoResponse | undefined,
    isLoading: boolean,
    isUserError: boolean,
    isSigninError: boolean,
    // signinError: boolean,
    signin: (login: string, password: string) => void,
    // signout: any,
};

const AuthContext = React.createContext<AuthContext | null>(null);

const AuthProvider = ({ children }) => {
    const [
        doLogin,
        {
            isLoading: isSigninLoading,
            isError: isSigninError,
            error: signinError,
        },
    ] = useSigninMutation();

    const [signout, { isLoading: isSignoutLoading }] = useSignoutMutation();

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
