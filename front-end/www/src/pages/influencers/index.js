import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';
import ListGroup from 'react-bootstrap/ListGroup';
import InfluencersService from '../../services/influencers';

class Influencers extends Component {
    state = {
        listInfluencers: []
    }
    
    componentDidMount() {
        let { user } = this.props;
        
        InfluencersService.setToken(user.jwt);
        InfluencersService.listInfluencers([], function(listCampaigns) {
            this.setState({ listCampaigns });
        }.bind(this));
    }

    render() {
        const { listInfluencers } = this.state;

        return (
            <div className="App-header">
                <h2>Influenciadores cadastrados</h2>
                
                <ListGroup>
                    {
                        listInfluencers.length > 0 ?
                        listInfluencers.map(
                            influencer => (
                                <ListGroup.Item key={influencer.id}>
                                    Nome: {influencer.name}
                                    Instagram: {influencer.instagram}
                                    Seguidores: {influencer.qtd_followers}
                                    Categoria: {influencer.category}
                                    Criada em: {influencer.created_at}
                                    última atualização: {influencer.updated_at}
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
