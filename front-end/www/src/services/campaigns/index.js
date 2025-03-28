import Api from '../api';

class CampaignsService {
    static setToken = (token) => {
        Api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    };

    static listCampaigns = async (data, callback) => {
        try {
            let response = await Api.get(`/campaigns/list`, data);

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

    
    static listCampaignInfluencers = async (id, callback) => {
        try {
            let response = await Api.get(`/campaigns/influencers/list/${id}`);

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

export default CampaignsService;
