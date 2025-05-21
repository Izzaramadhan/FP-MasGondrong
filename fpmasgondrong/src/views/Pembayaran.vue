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