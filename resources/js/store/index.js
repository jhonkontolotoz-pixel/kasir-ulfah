import {
    createStore
} from 'vuex'

import createPersistedState from 'vuex-persistedstate'

const store = createStore({
    plugins: [
        createPersistedState()
    ],
    state() {
        return {
            authenticated: false,
            user: {},
            products : [],
            _lang : 'en',
            _translate : {},
        }
    },
    mutations: {

        SET_AUTHENTICATED(state, payload) {
            state.authenticated = payload
        },
        SET_USER(state, payload) {
            state.user = payload
        },
        SET_LANG(state, payload){
            state._lang = payload
        },
        SET_TRANSLATE(state, payload){
            state._translate = payload
        }

    },
    actions: {

        login({
            commit
        }) {

            axios.get('/api/user').then(res => {

                console.log("logging...")
                commit('SET_USER', res.data)
                commit('SET_AUTHENTICATED', true)

                console.log("should be logged - ")

            }).catch(err => {
                console.log(err)

                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)

                console.log("loggin failed - ")

            })
        },
        logout({
            commit
        }) {
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
        },
        setLang({
            commit
        } , _lang) {
            axios.post('/api/setLang', {
                _lang: _lang
            }).then(res => {
                commit('SET_LANG', _lang)
            }).catch(err => {
                console.log("cant fetch lan")
            })

        }
    },
    getters: {

        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        },
        isAdmin(state) {
            if (Object.keys(state.user).length != 0) {
                return state.user.roles[0].name == "admin" ? true : false;
            }
            return false
        },
        isSupervisor(state) {
            if (Object.keys(state.user).length != 0) {
                return state.user.roles[0].name == "supervisor" ? true : false;
            }
            return false
        },
        getLang(state){
            return state._lang
        },
        get_translate(state)
        {
            return state._translate
        }
    }
})

export default store
