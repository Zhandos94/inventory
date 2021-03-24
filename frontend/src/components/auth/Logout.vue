<template>
  <div></div>
</template>

<script>
import AppStorage from '../../helpers/AppStorage'

export default {
  created () {
    const token = AppStorage.getToken()

    this.axios.post('http://localhost:8000/api/auth/logout', null, {
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      }
    })
      .finally(() => {
        this.$store.dispatch('clearLogin', { login: false })

        this.$router.push({ name: 'login' })
        this.disabledBtn = false
      })
  }
}

</script>
