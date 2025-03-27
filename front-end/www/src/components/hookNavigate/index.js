import React from 'react';
import { useNavigate } from 'react-router-dom';


const HookNavigate = ({ Component, ...props }) => {
    const navigate = useNavigate();

    return React.createElement(Component, { ...props, navigate });
};

export default HookNavigate;
