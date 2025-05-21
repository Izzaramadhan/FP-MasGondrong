<template>
  <div class="cara-sewa-page">
    <h1 class="title">Cara Sewa Kendaraan</h1>
    <div class="steps">
      <div class="step" v-for="(langkah, i) in langkahSewa" :key="i">
        <div class="step-number">{{ i + 1 }}</div>
        <h2 class="step-title">{{ langkah.judul }}</h2>
        <p class="step-desc">{{ langkah.deskripsi }}</p>
      </div>
    </div>
  </div>
</template>