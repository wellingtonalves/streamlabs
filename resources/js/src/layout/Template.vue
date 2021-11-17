<template>
  <v-app>
    <div id="template">
      <div class="header">
        <img src="../../../assets/images/logo.png" class="logo" alt="Logo Twitch">
        <v-spacer/>
        <v-menu offset-y>
          <template v-slot:activator="{ on, attrs }">
            <v-avatar>
              <img
                  :src="user.image"
                  :alt="user.name"
                  v-bind="attrs"
                  v-on="on"
              >
            </v-avatar>
          </template>
          <v-list dense>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>{{ user.name }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title @click="logoff">Logout</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
      <div class="content">
        <router-view/>
      </div>
    </div>
  </v-app>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';

export default {
  name: "Template",
  computed: {
    ...mapGetters('auth', ['user'])
  },
  methods:{
    ...mapActions('auth', ['logout']),
    logoff(){
      this.logout(this)
    }
  }
}
</script>

<style scoped>

</style>