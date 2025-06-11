import { createRouter, createWebHistory } from 'vue-router'

import HomePage from '@/views/HomePage.vue'
import Kelompok from '@/views/Kelompok.vue'
import Login from '@/views/Login.vue'
import CaraSewa from '@/views/CaraSewa.vue'
import Register from '@/views/Register.vue'
import EditProfil from '@/views/EditProfil.vue'
import Pemesanan from '@/views/Pemesanan.vue'
import Pembayaran from '@/views/Pembayaran.vue'
import RiwayatPemesanan from '@/views/RiwayatPemesanan.vue'

const routes = [
  { path: '/', name: 'HomePage', component: HomePage },
  { path: '/kelompok', name: 'Kelompok', component: Kelompok },
  { path: '/login', name: 'Login', component: Login },
    { path: '/cara-sewa', name: 'CaraSewa', component: CaraSewa },
  { path: '/register', name: 'Register', component: Register },
  { path: '/edit-profil', name: 'EditProfil', component: EditProfil },
  { path: '/pemesanan', name: 'Pemesanan', component: Pemesanan },
   {
    path: '/pemesanan/:kendaraan',
    name: 'Pemesanan',
    component: () => import('@/views/Pemesanan.vue'),
    props: true 
  },
  { path: '/pembayaran', name: 'Pembayaran', component: Pembayaran },
  { path: '/riwayat', name: 'RiwayatPemesanan', component: RiwayatPemesanan }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router