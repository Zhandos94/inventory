class Token {
  isValid (token) {
    const payload = this.payload(token)

    if (payload) {
      payload.iss = ('http://localhost:8000/login' || 'http://localhost:8000/register')

      return payload
    }
    return false
  }

  payload (token) {
    const payload = token.split('.')[1]

    return this.decode(payload)
  }

  decode (payload) {
    return JSON.parse(atob(payload))
  }
}

export default new Token()
