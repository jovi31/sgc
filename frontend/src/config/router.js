import Vue from 'vue'
import VueRouter from 'vue-router'

import Index from '../components/Index'
import Page404 from '../components/Page404'
import Home from '../components/Home'
import AdminPages from '../components/admin/AdminPages'
import ArticlesByCategory from '../components/article/ArticlesByCategory'
import ArticleById from '../components/article/ArticleById'
import Auth from '../components/Auth'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    component: Index,
    children: [
      {
        name: 'Home',
        path: '',
        component: Home
      },
      {
        name: 'AdminPages',
        path: '/admin',
        component: AdminPages
      },
      {
        name: 'ArticlesByCategory',
        path: '/categories/:id/articles',
        component: ArticlesByCategory
      },
      {
        name: 'ArticleById',
        path: '/articles/:id',
        component: ArticleById
      }
    ]
  },
  {
    name: 'Auth',
    path: '/auth',
    component: Auth
  },
  {
    path: '*',
    component: Page404
  }
]

export default new VueRouter({
  mode: 'history',
  routes
})
