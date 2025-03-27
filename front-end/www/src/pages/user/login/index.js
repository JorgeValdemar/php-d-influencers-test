import React, { Component } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../../actions';
import UserService from '../../../services/user';

class Login extends Component {
    
    state = {
        email: '',
        password: '',
        errorMessage: ''
    }
    
    constructor(props) {
        super(props);
    
        this.handleChange = this.handleChange.bind(this);
    }
    
    //goBack = () => {
       // this.props.history.goBack();
    //}

    handleChange(event) {
        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.type === 'file' ? target.files[0] : target.value;
        const name = target.name;

        this.setState({[name]:value});
    }

    doLogin = () => {
        let {email, password} = this.state;

        UserService.login(email, password, function(result, user, token) {

            if (result === true) {

                this.setState(
                    {errorMessage: ''}, 
                    function() {
                        const { userChange } = this.props;

                        localStorage.setItem('token', token);
                        localStorage.setItem('user/name', 'logado');
                        localStorage.setItem('user/email', email);

                        userChange({
                            name: 'logado',
                            email: email, 
                            jwt: token
                        });
                    }
                );

                this.props.navigate('/');

            } else {
                this.setState({errorMessage: result});
            }
        }.bind(this));
    }

    render() {
        //const {  } = this.state;

        return (
            <div className="App-header">
                <h2>logar</h2>
                
                <div className='row'>

                    <div className='col-12'>

                        <Form>
                            <Form.Group className="mb-3" controlId="formBasicEmail">
                                <Form.Label>Email address</Form.Label>
                                <Form.Control type="email" placeholder="Enter email" name='email' onChange={this.handleChange} />

                            </Form.Group>

                            <Form.Group className="mb-3" controlId="formBasicPassword">
                                <Form.Label>Password</Form.Label>
                                <Form.Control type="password" placeholder="Password" name='password' onChange={this.handleChange} />
                            </Form.Group>
                            
                            <Alert variant={'warning'} hidden={this.state.errorMessage == ''}>{this.state.errorMessage}</Alert>
        
                            <Button variant='primary' type="button" onClick={this.doLogin}>
                                Submit
                            </Button>
                        </Form>

                    </div>

                </div>

            </div>
        );
    }
}

const mapStateToProps = store => ({
    user: store.userState.user
});
const mapDispatchToProps = dispatch => bindActionCreators({ userChange }, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Login);