<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">
      <span style="color: #1E73BE;">RIWAYAT PEMESANAN</span>
    </h2>

 <div v-if="pemesanan.length === 0" class="text-center text-muted">
  Belum ada riwayat pemesanan.
</div>

<div v-else class="row">
  <div
    v-for="item in pemesanan"
    :key="item.id_pemesanan"
    class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"
  >

    <div class="card h-100 p-3">
      <p><strong>ID Pemesanan:</strong> {{ item.id_pemesanan }}</p>
      <p><strong>Tanggal Mulai:</strong> {{ formatTanggal(item.tgl_mulai) }}</p>
      <p><strong>Tanggal Selesai:</strong> {{ formatTanggal(item.tgl_selesai) }}</p>
      <p><strong>Kendaraan:</strong> {{ item.jenis }} - {{ item.tipe }} ({{ item.plat_nomor }})</p>
      <p><strong>Total Harga:</strong> Rp {{ formatHarga(item.total_harga) }}</p>
      <p><strong>Status:</strong> 
        <span :class="{
          'text-warning': item.status === 'diproses',
          'text-success': item.status === 'selesai',
          'text-danger': item.status === 'batal'
        }">{{ item.status }}</span>
      </p>
    </div>
  </div>
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
  const user = JSON.parse(localStorage.getItem('user'))
  const id_user = user ? user.id_user : null
  console.log("Dari localStorage: ", id_user)

  if (!id_user) {
    console.error("ID user tidak ditemukan!")
    return
  }

  try {
    const url = `http://localhost/2/backend/index.php/api/pemesanan/riwayat/${id_user}`
    console.log("URL yang dipanggil:", url)
    const res = await axios.get(url)
    console.log("Data diterima:", res.data)
    this.pemesanan = res.data.data
  } catch (err) {
    console.error('Gagal mengambil data pemesanan:', err)
  }
}

,
    formatTanggal(tanggal) {
      return new Date(tanggal).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    },
    formatHarga(harga) {
      return parseInt(harga).toLocaleString('id-ID')
    }
  },
  mounted() {
    this.fetchPemesanan();
    console.log("mounted: siap ambil data");
  }
}
</script>

<style scoped>
.card {
  background-color: #f8f9fa;
  border-left: 5px solid #1E73BE;
}
</style>
