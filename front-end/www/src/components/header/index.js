import React, { Component } from 'react';
import { NavLink, useNavigate } from 'react-router-dom';

import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import { userChange } from '../../actions';
import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import Navbar from 'react-bootstrap/Navbar';

// import { Icon } from 'react-bootstrap-icons';

class Header extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        let token = localStorage.getItem('token');
        let userName = localStorage.getItem('user/name');
        let userEmail = localStorage.getItem('user/email');

        if (token !== null && userName !== null && userEmail !== null) {
            const { userChange } = this.props;

            userChange({
                name: userName,
                email: userEmail, 
                jwt: token
            });
        }
    }

    render() {
        let { user } = this.props;

        return (
            <div className="App-header-content row">
                <sub className="App-sub-header">
                    <div className='sub-header-navbar row'>
                                
                        <div className="col-12">
                            <Navbar bg="primary" data-bs-theme="dark">
                                <Container>
                                <Navbar.Brand>D-Influencers</Navbar.Brand>
                                <Nav className="me-auto">
                                    <NavLink to={`/`} className={'nav-link'}>Home</NavLink>
                                    <NavLink to={`/user/login`} className={'nav-link'}>login</NavLink>
                                    <NavLink to={`/user/register`} className={'nav-link'}>Register</NavLink>
                                    <NavLink to={`/influencers`} className={'nav-link'}>Influencers</NavLink>
                                    <NavLink to={`/campaigns`} className={'nav-link'}>Campaigns</NavLink>
                                </Nav>
                                </Container>
                            </Navbar>

                        </div>

                    </div>
                </sub>

            </div>
        )
    };
}

const mapStateToProps = store => ({
    user: store.userState.user
});
const mapDispatchToProps = dispatch => bindActionCreators({ userChange }, dispatch);

export default connect(mapStateToProps, mapDispatchToProps)(Header);
