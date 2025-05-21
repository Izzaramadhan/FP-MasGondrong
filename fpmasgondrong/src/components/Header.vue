<template>
  <header class="header">
    <div class="header-inner d-flex justify-content-between align-items-center">
      <img src="@/assets/images/logobaru2.png" alt="Logo Rental" class="img-logo" />
      <span class="brand">MasGondrong Rent</span>
    </div>

    <div class="right">
      <nav class="navbar">
        <router-link to="/">Beranda</router-link>
        <router-link to="/kelompok">Tentang Kami</router-link>
        <router-link to="/cara-sewa">Cara Sewa</router-link>
      </nav>

      <div class="btn-group">
        <router-link v-if="!isLoggedIn" to="/register" class="btn-pesan">Register</router-link>
        <router-link v-if="!isLoggedIn" to="/login" class="btn-login">Login</router-link>
        <button v-else @click="logout" class="btn-login">Logout</button>
      </div>
    </div>
  </header>
</template>