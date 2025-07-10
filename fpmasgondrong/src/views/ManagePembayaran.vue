<template>
  <AdminLayout>
    <template #header></template>
    <h1 class="text-center my-4 judul-kelola">Kelola Pembayaran</h1>

    <!-- Grafik -->
    <div class="container mb-5">
      <div class="row">
        <div class="col-md-6 mb-4">
          <h5 class="text-center">Status Pembayaran</h5>
          <div class="chart-wrapper">
          <DoughnutChart v-if="statusChartData" :data="statusChartData" :options="chartOptions" class="chart-container" />
        </div>
        </div>
        <div class="col-md-6 mb-4">
          <h5 class="text-center">Jumlah Pembayaran per Metode</h5>
          <div class="chart-wrapper mt-4">
          <BarChart v-if="metodeChartData" :data="metodeChartData" :options="chartOptions" class="chart-container" />
        </div>
        </div>
      </div>
    </div>

    <!-- Tabel -->
    <div class="container">
      <div class="card shadow-sm w-100">
        <div class="card-header border-bottom-0">
          <h3 class="card-title"><i class="fas fa-credit-card me-2"></i>Daftar Pembayaran</h3>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover align-middle">
            <thead class="bg-light text-secondary text-uppercase small">
              <tr>
                <th>Bukti</th>
                <th>ID Pemesanan</th>
                <th>Tgl Bayar</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Ubah Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="p in pembayaran" :key="p.id_pembayaran">
                <td>
                  <img :src="getGambarUrl(p.bukti_bayar, p.metode)" class="bukti-img" alt="bukti" />
                </td>
                <td>{{ p.id_pemesanan }}</td>
                <td>{{ p.tgl_bayar }}</td>
                <td>Rp {{ p.jml_bayar.toLocaleString('id-ID') }}</td>
                <td>{{ p.metode }}</td>
                <td>
                  <span class="badge rounded-pill"
                        :class="{
                          'bg-success': p.status === 'lunas',
                          'bg-danger': p.status === 'belum lunas'
                        }">
                    {{ p.status }}
                  </span>
                </td>
                <td>
                  <select v-model="p.status" class="form-select form-select-sm"
                          @change="ubahStatus(p.id_pembayaran, p.status)">
                    <option value="lunas">Lunas</option>
                    <option value="belum lunas">Belum Lunas</option>
                  </select>
                </td>
              </tr>
              <tr v-if="pembayaran.length === 0">
                <td colspan="7" class="text-center text-muted py-3">Data pembayaran tidak tersedia</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import axios from 'axios';
import AdminLayout from '@/components/AdminLayout.vue';
import { Doughnut, Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, ArcElement, BarElement, CategoryScale, LinearScale);

export default {
  components: {
    AdminLayout,
    DoughnutChart: Doughnut,
    BarChart: Bar
  },
  data() {
    return {
      pembayaran: [],
      statusChartData: null,
      metodeChartData: null,
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    };
  },
  mounted() {
    this.ambilDataPembayaran();
  },
  methods: {
    ambilDataPembayaran() {
      axios.get('http://localhost/2/backend/index.php/api/pembayaran')
        .then(res => {
          this.pembayaran = res.data;
          this.generateCharts();
        })
        .catch(err => {
          console.error('Gagal mengambil data pembayaran:', err);
        });
    },
    ubahStatus(id_pembayaran, status) {
      axios.post('http://localhost/2/backend/index.php/api/pembayaran/update_status', {
        id_pembayaran,
        status
      })
      .then(res => {
        if (res.data.success) {
          const pembayaran = this.pembayaran.find(p => p.id_pembayaran === id_pembayaran);
          if (pembayaran) pembayaran.status = status;
          alert('Status berhasil diperbarui!');
          this.generateCharts();
        } else {
          alert('Gagal: ' + res.data.message);
        }
      })
      .catch(err => {
        console.error('Gagal mengirim request:', err);
        alert('Terjadi kesalahan jaringan.');
      });
    },
    getGambarUrl(filename, metode) {
      if (!filename) {
        if (metode === 'Tunai') {
          return 'http://localhost/2/backend/assets/vue/img/bukti_bayar/tunai.png';
        }
        return '';
      }
      return `http://localhost/2/backend/assets/vue/img/bukti_bayar/${filename}`;
    },
    generateCharts() {
      const statusCounts = { lunas: 0, 'belum lunas': 0 };
      const metodeTotals = {};

      this.pembayaran.forEach(p => {
        if (statusCounts[p.status] !== undefined) {
          statusCounts[p.status]++;
        }

        if (!metodeTotals[p.metode]) metodeTotals[p.metode] = 0;
        metodeTotals[p.metode] += parseFloat(p.jml_bayar);
      });

      this.statusChartData = {
        labels: Object.keys(statusCounts),
        datasets: [
          {
            label: 'Status Pembayaran',
            data: Object.values(statusCounts),
            backgroundColor: ['#2ecc71', '#e74c3c']
          }
        ]
      };

      this.metodeChartData = {
        labels: Object.keys(metodeTotals),
        datasets: [
          {
            label: 'Jumlah Bayar',
            data: Object.values(metodeTotals),
            backgroundColor: ['#3498db', '#f39c12']
          }
        ]
      };
    }
  }
};
</script>

<style scoped>
.card {
  max-width: 1500px;
  margin-bottom: 20px;
}
.judul-kelola {
  font-size: 2.5rem;
  font-weight: bold;
}
.bukti-img {
  max-width: 100px;
  max-height: 80px;
  object-fit: contain;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.card-title i {
  margin-right: 6px;
}
.table td,
.table th {
  vertical-align: middle;
}
.chart-container {
  position: relative;
  height: 300px;
}
</style>