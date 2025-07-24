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
      { nama: "Hanjaya Hartono", nim: "23.11.5449", deskripsi: "Backend Developer (Laravel)", foto: "Anggota1.jpg" },
      { nama: "Alfin Nabil", nim: "23.11.5461", deskripsi: "Desain Ui/Ux (Figma) & Quality Assurance (Tester)", foto: "anggota2.jpeg" },
      { nama: "Danang Wijayanto", nim: "23.11.5468", deskripsi: "Frontend Developer (Membuat tampilan antarmuka pengguna (UI) untuk halaman)", foto: "anggota3.jpeg" },
      { nama: "Izzuddin Akmal Daffani Ramadhan",  nim: "23.11.5483",deskripsi: "Database Administrator (Mysql)", foto: "anggota4.jpeg" },
      { nama: "Ahmad Baihaqi",  nim: "23.11.5497",deskripsi: "Frontend Developer (Menyambungkan frontend dengan backend via fetch/axios)", foto: "anggota5.jpeg" }
    ];
    return { anggotaKelompok };
  }
};
</script>

<style scoped>
</style>