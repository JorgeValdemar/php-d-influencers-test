import { userReducer } from './userReducer';
// import { OtherReducer } from './otherReducer';
import { combineReducers } from 'redux';

export const Reducers = combineReducers({
  userState: userReducer
  //otherState: otherReducer
});