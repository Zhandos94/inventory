<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app temporary>

      <v-list dense>
        <v-list-item link v-for="link of links" :key="link.title" :to="link.url">
          <v-list-item-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ link.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

    </v-navigation-drawer>
    <v-app-bar app color="indigo" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>
        <router-link to="/" tag="span" class="pointer">Shop</router-link>
      </v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>

      <v-btn @click="logout" :disabled="disabledBtn" v-if="!login">
        Logout
      </v-btn>
    </v-app-bar>

    <v-content>

        <router-view></router-view>

    </v-content>
    <v-footer color="indigo" app>
      <span class="white--text">&copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
import AppStorage from './helpers/AppStorage'
import User from './helpers/User'

export default {
  name: 'App',
  props: {
    source: String
  },
  components: {},
  beforeCreate () {
    if (User.loggedIn()) {
      this.login = true
    }
  },
  data: () => ({
    login: false,
    drawer: null,
    disabledBtn: false,
    links: [
      { title: 'Login', icon: 'key', url: '/login' },
      { title: 'Registration', icon: 'mdi-email', url: '/registration' },
      { title: 'Orders', icon: 'mdi-email', url: '/orders' },
      { title: 'Add', icon: 'mdi-email', url: '/list' },
    ]
  }),
  methods: {
    logout () {
      this.disabledBtn = true
      const token = AppStorage.getToken()
      this.axios.post('http://localhost:8000/api/auth/logout', null, {
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${token}`
        }
      })
        .then(res => {
          if (res.status) {
            AppStorage.clear()
            this.$router.push({ name: 'login' })
          }
        })
        .catch((error) => {
          console.error(error)
        })
        .finally(() => {
          this.disabledBtn = false
        })
    }
  }
}
</script>

<style scoped>
  .pointer {
    cursor: pointer;
  }
</style>
