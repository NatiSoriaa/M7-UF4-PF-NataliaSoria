<template>
  <div class="container">
    <h2>Registro</h2>
    <form @submit.prevent="register">
      <div>
        <label>Nombre:</label>
        <input type="text" v-model="name" required />
      </div>
      <div>
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label>Contraseña:</label>
        <input type="password" v-model="password" required />
      </div>
      <div>
        <label>Confirmar Contraseña:</label>
        <input type="password" v-model="password_confirmation" required />
      </div>
      <div>
        <label>Rol:</label>
        <select v-model="role" required>
          <option value="user">Usuario</option>
          <option value="admin">Administrador</option>
        </select>
      </div>
      <button type="submit">Registrarse</button>
    </form>
    <p v-if="errorMessage" style="color:red;">{{ errorMessage }}</p>
    <p v-if="successMessage" style="color:green;">{{ successMessage }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '', // Cambiado de confirmPassword a password_confirmation
      role: 'user', // Valor predeterminado del rol
      errorMessage: '',
      successMessage: '',
    };
  },
  methods: {
    async register() {
      try {
        // Solicitar el CSRF token de Sanctum
        const csrfResponse = await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
        if (!csrfResponse.ok) {
          throw new Error('Error al obtener el token CSRF.');
        }

        // Enviar datos de registro al backend
        const res = await fetch('/api/register', {
          method: 'POST',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation, // Enviar el campo correcto
            role: this.role,
          }),
        });

        const data = await res.json();

        if (res.ok) {
          this.successMessage = 'Usuario registrado con éxito.';
          this.errorMessage = '';
          this.name = '';
          this.email = '';
          this.password = '';
          this.password_confirmation = '';
          this.role = 'user';
        } else {
          this.errorMessage = data.message || 'Error al registrar el usuario.';
          this.successMessage = '';
        }
      } catch (error) {
        this.errorMessage = 'Error de red o problema con el servidor.';
        this.successMessage = '';
      }
    },
  },
};
</script>