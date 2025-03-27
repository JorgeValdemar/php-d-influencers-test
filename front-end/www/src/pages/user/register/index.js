import React, { Component } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import UserService from '../../../services/user';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../../actions';

class Register extends Component {
    state = {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
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

    doRegister = () => {
        let {name, email, password, password_confirmation} = this.state;

        UserService.register({name, email, password, password_confirmation}, function(result, user, token) {

            if (result === true) {

                this.setState(
                    {errorMessage: ''}, 
                    function() {
                        const { userChange } = this.props;

                        localStorage.setItem('token', token);
                        localStorage.setItem('user/name', user.name);
                        localStorage.setItem('user/email', user.email);

                        userChange({
                            name: user.name,
                            email: user.email, 
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
                <h2>cadastrar</h2>
                
                <div className='row'>

                    <div className='col-12'>

                        <Form>
                            <Form.Group className="mb-3" controlId="formBasicUser">
                                <Form.Control type="text" placeholder="Nome de usuário" name='name' onChange={this.handleChange} />

                            </Form.Group>

                            <Form.Group className="mb-3" controlId="formBasicEmail">
                                <Form.Control type="email" placeholder="E-mail" name='email' onChange={this.handleChange} />

                            </Form.Group>

                            <Form.Group className="mb-3" controlId="formBasicPassword">
                                <Form.Control type="password" placeholder="senha" name='password' onChange={this.handleChange} />
                            </Form.Group>
        
                            <Form.Group className="mb-3" controlId="formBasicPassword">
                                <Form.Control type="password" placeholder="confirme a senha" name='password_confirmation' onChange={this.handleChange} />
                            </Form.Group>

                            <Alert variant={'warning'} hidden={this.state.errorMessage == ''}>{this.state.errorMessage}</Alert>

                            <Button variant='primary' type="button" onClick={this.doRegister}>
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

export default connect(mapStateToProps, mapDispatchToProps)(Register);
