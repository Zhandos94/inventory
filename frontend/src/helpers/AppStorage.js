class AppStorage {
  storeToken (token) {
    localStorage.setItem('inventory_token', token)
  }

  storeUser (user) {
    localStorage.setItem('inventory_user', user)
  }

  store (token, user) {
    this.storeToken(token)
    this.storeUser(user)
  }

  clear () {
    localStorage.removeItem('inventory_token')
    localStorage.removeItem('inventory_user')
  }

  getToken () {
    return localStorage.getItem('inventory_token')
  }

  getUser () {
    return localStorage.getItem('inventory_user')
  }
}

export default new AppStorage()
