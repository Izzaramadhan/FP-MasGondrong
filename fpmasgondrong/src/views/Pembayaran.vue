<template>
  <div class="container pembayaran-wrapper">
    <h4 class="text-center mb-3">Pembayaran</h4>

    <div class="total-harga">
      Total: Rp {{ jml_bayar.toLocaleString('id-ID') }}
    </div>

    <form @submit.prevent="handlePayment" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="tgl_bayar" class="form-label">Tanggal Bayar</label>
        <input type="text" id="tgl_bayar" class="form-control" :value="formattedDate" readonly />
      </div>

      <div class="mb-3">
        <label for="metode" class="form-label">Metode Pembayaran</label>
        <select v-model="metode" id="metode" class="form-select" required>
          <option value="">-- Pilih Metode --</option>
          <option value="TF">Transfer</option>
          <option value="Qris">QRIS</option>
          <option value="Tunai">Tunai</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="bukti" class="form-label">Upload Bukti Pembayaran</label>
        <input type="file" @change="handleFileChange" class="form-control" accept="image/*,.pdf" required />
      </div>

      <button type="submit" class="btn btn-green w-100">Bayar Sekarang</button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'PembayaranPage',
  data() {
    return {
      metode: '',
      formattedDate: '',
      jml_bayar: 125000,
      buktiFile: null,
      id_pemesanan: null
    };
  },
created() {
  const today = new Date();
  this.formattedDate = today.toISOString().split('T')[0];

  this.id_pemesanan = this.$route.query.id_pemesanan;

  if (!this.id_pemesanan) {
    alert('ID Pemesanan tidak ditemukan. Silakan ulangi proses pemesanan.');
    this.$router.push('/');
    return;
  }

  // Ambil total_harga dari database berdasarkan id_pemesanan
  fetch(`http://localhost/2/backend/index.php/api/pemesanan/${this.id_pemesanan}`)
    .then(res => res.json())
    .then(data => {
      if (data.status && data.data) {
        this.jml_bayar = parseInt(data.data.total_harga);
      } else {
        alert('Data pemesanan tidak ditemukan.');
        this.$router.push('/');
      }
    })
    .catch(err => {
      console.error('Gagal mengambil data pemesanan:', err);
      alert('Terjadi kesalahan saat mengambil data pemesanan.');
    });
},
  methods: {
    handleFileChange(e) {
      this.buktiFile = e.target.files[0];
    },
    async handlePayment() {
      if (!this.metode || !this.buktiFile) {
        alert('Lengkapi semua data!');
        return;
      }

      const formData = new FormData();
      formData.append('id_pemesanan', this.id_pemesanan);
      formData.append('tgl_bayar', this.formattedDate);
      formData.append('metode', this.metode);
      formData.append('jml_bayar', this.jml_bayar);
      formData.append('bukti_bayar', this.buktiFile);

      try {
        const res = await fetch('http://localhost/2/backend/index.php/api/pembayaran/simpan', {
          method: 'POST',
          body: formData
        });

        const resultText = await res.text();
        console.log('Raw response:', resultText);

        let result;
        try {
          result = JSON.parse(resultText);
        } catch (jsonErr) {
          console.error('❌ Bukan JSON:', resultText);
          alert('Terjadi kesalahan di server: ' + resultText);
          return;
        }

        alert(result.message);
        this.$router.push('/');
      } catch (err) {
        console.error('❌ Error saat fetch:', err);
        alert('Gagal melakukan pembayaran.');
      }
    }
  }
};
</script>


<style scoped>
.pembayaran-wrapper {
  max-width: 500px;
  margin: 80px auto;
  background: #f8f9fa;
  padding: 30px;
  border-radius: 8px;
}
.total-harga {
  font-weight: bold;
  font-size: 1.2rem;
  margin-bottom: 15px;
}
</style>
