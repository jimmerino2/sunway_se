const token = localStorage.getItem('authToken');
const username = localStorage.getItem('username');

if (!token) {
    console.log('token is unavailable');
} else {
    console.log('token is:', token);
}

if (!username) {
    console.log('username is unavailable')
} else {
    console.log('Retrieved username from localStorage:', username);
}