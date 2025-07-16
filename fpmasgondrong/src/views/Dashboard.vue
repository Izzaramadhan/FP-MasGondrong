<template>
  <AdminLayout>
    <div class="dashboard">
      <h1>Dashboard Admin</h1>

      <div class="chart-grid">
        <!-- Statistik Kendaraan -->
        <div class="chart-item">
          <h3>Statistik Kendaraan</h3>
          <canvas id="kendaraanChart"></canvas>
        </div>

        <!-- Status Pembayaran -->
        <div class="chart-item">
          <h3>Status Pembayaran</h3>
          <canvas id="pembayaranStatusChart"></canvas>
        </div>

        <!-- Jumlah Pembayaran per Metode -->
        <div class="chart-item">
          <h3>Jumlah Pembayaran per Metode</h3>
          <canvas id="pembayaranMetodeChart"></canvas>
        </div>

        <!-- Statistik Pemesanan -->
        <div class="chart-item">
          <h3>Jumlah Pemesanan per Hari</h3>
          <canvas id="pemesananLineChart"></canvas>
        </div>

        <!-- Status Pemesanan -->
        <div class="chart-item">
          <h3>Status Pemesanan</h3>
          <canvas id="pemesananDoughnutChart"></canvas>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/components/AdminLayout.vue';
import axios from 'axios';
import Chart from 'chart.js/auto';

export default {
  name: 'DashboardAdmin',
  components: {
    AdminLayout
  },
  data() {
    return {
      chartKendaraan: null,
      chartPembayaranStatus: null,
      chartPembayaranMetode: null,
      chartPemesananLine: null,
      chartPemesananDoughnut: null
    };
  },
  mounted() {
    this.fetchStatistikKendaraan();
    this.fetchStatistikPembayaran();
    this.fetchStatistikPemesanan();
  },
  methods: {
    fetchStatistikKendaraan() {
      axios.get('http://localhost/2/backend/index.php/api/kendaraan')
        .then(response => {
          const kendaraan = Array.isArray(response.data) ? response.data : response.data.data;
          const tersedia = kendaraan.filter(k => k.status.toLowerCase() === 'tersedia').length;
          const tidakTersedia = kendaraan.length - tersedia;

          const ctx = document.getElementById('kendaraanChart').getContext('2d');
          if (this.chartKendaraan) this.chartKendaraan.destroy();
          this.chartKendaraan = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ['Tersedia', 'Tidak Tersedia'],
              datasets: [{
                data: [tersedia, tidakTersedia],
                backgroundColor: ['#28a745', '#6c757d'],
                borderColor: ['#fff', '#fff'],
                borderWidth: 2
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom'
                }
              }
            }
          });
        })
        .catch(error => {
          console.error('Gagal ambil data kendaraan:', error);
        });
    },

    fetchStatistikPembayaran() {
      axios.get('http://localhost/2/backend/index.php/api/pembayaran')
        .then(res => {
          const pembayaran = res.data;

          const statusCounts = { lunas: 0, 'belum lunas': 0 };
          const metodeTotals = {};

          pembayaran.forEach(p => {
            if (statusCounts[p.status] !== undefined) statusCounts[p.status]++;
            if (!metodeTotals[p.metode]) metodeTotals[p.metode] = 0;
            metodeTotals[p.metode] += parseFloat(p.jml_bayar);
          });

          const statusCtx = document.getElementById('pembayaranStatusChart').getContext('2d');
          if (this.chartPembayaranStatus) this.chartPembayaranStatus.destroy();
          this.chartPembayaranStatus = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
              labels: Object.keys(statusCounts),
              datasets: [{
                label: 'Status Pembayaran',
                data: Object.values(statusCounts),
                backgroundColor: ['#2ecc71', '#e74c3c']
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom'
                }
              }
            }
          });

          const metodeCtx = document.getElementById('pembayaranMetodeChart').getContext('2d');
          if (this.chartPembayaranMetode) this.chartPembayaranMetode.destroy();
          this.chartPembayaranMetode = new Chart(metodeCtx, {
            type: 'bar',
            data: {
              labels: Object.keys(metodeTotals),
              datasets: [{
                label: 'Jumlah Bayar',
                data: Object.values(metodeTotals),
                backgroundColor: '#3498db'
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(value) {
                      return 'Rp ' + value.toLocaleString('id-ID');
                    }
                  }
                }
              },
              plugins: {
                legend: {
                  display: false
                }
              }
            }
          });
        })
        .catch(err => {
          console.error('Gagal ambil data pembayaran:', err);
        });
    },

    fetchStatistikPemesanan() {
      axios.get('http://localhost/2/backend/index.php/api/pemesanan')
        .then(res => {
          const pemesanan = res.data;

          const countPerDate = {};
          pemesanan.forEach(item => {
            const date = item.tgl_mulai;
            countPerDate[date] = (countPerDate[date] || 0) + 1;
          });

          const lineCtx = document.getElementById('pemesananLineChart').getContext('2d');
          if (this.chartPemesananLine) this.chartPemesananLine.destroy();
          this.chartPemesananLine = new Chart(lineCtx, {
            type: 'line',
            data: {
              labels: Object.keys(countPerDate),
              datasets: [{
                label: 'Pemesanan per Tanggal',
                data: Object.values(countPerDate),
                borderColor: '#3498db',
                backgroundColor: '#3498db',
                tension: 0.3,
                fill: false
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom'
                }
              },
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });

          const statusCount = { diproses: 0, selesai: 0, batal: 0 };
          pemesanan.forEach(p => {
            if (statusCount[p.status] !== undefined) statusCount[p.status]++;
          });

          const doughnutCtx = document.getElementById('pemesananDoughnutChart').getContext('2d');
          if (this.chartPemesananDoughnut) this.chartPemesananDoughnut.destroy();
          this.chartPemesananDoughnut = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
              labels: ['Diproses', 'Selesai', 'Batal'],
              datasets: [{
                data: [statusCount.diproses, statusCount.selesai, statusCount.batal],
                backgroundColor: ['#f1c40f', '#2ecc71', '#e74c3c']
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'bottom'
                }
              }
            }
          });
        })
        .catch(err => {
          console.error('Gagal ambil data pemesanan:', err);
        });
    }
  }
}
</script>

<style scoped>
.dashboard {
  text-align: center;
  background-color: #f7f9fb;
  padding: 40px 20px;
}

.dashboard h1 {
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
}

.chart-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 24px;
  justify-items: center;
}

.chart-item {
  width: 100%;
  max-width: 500px;
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>
