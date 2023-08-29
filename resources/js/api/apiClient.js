import axios from 'axios';

// Put your backend url here
export const API_URL = Laravel.baseURL;

const $api = axios.create({
    withCredentials: true,
    baseURL: API_URL,
    headers : {
        'content-type' : 'application/json'
    }
})

$api.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${localStorage.getItem('tk')}`
    return config;
})


export default $api;
