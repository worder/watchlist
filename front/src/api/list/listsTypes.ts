export interface UserList {
    listId: number,
    userId: number,
    title: string,
    desc: string,
}

export type UserListsResult = UserList[];