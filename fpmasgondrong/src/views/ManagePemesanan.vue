<template>
  <div>
    <NavbarAdmin />
    <h1>MANAGE PEMESANAN</h1>
    <div class="card-container">
      <div v-for="item in pemesanan" :key="item.id_pemesanan" class="card">
        <p><strong>Nama:</strong> {{ item.nama_user }}</p>
        <p><strong>Kendaraan:</strong> {{ item.nama_kendaraan }}</p>
        <p><strong>Tanggal:</strong> {{ item.tgl_mulai }} - {{ item.tgl_selesai }}</p>
        <p><strong>Status:</strong> {{ item.status }}</p>
 <select v-model="item.status" @change="updateStatus(item.id_pemesanan, item.status)">
  <option value="diproses">Diproses</option>
  <option value="selesai">Selesai</option>
  <option value="batal">Batal</option>
</select>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import NavbarAdmin from '@/components/NavbarAdmin.vue';

export default {
  components: {
    NavbarAdmin
  },
  data() {
    return {
      pemesanan: []
    }
  },
  mounted() {
    axios.get('http://localhost/1/backend/index.php/api/pemesanan')
      .then(res => {
        this.pemesanan = res.data;
      })
      .catch(err => {
        console.error('Gagal memuat data pemesanan:', err);
      });
  },
  methods: {
updateStatus(id_pemesanan, status) {
  axios.post(`http://localhost/1/backend/index.php/pemesanan/update_status`, {
    id_pemesanan,
    status
  }).then(() => {
    alert('Status diperbarui!');
  }).catch(err => {
    console.error('Gagal memperbarui status:', err);
  });
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

.card-container {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  padding: 0 20px 20px;
}

.card {
  background-color: #ffffff;
  border: 1px solid #ccc;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
}
</style>
