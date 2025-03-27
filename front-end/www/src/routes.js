import React from 'react';
import { isAuthenticated } from './auth';

import { BrowserRouter, Routes, Navigate, Route } from 'react-router-dom';
import HookNavigate from './components/hookNavigate';

import Header from './components/header';

import Home from './pages/home';
import Register from './pages/user/register';
import Login from './pages/user/login';
import Influencers from './pages/influencers';
import Campaigns from './pages/campaigns';
import Campaign from './pages/campaign';

const PrivateRoute = ({ Component, ...props }) => {
    return isAuthenticated() ? React.createElement(Component, { ...props }) : <Navigate to="/" />;
};

const RoutesPack = () => (
    <BrowserRouter>
        <Header />
        <Routes>
            <Route exact path="/" element={<Home />} />
            
            <Route exact path="/influencers" element={<PrivateRoute Component={Influencers} />} />
            <Route exact path="/campaigns" element={<PrivateRoute Component={Campaigns} />} />
            <Route exact path="/campaign/:id" element={<PrivateRoute Component={Campaign} />} />
            
            <Route exact path="/user/login" element={<HookNavigate Component={Login} />} />
            <Route exact path="/user/register" element={<HookNavigate Component={Register} />} />
        </Routes>
    </BrowserRouter>
);

export default RoutesPack;
