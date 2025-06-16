<template>
  <div class="pemesanan-wrapper">
    <div class="pemesanan-card">
      <div class="pemesanan-card-body">
        <!-- Kolom Kiri -->
        <div class="kendaraan-info">
          <img :src="gambarKendaraan" alt="Gambar Kendaraan" />
          <h5>{{ kendaraanDipilih }}</h5>
          <p>Motor atau mobil pilihan yang siap digunakan untuk kebutuhan Anda.</p>
        </div>

        <!-- Kolom Kanan -->
        <div class="form-pemesanan">
          <form @submit.prevent="pesanKendaraan">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" v-model="tglMulai" class="form-control" required />

            <label class="form-label">Tanggal Selesai</label>
            <input type="date" v-model="tglSelesai" class="form-control" required />

            <div class="total-harga">Total Harga: Rp 125.000</div>

            <button type="submit" class="btn-green">Pesan Sekarang</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default {
  name: 'PemesananPage',
  setup() {
    const route = useRoute()
    const router = useRouter()
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
  const user = JSON.parse(localStorage.getItem('user')) || {}
  const id_user = user.id_user
  const id_kendaraan = route.params.id_kendaraan || 1 // Pastikan id_kendaraan ada

  const totalHarga = 125000 // (optional) bisa dihitung otomatis dari tanggal

  const data = {
    id_user,
    id_kendaraan,
    tgl_mulai: tglMulai.value,
    tgl_selesai: tglSelesai.value,
    total_harga: totalHarga
  }

  fetch('http://localhost/1/backend/index.php/pemesanan/simpan', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(response => {
    if (response.status === 'success') {
      alert('Pemesanan berhasil!')
      router.push('/pembayaran')
    } else {
      alert('Gagal menyimpan data pemesanan.')
    }
  })
  .catch(() => alert('Terjadi kesalahan saat menghubungi server.'))
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

</style>