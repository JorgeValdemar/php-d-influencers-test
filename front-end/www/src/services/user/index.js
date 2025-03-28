import Api from '../api';

class UserService {
    static login = async (email, password, callback) => {
        try {
            let response = await Api.post(`/user/login`, {email, password});

            if (!response.data.error) {
                callback(true, response.data.user, response.data.token);
            } else {
                callback('Falha ao criar autenticação');
            }
        } catch (error) {
            if (!error.response) {
                callback(typeof(error.message) != 'object' ? error.message : 'Erro desconhecido');
            } else if(error.response.status === 401) {
                callback(error.response.data.message);
            } else {
                callback('Houve um erro, tente novamente mais tarde.');
            }
        }
    }

    static register = async (user, callback) => {
        try {
            let response = await Api.post(`/user/register`, user);

            if (!response.data.error) {
                callback(true, response.data.user, response.data.token);
            } else {
                callback('Falha ao criar autenticação');
            }
        } catch (error) {
            if (!error.response) {
                callback(typeof(error.message) != 'object' ? error.message : 'Erro desconhecido');
            } else if(error.response.status === 401) {
                callback(error.response.data.message);
            } else {
                callback('Houve um erro, tente novamente mais tarde.');
            }
        }
    }

}

export default UserService;
