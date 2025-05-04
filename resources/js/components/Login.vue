<template>
  <div class="container">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Contraseña:</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Iniciar sesión</button>
    </form>
    <p v-if="errorMessage" style="color:red;">{{ errorMessage }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    async login() {
      try {
        // Solicitar el CSRF token de Sanctum
        await fetch('/sanctum/csrf-cookie', { credentials: 'include' });

        const res = await fetch('/api/login', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ email: this.email, password: this.password }),
        });

        const data = await res.json();

        if (res.ok) {
          localStorage.setItem('token', data.token); // Guarda el token
          window.location.href = '/products'; // Redirige a la página de productos
        } else {
          this.errorMessage = data.message || 'Error al iniciar sesión.';
        }
      } catch (error) {
        this.errorMessage = 'Error de red.';
      }
    },
  },
};
</script>
