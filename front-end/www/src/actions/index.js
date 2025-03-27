import { USER_UPDATE_VALUE } from '../actions/actionTypes';

export const userChange = value => ({
    type: USER_UPDATE_VALUE,
    user: value
});