<template>
  <main class="home">
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

    <!-- Kendaraan Carousel Section -->
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

      <div class="container text-center position-relative carousel-wrapper">
        <button class="carousel-nav prev" @click="prevSlide" :disabled="slideIndex === 0">❮</button>

       <div class="row flex-nowrap overflow-auto" style="gap: 1rem;">
  <div class="col-md-4" v-for="(item, index) in kendaraanTampil" :key="index">
    <div class="card kendaraan-card text-center shadow">
      <img :src="getGambarUrl(item.gambar)" alt="Gambar kendaraan" class="img-fluid mb-3 kendaraan-img" />
      <h5>{{ item.tipe }}</h5>
      <p class="text-primary">Rp {{ formatHarga(item.harga_perhari) }}/hari</p>
      <button class="btn btn-outline-primary mt-auto" @click="handleSewa(item.tipe)">Sewa Sekarang</button>
    </div>
  </div>
</div>

        <button class="carousel-nav next" @click="nextSlide" :disabled="slideIndex + 3 >= kendaraanTersaring.length">❯</button>
      </div>
    </section>


 <!-- Testimoni -->
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
import { ref, computed, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'HomePage',
  setup() {
    const router = useRouter()
    const kendaraan = ref([])

    const kategoriDipilih = ref('')
    const slideIndex = ref(0)
    

    const kendaraanTersaring = computed(() => {
      if (!kategoriDipilih.value) return kendaraan.value
      return kendaraan.value.filter(k => k.jenis.toLowerCase() === kategoriDipilih.value.toLowerCase())
    })

    const kendaraanTampil = computed(() => {
      const start = slideIndex.value
      return kendaraanTersaring.value.slice(start, start + 3)
    })

    const nextSlide = () => {
      if (slideIndex.value + 3 < kendaraanTersaring.value.length) {
        slideIndex.value += 1
      }
    }

    const prevSlide = () => {
      if (slideIndex.value > 0) {
        slideIndex.value -= 1
      }
    }

    watch(kategoriDipilih, () => {
      slideIndex.value = 0
    })

    const handleSewa = (namaKendaraan) => {
      router.push({ name: 'Pemesanan', params: { kendaraan: namaKendaraan } })
    }
    const testimonials = ref([
      { nama: 'Danang', text: 'Pelayanannya cepat dan motornya bersih! Saya sewa Beat 3 hari dan semuanya lancar. Mas Gondrong juga ramah banget!', rating: 5 },
      { nama: 'Ubay', text: 'Mobil Avanza yang saya sewa nyaman dipakai untuk perjalanan keluarga. Harganya juga bersahabat. Recommended!', rating: 5 },
      { nama: 'Brodin', text: 'Pertama kali ke Jogja dan bingung cari kendaraan. Untung ketemu Sewa Kendaraan Mas Gondrong. Prosesnya gampang, motor langsung diantar ke hotel.', rating: 5 }
    ])

const getGambarUrl = (namaFile) => {
  const url = `http://localhost/1/backend/assets/vue/img/kendaraan/${namaFile}`;
  console.log('Gambar URL:', url); // ✅ DEBUG: Cek ini di console browser
  return url;
}


    const formatHarga = (harga) => {
      return parseInt(harga).toLocaleString('id-ID')
    }

    const fetchData = async () => {
      try {
        const resKendaraan = await axios.get('http://localhost/1/backend/index.php/api/kendaraan')
        kendaraan.value = resKendaraan.data

      
      } catch (error) {
        console.error('Gagal mengambil data:', error)
      }
    }

    onMounted(() => {
      fetchData()
    })

    return {
      kendaraan,
      kategoriDipilih,
      kendaraanTersaring,
      kendaraanTampil,
      handleSewa,
      getGambarUrl,
      formatHarga,
      slideIndex,
      nextSlide,
      prevSlide,
      testimonials
    }
  }
}
</script>

<style scoped>
/* Kendaraan Card */
.kendaraan-card {
  min-height: 400px;
  max-width: 300px;
  margin: auto;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-radius: 1rem;
  padding: 1rem;
  background: white;
  transition: transform 0.3s ease;
}

.kendaraan-card:hover {
  transform: translateY(-5px);
}

.kendaraan-img {
  max-height: 180px;
  object-fit: cover;
  border-radius: 0.5rem;
}

/* Row Kendaraan */
.carousel-wrapper .row {
  flex-wrap: nowrap;
  overflow-x: auto;
  padding: 1rem 0;
  scroll-behavior: smooth;
}

.carousel-wrapper .col-md-4 {
  flex: 0 0 auto;
  width: 300px;
}

/* Tombol Carousel */
.carousel-nav {
  background: white;
  border: 1px solid #ccc;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 24px;
  line-height: 36px;
  text-align: center;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
}

.carousel-nav.prev {
  left: 0;
}

.carousel-nav.next {
  right: 0;
}

/* Testimoni */
.review-card {
  min-height: 280px;
  padding: 1.5rem;
  background-color: #f8f9fa;
  border-radius: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: center;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

.review-card p {
  font-size: 16px;
  margin-bottom: 1rem;
  color: #333;
}

.review-card h5 {
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.stars i {
  color: #ffc107;
}


/* Review Card */
.review-card {
  background-color: #f9f9f9;
  padding: 25px;
  border-radius: 1rem;
  text-align: center;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  min-height: 280px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  transition: transform 0.2s;
}

.review-card:hover,
.kendaraan-card:hover {
  transform: translateY(-5px);
}

.stars i {
  color: #ffc107;
}
.carousel-wrapper {
  position: relative;
}

.carousel-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 10;
  background: white;
  border: 1px solid #ccc;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  padding: 0;
}



</style>
