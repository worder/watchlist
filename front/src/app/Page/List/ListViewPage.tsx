import React from 'react';
import { useParams } from 'react-router-dom';
import { useGetListItemsQuery } from '../../../api/listItems/listItemsApi';

type UrlParams = {
    listId: string;
}

const ListViewPage = () => {
    
    const { listId } = useParams<UrlParams>();
    
    const listItemsResult = listId && useGetListItemsQuery(parseInt(listId, 10));

    console.log(listItemsResult);

    return <div>ListView: {listId}</div>;
};

export default ListViewPage;
