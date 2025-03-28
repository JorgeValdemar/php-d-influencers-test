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