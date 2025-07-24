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
        class="riwayat-card d-flex p-3 mb-4"
      >
        <!-- Gambar -->
        <div class="img-container me-4">
          <img
            :src="`http://localhost:8000/storage/kendaraan/${item.kendaraan.gambar}`"
            alt="Gambar Kendaraan"
            v-if="item.kendaraan && item.kendaraan.gambar"
          />
        </div>

        <!-- Konten -->
        <div class="flex-grow-1">
          <h5 class="mb-2">ID Pemesanan: {{ item.id_pemesanan }}</h5>
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
        const res = await axios.get(url);

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
    this.fetchPemesanan();
  }
};
</script>

<style scoped>
.riwayat-card {
  background-color: #f8f9fa;
  border-left: 5px solid #1E73BE;
  border-radius: 10px;
  transition: 0.2s ease-in-out;
  min-height: 180px;
  align-items: center;
}

.riwayat-card:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.img-container {
  width: 240px;
  height: 150px;
  overflow: hidden;
  border-radius: 8px;
  background-color: #eaeaea;
  flex-shrink: 0;
}

.img-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
