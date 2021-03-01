import Token from './Token'
import AppStorage from './AppStorage'

class User {
  responseAfterLogin (res) {
    const accessToken = res.data.access_token
    const user = res.data.user.name

    if (Token.isValid(accessToken)) {
      AppStorage.store(accessToken, user)
    }
  }

  hasToken () {
    const storeToken = AppStorage.getToken()

    if (storeToken) {
      return Token.isValid(storeToken)
    }
    return false
  }

  loggedIn () {
    return this.hasToken()
  }

  name () {
    if (this.loggedIn()) {
      const user = AppStorage.getUser()
      return user ? user.name : null
    }
  }

  id () {
    if (this.loggedIn()) {
      const payload = Token.payload(AppStorage.getToken())

      return payload.sub
    }

    return false
  }
}

export default new User()
