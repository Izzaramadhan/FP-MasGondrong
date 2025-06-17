<template>

  <div class="cara-sewa-page">
    <h1 class="title">Cara Sewa Kendaraan</h1>
    <div class="steps">
      <div class="step" v-for="(langkah, i) in langkahSewa" :key="i">
        <div class="step-number">{{ i + 1 }}</div>
        <h2 class="step-title">{{ langkah.judul }}</h2>
        <p class="step-desc">{{ langkah.deskripsi }}</p>
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
        judul: 'Pilih Kendaraan',
        deskripsi: 'Telusuri halaman menu untuk memilih kendaraan yang ingin Anda sewa sesuai dengan kebutuhan Anda.'
      },
      {
        judul: 'Isi Form Pemesanan',
        deskripsi: 'Klik "Sewa Sekarang" lalu lengkapi data pemesanan seperti tanggal mulai dan selesai sewa.'
      },
      {
        judul: 'Lakukan Pembayaran',
        deskripsi: 'Setelah mengisi form, Anda akan diarahkan ke halaman pembayaran. Pilih metode pembayaran dan konfirmasi.'
      },
      {
        judul: 'Konfirmasi & Verifikasi',
        deskripsi: 'Tim kami akan menghubungi Anda untuk memverifikasi dan mengonfirmasi pesanan Anda.'
      },
      {
        judul: 'Nikmati Perjalanan Anda',
        deskripsi: 'Kendaraan akan diantar atau bisa Anda ambil sesuai kesepakatan. Selamat berkendara!'
      }
    ]
    return { langkahSewa }
  }
}
</script>

<style scoped>
.cara-sewa-page {
  padding: 100px 20px 40px;
  background-color: #f9f9f9;
  text-align: center;
  min-height: 100vh;
}

.title {
  font-size: 3rem;
  color: #1e73be;
  margin-bottom: 3rem;
  font-weight: bold;
}

.steps {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  max-width: 700px;
  margin: 0 auto;
}

.step {
  background: #fff;
  border: 1px solid #ddd;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

.step-number {
  background-color: #1e73be;
  color: #fff;
  font-size: 2rem;
  width: 40px;
  height: 40px;
  margin: 0 auto 1rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.step-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 0.5rem;
}

.step-desc {
  font-size: 1.4rem;
  color: #555;
}
</style>