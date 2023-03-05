import { useAuth } from '../../app/Components/Auth/AuthContext';
import { useGetUserListsQuery } from './listApi';

const useGetCurrentUserLists = () => {
    const auth = useAuth();
    const { data, isSuccess } = useGetUserListsQuery(auth?.user?.id ?? 0, {
        skip: !auth?.user?.id,
    });

    return {
        data,
        isSuccess,
    };
};

export default useGetCurrentUserLists;
