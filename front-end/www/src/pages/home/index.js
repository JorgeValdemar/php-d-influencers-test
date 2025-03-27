import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';

class Home extends Component {
    
    goBack = () => {
        this.props.history.goBack();
    }

    render() {
        //const {  } = this.state;

        return (
            <div className="App-header">
                <h2>Bem vindo</h2>
                
                <p>
                    Este mini site web é possível logar e visualizar os dados brevemente.
                    <br />
                    Para uma versão mais completa o Postman tem todas as rotas:
                    <br />
                    <a href='https://documenter.getpostman.com/view/32118189/2sAYkLmweB'>https://documenter.getpostman.com/view/32118189/2sAYkLmweB</a>
                </p>
                
            </div>
        );
    }
}


const mapStateToProps = store => ({
    user: store.userState.user
});
const mapDispatchToProps = dispatch => bindActionCreators({ userChange }, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Home);
