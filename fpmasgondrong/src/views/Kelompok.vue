<template>
  <div class="kelompok-page">
    <h1 class="title">Anggota Kelompok</h1>
    <div class="card-container">
      <div class="card" v-for="(anggota, index) in anggotaKelompok" :key="index">
        <img :src="require(`@/assets/images/anggota/${anggota.foto}`)" :alt="anggota.nama" class="product-img" />
        <h3>{{ anggota.nama }}</h3>
        <h4>{{ anggota.nim }}</h4>
        <p>{{ anggota.deskripsi }}</p>
      </div>
    </div>
  </div>
</template>

  //Menampilkan nama, NIM, dan deskripsi masing-masing
<script>
export default {
  name: "KelompokPage",
  setup() {
    const anggotaKelompok = [
      { nama: "Izzuddin Akmal Daffani Ramadhan", nim: "23.11.5483", deskripsi: "Anggota", foto: "anggota1.jpeg" },
      { nama: "Ahmad Baihaqi", nim: "23.11.5497", deskripsi: "Anggota", foto: "anggota2.jpeg" },
      { nama: "Danang Wijayanto", nim: "23.11.5468", deskripsi: "Anggota", foto: "anggota3.jpeg" },
      { nama: "Alfin Nabil",  nim: "23.11.5461",deskripsi: "Anggota", foto: "anggota4.jpeg" },
      { nama: "Hanjaya Hartono",  nim: "23.11.5449",deskripsi: "Anggota", foto: "anggota5.jpeg" }
    ];
    return { anggotaKelompok };
  }
};
</script>

<style scoped>
</style>