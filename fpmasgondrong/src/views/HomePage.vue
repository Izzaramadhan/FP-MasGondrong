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
        <a href="#pesan" class="btn btn-primary mt-3">Sewa Sekarang!</a>
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

    <!-- Menu Section -->
    <section class="menu" id="menu">
      <h1 class="heading">Ketersediaan <span> Kendaraan</span></h1>
      <div class="d-flex">
        <label for="kategori">Pilih Kategori:</label>
        <select id="kategori" class="form-select me-2" v-model="kategoriDipilih">
          <option value="">Semua Kategori</option>
          <option value="mobil">Mobil</option>
          <option value="motor">Motor</option>
        </select>
      </div>
      <div class="box-container">
        <div class="container">
          <div class="row">
            <div class="col-md-4" v-for="(item, index) in kendaraanTersaring" :key="index">
              <div class="box">
                <!-- Corrected image binding -->
                <img :src="require(`@/assets/images/${item.gambar}`)" />
                <img :alt="'Gambar kendaraan ' + item.nama"
                     class="product-img"
                     width="150"
                     height="100" />
                <h3 class="product-title">{{ item.nama }}</h3>
                <div class="price">{{ item.harga }}</div>
                <button class="btn add-cart" @click.prevent="handleSewa(item.nama)">
                  Sewa Sekarang
                </button>
              </div>
            </div>
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
      const isLoggedIn = localStorage.getItem('user')
      if (!isLoggedIn) {
        alert('Silakan login terlebih dahulu untuk melakukan pemesanan.')
        router.push('/login')
        return
      }
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