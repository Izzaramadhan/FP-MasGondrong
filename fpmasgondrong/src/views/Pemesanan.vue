<template>
  <div class="container pemesanan-wrapper">
    <div class="card shadow">
      <div class="card-body">
        <!-- Info Kendaraan -->
        <div class="text-center mb-3">
          <img :src="gambarKendaraan" :alt="kendaraanDipilih" class="img-fluid kendaraan-img" />
          <h5 class="mt-3">{{ kendaraanDipilih }}</h5>
          <p class="text-muted">
            Motor atau mobil pilihan yang siap digunakan untuk kebutuhan Anda.
          </p>
        </div>

        <!-- Form -->
        <form @submit.prevent="pesanKendaraan">
          <div class="mb-3">
            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" v-model="tglMulai" class="form-control" id="tgl_mulai" required />
          </div>

          <div class="mb-3">
            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" v-model="tglSelesai" class="form-control" id="tgl_selesai" required />
          </div>

          <div class="text-center mb-3">
            <div class="total-harga">Total Harga: Rp 125.000</div>
          </div>

          <router-link to="/pembayaran" class="btn btn-green w-100">Pesan Sekarang</router-link>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, } from 'vue'
import { useRoute } from 'vue-router'

export default {
  name: 'PemesananPage',
  setup() {
    const route = useRoute()
    const kendaraanDipilih = ref(route.params.kendaraan || 'Honda Scoopy')

    const tglMulai = ref('')
    const tglSelesai = ref('')

    const gambarKendaraan = computed(() => {
      // Opsional: sesuaikan dengan nama file di /assets/images
      const nama = kendaraanDipilih.value.toLowerCase()
      if (nama.includes('Innova')) return require('@/assets/images/Innova.jpg')
      if (nama.includes('Pajero')) return require('@/assets/images/Pajero.jpg')
      if (nama.includes('vario')) return require('@/assets/images/vario.jpg')
      return require('@/assets/images/Scoopy.jpg')
    })

    const pesanKendaraan = () => {
      console.log('Pemesanan:', {
        kendaraan: kendaraanDipilih.value,
        tanggalMulai: tglMulai.value,
        tanggalSelesai: tglSelesai.value
      })
    }

    return {
      kendaraanDipilih,
      tglMulai,
      tglSelesai,
      pesanKendaraan,
      gambarKendaraan
    }
  }
}
</script>

<style scoped>
.pemesanan-wrapper {
  max-width: 500px;
  margin: 80px auto;
}
.total-harga {
  font-weight: bold;
  font-size: 1.2rem;
}
.kendaraan-img {
  width: 100%;
  max-height: 250px;
  object-fit: cover;
}
</style>