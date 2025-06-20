<template>
  <NavbarAdmin />
  <div>
    <h1>MANAGE PENGGUNA</h1>
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>No HP</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="u in pengguna" :key="u.id_user">
          <td>{{ u.nama }}</td>
          <td>{{ u.email }}</td>
          <td>{{ u.no_hp }}</td>
          <td>
            <button @click="hapusPengguna(u.id_user)">Hapus</button>
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
      pengguna: []
    };
  },
  mounted() {
    this.getPengguna();
  },
  methods: {
getPengguna() {
  axios.get('http://localhost/2/backend/index.php/api/pengguna')
    .then(response => {
      console.log('DATA PENGGUNA:', response.data); // lihat struktur di console
      this.pengguna = response.data;
    })
    .catch(error => {
      console.error('Gagal mengambil data pengguna:', error);
    });
}
,
    hapusPengguna(id) {
      if (confirm('Yakin ingin menghapus pengguna ini?')) {
        axios.get(`http://localhost/2/backend/index.php/api/pengguna/delete/${id}`)
          .then(res => {
            if (res.data.success) {
              this.getPengguna(); // refresh data
            } else {
              alert('Gagal menghapus pengguna');
            }
          })
          .catch(err => {
            console.error('Gagal menghapus:', err);
          });
      }
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