<template>
  <div class="login-form">
    <h2>Connexion</h2>
    <form @submit.prevent="login" :class="{ 'loading': loading }">
      <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de passe:</label>
        <input id="password" type="password" v-model="password" required>
      </div>
      <button type="submit" class="btn-submit" :disabled="loading">Se connecter</button>
    </form>
    <p class="mt-3">Pas encore inscrit? <router-link to="/register">Inscrivez-vous ici</router-link></p>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
//import axios from 'axios';

export default {
  name: 'LoginForm',
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      
      error: ''
    };
  },
  methods: {
    async login() {
      this.loading = true;
      this.error = '';

      
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
