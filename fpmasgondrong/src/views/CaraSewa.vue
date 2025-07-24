<template>
  <div class="cara-sewa-page">
    <h1 class="title">Cara Sewa Kendaraan</h1>
    <div class="steps-horizontal">
      <div class="step-horizontal" v-for="(langkah, i) in langkahSewa" :key="i">
        <div class="circle-number">{{ i + 1 }}</div>
        <div class="text-box">
          <h2 class="step-title">{{ langkah.judul }}</h2>
          <p class="step-desc">{{ langkah.deskripsi }}</p>
        </div>
        <div v-if="i < langkahSewa.length - 1" class="arrow"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CaraSewa',
  setup() {
    const langkahSewa = [
      {
        judul: 'Login / Registrasi',
        deskripsi: 'Masuk ke akun Anda atau daftar jika belum punya untuk mulai menyewa kendaraan.'
      },
      {
        judul: 'Pilih Kendaraan',
        deskripsi: 'Jelajahi daftar kendaraan dan pilih yang paling sesuai dengan kebutuhan Anda.'
      },
      {
        judul: 'Isi Form Pemesanan',
        deskripsi: 'Lengkapi data pemesanan seperti tanggal sewa dan lokasi pengambilan kendaraan.'
      },
      {
        judul: 'Lakukan Pembayaran',
        deskripsi: 'Pilih metode pembayaran dan konfirmasi pembayaran Anda melalui sistem.'
      },
      {
        judul: 'Konfirmasi & Verifikasi',
        deskripsi: 'Tunggu verifikasi dari tim kami dan pastikan semua data sudah sesuai.'
      },
      {
        judul: 'Nikmati Perjalanan',
        deskripsi: 'Ambil atau tunggu kendaraan diantar, dan nikmati perjalanan Anda dengan aman.'
      }
    ]
    return { langkahSewa }
  }
}
</script>

<style scoped>
.cara-sewa-page {
  padding: 80px 20px;
  background-color: #f5f7fa;
  text-align: center;
}

.title {
  font-size: 3.8rem; /* Sebelumnya 3.0rem */
  font-weight: bold;
  color: #1e73be;
  margin-bottom: 3rem;
}

.steps-horizontal {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 40px;
  flex-wrap: wrap;
  position: relative;
  padding: 0 20px;
}

.step-horizontal {
  display: flex;
  flex-direction: column;
  align-items: center;
  max-width: 220px; /* Lebarkan sedikit untuk tampung teks lebih besar */
  position: relative;
}

.circle-number {
  width: 60px;
  height: 60px;
  background-color: #1e73be;
  color: white;
  font-size: 1.8rem; /* Sebelumnya 1.4rem */
  font-weight: bold;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
  z-index: 1;
}

.text-box {
  background-color: white;
  padding: 1.2rem;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  text-align: left;
}

.step-title {
  font-size: 1.5rem; /* Sebelumnya 1.2rem */
  font-weight: 600;
  color: #333;
  margin-bottom: 0.5rem;
}

.step-desc {
  font-size: 1.1rem; /* Sebelumnya 0.95rem */
  color: #666;
}

/* Panah antar langkah */
.arrow {
  width: 60px;
  height: 2px;
  background-color: #ccc;
  position: absolute;
  top: 30px;
  left: 100%;
  transform: translateY(-50%);
  z-index: 0;
}

/* Responsive: Stack vertically */
@media (max-width: 768px) {
  .steps-horizontal {
    flex-direction: column;
    align-items: center;
  }

  .arrow {
    display: none;
  }

  .step-horizontal {
    max-width: 90%;
  }

  .text-box {
    text-align: center;
  }

  .title {
    font-size: 2.6rem;
  }

  .step-title {
    font-size: 1.3rem;
  }

  .step-desc {
    font-size: 1.05rem;
  }

  .circle-number {
    width: 55px;
    height: 55px;
    font-size: 1.6rem;
  }
}
</style>
