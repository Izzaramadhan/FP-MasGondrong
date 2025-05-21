<template>
  <div class="container mt-5">
    <div class="login-box">
      <h4 class="text-center mb-4">Edit Profil Pembeli</h4>
      <form @submit.prevent="submitForm">
        <div class="mb-3" v-for="(field, index) in fields" :key="index">
          <label>{{ field.label }}</label>
          <component :is="field.type === 'textarea' ? 'textarea' : 'input'"
                     class="form-control"
                     :type="field.inputType"
                     v-model="form[field.model]"
                     :rows="field.rows || null" />
        </div>
        <button type="submit" class="btn btn-green w-100">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</template>