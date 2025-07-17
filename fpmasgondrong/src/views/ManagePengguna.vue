<template>
  <AdminLayout>
    <template #header></template>
    <h1 class="text-center my-4 judul-kelola">Kelola Pengguna</h1>

    <!-- Statistik Ringkasan -->
    <div class="row mb-4 text-center">
      <div class="col-md-3" v-for="item in summaryCards" :key="item.title">
        <div class="card shadow-sm p-3">
          <h6>{{ item.title }}</h6>
          <h4 class="text-primary">{{ item.value }}</h4>
        </div>
      </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="container">
      <div class="card shadow-sm">
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead class="bg-light text-secondary text-uppercase small">
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in pengguna" :key="u.id_user">
                <td>{{ u.nama }}</td>
                <td>{{ u.email }}</td>
                <td>{{ u.no_hp }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-outline-danger" @click="hapusPengguna(u.id_user)">
                    <i class="fas fa-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              <tr v-if="pengguna.length === 0">
                <td colspan="4" class="text-center text-muted py-3">Data pengguna tidak tersedia</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import api from '@/api';
import AdminLayout from '@/components/AdminLayout.vue';

export default {
  components: { AdminLayout },
  data() {
    return {
      pengguna: [],
      summaryCards: []
    };
  },
  mounted() {
    this.getPengguna();
  },
  methods: {
    getPengguna() {
      api.get('pengguna')
        .then(response => {
          this.pengguna = response.data;
          this.summaryCards = [
            { title: 'Total Pengguna', value: this.pengguna.length }
          ];
        })
        .catch(error => {
          console.error('Gagal mengambil data pengguna:', error);
        });
    },
    hapusPengguna(id) {
      if (confirm('Yakin ingin menghapus pengguna ini?')) {
        api.get(`pengguna/delete/${id}`)
          .then(res => {
            if (res.data.success) {
              this.getPengguna();
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

.card {
  max-width: 1500px;
  margin-bottom: 20px;
}
</style>
