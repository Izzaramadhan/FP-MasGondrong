<template>
  <footer class="footer">
    <div class="footer-container">
      <!-- Kolom Logo dan Kontak -->
      <div class="footer-column">
        <img src="@/assets/images/logobaru2.png" alt="Logo" class="footer-logo" />
        <p>MasGondrongrent@gmail.com</p>
        <p>+62 917-134-1422</p>
        <p>@MasGondrongrent</p>
      </div>

      <!-- Kolom Support -->
      <div class="footer-column">
        <h2>Support</h2>
        <a href="#">Hubungi Kami</a>
        <a href="#">Customer Service</a>
      </div>

      <!-- Kolom Company -->
      <div class="footer-column">
        <h2>Company</h2>
        <a href="#">Tentang Kami</a>
        <a href="#">Affiliates</a>
        <a href="#">Partnership</a>
      </div>

      <!-- Kolom Newsletter -->
      <div class="footer-column">
        <h2>Newsletters</h2>
        <p>Masukkan Email Anda Untuk Info Dan Update Terbaru!</p>
        <input type="email" placeholder="Your Email Address" class="newsletter" />
      </div>
    </div>

    <hr />
    <div class="credit">
      Mas Gondrong Rent © 2025 | All Rights Reserved.
    </div>
  </footer>
</template>

<script>
export default {
  name: 'AppFooter'
}
</script>