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
    ></v-data-table>
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
  name: "HighestComponent",
  data() {
    return {
      loading: true,
      data: {},
      page: 1,
      headers: [
        {text: 'Game', value: 'game_name', sortable: false},
        {text: 'Viewer count', value: 'viewer_count', sortable: false},
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
    ...mapActions('stream', ['getHighest']),
    streamService(type = 'database') {
      this.loading = true
      this.getHighest({type, page: this.page}).then(response => {
        this.data = response.data
      }).finally(() => {
        this.loading = false
      })
    },
  }
}
</script>

<style scoped>

</style>