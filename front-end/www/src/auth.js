export const isAuthenticated = () => {
    let token = localStorage.getItem('token');
    let userEmail = localStorage.getItem('user/email');

    if (token !== null && userEmail !== null) {
        return true;
    }

    return false;
};