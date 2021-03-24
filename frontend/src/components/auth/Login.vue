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
                :error-messages="errors.email ? errors.email : null"
              ></v-text-field>

              <v-text-field
                id="password"
                label="Password"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
                v-model="form.password"
                :rules="passwordRules"
                :error-messages="errors.password ? errors.password : null"
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn block color="primary" @click="onSubmit" :disabled="!valid && disabledBtn">Login</v-btn>
          </v-card-actions>

          <br>
          <v-row justify="center">
            <router-link to="registration">Registration</router-link>
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
      errors: {},
      valid: false,
      disabledBtn: true,
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'Is not t valid e-mail'
      ],
      passwordRules: [
        v => !!v || 'Password is required'
      ]
    }
  },
  methods: {
    onSubmit () {
      if (this.$refs.form.validate()) {
        this.disabledBtn = true

        this.axios.post('http://localhost:8000/api/auth/login', this.form)
          .then(res => {
            this.$store.dispatch('setLogin', { login: true })
            this.valid = true
            User.responseAfterLogin(res)
            this.$router.push({ name: 'home' })
          })
          .catch((error) => {
            this.errors = error.response.data.errors
          })
          .finally(() => {
            this.disabledBtn = false
          })
      }
    }
  }
}
</script>
