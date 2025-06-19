<template>
  <div class="container">
    <div class="login-box">
      <h4 class="text-center mb-4">Login Pembeli</h4>

      <form @submit.prevent="handleLogin">
        <div class="mb-3">
          <label>Email</label>
          <input v-model="email" type="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="password" type="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-green w-100">Login</button>
      </form>

      <p class="text-center mt-3">
        Belum punya akun?
        <router-link to="/register" class="text-decoration-none">Daftar Disini</router-link>
      </p>
      <p class="text-center mt-3">
        Login sebagai Admin?
        <router-link to="/adminlogin" class="text-decoration-none">Klik  Disini</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
handleLogin() {
  fetch('http://localhost/1/backend/index.php/auth/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: this.email,
      password: this.password
    })
  })
  .then(res => res.json())
  .then(data => {
  if (data.status === 'success') {
    alert('Login berhasil');

    // Simpan ke localStorage
localStorage.setItem('user', JSON.stringify(data.user));


    // TAMBAHKAN BARIS INI:
    localStorage.setItem('userLoggedIn', 'true');
    window.dispatchEvent(new Event('user-login-changed')); // agar header tahu

    this.$router.push('/');
  }

  });
}

  }
};
</script>

<style scoped>

</style>