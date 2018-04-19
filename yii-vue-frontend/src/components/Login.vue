<template>
  <div class="container">
    <form class="form-signin">
      <h2 class="form-signin-heading">Please sign in</h2>
      <label for="inputEmail" class="sr-only">Email地址：</label>
      <input type="email" v-model="formInline.user" id="inputEmail" class="form-control" placeholder="Email address" required autofocus />
      <label for="inputPassword" class="sr-only">密码：</label>
      <input type="password" v-model="formInline.password" id="inputPassword" class="form-control" placeholder="Password" required>
      <button class="btn btn-lg btn-primary btn-block" @click.self.prevent="handleSubmit()">登录</button>
    </form>
  </div> <!-- /container -->
</template>

<script>
import Auth from '../services/auth'

export default {
  name: 'Login',
  data () {
    return {
      formInline: {
        user: '',
        password: ''
      }
    }
  },
  methods: {
    handleSubmit () {
      let obj = {
        name: this.formInline.user,
        password: this.formInline.password
      }
      if (this.formInline.user.length === 0 || this.formInline.password.length === 0) {
        this.errorOpenFunc('用户名与密码不能为空！')
        return false
      }
      this.$http.fetch('/auth/index', obj)
        .then((res) => {
          console.log(res)
          if (res.data.success) {
            Auth.login(res.data.msg)
            this.$router.push({path: '/'})
          } else {
            this.errorOpenFunc(res.data.msg)
          }
        }, (err) => {
          this.errorOpenFunc('请求错误！')
        })
    },
    // 普通提示
    errorOpenFunc: function (content) {
      this.$layer.open({
        content: content,
        skin: 'msg',
        time: 3000
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
