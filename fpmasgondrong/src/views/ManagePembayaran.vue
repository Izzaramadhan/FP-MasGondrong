<template>
  <NavbarAdmin />
  <div>
    <h1>MANAGE PEMBAYARAN</h1>
    <div class="grid-container">
      <div v-for="p in pembayaran" :key="p.id" class="card">
        <!-- Tambahkan gambar bukti bayar -->
        <img :src="getGambarUrl(p.bukti_bayar)" alt="Bukti Pembayaran" class="bukti-img" />

        <p><strong>ID Pemesanan:</strong> {{ p.id_pemesanan }}</p>
        <p><strong>Tanggal Bayar:</strong> {{ p.tgl_bayar }}</p>
        <p><strong>Jumlah Bayar:</strong> Rp {{ p.jml_bayar.toLocaleString('id-ID') }}</p>
        <p><strong>Metode:</strong> {{ p.metode }}</p>
        <p><strong>Status:</strong> {{ p.status }}</p>

        <div class="btn-group">
          <button @click="ubahStatus(p.id, 'lunas')">Set Lunas</button>
          <button @click="ubahStatus(p.id, 'belum lunas')">Set Belum Lunas</button>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import axios from 'axios'
import NavbarAdmin from '@/components/NavbarAdmin.vue'

export default {
  components: { NavbarAdmin },
  data() {
    return {
      pembayaran: []
    }
  },
  mounted() {
    axios.get('http://localhost/2/backend/index.php/api/pembayaran')
      .then(res => {
        this.pembayaran = res.data
      })
      .catch(err => {
        console.error('Gagal mengambil data pembayaran:', err)
      })
  },
  methods: {
    ubahStatus(id, status) {
      const p = this.pembayaran.find(x => x.id === id)
      if (p) p.status = status
    },
    getGambarUrl(filename) {
      if (!filename) return ''
      return `http://localhost/2/backend/assets/vue/img/bukti_bayar/${filename}`
    }
  }
}
</script>

<style scoped>

h1 {
  text-align: center;
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
  background-color: #f7f9fb;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  padding: 20px;
}

.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  text-align: left;
}

.card p {
  margin: 6px 0;
}

.btn-group {
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

button {
  background-color: #3498db;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}
.bukti-img {
  width: 100%;
  max-height: 150px;
  object-fit: contain;
  border-radius: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
}

</style>