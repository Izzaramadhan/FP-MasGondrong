<template>
  <div class="container">
    <div class="register-box">
      <h4 class="text-center mb-4">Daftar Akun Marketplace</h4>

      <form @submit.prevent="handleRegister">
        <div class="mb-3">
          <label>Nama Lengkap</label>
          <input v-model="form.nama" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input v-model="form.email" type="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>No. HP</label>
          <input v-model="form.no_hp" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Alamat</label>
          <input v-model="form.alamat" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="form.password" type="password" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Konfirmasi Password</label>
          <input v-model="form.konfirmasi" type="password" class="form-control" required />
        </div>

        <button type="submit" class="btn btn-green w-100">Daftar</button>
      </form>

      <p class="text-center mt-3">
        Sudah punya akun? <router-link to="/login" class="text-decoration-none">Login disini</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegisterPage',
  data() {
    return {
      form: {
        nama: '',
        email: '',
        no_hp: '',
        alamat: '',
        password: '',
        konfirmasi: ''
      }
    };
  },
  methods: {
    handleRegister() {
      if (this.form.password !== this.form.konfirmasi) {
        alert("Password dan konfirmasi tidak cocok.");
        return;
      }
      // Simulasi pengiriman data
      console.log("Data registrasi:", this.form);
      alert("Pendaftaran berhasil (simulasi).");
    }
  }
};
</script>

<style scoped>

</style>