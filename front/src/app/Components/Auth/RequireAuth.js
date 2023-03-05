import React, { useContext } from 'react';
import { Navigate } from 'react-router-dom';
import { useAuth } from './AuthContext';

const RequireAuth = ({ children }) => {
    const { user, isLoading } = useAuth();

    if (!isLoading && !user) {
        return <Navigate to="/login" />
    } else if (isLoading) {
        return <div>loading...</div>
    }

    return children;
};

export default RequireAuth;
