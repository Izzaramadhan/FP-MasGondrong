<template>
  <main class="home">
    <!-- Hero Section -->
    <section class="hero-section container py-5">
      <div class="row align-items-center">
        <div class="col-md-6 home-content">
          <h1><span class="text-primary">Sewa Kendaraan</span> <span class="text-warning">Lebih Mudah</span></h1>
          <p class="lead">Sewa Kendaraan Mas Gondrong adalah 
            solusi sewa motor dan mobil terpercaya 
            dengan proses mudah dan cepat.</p>
          <a href="#menu" class="btn btn-info text-white">Sewa Sekarang</a>
        </div>
        <div class="col-md-6 text-center">
          <img :src="require('@/assets/images/New.png')" class="hero-image shadow rounded" />
        </div>
      </div>
    </section>

    <!-- Kendaraan Section -->
    <section class="menu py-5" id="menu">
      <h2 class="text-center text-primary">Pilihan Mobil dan Motor Terbaik</h2>
      <p class="text-center text-muted">Berbagai jenis kendaraan berkualitas siap menemani perjalanan anda</p>

      <div class="d-flex justify-content-center align-items-center my-3">
        <label for="kategori" class="me-2">Pilih Kategori:</label>
        <select id="kategori" class="form-select w-auto" v-model="kategoriDipilih">
          <option value="">Semua Kendaraan</option>
          <option value="mobil">Mobil</option>
          <option value="motor">Motor</option>
        </select>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-3 mb-4" v-for="(item, index) in kendaraanTersaring" :key="index">
            <div class="card text-center kendaraan-card">
              <img :src="require(`@/assets/images/${item.gambar}`)" class="img-fluid" />
              <h5>{{ item.nama }}</h5>
              <p class="text-primary">{{ item.harga }}</p>
              <button class="btn btn-outline-primary" @click.prevent="handleSewa(item.nama)">Sewa Sekarang</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimoni -->
    <section class="review py-5">
      <h2 class="text-center text-primary">Testimoni</h2>
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-3" v-for="(review, i) in testimonials" :key="i">
            <div class="review-card">
              <p>{{ review.text }}</p>
              <img :src="require('@/assets/images/logo.jpg')" :alt="review.nama" class="rounded-circle my-2" width="60" height="60" />
              <h5>{{ review.nama }}</h5>
              <div class="stars">
                <i class="fas fa-star" v-for="s in review.rating" :key="s"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Lokasi -->
    <section class="contact-section py-5 bg-light">
      <div class="container text-center">
        <h2 class="text-primary">Lokasi Kami</h2>
        <iframe
          src="https://maps.google.com/maps?q=-7.7740031,110.3738059&z=15&ie=UTF8&iwloc=&output=embed"
          width="100%" height="300"
          class="rounded shadow-sm my-3"
          style="border:0;"
          allowfullscreen loading="lazy">
        </iframe>
        <a href="https://maps.app.goo.gl/ug6aD8m1k7QJuVqt8" class="text-primary" target="_blank">Lihat peta lebih besar</a>
      </div>
    </section>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/6285353432343?text=Halo,%20saya%20tertarik%20dengan%20layanan%20sewa%20kendaraan%20Mas%20Gondrong." class="whatsapp-float" target="_blank">
      <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp" />
    </a>
  </main>
</template>

<script>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

export default {
  name: 'HomePage',
  setup() {
    const router = useRouter()

    const kendaraan = ref([
      { nama: 'Honda Beat', gambar: 'Beat.jpg', harga: 'Rp.100.000/hari', kategori: 'motor' },
      { nama: 'Honda Scoopy', gambar: 'Scoopy.jpg', harga: 'Rp.125.000/hari', kategori: 'motor' },
      { nama: 'Honda Vario', gambar: 'vario.jpg', harga: 'Rp.150.000/hari', kategori: 'motor' },
      { nama: 'Mitsubishi Pajero', gambar: 'Pajero.jpg', harga: 'Rp.800.000/hari', kategori: 'mobil'},
      { nama: 'Brio', gambar: 'Brio.jpeg', harga: 'Rp.375.000/hari', kategori: 'mobil' },
      { nama: 'Toyota Zenix', gambar: 'Innova.jpg', harga: 'Rp.500.000/hari', kategori: 'mobil' }
    ])

    const kategoriDipilih = ref('')

    const kendaraanTersaring = computed(() => {
      if (!kategoriDipilih.value) return kendaraan.value
      return kendaraan.value.filter(k => k.kategori === kategoriDipilih.value)
    })

    const testimonials = ref([
      { nama: 'Danang', text: 'Pelayanannya cepat dan motornya bersih! Saya sewa Beat 3 hari dan semuanya lancar. Mas Gondrong juga ramah banget!', rating: 5 },
      { nama: 'Ubay', text: 'Mobil Avanza yang saya sewa nyaman dipakai untuk perjalanan keluarga. Harganya juga bersahabat. Recommended!', rating: 5 },
      { nama: 'Brodin', text: 'Pertama kali ke Jogja dan bingung cari kendaraan. Untung ketemu Sewa Kendaraan Mas Gondrong. Prosesnya gampang, motor langsung diantar ke hotel.', rating: 5 }
    ])

   const handleSewa = (namaKendaraan) => {
  router.push({ name: 'Pemesanan', params: { kendaraan: namaKendaraan } })
}

    return {
      kendaraan,
      kategoriDipilih,
      kendaraanTersaring,
      testimonials,
      handleSewa
    }
  }
}
</script>

<style scoped>

</style>