export interface User {
    id: number;
    email: string;
    username: string;
};

export type UserInfoResponse = User | null;