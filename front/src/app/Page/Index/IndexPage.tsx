import React from 'react';
import { Helmet } from 'react-helmet';
import { useGetIndexListItemsQuery } from '../../../api/listItems/listItemsApi';
import { useAuth } from '../../Components/Auth/AuthContext';
import ItemsList from '../../Components/ItemsList/ItemsList';

const IndexPage = () => {
    const auth = useAuth();

    const userId = auth?.user?.id;

    const indexList = useGetIndexListItemsQuery({ userId }, { skip: !userId });

    const data = indexList?.data;

    const {
        total = 0,
        pages = 0,
        page = 0, 
        items = []
    } = data || {};

    return (
        <>
            <Helmet>
                <title>Index</title>
            </Helmet>
            <div>
                <ItemsList
                    items={items}
                    total={total}
                    page={page}
                    pages={pages}
                />
            </div>
        </>
    );
};

export default IndexPage;
