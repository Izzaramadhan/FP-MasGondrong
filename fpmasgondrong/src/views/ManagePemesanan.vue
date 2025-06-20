<template>
  <div>
    <NavbarAdmin />
    <h1>MANAGE PEMESANAN</h1>

    <!-- Filter Status -->
    <div class="filter-container">
      <button
        v-for="status in ['semua', 'diproses', 'selesai', 'batal']"
        :key="status"
        :class="['filter-button', filterStatus === status ? 'active' : '']"
        @click="filterStatus = status"
      >
        {{ status.toUpperCase() }}
      </button>
    </div>

<div class="tabel-container">
  <table class="styled-table">
    <thead>
      <tr>
        <th>Nama User</th>
        <th>Kendaraan</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Ubah Status</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in pemesananTersaring" :key="item.id_pemesanan">
        <td>{{ item.nama_user }}</td>
        <td>{{ item.nama_kendaraan }}</td>
        <td>{{ item.tgl_mulai }} - {{ item.tgl_selesai }}</td>
        <td>{{ item.status }}</td>
        <td>
          <select v-model="item.status" @change="updateStatus(item.id_pemesanan, item.status)">
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="batal">Batal</option>
          </select>
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
      pemesanan: [],
      filterStatus: 'semua'
    };
  },
  computed: {
    pemesananTersaring() {
      if (this.filterStatus === 'semua') {
        return this.pemesanan;
      }
      return this.pemesanan.filter(p => p.status === this.filterStatus);
    }
  },
  mounted() {
    axios.get('http://localhost/2/backend/index.php/api/pemesanan')
      .then(res => {
        this.pemesanan = res.data;
      })
      .catch(err => {
        console.error('Gagal memuat data pemesanan:', err);
      });
  },
  methods: {
    updateStatus(id_pemesanan, status) {
 axios.post("http://localhost/2/backend/index.php/api/pemesanan/update_status", {
  id_pemesanan,
  status
}).then(() => {
    alert('Status diperbarui!');
  }).catch(err => {
    console.error('Gagal memperbarui status:', err);
  });
}

  }
};
</script>

<style scoped>
h1 {
  text-align: center;
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 20px;
  background-color: #f7f9fb;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.filter-container {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.filter-button {
  background-color: #ecf0f1;
  color: #2c3e50;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: bold;
  text-transform: uppercase;
}

.filter-button:hover {
  background-color: #dcdde1;
}

.filter-button.active {
  background-color: #3498db;
  color: white;
}

/* Bungkus tabel agar body scrollable */
.tabel-container {
  max-height: 400px;
  overflow-y: auto;
  border: 1px solid #ccc;
  margin-top: 20px;
}

/* Table tetap rapi */
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
  z-index: 2;
  padding: 10px;
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

.styled-table tbody tr:hover td {
  background-color: #f1f1f1;
}

select {
  padding: 6px 12px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

</style>
