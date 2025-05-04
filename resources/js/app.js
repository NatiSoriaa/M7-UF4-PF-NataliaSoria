import { createApp } from 'vue';
import Login from './components/Login.vue';
import ProductList from './components/ProductList.vue';
import axios from 'axios';

// Configurar Axios para usar el token automáticamente si existe
const token = localStorage.getItem('token');
if (token) {
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}
axios.defaults.withCredentials = true; // Necesario para Sanctum

// Crear la app Vue
const app = createApp({});

// Registrar componentes Vue globalmente
app.component('login', Login);
app.component('product-list', ProductList);

// Montar la app en el div con id="app"
app.mount('#app');
