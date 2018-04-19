<template>
  <div class="container">
    <h1>Home Page</h1>
    <router-link :to="{name: 'Login'}">Login</router-link>
    <br/>
    <button v-if="msg.length > 0 " @click="logout()">Logout</button>
  </div> <!-- /container -->
</template>

<script>
import auth from '../services/auth'

export default {
  name: 'home',
  components: {

  },
  data () {
    return {
      msg: ''
    }
  },
  created() {
    this.$http.fetch('/item').then((res) => {
      this.msg = res.data.msg
    })
  },
  methods: {
    logout() {
      auth.logout()
      this.$router.push({name:'Login'})
    }
  }
}
</script>

<style>

</style>
