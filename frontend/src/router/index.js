import { createRouter, createWebHistory } from 'vue-router'
import ProductList from '@/views/ProductList.vue'
import OrderList from '@/views/OrderList.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'All Products',
      component: ProductList
    },
    {
      path: '/orders', // Add the new route
      name: 'Orders',
      component: OrderList
    }
  ]
})

export default router
