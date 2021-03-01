<template>
  <v-container
    class="fill-height"
    fluid
  >
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Login form</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form" v-model="valid" validation>
              <v-text-field
                label="Email"
                name="email"
                prepend-icon="mdi-account"
                type="text"
                v-model="form.email"
                :rules="emailRules"
              ></v-text-field>

              <v-text-field
                id="password"
                label="Password"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
                :counter="8"
                v-model="form.password"
                :rules="passwordRules"
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn block color="primary" @click="onSubmit" :disabled="!valid">Login</v-btn>
          </v-card-actions>

          <br>
          <v-row justify="center">
            <router-link to="registration">Create account</router-link>
          </v-row>
          <v-row justify="center">
            <router-link to="forget-password">Forget password</router-link>
          </v-row>
          <br>
        </v-card>

      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import User from '../../helpers/User'

export default {
  name: 'Login',
  created () {
    if (User.loggedIn()) {
      this.$router.push({ name: 'home' })
    }
  },
  data () {
    return {
      form: {
        email: '',
        password: ''
      },
      valid: false,
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'Is not t valid e-mail'
      ],
      passwordRules: [
        v => !!v || 'Password is required',
        v => (v && v.length >= 8) || 'Password must be equal or more than 6 characters'
      ]
    }
  },
  methods: {
    onSubmit () {
      console.info('main')
      console.log(this.axios)
      if (this.$refs.form.validate()) {
        this.axios.post('http://localhost:8000/api/auth/login', this.form)
          .then(res => {
            User.responseAfterLogin(res)
            this.$router.push({ name: 'home' })
          })
          .catch(error => console.error(error.response.data))
      }
    }
  }
}
</script>
