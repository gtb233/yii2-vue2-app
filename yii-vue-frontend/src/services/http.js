import axios from 'axios'
import setting from '../config/setting'
import router from '../router/index'
import auth from './auth'

// axios 配置
axios.defaults.timeout = 3600
axios.defaults.baseURL = setting.remoteHost

// http request 拦截器
axios.interceptors.request.use(
  config => {
    if (auth.authenticated()) {
      let token = auth.getToken()

      // config.headers = {
      //   'Content-Type': 'application/json'
      // }
      config.headers.common['authorization'] = `bearer ${token}`
    }
    return config
  },
  err => {
    return Promise.reject(err)
  }
)

axios.interceptors.response.use(
  response => {
    return response
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 401:
          // 401清除TOKEN并跳转到登录
          auth.logout()
          router.replace({
            name: 'Login'
            // query: {redirect: router.currentRoute.fullPath}
          })
      }
    }
    console.log(error)
    return Promise.reject(error)
  }
)

export default {
  fetch (url, params) {
    return new Promise((resolve, reject) => {
      axios.post(url, params)
        .then(response => {
          resolve(response)
        })
        .catch((error) => {
          reject(error)
        })
    })
  }
}
