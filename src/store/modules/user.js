import { login, logout, getInfo } from '@/api/user'
import { getToken, setToken, removeToken } from '@/utils/auth'
import { resetRouter } from '@/router'

const state = {
  token: '',
  name: '',
  avatar: '',
  role: '',
  sid: ''
}

const mutations = {
  SET_TOKEN: (state, token) => {
    state.token = token
  },
  SET_NAME: (state, name) => {
    state.name = name
  },
  SET_AVATAR: (state, avatar) => {
    state.avatar = avatar
  },
  SET_ROLE: (state, role) => {
    state.role = role
  },
  SET_SID: (state, sid) => {
    state.sid = sid
  }
}

const actions = {
  // user login
  login({ commit }, userInfo) {
    const { user, password } = userInfo
    return new Promise((resolve, reject) => {
      login({ user: user.trim(), password: password }).then(response => {
        commit('SET_TOKEN', response.token)
        setToken(response.token)
        commit('SET_ROLE', response.role)
        commit('SET_SID', response.sid)
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  // get user info
  getInfo({ commit, state }) {
    return new Promise((resolve, reject) => {
      getInfo(state.token, state.sid).then(response => {
        const data = response.info
        if (!data) {
          reject('Verification failed, please Login again.')
        }

        const { name, avatar, role } = data

        commit('SET_NAME', name)
        commit('SET_AVATAR', avatar)
        commit('SET_ROLE', role)
        resolve(data)
      }).catch(error => {
        console.log(error)
        reject(error)
      })
    })
  },

  // user logout
  logout({ commit, state }) {
    return new Promise((resolve, reject) => {
      logout(state.token).then(() => {
        commit('SET_TOKEN', '')
        removeToken()
        resetRouter()
        resolve()
      }).catch(error => {
        reject(error)
      })
    })
  },

  // remove token
  resetToken({ commit }) {
    return new Promise(resolve => {
      commit('SET_TOKEN', '')
      removeToken()
      resolve()
    })
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions
}

