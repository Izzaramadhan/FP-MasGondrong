<template>
  <AdminLayout>
  <div class="form-container">
    <h1>Tambah Kendaraan</h1>

    <form @submit.prevent="simpanKendaraan" enctype="multipart/form-data">
      <label>Tipe Kendaraan</label>
      <input v-model="tipe" type="text" required />

      <label>Jenis Kendaraan</label>
      <select v-model="jenis" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="Mobil">Mobil</option>
        <option value="Motor">Motor</option>
      </select>

      <label>Plat Nomor</label>
      <input v-model="plat_nomor" type="text" required />

      <label>Harga per Hari</label>
      <input v-model.number="harga_perhari" type="number" required />

      <label>Gambar Kendaraan</label>
      <input type="file" @change="handleFileChange" required />

      <button type="submit">Simpan</button>
    </form>
  </div>

  </AdminLayout>
</template>

<script>
import AdminLayout from '@/components/AdminLayout.vue';
import axios from 'axios'

export default {
  components: { AdminLayout },
  data() {
    return {
      tipe: '',
      jenis: '',
      plat_nomor: '',
      harga_perhari: '',
      gambar: null
    }
  },
  methods: {
    handleFileChange(event) {
      this.gambar = event.target.files[0]
    },
    async simpanKendaraan() {
      if (!this.gambar) {
        alert('Gambar belum dipilih!')
        return
      }

      const formData = new FormData()
      formData.append('tipe', this.tipe)
      formData.append('jenis', this.jenis)
      formData.append('plat_nomor', this.plat_nomor)
      formData.append('harga_perhari', this.harga_perhari)
      formData.append('gambar', this.gambar)

try {
  const response = await axios.post(
    'http://localhost/2/backend/index.php/api/kendaraan/simpan',
    formData,
    { headers: { 'Content-Type': 'multipart/form-data' } }
  )

if (response.data.status) {
  alert('Berhasil menambahkan kendaraan!')
  this.$router.push('/admin/manage-kendaraan')
} else {
  const msg = response.data.message || response.data.error || 'Gagal tanpa pesan';
  alert('Gagal menyimpan kendaraan: ' + msg)
}

} catch (err) {
  console.error('❌ Gagal menyimpan kendaraan:', err)
  alert('Terjadi kesalahan saat menyimpan.')
}

    }
  }
}
</script>

<style scoped>
.form-container {
  max-width: 500px;
  margin: 50px auto;
  background: #f7f9fb;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input,
select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  background-color: #3498db;
  color: white;
  padding: 10px 16px;
  border: none;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
}

button:hover {
  background-color: #2980b9;
}
</style>
