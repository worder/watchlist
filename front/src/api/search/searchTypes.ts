interface SearchItem {
    id: number;
    type: string;
    title: string;
    title_original: string;
    release_date: string;
}

interface SearchResult {
    items: SearchItem[];
    page: number;
    pages: number;
    total: number;
}

interface SearchOptionsMediaType {
    id: string;
    name: string;
}

interface SearchOptionsApi {
    id: string;
    media_types: SearchOptionsMediaType[];
    name: string;
    name_short: string;
}

type SearchOptionsResult = SearchOptionsApi[];

export {
    SearchItem,
    SearchResult,
    SearchOptionsApi,
    SearchOptionsMediaType,
    SearchOptionsResult,
};
