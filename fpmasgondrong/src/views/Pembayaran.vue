<template>
  <div class="container pembayaran-wrapper">
    <h4 class="text-center mb-3">Pembayaran</h4>

    <div class="total-harga">
      Total: Rp 125.000
    </div>

    <div class="mb-3">
      <label for="tgl_bayar" class="form-label">Tanggal Bayar</label>
      <input type="text" id="tgl_bayar" class="form-control" :value="formattedDate" readonly />
    </div>

    <form @submit.prevent="handlePayment">
      <div class="mb-3">
        <label for="metode" class="form-label">Metode Pembayaran</label>
        <select v-model="metode" id="metode" class="form-select" required>
          <option value="">-- Pilih Metode --</option>
          <option value="TF">Transfer</option>
          <option value="Qris">QRIS</option>
          <option value="TUNAI">Tunai</option>
        </select>
      </div>
      <router-link to="/" class="btn btn-green w-100">Bayar Sekarang</router-link>
    </form>
  </div>
</template>

<script>
export default {
  name: 'PembayaranPage',
  data() {
    return {
      metode: '',
      formattedDate: ''
    };
  },
  created() {
    const today = new Date();
    this.formattedDate = today.toLocaleDateString('id-ID', {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    });
  },
  methods: {
    handlePayment() {
      // Di sini kita bisa ditambahkan validasi/metode simpan data pembayaran
      alert(`Pembayaran dengan metode ${this.metode} berhasil (simulasi).`);
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
