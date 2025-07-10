<template>

  <div class="wrapper layout-fixed layout-navbar-fixed sidebar-mini">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand custom-navbar">

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <span class="nav-link font-weight-bold">MasGondrong Rent - ADMIN</span>
        </li>
      </ul>

      <!-- Right navbar -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <button v-if="isLoggedIn" @click="logout" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img
          src="@/assets/images/navbar/logobaru2.png"
          alt="Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: .8"
        />
        <span class="brand-text font-weight-light">Admin MasGondrong</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
            <li class="nav-item">
              <router-link to="/admin/kendaraan" class="nav-link" exact>
                <i class="nav-icon fas fa-car"></i>
                <p>Kelola Kendaraan</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pemesanan" class="nav-link" exact>
                <i class="nav-icon fas fa-book"></i>
                <p>Kelola Pemesanan</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pembayaran" class="nav-link" exact>
                <i class="nav-icon fas fa-credit-card"></i>
                <p>Kelola Pembayaran</p>
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/admin/pengguna" class="nav-link" exact>
                <i class="nav-icon fas fa-users"></i>
                <p>Kelola Pengguna</p>
              </router-link>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <slot />
    </div>
  </section>
</div>
</template>

<script>
export default {
  props: {
    navbarColor: {
      type: String,
      default: '#4B0082' // Default warna ungu tua (Indigo)
    }
  },
  computed: {
    isLoggedIn() {
      return !!localStorage.getItem('isLoggedIn');
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('isLoggedIn');
      this.$router.push('/login');
    }
  }
};

</script>

<style scoped>
.brand-image {
  width: 35px;
  height: 35px;
}
.custom-navbar {
  background-color: #53c9f5;
  color: white;
  height: 70px; /* default sekitar 56px, jadi lebih tinggi */
  font-size: 1.4rem; /* perbesar font di navbar */
  display: flex;
  align-items: center; /* pastikan isi vertikal tengah */
}

.custom-navbar .nav-link {
  color: white;
  font-size: 1.4rem;

}

.custom-navbar .btn {
  font-size: 1rem;
}
.sidebar .nav-link p,
.sidebar .nav-link i {
  font-size: 1.05rem; /* Teks di sidebar */
}

.sidebar .nav-link {
  padding: 10px 15px;
}

body {
  margin: 0 !important;
  padding: 0 !important;
}
/* Pastikan wrapper tidak menyebabkan overflow horizontal */
.wrapper {
  width: 100%;
  max-width: 100vw;
  overflow-x: hidden;
  display: flex;
  flex-direction: column;
}

/* Tambahkan padding kiri agar konten tidak tertutup sidebar */
.content-wrapper {
  padding-top: 50px;
  padding-left: 200px;   /* Tambahkan ini */
  padding-right: 20px;  /* Tambahkan ini */
  min-height: 100vh;
  box-sizing: border-box;
}


/* Agar layout header tetap responsif dan tidak "nabrak" */
.content-header .d-flex {
  flex-wrap: wrap;
  gap: 1rem;
}

/* Jika tombol menghilang di layar kecil */
@media (max-width: 576px) {
  .content-header .btn {
    width: 100%;
  }
}


/* Navbar tetap fixed, tapi jangan menutupi konten */
.main-header {
  top: 0;
  position: fixed;
  width: 100%;
  z-index: 1030;
}



/* Kontainer konten menyesuaikan ruang setelah sidebar */
.content {
  margin-left: 250px; /* offset untuk sidebar */
}

/* Atur kartu/tabel agar tidak overflow */
.card {
  width: 100%;
  max-width: 100%;
  overflow-x: auto;
}

/* Ukuran kotak menu sidebar */
/* Perbesar area klik dan tinggi tiap menu */
.sidebar .nav-sidebar > .nav-item > .nav-link {
  padding-top: 16px !important;
  padding-bottom: 16px !important;
  padding-left: 20px !important;
  font-size: 1.2rem !important;
  height: auto !important;
  line-height: 1.6 !important;
}

/* Perbesar ikon menu */
.sidebar .nav-sidebar > .nav-item > .nav-link i.nav-icon {
  font-size: 1.4rem !important;
  margin-right: 12px;
}

/* Perbesar teks menu */
.sidebar .nav-sidebar > .nav-item > .nav-link p {
  font-size: 1.2rem !important;
  margin: 0;
}

/* Tambahan agar menu lebih "lega" dan enak dilihat */
.sidebar .nav-sidebar > .nav-item {
  margin-bottom: 8px;
}
.content-header {
  padding-left: 260px; /* supaya sejajar dengan konten */
}


</style>
