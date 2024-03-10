import { createRouter, createWebHistory } from 'vue-router'
import vOrders from '../views/vOrders.vue'
import vAddOrder from '../views/vAddOrder.vue'
import vOrder from '../views/vOrder.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'orders',
      component: vOrders,
    },
    {
      path: '/addorder',
      name: 'addorder',
      component: vAddOrder,
    },
    {
      path: '/orders/:number',
      name: 'order',
      component: vOrder,
    },
  ]
})

export default router
