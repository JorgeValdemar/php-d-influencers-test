import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';
import ListGroup from 'react-bootstrap/ListGroup';
import Accordion from 'react-bootstrap/Accordion';
import InfluencersService from '../../services/influencers';

class Influencers extends Component {
    state = {
        listInfluencers: [],
        listInfluencerCampaigns: []
    }
    
    componentDidMount() {
        let { user } = this.props;
        
        InfluencersService.setToken(user.jwt);
        InfluencersService.listInfluencers([], function(listInfluencers) {
            if (listInfluencers instanceof Array) {
                this.setState({ listInfluencers });
            } else {
                alert("A sessão expirou ou a API está fora, tente novamente mais tarde");
                // A maior probabilidade aqui é que a sessao no back caiu, o front precisa deslogar, 
                // vale lembrar: é um tratamento rápido e não um bem trabalhado 
                const { userChange } = this.props;

                localStorage.removeItem('token');
                localStorage.removeItem('user/name');
                localStorage.removeItem('user/email');

                userChange({
                    name: '',
                    email: '',
                    jwt: false
                });
            }
        }.bind(this));
    }

    handlerListCampaignsByInfluencerId(influencerId) {
        InfluencersService.listInfluencerCampaigns(influencerId, function(listInfluencerCampaigns) {
            this.setState({ listInfluencerCampaigns: listInfluencerCampaigns instanceof Array ? listInfluencerCampaigns : [] });
        }.bind(this));
    }

    render() {
        const { listInfluencers, listInfluencerCampaigns } = this.state;

        return (
            <div className="App-header">
                <h2>Influenciadores cadastrados</h2>
                
                <ListGroup numbered>
                    {
                        listInfluencers.length > 0 ?
                        listInfluencers.map(
                            influencer => (
                                <ListGroup.Item key={influencer.id} className='list-simple-v1'>
                                    Nome: {influencer.name}
                                    <br />
                                    Instagram: {influencer.instagram}
                                    <br />
                                    Seguidores: {influencer.qtd_followers}
                                    <br />
                                    Categoria: {influencer.category}
                                    
                                    <br />

                                    <Accordion>
                                        <Accordion.Item eventKey="0">
                                            <Accordion.Header onClick={(e) => this.handlerListCampaignsByInfluencerId(influencer.id, e)}>Campanhas Participando</Accordion.Header>
                                            <Accordion.Body>
                                                <ListGroup numbered>
                                                    {
                                                        listInfluencerCampaigns.length > 0 ?
                                                        listInfluencerCampaigns.map(
                                                            campaign => (
                                                                <ListGroup.Item key={campaign.id}>{campaign.name}</ListGroup.Item>
                                                            )
                                                        ) : "Este influencer não está participando de uma campanha"
                                                    }
                                                </ListGroup>
                                            </Accordion.Body>
                                        </Accordion.Item>
                                    </Accordion>
                                </ListGroup.Item>
                            )
                        ) : "Nenhum influenciador cadastrado."
                    }
                </ListGroup>
                
            </div>
        );
    }
}


const mapStateToProps = store => ({
    user: store.userState.user
});
const mapDispatchToProps = dispatch => bindActionCreators({ userChange }, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Influencers);
