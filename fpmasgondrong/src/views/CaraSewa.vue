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