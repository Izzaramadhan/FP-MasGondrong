<template>
  <div class="pemesanan-wrapper">
    <div class="pemesanan-card">
      <div class="pemesanan-card-body">
        <!-- Kolom Kiri -->
        <div class="kendaraan-info">
          <img :src="gambarKendaraan" alt="Gambar Kendaraan" />
          <h5>{{ kendaraanDipilih }}</h5>
 <p><strong>Harga per hari:</strong> {{ formatRupiah(hargaPerHari) }}</p>
<p>Motor atau mobil pilihan yang siap digunakan untuk kebutuhan Anda.</p>

        </div>

        <!-- Kolom Kanan -->
        <div class="form-pemesanan">
          <form @submit.prevent="pesanKendaraan">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" v-model="tglMulai" class="form-control" required />

            <label class="form-label">Tanggal Selesai</label>
            <input type="date" v-model="tglSelesai" class="form-control" required />

<div class="total-harga">Total Harga: Rp {{ totalHarga.toLocaleString('id-ID') }}</div>


            <button type="submit" class="btn-green">Pesan Sekarang</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'PemesananPage',
  setup() {
    const route = useRoute()
    const router = useRouter()
    const kendaraanDipilih = ref(route.params.kendaraan || 'Honda Scoopy')
    const id_kendaraan = ref(route.params.id_kendaraan || 1)

    const tglMulai = ref('')
    const tglSelesai = ref('')

        const formatRupiah = (angka) => {
      return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    }


    const hargaPerHari = ref(0)
    const totalHarga = ref(0)

    // Ambil harga_perhari dari server berdasarkan id_kendaraan
    const fetchHargaPerHari = async () => {
      try {
        const res = await axios.get(`http://localhost/2/backend/index.php/api/kendaraan/${id_kendaraan.value}`)
        hargaPerHari.value = parseInt(res.data.data.harga_perhari)
      } catch (err) {
        console.error('Gagal mengambil harga_perhari:', err)
        hargaPerHari.value = 0
        
      }
      
    }

    // Hitung total harga otomatis
    const hitungTotalHarga = () => {
      if (tglMulai.value && tglSelesai.value && hargaPerHari.value > 0) {
        const mulai = new Date(tglMulai.value)
        const selesai = new Date(tglSelesai.value)
        const selisihHari = Math.ceil((selesai - mulai) / (1000 * 60 * 60 * 24)) + 1
        totalHarga.value = selisihHari > 0 ? selisihHari * hargaPerHari.value : 0
      } else {
        totalHarga.value = 0
      }
    }

    // Reaktif hitung ulang saat tanggal berubah
    watch([tglMulai, tglSelesai], hitungTotalHarga)

    // Ambil gambar berdasarkan nama
    const gambarKendaraan = computed(() => {
      const nama = kendaraanDipilih.value.toLowerCase()
      if (nama.includes('innova')) return require('@/assets/images/Innova.jpg')
      if (nama.includes('pajero')) return require('@/assets/images/Pajero.jpg')
      if (nama.includes('vario')) return require('@/assets/images/vario.jpg')
      return require('@/assets/images/Scoopy.jpg')
    })

const pesanKendaraan = async () => {
  const userString = localStorage.getItem('user')
  console.log('Isi localStorage user:', userString)

  const user = JSON.parse(userString)
  if (!user || !user.id_user) {
    alert('Anda belum login! Silakan login terlebih dahulu.')
    return
  }

  const id_user = user.id_user

  const data = {
    id_user,
    id_kendaraan: id_kendaraan.value,
    tgl_mulai: tglMulai.value,
    tgl_selesai: tglSelesai.value,
    total_harga: totalHarga.value
  }

  console.log('Data dikirim ke backend:', data)

  try {
    const res = await axios.post('http://localhost/2/backend/index.php/api/pemesanan/simpan', data, {
      headers: { 'Content-Type': 'application/json' }
    })

    if (res.data.status === 'success') {
      alert('Pemesanan berhasil!')
      router.push('/pembayaran')
    } else {
      alert('Gagal menyimpan data pemesanan: ' + res.data.message)
    }
  } catch (error) {
    console.error(error)
    alert('Terjadi kesalahan saat menghubungi server.')
  }
}




    

    fetchHargaPerHari()

    return {
      kendaraanDipilih,
      tglMulai,
      tglSelesai,
      pesanKendaraan,
      gambarKendaraan,
      hargaPerHari,
      formatRupiah,
      totalHarga
    }
  }
}
</script>


<style scoped>

</style>