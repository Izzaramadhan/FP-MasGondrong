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
import { ref, computed, watch, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'PemesananPage',
  setup() {
    const route = useRoute()
    const router = useRouter()
    const id_kendaraan = ref(route.params.id_kendaraan || 1)
    const kendaraanDipilih = ref('')
    const gambarFile = ref('')

    const tglMulai = ref('')
    const tglSelesai = ref('')

    const formatRupiah = (angka) => {
      return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
    }

    const hargaPerHari = ref(0)
    const totalHarga = ref(0)

    const fetchKendaraan = async () => {
      try {
        const res = await axios.get(`http://localhost:8000/api/kendaraan/${id_kendaraan.value}`)
        const data = res.data.data

        kendaraanDipilih.value = data.tipe
        hargaPerHari.value = parseInt(data.harga_perhari)
        gambarFile.value = data.gambar
      } catch (err) {
        console.error('Gagal mengambil data kendaraan:', err)
        alert('Kendaraan tidak ditemukan, silakan kembali ke halaman utama.')
        router.push('/')
      }
    }

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

    watch([tglMulai, tglSelesai], hitungTotalHarga)

    const gambarKendaraan = computed(() => {
      return `http://localhost/2/backend/assets/vue/img/kendaraan/${gambarFile.value}`
    })

    const pesanKendaraan = async () => {
      const userString = localStorage.getItem('user')
      const user = userString ? JSON.parse(userString) : null

      if (!user || !user.id_user) {
        alert('Anda belum login! Silakan login terlebih dahulu.')
        return
      }

      if (!tglMulai.value || !tglSelesai.value) {
        alert('Tanggal pemesanan belum lengkap.')
        return
      }

      if (new Date(tglSelesai.value) < new Date(tglMulai.value)) {
        alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.')
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

      try {
        const res = await axios.post('http://localhost:8000/api/pemesanan/simpan', data, {
          headers: { 'Content-Type': 'application/json' }
        })

        if (res.data.status === 'success') {
          const idPemesananBaru = res.data.id_pemesanan
          alert('Pemesanan berhasil! Lanjut ke pembayaran.')

          router.push({
            name: 'Pembayaran',
            query: { id_pemesanan: idPemesananBaru }
          })
        } else {
          alert('Gagal menyimpan data pemesanan: ' + res.data.message)
        }
      } catch (error) {
        console.error('Gagal menyimpan pemesanan:', error)
        alert('Terjadi kesalahan saat menghubungi server.')
      }
    }

    onMounted(() => {
      fetchKendaraan()
    })

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
.pemesanan-wrapper {
  max-width: 900px;
  margin: 80px auto;
  padding: 30px;
  background: #f9f9f9;
  border-radius: 12px;
}

.pemesanan-card-body {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}

.kendaraan-info {
  flex: 1;
  text-align: center;
}

.kendaraan-info img {
  width: 100%;
  max-width: 280px;
  object-fit: contain;
  border-radius: 8px;
  margin-bottom: 20px;
}

.form-pemesanan {
  flex: 1;
}

.form-label {
  font-weight: bold;
  margin-top: 10px;
}

.total-harga {
  font-weight: bold;
  font-size: 1.2rem;
  margin: 20px 0;
}

.btn-green {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 12px;
  width: 100%;
  border-radius: 6px;
  cursor: pointer;
}

.btn-green:hover {
  background-color: #218838;
}
</style>
