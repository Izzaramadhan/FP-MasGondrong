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
        <router-link to="/adminlogin" class="text-decoration-none">Klik Disini</router-link>
      </p>
    </div>
  </div>
</template>

<script>
import api from '@/api';

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
      api.post('auth/login', {
        email: this.email,
        password: this.password
      })
      .then(res => {
        const data = res.data;
        if (data.status === 'success') {
          alert('Login berhasil');

          localStorage.setItem('user', JSON.stringify(data.user));
          localStorage.setItem('userLoggedIn', 'true');
          window.dispatchEvent(new Event('user-login-changed'));
          this.$router.push('/');
        } else {
          alert('Email atau password salah!');
        }
      })
      .catch(err => {
        console.error('Login error:', err);
        alert('Terjadi kesalahan saat login. Silakan coba lagi.');
      });
    }
  }
};
</script>

<style scoped>
/* tambahkan style jika perlu */
</style>
