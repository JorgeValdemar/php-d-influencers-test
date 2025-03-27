import React, { Component } from 'react';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';

class Campaign extends Component {
    
    goBack = () => {
        this.props.history.goBack();
    }

    render() {
        //const {  } = this.state;

        return (
            <div className="App-header">
                <h2>Ver Campanha</h2>
                
                
            </div>
        );
    }
}

const mapStateToProps = store => ({
    user: store.userState.user
});
const mapDispatchToProps = dispatch => bindActionCreators({ userChange }, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Campaign);