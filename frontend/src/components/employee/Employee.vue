<template>
  <v-container>
    <v-layout row>
      <v-flex>
        <h1>Employee</h1>
        <div class="mb-5">
          <v-text-field v-model="search.name" label="Name"></v-text-field>
          <v-text-field v-model="search.email" label="Email"></v-text-field>
          <div>
            <v-btn
              depressed
              color="primary"
              @click="searchFilter"
              :disabled="loading"
            >
              Search
            </v-btn>
          </div>
        </div>

        <div class="d-flex flex-row-reverse mb-5">
          <router-link to="/employee/create" tag="span" class="pointer float-right v-btn v-btn--is-elevated v-size--default success">Create</router-link>
        </div>
        .clear
        <v-data-table
          :headers="tableHeader"
          :items="data"
          :options.sync="options"
          :items-per-page="pagination.itemsPerPage"
          :server-items-length="pagination.total"
          :loading="loading"
          loading-text="Loading... Please wait"
          class="elevation-1"
        >
          <template v-slot:item.photo="{ item }">
            <v-img
              max-height="40"
              max-width="40"
              v-if="item.photo"
              :src="'http://localhost:8000/uploads' + item.photo">
            </v-img>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import AppStorage from '@/helpers/AppStorage'

const token = AppStorage.getToken()

export default {
  name: 'Employee',

  data () {
    return {
      loading: true,
      options: {},
      pagination: {
        itemsPerPage: 10,
        total: 0
      },
      data: [],
      search: {
        name: null,
        email: null
      },
      tableHeader: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Photo', value: 'photo' },
        { text: 'Join at', value: 'join_at' }
      ]
    }
  },
  watch: {
    options: {
      handler () {
        this.getAllEmployee()
      }
    }
  },
  methods: {
    searchFilter () {
      this.getAllEmployee()
    },
    getAllEmployee () {
      this.loading = true
      this.axios.get('http://localhost:8000/api/employee', {
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${token}`
        },
        params: {
          search: this.search,
          page: this.options.page,
          perPage: this.options.itemsPerPage,
          sortBy: this.options.sortBy,
          sortDesc: this.options.sortDesc
        }
      })
        .then(({ data }) => {
          this.loading = false
          this.pagination.total = data.total
          this.pagination.itemsPerPage = data.per_page.toInteger
          this.data = data.data
        })
    }
  }
}
</script>

<style scoped>

</style>
