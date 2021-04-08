<template>
  <v-container>
    <v-layout row>
      <v-flex>
        <h1>Employee</h1>
        <div class="d-flex flex-row-reverse mb-5">
          <router-link to="/employee/create" tag="span" class="pointer float-right v-btn v-btn--is-elevated  v-size--default success">Create</router-link>
        </div>
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
    getAllEmployee () {
      this.loading = true
      this.axios.get('http://localhost:8000/api/employee', {
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${token}`
        },
        params: {
          page: this.options.page,
          perPage: this.options.itemsPerPage,
          sortBy: this.options.sortBy
        }
      })
        .then(({ data }) => {
          console.info(data)
          this.loading = false
          this.pagination.total = data.total
          this.pagination.itemsPerPage = data.per_page
          this.data = data.data
        })
    }
  }
}
</script>

<style scoped>

</style>
