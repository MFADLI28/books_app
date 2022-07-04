import $axios from "../api";

const actions = {
    submit({commit}, payload) {
        localStorage.setItem('token',null);
        commit('SET_TOKEN',null,{root:true});
        return new Promise((resolve, reject) => {
            $axios.post('/login', payload)
               .then((response) => {
                if (response.data.status === 'success') {
                    localStorage.setItem('token',response.data.token);
                    commit('SET_TOKEN',response.data.token, {root:true})
                } else {
                    commit('SET_ERRORS', {invalid: 'Email/Password salah'},{root:true})
                }
                resolve (reponse.data)
               })
               .catch((error) => {
                if (error.response.status === 422) {
                    commit('SET_ERRORS',error.response.data.errors, {root:true})
                }
               })
        })
    }
}

export default {
    namespaced:true,
    actions,
}