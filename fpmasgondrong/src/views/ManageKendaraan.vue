<template>
  <NavbarAdmin />
  <div>
    <h1>MANAGE KENDARAAN</h1>
    <button @click="$router.push('/admin/tambah-kendaraan')" class="btn-tambah">
  + Tambah Kendaraan
</button>

<div class="table-wrapper">
  <table class="styled-table">
    <thead>
      <tr>
        <th>Gambar</th>
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
        <td><img :src="getGambarUrl(k.gambar)" class="kendaraan-img" /></td>
        <td>{{ k.tipe }}</td>
        <td>{{ k.jenis }}</td>
        <td>{{ k.plat_nomor }}</td>
        <td>{{ k.harga_perhari }}</td>
        <td>{{ k.status }}</td>
        <td>
          <div class="aksi-container">
            <button class="btn-aksi" @click="hapusKendaraan(k.id_kendaraan)">Hapus</button>
            <button class="btn-aksi" @click="$router.push(`/admin/edit-kendaraan/${k.id_kendaraan}`)">Edit</button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

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
  axios.get('http://localhost/2/backend/index.php/api/kendaraan')
    .then(response => {
      this.kendaraan = response.data;
    })
    .catch(error => {
      console.error('Gagal mengambil data kendaraan:', error);
    });
    },
      getGambarUrl(filename) {
    return `http://localhost/2/backend/assets/vue/img/kendaraan/${filename}`;
  },
hapusKendaraan(id) {
  if (confirm("Apakah kamu yakin ingin menghapus kendaraan ini?")) {
    axios.post('http://localhost/2/backend/index.php/api/kendaraan/delete', { id })
      .then(() => {
        this.kendaraan = this.kendaraan.filter(k => k.id_kendaraan !== id);
      })
      .catch(err => {
        console.error('Gagal menghapus kendaraan:', err);
      });
  }
}


  }
};
</script>

<style scoped>
/* Bungkus tabel agar hanya bagian body yang scroll */
.table-wrapper {
  max-height: 400px;
  overflow-y: auto;
  border: 1px solid #ccc;
}

/* Tabel dengan layout stabil */
.styled-table {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

/* Header sticky */
.styled-table thead th {
  position: sticky;
  top: 0;
  background-color: #3498db;
  color: white;
  padding: 10px;
  text-align: center;
  z-index: 1;
  border: 1px solid #ddd;
}

/* Body tabel */
.styled-table tbody td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
  background-color: white;
}

.styled-table tbody tr:nth-child(even) td {
  background-color: #f9f9f9;
}

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

.btn-tambah {
  margin: 20px;
  padding: 10px 16px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-tambah:hover {
  background-color: #2980b9;
}

.aksi-container {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.btn-aksi {
  background-color: #3498db;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-aksi:hover {
  background-color: #2980b9;
}

.kendaraan-img {
  width: 100px;
  height: auto;
  object-fit: contain;
  border: 1px solid #ccc;
  border-radius: 6px;
  max-height: 80px;
}



</style>