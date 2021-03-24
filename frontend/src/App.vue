<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app temporary v-if="authorised">

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

    <v-app-bar app color="indigo" dark v-if="authorised">
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
      <router-link to="/logout" tag="span" class="pointer" :disabled="disabledBtn" v-if="authorised">Logout</router-link>
    </v-app-bar>

    <v-content>

        <router-view></router-view>

    </v-content>

    <v-footer color="indigo" app v-if="authorised">
      <span class="white--text">&copy; 2020</span>
    </v-footer>
  </v-app>
</template>

<script>
import User from './helpers/User'

export default {
  name: 'App',
  props: {
    source: String
  },
  components: {},
  computed: {
    authorised () {
      let userAuthorised = false

      if (User.loggedIn()) {
        userAuthorised = this.$store.dispatch('setLogin', true)
      }
      return userAuthorised
    }
  },
  watch: {
    authorised () {
      return this.$store.state.authorise.userAuthorised
    }
  },
  data: () => ({
    drawer: null,
    disabledBtn: false,
    links: [
      { title: 'Login', icon: 'key', url: '/login' },
      { title: 'Registration', icon: 'mdi-email', url: '/registration' },
      { title: 'Orders', icon: 'mdi-email', url: '/orders' },
      { title: 'Add', icon: 'mdi-email', url: '/list' }
    ]
  })
}
</script>

<style scoped>
  .pointer {
    cursor: pointer;
  }
</style>
