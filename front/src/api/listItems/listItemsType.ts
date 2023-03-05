export interface ListItemPutProps {
    api: string;
    mediaId: string;
    mediaType: string;
    listId: number;
    status: number;
    date: number;
}   

export interface ListItem {
    id: number;
    api: string;
    mediaId: string;
    type: string;
    release_date: string;
    original_title: string;
    title: string;
    posters: {
        s?: string;
        m?: string;
        l?: string;
    };
}

export interface IndexListItemsProps {
    userId?: number;
}

export interface ListItemsResult {
    total: number;
    page: number;
    pages: number;
    items: ListItem[];
}