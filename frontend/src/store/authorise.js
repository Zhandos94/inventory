import AppStorage from '@/helpers/AppStorage'

export default {
  state: {
    userAuthorised: false
  },
  mutations: {
    setLogin (state, payload) {
      state.userAuthorised = payload
    },
    clearLogin (state) {
      AppStorage.clear()

      state.userAuthorised = false
    }
  },
  actions: {
    setLogin ({ commit }, payload) {
      commit('setLogin', payload)
    },
    clearLogin ({ commit }, payload) {
      commit('clearLogin', payload)
    }
  },
  getters: {
    userAuthorised (state) {
      return state.userAuthorised
    }
  }
}
