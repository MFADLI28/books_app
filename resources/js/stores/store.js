import Vue from "vue";
import Vuex from 'vuex'
import auth from './auth.js'


Vue.use(Vuex);

const store = new Vuex.Store ({
    modules : {
        auth,
        
    },
    state: {
        token: localStorage.getItem('token'),
        errors: []
    },
    getters: {
        isAuth:state => {
            return state.token != null && state.token != ' underfined';
        }
    },
    mutations: {
        SET_TOKEN(state,payload) {
            state.token = payload
        },
        SET_ERRORS(state, payload) {
          state.errors= payload
        },
        CLEAR_ERRORS(state) {
            state.errors = []
        }
    }
})

export default store;