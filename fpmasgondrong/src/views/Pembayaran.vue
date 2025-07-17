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
          <option value="Tunai">Tunai</option>
        </select>
      </div>

      <!-- Info rekening jika transfer -->
      <div v-if="showRekeningCard" class="qr-popup">
        <div class="qr-card">
          <h5 class="text-center">Transfer ke Salah Satu Rekening Berikut</h5>
          <ul class="text-start">
            <li><strong>BNI:</strong> 1234567890 a.n. Mas Gondrong Rent</li>
            <li><strong>BRI:</strong> 0987654321 a.n. Mas Gondrong Rent</li>
            <li><strong>Mandiri:</strong> 1122334455 a.n. Mas Gondrong Rent</li>
          </ul>
          <p class="text-center text-muted mt-2">Setelah transfer, upload bukti pembayaran di bawah.</p>
        </div>
      </div>

      <!-- Upload jika bukan tunai -->
      <div class="mb-3 mt-3" v-if="metode !== 'Tunai'">
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
      id_pemesanan: null,
      showRekeningCard: false
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

    fetch(`http://localhost:8000/api/pemesanan/${this.id_pemesanan}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success' && data.data) {
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
  watch: {
    metode(newVal) {
      this.showRekeningCard = newVal === 'TF';
    }
  },
  methods: {
    handleFileChange(e) {
      this.buktiFile = e.target.files[0];
    },
    async handlePayment() {
      if (!this.metode || (this.metode !== 'Tunai' && !this.buktiFile)) {
        alert('Lengkapi semua data!');
        return;
      }

      const formData = new FormData();
      formData.append('id_pemesanan', this.id_pemesanan);
      formData.append('tgl_bayar', this.formattedDate);
      formData.append('metode', this.metode);
      formData.append('jml_bayar', this.jml_bayar);

      if (this.metode !== 'Tunai' && this.buktiFile) {
        formData.append('bukti_bayar', this.buktiFile);
      }

      try {
        const res = await fetch('http://localhost:8000/api/pembayaran/simpan', {
          method: 'POST',
          body: formData
        });

        const resultText = await res.text();
        let result;

        try {
          result = JSON.parse(resultText);
        } catch (jsonErr) {
          console.error('❌ Respon bukan JSON:', resultText);
          alert('Server error: ' + resultText);
          return;
        }

        if (res.ok && result.status === 'success') {
          alert(result.message || 'Pembayaran berhasil!');
          this.$router.push('/');
        } else {
          alert(result.message || 'Terjadi kesalahan.');
        }
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
.qr-popup {
  margin: 20px 0;
  display: flex;
  justify-content: center;
}
.qr-card {
  background: #ffffff;
  padding: 20px 25px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  text-align: center;
  max-width: 350px;
  width: 100%;
}
.qr-card ul {
  padding-left: 1rem;
  text-align: left;
  list-style-type: disc;
}
</style>
