<template>
  <main>
    <!-- Hero Section -->
    <section class="hero py-5" 
     :style="{
      backgroundImage: `url(${require('@/assets/images/Banner2.jpeg')})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center'
    }"
  >
  <div class="container">
    <div class="row align-items-center">
      
      <!-- Kolom Teks -->
      <div class="col-md-6 text-white">
        <h1 class="fw-bold">Sewa Kendaraan Mas Gondrong</h1>
        <p class="lead">Dari Mas Gondrong untuk perjalanan hebatmu</p>
        <a href="#menu" class="btn btn-primary mt-3">Sewa Sekarang!</a>
      </div>

      <!-- Kolom Gambar -->
      <div class="col-md-6 text-center">
        <img :src="require('@/assets/images/mobilbanner.png')" alt="Kendaraan Mas Gondrong" class="img-fluid">
      </div>

    </div>
  </div>
</section>

    <!-- About Section -->
    <section class="about" id="about">
      <h1 class="heading"><span>Deskripsi </span> Singkat</h1>
      <div class="row g-0">
        <div class="image">
          <img :src="require('@/assets/images/Banner1.jpeg')" alt="Banner perusahaan" class="img-fluid" width="600" height="400">
        </div>
        <div class="content">
          <h2>Sewa Kendaraan Lebih Mudah</h2>
          <p>
            Sewa Kendaraan Mas Gondrong adalah solusi sewa motor dan mobil terpercaya dengan proses mudah dan cepat.
            Temukan berbagai pilihan kendaraan sesuai kebutuhan Anda, pesan secara online, dan nikmati perjalanan tanpa ribet. 
            Aman, praktis, dan siap melayani di berbagai kota.
          </p>
        </div>
      </div>
    </section>

    <!-- Menu Section - UPDATED -->
    <section class="menu" id="menu">
      <h1 class="heading">Ketersediaan <span> Kendaraan</span></h1>
      
      <!-- Filter Kategori -->
      <div class="d-flex mb-3">
        <label for="kategori">Pilih Kategori:</label>
        <select id="kategori" class="form-select me-2" v-model="kategoriDipilih">
          <option value="">Semua Kategori</option>
          <option value="mobil">Mobil</option>
          <option value="motor">Motor</option>
        </select>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="text-center my-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Memuat data kendaraan dari server...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="alert alert-warning my-4">
        <h5><i class="fas fa-exclamation-triangle"></i> Pemberitahuan</h5>
        <p>{{ error }}</p>
        <p><small><i class="fas fa-info-circle"></i> Menampilkan data contoh sementara. Data akan diperbarui secara otomatis.</small></p>
        <button class="btn btn-outline-primary btn-sm" @click="loadKendaraan">
          <i class="fas fa-sync-alt"></i> Coba Lagi
        </button>
      </div>

      <!-- Daftar Kendaraan -->
      <div class="box-container">
        <div class="container">
          <!-- Info Jumlah Kendaraan -->
          <div class="row mb-3" v-if="!loading">
            <div class="col-12">
              <p class="text-muted">
                <i class="fas fa-car"></i> 
                Menampilkan {{ kendaraanTersaring.length }} kendaraan
                <span v-if="kategoriDipilih"> untuk kategori "{{ kategoriDipilih }}"</span>
              </p>
            </div>
          </div>

          <!-- Cards Kendaraan -->
          <div class="row">
            <div class="col-md-4 mb-4" v-for="(item, index) in kendaraanTersaring" :key="item.id_kendaraan || index">
              <div class="box">
                <!-- Badge untuk kendaraan dari database -->
                <div v-if="item.id_kendaraan" class="badge bg-success position-absolute" style="top: 10px; right: 10px; z-index: 1;">
                  <i class="fas fa-database"></i> Live Data
                </div>
                
                <!-- Gambar Kendaraan -->
                <img 
                  :src="require(`@/assets/images/${item.gambar}`)" 
                  :alt="'Gambar kendaraan ' + item.nama"
                  class="product-img"
                  width="150"
                  height="100" 
                />
                
                <!-- Info Kendaraan -->
                <h3 class="product-title">{{ item.nama }}</h3>
                
                <!-- Info tambahan untuk data dari database -->
                <div v-if="item.tipe && item.jenis" class="text-muted small mb-2">
                  <i class="fas fa-tag"></i> {{ item.tipe }} - {{ item.jenis }}
                </div>
                
                <div class="price">{{ item.harga }}</div>
                
                <!-- Tombol Sewa -->
                <button class="btn add-cart" @click.prevent="handleSewa(item.nama)">
                  <i class="fas fa-car"></i> Sewa Sekarang
                </button>
              </div>
            </div>
          </div>

          <!-- Pesan jika tidak ada kendaraan -->
          <div v-if="!loading && kendaraanTersaring.length === 0" class="text-center my-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4>Tidak ada kendaraan ditemukan</h4>
            <p class="text-muted">Coba ubah filter kategori atau hubungi kami untuk ketersediaan kendaraan.</p>
            <button class="btn btn-outline-primary" @click="kategoriDipilih = ''">
              <i class="fas fa-refresh"></i> Reset Filter
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Review Section -->
    <section class="review" id="review">
      <h1 class="heading"><span>Testi</span>moni</h1>
      <div class="box-container">
        <div class="container">
          <div class="row">
            <div class="col-md-4" v-for="(review, i) in testimonials" :key="i">
              <div class="box">
                <p>{{ review.text }}</p>
                <img :src="require('@/assets/images/logo.jpg')" :alt="'Foto pelanggan ' + review.nama" class="user" width="100" height="100" />
                <h3>{{ review.nama }}</h3>
                <div class="stars">
                  <i class="fas fa-star" v-for="s in review.rating" :key="s"></i>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section py-5">
      <div class="container">
        <div class="row">
          <!-- Kolom Kiri: Peta -->
          <div class="col-md-6 mb-4">
           <iframe
      src="https://maps.google.com/maps?q=-7.7740031,110.3738059&z=15&ie=UTF8&iwloc=&output=embed"
      width="100%" height="300"
      style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy">
    </iframe>

            <div class="mt-2">
              <a href="https://maps.app.goo.gl/ug6aD8m1k7QJuVqt8" target="_blank" rel="noopener" class="text-primary">Lihat peta lebih besar</a>
            </div>
          </div>

          <!-- Kolom Kanan: Form -->
          <div class="col-md-6">
            <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
              <h3>Hubungi kami!</h3>
              <a href="https://wa.me/6285353432343?text=Halo,%20saya%20tertarik%20untuk%20menyewa%20kendaraan%20dari%20Mas%20Gondrong." class="btn btn-success mb-3" target="_blank">Hubungi Kami via WhatsApp</a>

              <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
              </div>

              <div class="mb-3">
                <label for="message" class="form-label">Pesan</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message..."></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Kirim Pesan</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- WhatsApp Floating Button -->
    <a
      href="https://wa.me/6285353432343?text=Halo,%20saya%20tertarik%20dengan%20layanan%20sewa%20kendaraan%20Mas%20Gondrong."
      class="whatsapp-float"
      target="_blank"
      rel="noopener"
      aria-label="Hubungi Mas Gondrong melalui WhatsApp"
    >
      <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp" width="48" height="48" />
    </a>
  </main>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { apiService } from '@/services/api'
import { kendaraanAPI } from '@/services/api'

export default {
  name: 'HomePage',
  setup() {
    const router = useRouter()

    // Data state
    const kendaraan = ref([])
    const loading = ref(true)
    const error = ref(null)
    const kategoriDipilih = ref('')

    // Data testimonials (tetap pakai data statis)
    const testimonials = ref([
      { nama: 'Danang', text: 'Pelayanannya cepat dan motornya bersih! Saya sewa Beat 3 hari dan semuanya lancar. Mas Gondrong juga ramah banget!', rating: 5 },
      { nama: 'Ubay', text: 'Mobil Avanza yang saya sewa nyaman dipakai untuk perjalanan keluarga. Harganya juga bersahabat. Recommended!', rating: 5 },
      { nama: 'Brodin', text: 'Pertama kali ke Jogja dan bingung cari kendaraan. Untung ketemu Sewa Kendaraan Mas Gondrong. Prosesnya gampang, motor langsung diantar ke hotel.', rating: 5 }
    ])

    // Computed untuk filter kendaraan
    const kendaraanTersaring = computed(() => {
      if (!kategoriDipilih.value) return kendaraan.value
      return kendaraan.value.filter(k => k.jenis === kategoriDipilih.value)
    })

    // Function untuk load data dari API
    const loadKendaraan = async () => {
      try {
        console.log('Fetching data kendaraan dari API...')
        loading.value = true
        
        const result = await kendaraanAPI.getAll()
        console.log('Response dari API:', result)
        
        if (result.success) {
          // Transform data dari database ke format yang dibutuhkan frontend
          kendaraan.value = result.data.map(item => ({
            id_kendaraan: item.id_kendaraan,
            nama: `${item.tipe} ${item.jenis}`,
            tipe: item.tipe,
            jenis: item.jenis,
            harga: `Rp.${formatPrice(item.harga_perhari)}/hari`,
            harga_perhari: item.harga_perhari,
            kategori: item.jenis.toLowerCase().includes('motor') ? 'motor' : 'mobil',
            gambar: 'default.jpg' // Bisa disesuaikan nanti
          }))
          
          console.log('Data kendaraan berhasil dimuat:', kendaraan.value)
        } else {
          error.value = result.message || 'Gagal memuat data kendaraan'
          console.error('API Error:', result.message)
        }
      } catch (err) {
        console.error('Error loading kendaraan:', err)
        error.value = 'Terjadi kesalahan saat memuat data'
        
        // Fallback ke data statis jika API error
        console.log('Menggunakan data fallback...')
        kendaraan.value = [
          { nama: 'Honda Beat', gambar: 'Beat.jpg', harga: 'Rp.100.000/hari', kategori: 'motor' },
          { nama: 'Honda Scoopy', gambar: 'Scoopy.jpg', harga: 'Rp.125.000/hari', kategori: 'motor' },
          { nama: 'Honda Vario', gambar: 'vario.jpg', harga: 'Rp.150.000/hari', kategori: 'motor' },
          { nama: 'Mitsubishi Pajero', gambar: 'Pajero.jpg', harga: 'Rp.800.000/hari', kategori: 'mobil'},
          { nama: 'Brio', gambar: 'Brio.jpeg', harga: 'Rp.375.000/hari', kategori: 'mobil' },
          { nama: 'Toyota Zenix', gambar: 'Innova.jpg', harga: 'Rp.500.000/hari', kategori: 'mobil' }
        ]
      } finally {
        loading.value = false
      }
    }

    // Function untuk format harga
    const formatPrice = (price) => {
      return new Intl.NumberFormat('id-ID').format(price)
    }

    // Function handle sewa (tetap sama)
    const handleSewa = (namaKendaraan) => {
      const isLoggedIn = localStorage.getItem('user')
      if (!isLoggedIn) {
        alert('Silakan login terlebih dahulu untuk melakukan pemesanan.')
        router.push('/login')
        return
      }
      router.push({ name: 'Pemesanan', params: { kendaraan: namaKendaraan } })
    }

    // Load data saat component mounted
    onMounted(() => {
      loadKendaraan()
    })

    return {
      kendaraan,
      loading,
      error,
      kategoriDipilih,
      kendaraanTersaring,
      testimonials,
      handleSewa,
      loadKendaraan,
      formatPrice
    }
  }
}
</script>

<style scoped>
</style>