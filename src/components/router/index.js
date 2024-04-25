import { createRouter, createWebHistory } from 'vue-router'
import vOrders from '../views/vOrders.vue'
import vOrderEdit from '../views/vOrderEdit.vue'
import vOrder from '../views/vOrder.vue'
import vOrganization from '../views/vOrganization.vue'
import vAddMember from '../views/vAddMember.vue'
import vShiftCalendar from '../views/vShiftCalendar.vue'
import vAuditLog from '../views/vAuditLog.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'orders',
      component: vOrders,
    },
    {
      path: '/order/edit',
      name: 'addorder',
      component: vOrderEdit,
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
    },
    {
      path: '/auditlog',
      name: 'auditlog',
      component: vAuditLog,
    },
  ]
})

export default router
