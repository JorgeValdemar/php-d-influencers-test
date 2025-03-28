import Api from '../api';

class InfluencersService {
    static setToken = (token) => {
        Api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    };

    static listInfluencers = async (data, callback) => {
        try {
            let response = await Api.get(`/influencers/list`, data);

            if (!response.data.error) {
                callback(response.data);
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

    static listInfluencerCampaigns = async (id, callback) => {
        try {
            let response = await Api.get(`/influencers/campaigns/list/${id}`);

            if (!response.data.error) {
                callback(response.data);
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

export default InfluencersService;
