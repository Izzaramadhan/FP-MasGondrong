<template>
  <div class="container my-5">
    <h2 class="text-center mb-4">
      <span style="color: #1E73BE;">RIWAYAT PEMESANAN</span>
    </h2>

    <div v-if="pemesanan.length === 0" class="text-center text-muted">
      Belum ada riwayat pemesanan.
    </div>

    <div v-else>
  <div
    v-for="item in pemesanan"
    :key="item.id_pemesanan"
    class="card mb-4 w-100"
  >
    <div class="d-flex flex-column flex-md-row">
      <!-- Gambar -->
      <div class="flex-shrink-0" style="width: 300px;">
        <img
          :src="`http://localhost:8000/uploads/${item.kendaraan.gambar}`"
          class="img-fluid h-100"
          alt="Gambar Kendaraan"
          style="object-fit: cover;"
          v-if="item.kendaraan && item.kendaraan.gambar"
        />
      </div>

      <!-- Konten -->
      <div class="p-3 flex-grow-1">
        <h5 class="mb-3">ID Pemesanan: {{ item.id_pemesanan }}</h5>

        <p><strong>Tanggal Mulai:</strong> {{ formatTanggal(item.tgl_mulai) }}</p>
        <p><strong>Tanggal Selesai:</strong> {{ formatTanggal(item.tgl_selesai) }}</p>

        <p v-if="item.kendaraan">
          <strong>Kendaraan:</strong>
          {{ item.kendaraan.jenis }} - {{ item.kendaraan.tipe }}
          ({{ item.kendaraan.plat_nomor }})
        </p>

        <p><strong>Total Harga:</strong> Rp {{ formatHarga(item.total_harga) }}</p>

        <p>
          <strong>Status:</strong>
          <span :class="{
            'text-warning': item.status === 'diproses',
            'text-success': item.status === 'selesai',
            'text-danger': item.status === 'batal'
          }">
            {{ item.status }}
          </span>
        </p>
      </div>
    </div>
  </div>
</div>

  </div>
</template>


<script>
import axios from 'axios';

export default {
  name: 'RiwayatPemesanan',
  data() {
    return {
      pemesanan: []
    };
  },
  methods: {
    async fetchPemesanan() {
      const userString = localStorage.getItem('user');
      if (!userString) {
        alert('Anda belum login!');
        this.$router.push('/login');
        return;
      }

      const user = JSON.parse(userString);
      const id_user = user.id_user;

      try {
        const url = `http://localhost:8000/api/pemesanan/riwayat/${id_user}`;
console.log('🔗 Fetching from:', url);
const res = await axios.get(url);
console.log('📥 Response:', res.data);


if (res.data.status) {
  this.pemesanan = res.data.data || [];
} else {
  alert('Gagal mengambil data pemesanan.');
}

      } catch (err) {
        console.error('Gagal mengambil data pemesanan:', err);
        alert('Terjadi kesalahan saat menghubungi server.');
      }
    },
    formatTanggal(tanggal) {
      return new Date(tanggal).toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    formatHarga(harga) {
      return parseInt(harga).toLocaleString('id-ID');
    }
  },
  mounted() {
  console.log('📦 Halaman RiwayatPemesanan dimuat!');
  this.fetchPemesanan();
}

};
</script>

<style scoped>
.riwayat-card {
  background-color: #f8f9fa;
  border-left: 5px solid #1E73BE;
  transition: 0.2s ease-in-out;
  width: 100%;
}

.riwayat-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.riwayat-card img {
  min-height: 200px;
  max-height: 250px;
}

</style>
