template>
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
        Bethisum punya akun?
        <router-link to="/register" class="text-decoration-none">Daftar Disini</router-link>
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
      console.log('Login dengan:', this.email, this.password);
      alert('Login berhasil (simulasi)');
    }
  }
};
</script>