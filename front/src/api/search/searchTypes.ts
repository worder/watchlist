export interface Posters {
    s?: string,
    m?: string,
    l?: string,
    o?: string,
}

export interface SearchItem {
    api: string;
    id: number;
    type: string;
    title: string;
    title_original: string;
    release_date: string;
    posters?: Posters
}

export interface SearchResult {
    items: SearchItem[];
    page: number;
    pages: number;
    total: number;
}

export interface SearchQueryParams {
    term: string;
    api: string;
    type: string;
    page: number;
}