import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';
import ListGroup from 'react-bootstrap/ListGroup';
import Accordion from 'react-bootstrap/Accordion';
import CampaignsService from '../../services/campaigns';

class Campaigns extends Component {
    state = {
        listCampaigns: [],
        listCampaignInfluencers: []
    }

    componentDidMount() {
        let { user } = this.props;

        CampaignsService.setToken(user.jwt);
        CampaignsService.listCampaigns([], function(listCampaigns) {
            if (listCampaigns instanceof Array) {
                this.setState({ listCampaigns });
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

    handlerListInfluencersByCampaignId(campaignId) {
        CampaignsService.listCampaignInfluencers(campaignId, function(listCampaignInfluencers) {
            this.setState({ listCampaignInfluencers: listCampaignInfluencers instanceof Array ? listCampaignInfluencers : []  });
        }.bind(this));
    }

    render() {
        const { listCampaigns, listCampaignInfluencers } = this.state;

        return (
            <div className="App-header">
                <h2>Campanhas cadastradas</h2>
                
                <ListGroup numbered>
                    {
                        listCampaigns.length > 0 ?
                        listCampaigns.map(
                            campaign => (
                                <ListGroup.Item key={campaign.id} className='list-simple-v1'>
                                    Nome: {campaign.name}
                                    <br />
                                    Valor: {campaign.budget}
                                    <br />
                                    Descrição: {campaign.description}
                                    <br />
                                    Início: {campaign.begin_date}
                                    <br />
                                    Encerramento: {campaign.end_date}

                                    <br />

                                    <Accordion>
                                        <Accordion.Item eventKey="0">
                                            <Accordion.Header onClick={(e) => this.handlerListInfluencersByCampaignId(campaign.id, e)}>Influenciadores Participando</Accordion.Header>
                                            <Accordion.Body>
                                                <ListGroup numbered>
                                                    {
                                                        listCampaignInfluencers.length > 0 ?
                                                        listCampaignInfluencers.map(
                                                            influencer => (
                                                                <ListGroup.Item key={influencer.id}>{influencer.name}</ListGroup.Item>
                                                            )
                                                        ) : "Nenhum influencer participando desta campanha"
                                                    }
                                                </ListGroup>
                                            </Accordion.Body>
                                        </Accordion.Item>
                                    </Accordion>
                                </ListGroup.Item>
                            )
                        ) : "Nenhuma campanha cadastrada"
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

export default connect(mapStateToProps, mapDispatchToProps)(Campaigns);