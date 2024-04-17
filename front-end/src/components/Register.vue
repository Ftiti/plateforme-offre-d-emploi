<template>
  <div class="register-form">
    <h2>Inscription</h2>
    <form @submit.prevent="register" :class="{ 'loading': loading }">
      <div class="form-group">
        <label for="name">Nom:</label>
        <input id="name" type="text" v-model="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe:</label>
        <input id="password" type="password" v-model="password" required>
      </div>
      <button type="submit" class="btn-submit" :disabled="loading">S'inscrire</button>
    </form>
    <p class="mt-3">Déjà inscrit?<router-link to="/login">Se connecter</router-link></p>
    <p v-if="error" class="error">{{ error }}</p>
    <p v-if="success" class="success">{{ success }}</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Register', // eslint-disable-line vue/multi-word-component-names
  data() {
    return {
      name: '',
      email: '',
      password: '',
      loading: false,
      error: '',
      success: ''
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.error = '';
      this.success = '';

      try {
        const response = await axios.post('http://localhost:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password
        });
        this.success = response.data.message;
        this.resetForm();
      } catch (error) {
        this.error = error.response.data.message || 'Erreur lors de l\'inscription';
      } finally {
        this.loading = false;
      }
    },
    resetForm() {
      this.name = '';
      this.email = '';
      this.password = '';
    }
  }
};
</script>

<style scoped>
.register-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.btn-submit {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #007bff;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
}

.btn-submit:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.error {
  color: red;
}

.success {
  color: green;
}
</style>
