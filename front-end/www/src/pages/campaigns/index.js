import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';
import ListGroup from 'react-bootstrap/ListGroup';
import CampaignsService from '../../services/campaigns';

class Campaigns extends Component {
    state = {
        listCampaigns: []
    }

    componentDidMount() {
        let { user } = this.props;

        CampaignsService.setToken(user.jwt);
        CampaignsService.listCampaigns([], function(listCampaigns) {
            this.setState({ listCampaigns });
        }.bind(this));
    }

    render() {
        const { listCampaigns } = this.state;

        return (
            <div className="App-header">
                <h2>Campanhas cadastradas</h2>
                
                <ListGroup>
                    {
                        listCampaigns.length > 0 ?
                        listCampaigns.map(
                            campaign => (
                                <ListGroup.Item key={campaign.id}>
                                    Nome: {campaign.name}
                                    Valor: {campaign.budget}
                                    Descrição: {campaign.description}
                                    Início: {campaign.begin_date}
                                    Encerramento: {campaign.end_date}
                                    Criada em: {campaign.created_at}
                                    última atualização: {campaign.updated_at}
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