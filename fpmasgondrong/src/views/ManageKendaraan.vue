<template>
  <NavbarAdmin />
  <div>
    <h1>MANAGE KENDARAAN</h1>
    <table>
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Jenis</th>
          <th>Plat</th>
          <th>Harga</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="k in kendaraan" :key="k.id_kendaraan">
          <td>{{ k.tipe }}</td>
          <td>{{ k.jenis }}</td>
          <td>{{ k.plat_nomor }}</td>
          <td>{{ k.harga_perhari }}</td>
          <td>{{ k.status }}</td>
          <td>
            <button @click="hapusKendaraan(k.id_kendaraan)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';
import NavbarAdmin from '@/components/NavbarAdmin.vue';

export default {
  components: { NavbarAdmin },
  data() {
    return {
      kendaraan: []
    };
  },
  mounted() {
    this.ambilDataKendaraan();
  },
  methods: {
    ambilDataKendaraan() {
  axios.get('http://localhost/1/backend/index.php/api/kendaraan')
    .then(response => {
      this.kendaraan = response.data;
    })
    .catch(error => {
      console.error('Gagal mengambil data kendaraan:', error);
    });
    },
hapusKendaraan(id) {
  axios.delete(`http://localhost/1/backend/index.php/api/kendaraan/${id}`)
    .then(() => {
      this.kendaraan = this.kendaraan.filter(k => k.id_kendaraan !== id);
    })
    .catch(err => {
      console.error(err);
    });
}

  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
h1{
  text-align: center;
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
  background-color: #f7f9fb;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}
th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

th {
  background-color: #3498db;
  color: white;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f1f1f1;
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
</style>