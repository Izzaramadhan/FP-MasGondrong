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
import AdminLogin from '@/views/AdminLogin.vue'
import Dashboard from '@/views/Dashboard.vue';
import ManagePemesanan from '@/views/ManagePemesanan.vue';
import ManagePembayaran from '@/views/ManagePembayaran.vue';
import ManageKendaraan from '@/views/ManageKendaraan.vue';
import ManagePengguna from '@/views/ManagePengguna.vue';

const routes = [
  { path: '/', name: 'HomePage', component: HomePage, meta: { showHeader: true } },
  { path: '/kelompok', name: 'Kelompok', component: Kelompok, meta: { showHeader: true } },
  { path: '/login', name: 'Login', component: Login, meta: { showHeader: false } },
  { path: '/cara-sewa', name: 'CaraSewa', component: CaraSewa, meta: { showHeader: true } },
  { path: '/register', name: 'Register', component: Register, meta: { showHeader: false } },
  { path: '/edit-profil', name: 'EditProfil', component: EditProfil, meta: { showHeader: true } },
  { path: '/pemesanan', name: 'Pemesanan', component: Pemesanan, meta: { showHeader: true } },
  {
    path: '/pemesanan/:kendaraan',
    name: 'PemesananKendaraan',
    component: () => import('@/views/Pemesanan.vue'),
    props: true,
    meta: { showHeader: true }
  },
  {
    path: '/pemesanan/:id_kendaraan',
    name: 'Pemesanan',
    component: () => import('@/views/Pemesanan.vue')
  }
,  
  { path: '/pembayaran', name: 'Pembayaran', component: Pembayaran, meta: { showHeader: true } },
  { path: '/riwayat', name: 'RiwayatPemesanan', component: RiwayatPemesanan, meta: { showHeader: true } },

  // Admin routes - header tidak ditampilkan
  { path: '/adminlogin', name: 'AdminLogin', component: AdminLogin, meta: { showHeader: false } },
  { path: '/admin/dashboard', name: 'Dashboard', component: Dashboard, meta: { showHeader: false } },
  { path: '/admin/pemesanan', name: 'ManagePemesanan', component: ManagePemesanan, meta: { showHeader: false } },
  { path: '/admin/pembayaran', name: 'ManagePembayaran', component: ManagePembayaran, meta: { showHeader: false } },
  { path: '/admin/kendaraan', name: 'ManageKendaraan', component: ManageKendaraan, meta: { showHeader: false } },
  { path: '/admin/pengguna', name: 'ManagePengguna', component: ManagePengguna, meta: { showHeader: false } },
  {path: '/admin/tambah-kendaraan',name: 'TambahKendaraan',component: () => import('@/views/TambahKendaraan.vue')},
  {path: '/admin/edit-kendaraan/:id',name: 'EditKendaraan', component: () => import('@/views/EditKendaraan.vue')},
  {
    path: '/admin/kendaraan',
    name: 'Kendaraan',
    component: () => import('@/views/ManageKendaraan.vue')
  }
  
  
]


const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router