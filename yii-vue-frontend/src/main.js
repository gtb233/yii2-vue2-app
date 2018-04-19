// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

import http from './services/http.js'

import iview from 'iview'
import 'iview/dist/styles/iview.css'
import 'bootstrap/dist/css/bootstrap.css'

import layer from 'vue-layer-mobile'
import 'vue-layer-mobile/need/layer.css'

Vue.config.productionTip = false

Vue.prototype.$http = http
Vue.use(iview)
Vue.use(layer)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
