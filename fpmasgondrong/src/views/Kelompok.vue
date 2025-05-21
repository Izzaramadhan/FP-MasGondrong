<template>
  <div class="kelompok-page">
    <h1 class="title">Anggota Kelompok</h1>
    <div class="card-container">
      <div class="card" v-for="(anggota, index) in anggotaKelompok" :key="index">
        <img :src="require(`@/assets/images/${anggota.foto}`)" :alt="anggota.nama" class="product-img" />
        <h3>{{ anggota.nama }}</h3>
        <h4>{{ anggota.nim }}</h4>
        <p>{{ anggota.deskripsi }}</p>
      </div>
    </div>
  </div>
</template>