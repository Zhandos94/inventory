<template>
  <v-container
    class="fill-height"
    fluid
  >
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Create employee</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form ref="form" v-model="valid" validation enctype="multipart/form-data">
              <v-text-field
                label="User name"
                name="name"
                prepend-icon="mdi-account"
                type="text"
                v-model="form.name"
                :rules="rules.nameRules"
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
                label="Phone"
                name="phone"
                prepend-icon="mdi-phone-dial"
                type="number"
                v-model="form.phone"
                :rules="rules.phoneRules"
                :error-messages="errors.phone ? errors.phone : null"
              ></v-text-field>

              <v-text-field
                label="Salary"
                name="salary"
                prepend-icon="mdi-currency-kzt"
                type="number"
                v-model="form.salary"
                :rules="rules.salaryRules"
                :error-messages="errors.salary ? errors.salary : null"
              ></v-text-field>

              <v-text-field
                label="Address"
                name="address"
                prepend-icon="mdi-map-marker"
                type="text"
                v-model="form.address"
                :rules="rules.addressRules"
                :error-messages="errors.address ? errors.address : null"
              ></v-text-field>

              <v-menu
                ref="dateMenu"
                v-model="dateMenu"
                :close-on-content-click="false"
                :return-value.sync="form.join_at"
                transition="scale-transition"
                offset-y
                min-width="auto"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    v-model="form.join_at"
                    label="Join date"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    :rules="rules.joinAtRules"
                    :error-messages="errors.join_at ? errors.join_at : null"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="form.join_at"
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="dateMenu = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.dateMenu.save(form.join_at)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>

<!--              <v-file-input-->
<!--                :rules="rules.imageRules"-->
<!--                accept="image/png, image/jpeg, image/bmp"-->
<!--                placeholder="Pick an avatar"-->
<!--                prepend-icon="mdi-camera"-->
<!--                @change="inputOnChange($event, this)"-->
<!--              >-->
<!--              </v-file-input>-->

              <div class="upload">
                <div class="d-flex align-center" style="height: 66px">
                  <input type="file" id="file" @change="inputOnChange($event)">
                  <img v-if="form.photo" :src="form.photo" alt="Avatar" style="height: 40px; width: auto">
                </div>
                <div class="v-messages theme--light error--text" role="alert">
                  <div class="v-messages__wrapper">
                    <div class="v-messages__message">{{photoError}}</div>
                  </div>
                </div>
              </div>

            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="onSubmit" :disabled="!valid && disabledBtn">Create</v-btn>
          </v-card-actions>
        </v-card>

      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import AppStorage from '../../helpers/AppStorage'

export default {
  name: 'Registration',
  data () {
    return {
      dateMenu: false,
      valid: false,
      disabledBtn: true,
      errors: { photo: null },
      form: {
        name: null,
        email: null,
        phone: null,
        salary: null,
        address: null,
        join_at: null,
        photo: null
      },
      rules: {
        nameRules: [
          v => !!v || 'User name is required'
        ],
        emailRules: [
          v => !!v || 'E-mail is required',
          v => /.+@.+\..+/.test(v) || 'Is not t valid e-mail'
        ],
        joinAtRules: [
          v => !!v || 'Join date is required'
        ],
        phoneRules: [
          v => !!v || 'Phone number is required'
          // v => /'(71|72|74|76|81|82|84|85|86|87|88|89)\\d{5}$/ || 'Phone number is not valid'
        ],
        addressRules: [
          v => (v && v.length <= 255) || 'Address not more than 2555 characters'
        ],
        salaryRules: [
        ],
        imageRules: [
        ]
      }
    }
  },
  computed: {
    photoError () {
      return this.errors.photo
    }
  },
  methods: {
    inputOnChange (event) {
      const file = event.target.files[0]
      this.form.photo = null
      this.errors.photo = null

      if (file.type.match(/image/gi)) {
        const reader = new FileReader()

        reader.onload = event => {
          this.form.photo = event.target.result
        }
        reader.readAsDataURL(file)
      } else {
        this.errors.photo = 'This file type is not allowed'
      }
    },
    onSubmit () {
      if (this.$refs.form.validate()) {
        this.disabledBtn = true
        const token = AppStorage.getToken()

        this.axios.post('http://localhost:8000/api/employee', this.form, {
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${token}`
          }
        })
          .then(res => {
            this.form.photo = null
            this.$refs.form.reset()
            this.$refs.form.resetValidation()

            this.$toast.open({
              message: 'Employee successfully created!',
              position: 'top-right',
              type: 'success'
            })
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
