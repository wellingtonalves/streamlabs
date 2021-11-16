<template>
  <div id="login">
    <v-progress-linear
        :active="loading"
        :indeterminate="loading"
        absolute
        bottom
        color="deep-purple accent-4"
    ></v-progress-linear>

    <v-btn
        width="300"
        :loading="loading"
        :disabled="loading"
        class="ma-2 white--text"
        @click="goToAuth"
    >
      SIGN IN WITH TWITCH.TV
      <v-icon
          right
          dark
      >
        mdi-twitch
      </v-icon>
    </v-btn>
  </div>
</template>

<script>
import {mapActions} from 'vuex';

export default {
  name: "Login",
  data() {
    return {
      loading: false
    }
  },
  mounted() {
    const token = this.$route.query.token;
    if (token) {
      this.loading = true
      this.login(token).then(() => {
        this.$router.push('home')
      })
    }
  },
  methods: {
    ...mapActions('auth', ['login']),
    goToAuth() {
      window.location.href = '/auth/redirect'
    }
  }
}
</script>

<style scoped>
#login {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>