<template>
  <NavbarAdmin />
  <div>
    <h1>MANAGE PEMBAYARAN</h1>
    <div class="grid-container">
      <div v-for="p in pembayaran" :key="p.id" class="card">
        <p><strong>ID Pemesanan:</strong> {{ p.id_pemesanan }}</p>
        <p><strong>Tanggal Bayar:</strong> {{ p.tgl_bayar }}</p>
        <p><strong>Jumlah Bayar:</strong> Rp {{ p.jml_bayar }}</p>
        <p><strong>Metode:</strong> {{ p.metode }}</p>
        <p><strong>Status:</strong> {{ p.status }}</p>
        <div class="btn-group">
          <button @click="ubahStatus(p.id, 'lunas')">Set Lunas</button>
          <button @click="ubahStatus(p.id, 'belum lunas')">Set Belum Lunas</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import NavbarAdmin from '@/components/NavbarAdmin.vue';
export default {
  components: { NavbarAdmin },
  data() {
    return {
      pembayaran: [
        { id: 1, id_pemesanan: 101, tgl_bayar: '2024-12-29', jml_bayar: 150000, metode: 'TF', status: 'belum lunas' },
        { id: 2, id_pemesanan: 102, tgl_bayar: '2024-12-30', jml_bayar: 200000, metode: 'Qris', status: 'lunas' }
      ]
    };
  },
  methods: {
    ubahStatus(id, status) {
      const p = this.pembayaran.find(x => x.id === id);
      if (p) p.status = status;
    }
  }
};
</script>
<style scoped>

h1 {
  text-align: center;
  font-size: 32px;
  color: #2c3e50;
  margin-bottom: 30px;
  background-color: #f7f9fb;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  padding: 20px;
}

.card {
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 15px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  text-align: left;
}

.card p {
  margin: 6px 0;
}

.btn-group {
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  gap: 6px;
}

button {
  background-color: #3498db;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}

</style>