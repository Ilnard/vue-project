import { createRouter, createWebHistory } from 'vue-router'
import vOrders from '../views/vOrders.vue'
import vAddOrder from '../views/vAddOrder.vue'
import vOrder from '../views/vOrder.vue'
import vOrganization from '../views/vOrganization.vue'
import vAddMember from '../views/vAddMember.vue'
import vShiftCalendar from '../views/vShiftCalendar.vue'

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
    {
      path: '/organization',
      name: 'organization',
      component: vOrganization,
    },
    {
      path: '/addmember',
      name: 'addmember',
      component: vAddMember,
    },
    {
      path: '/shiftcalendar',
      name: 'shiftcalendar',
      component: vShiftCalendar,
    }
    
  ]
})

export default router
