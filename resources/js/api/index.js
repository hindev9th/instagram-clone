import axios from 'axios';

// Put your backend url here
export const API_URL = Laravel.baseURL;

const $api = axios.create({
    withCredentials: true,
    baseURL: API_URL
})

$api.interceptors.request.use((config) => {
    config.headers.Authorization = `Bearer ${Laravel.api_token}`
    return config;
})


export default $api;
