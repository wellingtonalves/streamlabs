<template>
  <div>
    <v-skeleton-loader
        v-if="loading"
        v-bind="attrs"
        type="table-heading, list-item-two-line, list-item-two-line"
    ></v-skeleton-loader>
    <v-data-table
        v-if="!loading"
        :headers="headers"
        :items="data.data"
        class="elevation-1"
        hide-default-footer
        hide-default-header
    >
      <template #header="{ props: { headers } }">
        <thead class="v-data-table-header">
        <tr>
          <th
              v-for="header in headers"
              :key="data.value"
              class="text-uppercase"
              scope="col"
          >
            {{ header.text }}
            <template v-if="header.sort">
              <v-icon small @click="sortTop()" v-if="topSortDesc">mdi-arrow-up</v-icon>
              <v-icon small @click="sortTop()" v-if="!topSortDesc">mdi-arrow-down</v-icon>
            </template>
          </th>
        </tr>
        </thead>
      </template>
    </v-data-table>
    <v-pagination
        :total-visible="5"
        v-model="page"
        :length="data.last_page"
        prev-icon="mdi-menu-left"
        next-icon="mdi-menu-right"
    ></v-pagination>
  </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
  name: "TopComponent",
  data() {
    return {
      loading: true,
      data: {},
      page: 1,
      topSortDesc: true,
      headers: [
        {text: 'Title', value: 'title', sortable: false},
        {text: 'Game', value: 'game_name', sortable: false},
        {text: 'viewer count', value: 'viewer_count', sortable: false, sort: true},
      ],
      attrs: {
        class: 'mb-6',
        boilerplate: true,
        elevation: 2,
      },
    }
  },
  created() {
    this.streamService()
  },
  watch: {
    page() {
      this.streamService('array')
    },
  },
  methods: {
    ...mapActions('stream', ['getTop']),
    streamService(type = 'database', sort = 'desc') {
      this.loading = true
      this.getTop({type, page: this.page, sort: sort}).then(response => {
        this.data = response.data
      }).finally(() => {
        this.loading = false
      })
    },
    sortTop() {
      const sort = this.topSortDesc ? 'asc' : 'desc';
      this.streamService('array', sort)
      this.topSortDesc = !this.topSortDesc
    },
  }
}
</script>

<style scoped>

</style>