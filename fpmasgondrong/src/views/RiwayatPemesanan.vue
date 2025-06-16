<template>
  <div class="container my-5">
    <h2 class="text-center mb-4"><span style="color: #1E73BE;">RIWAYAT PEMESANAN</span></h2>

    <div v-for="item in pemesanan" :key="item.id_pemesanan" class="card mb-4 p-3">
      <p><strong>ID Pemesanan:</strong> {{ item.id_pemesanan }}</p>
      <p><strong>Tanggal:</strong> {{ formatTanggal(item.tgl_mulai) }}</p>
      <p><strong>Kendaraan:</strong> {{ item.kendaraan }}</p>
      <p><strong>Total Harga:</strong> Rp {{ item.total_harga }}</p>
      <p><strong>Status:</strong> {{ item.status }}</p>
    </div>

    <router-link to="/" class="btn btn-warning mt-3">Kembali ke halaman utama</router-link>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RiwayatPemesanan',
  data() {
    return {
      pemesanan: []
    }
  },
  methods: {
    async fetchPemesanan() {
      const id_user = localStorage.getItem('id_user') // pastikan sudah login
      try {
        const res = await axios.get(`http://localhost/1/backend/index.php/api/pemesanan/riwayat/${id_user}`)
        this.pemesanan = res.data.data
      } catch (err) {
        console.error(err)
      }
    },
    formatTanggal(tgl) {
      return new Date(tgl).toLocaleString('id-ID')
    }
  },
  mounted() {
    this.fetchPemesanan()
  }
}
</script>

<style scoped>

</style>
