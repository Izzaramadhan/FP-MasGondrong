<template>
  <NavbarAdmin />
  <div class="dashboard">
    <h1>Dashboard Admin</h1>
    <div class="dashboard-links">
      <router-link to="/admin/pemesanan">Kelola Pemesanan</router-link>
      <router-link to="/admin/pembayaran">Kelola Pembayaran</router-link>
      <router-link to="/admin/kendaraan">Kelola Kendaraan</router-link>
      <router-link to="/admin/pengguna">Kelola Pengguna</router-link>
    </div>
  </div>
</template>

<script>
import NavbarAdmin from '@/components/NavbarAdmin.vue';

export default {
  name: 'DashboardAdmin',
  components: {
    NavbarAdmin
  }
}
</script>
<style scoped>
.dashboard {
  text-align: center;
  background-color: #f7f9fb;
  padding: 40px 20px;
}

.dashboard h1 {
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
}

.dashboard-links {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
}

.dashboard-links a {
  text-decoration: none;
  background-color: #3498db;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  transition: all 0.3s ease;
  font-weight: bold;
}

.dashboard-links a:hover {
  background-color: #2980b9;
  transform: scale(1.05);
}
</style>
