<template>
  <AdminLayout>
    <div class="form-container">
      <h1>Tambah Kendaraan</h1>

      <form @submit.prevent="simpanKendaraan" enctype="multipart/form-data">
        <label for="tipe">Tipe Kendaraan</label>
        <input v-model="tipe" type="text" id="tipe" required />

        <label for="jenis">Jenis Kendaraan</label>
        <select v-model="jenis" id="jenis" required>
          <option value="">-- Pilih Jenis --</option>
          <option value="Mobil">Mobil</option>
          <option value="Motor">Motor</option>
        </select>

        <label for="plat_nomor">Plat Nomor</label>
        <input v-model="plat_nomor" type="text" id="plat_nomor" required />

        <label for="harga">Harga per Hari</label>
        <input v-model.number="harga_perhari" type="number" id="harga" required />

        <label for="gambar">Gambar Kendaraan</label>
        <input type="file" @change="handleFileChange" id="gambar" accept="image/*" required />

        <button type="submit">Simpan</button>
      </form>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from '@/components/AdminLayout.vue'
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
        alert('Silakan unggah gambar kendaraan terlebih dahulu.')
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
    'http://localhost:8000/api/kendaraan/simpan',
    formData,
    { headers: { 'Content-Type': 'multipart/form-data' } }
  )

  console.log(response.data) // Debug

  if (response.data.status === 'success' || response.data.status === true || response.data.message.includes('berhasil')) {
    alert('✅ ' + response.data.message)
    this.$router.push('/admin/manage-kendaraan')
  } else {
    alert('❌ ' + (response.data.message || 'Gagal menyimpan kendaraan.'))
  }
} catch (err) {
  console.error('❌ Gagal menyimpan kendaraan:', err)
  alert('Terjadi kesalahan saat menghubungi server.')
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
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 24px;
  text-align: center;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

label {
  font-weight: bold;
  margin-bottom: 4px;
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
