import axios from "axios";
import { create } from "lodash";
import store from "./stores/store";

const $axios = axios.create({
    baseURL:'api',
    headers: {
        'content type' : 'application/json'
    }
});

$axios.interceptors.request.use(
    function(config) {
        const token = store.state.token;
        if ( token ) config.headers.Authorization = `Bearer ${token}`;
        return config;
    },
    function ( error ) {
        return Promise.reject(error);
    }
);

export default $axios;