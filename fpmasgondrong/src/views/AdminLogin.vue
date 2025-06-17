<template>
  <div class="container">
    <div class="login-box">
      <h4 class="text-center mb-4">Login Admin</h4>

      <form @submit.prevent="login">
        <div class="mb-3">
          <label>Username</label>
          <input v-model="username" type="text" class="form-control" required />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input v-model="password" type="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-green w-100">Login</button>
      </form>

      <p class="text-center mt-3">
        Login sebagai pembeli?
        <router-link to="/login" class="text-decoration-none">Klik di sini</router-link>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdminLogin',
  data() {
    return {
      username: '',
      password: ''
    }
  },
  methods: {
    login() {
      if (this.username === 'admin' && this.password === 'admin123') {
        localStorage.setItem('isAdmin', true)
        localStorage.setItem('userLoggedIn', 'true')
        window.dispatchEvent(new Event('user-login-changed'))
        this.$router.push('/admin/dashboard')
      } else {
        alert('Login gagal')
      }
    }
  }
}
</script>
