import { USER_UPDATE_VALUE } from '../actions/actionTypes';

const initialState = {
    user: {
        name: '',
        email: '',
        jwt: false
    }
};

export const userReducer = (state = initialState, action) => {
    switch (action.type) {
        case USER_UPDATE_VALUE:
        return {
            ...state,
            user: action.user
        };
        default:
        return state;
    }
};