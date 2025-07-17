<template>
  <div class="container">
    <div class="register-box">
      <h4 class="text-center mb-4">Register</h4>

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
      // Validasi konfirmasi password
      if (this.form.password !== this.form.konfirmasi) {
        alert("Password dan konfirmasi tidak cocok.");
        return;
      }

      const payload = {
        nama: this.form.nama,
        email: this.form.email,
        no_hp: this.form.no_hp,
        alamat: this.form.alamat,
        password: this.form.password
      };

      fetch("http://localhost:8000/api/auth/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
      })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'success') {
            alert("Pendaftaran berhasil! Silakan login.");
            this.$router.push('/login');
          } else {
            alert(data.message || "Terjadi kesalahan.");
          }
        })
        .catch(err => {
          console.error(err);
          alert("Gagal mengirim data ke server.");
        });
    }
  }
};
</script>

<style scoped>
.register-box {
  max-width: 500px;
  margin: 80px auto;
  background: #f8f9fa;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.btn-green {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px;
  font-weight: bold;
  border-radius: 6px;
}

.btn-green:hover {
  background-color: #218838;
}
</style>
