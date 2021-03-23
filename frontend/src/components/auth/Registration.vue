<template>
  <v-container
    class="fill-height"
    fluid
  >
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Registration form</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form" v-model="valid" validation>
                <v-text-field
                  label="User name"
                  name="name"
                  prepend-icon="mdi-account"
                  type="text"
                  v-model="form.name"
                  :rules="rules.userNameRules"
                  :error-messages="errors.name ? errors.name : null"
                ></v-text-field>

              <v-text-field
                label="Email"
                name="email"
                prepend-icon="mdi-account"
                type="text"
                v-model="form.email"
                :rules="rules.emailRules"
                :error-messages="errors.email ? errors.email : null"
              ></v-text-field>

              <v-text-field
                id="password"
                label="Password"
                name="password"
                prepend-icon="mdi-lock"
                type="password"
                :counter="8"
                v-model="form.password"
                :rules="rules.passwordRules"
                :error-messages="errors.password ? errors.password : null"
              ></v-text-field>

                <v-text-field
                id="confirmPassword"
                label="Confirm password"
                name="confirmPassword"
                prepend-icon="mdi-lock"
                type="password"
                :counter="8"
                v-model="form.password_confirmation"
                :rules="rules.confirmPasswordRules"
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="onSubmit" :disabled="!valid && disabledBtn">Registration</v-btn>
          </v-card-actions>
        </v-card>

      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import User from '@/helpers/User'

export default {
  name: 'Registration',
  data () {
    return {
      valid: false,
      disabledBtn: true,
      errors: {},
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      rules: {
        userNameRules: [
          v => !!v || 'User name is required',
          v => (v && v.length <= 25) || 'User name not more than 25 characters'
        ],
        emailRules: [
          v => !!v || 'E-mail is required',
          v => /.+@.+\..+/.test(v) || 'Is not t valid e-mail'
        ],
        passwordRules: [
          v => !!v || 'Password is required',
          v => (v && v.length >= 8) || 'Password must be equal or more than 6 characters'
        ],
        confirmPasswordRules: [
          v => !!v || 'Confirm password is required',
          v => (v === this.form.password) || 'Confirm password should be match '
        ]
      }
    }
  },
  methods: {
    onSubmit () {
      if (this.$refs.form.validate()) {
        this.disabledBtn = true

        this.axios.post('http://localhost:8000/api/auth/register', this.form)
          .then(res => {
            this.valid = true
            User.responseAfterLogin(res)
            this.$router.push({ name: 'login' })
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
