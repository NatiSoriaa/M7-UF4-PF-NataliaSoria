<template>
  <div>
    <h2>Lista de Productos</h2>

    <!-- Botón solo para admin -->
    <div v-if="isAdmin">
      <button @click="showCreateForm = true">Nuevo Producto</button>
    </div>

    <table>
      <thead>
        <tr>
          <th @click="sortProducts('name')">Nombre</th>
          <th @click="sortProducts('price')">Precio</th>
          <th v-if="isAdmin">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in sortedProducts" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ product.price }}</td>
          <td v-if="isAdmin">
            <button @click="openEditForm(product)">Editar</button>
            <button @click="deleteProduct(product.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Formulario para crear producto -->
    <div v-if="showCreateForm">
      <form @submit.prevent="createProduct">
        <label>Nombre:</label>
        <input v-model="newProduct.name" required />
        <label>Precio:</label>
        <input v-model.number="newProduct.price" required />
        <button type="submit">Crear Producto</button>
        <button type="button" @click="showCreateForm = false">Cancelar</button>
      </form>
    </div>

    <!-- Formulario para editar producto -->
    <div v-if="showEditForm">
      <form @submit.prevent="updateProduct">
        <label>Nombre:</label>
        <input v-model="currentProduct.name" required />
        <label>Precio:</label>
        <input v-model.number="currentProduct.price" required />
        <button type="submit">Guardar Cambios</button>
        <button type="button" @click="closeEditForm">Cancelar</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
      sortedBy: 'name',
      newProduct: {
        name: '',
        price: ''
      },
      currentProduct: {
        id: null,
        name: '',
        price: ''
      },
      showCreateForm: false,
      showEditForm: false,
      isAdmin: false,
    };
  },
  computed: {
    sortedProducts() {
      return this.products.slice().sort((a, b) => {
        if (this.sortedBy === 'name') {
          return a.name.localeCompare(b.name);
        }
        return a.price - b.price;
      });
    }
  },
  mounted() {
    this.fetchProducts();
    this.checkUserRole();
  },
  methods: {
    async fetchProducts() {
      try {
        const res = await axios.get('/api/products');
        this.products = res.data;
      } catch (error) {
        console.error('Error al obtener productos:', error);
      }
    },
    async checkUserRole() {
      try {
        const res = await axios.get('/api/user');
        this.isAdmin = res.data.role === 'admin';
      } catch (error) {
        console.error('Error al verificar rol:', error);
      }
    },
    sortProducts(field) {
      this.sortedBy = field;
    },
    async createProduct() {
      try {
        const res = await axios.post('/api/products', this.newProduct);
        this.products.push(res.data);
        this.newProduct = { name: '', price: '' };
        this.showCreateForm = false;
      } catch (error) {
        console.error('Error al crear producto:', error);
      }
    },
    openEditForm(product) {
      this.currentProduct = { ...product };
      this.showEditForm = true;
    },
    closeEditForm() {
      this.showEditForm = false;
      this.currentProduct = { id: null, name: '', price: '' };
    },
    async updateProduct() {
      try {
        const res = await axios.put(`/api/products/${this.currentProduct.id}`, this.currentProduct);
        const index = this.products.findIndex(p => p.id === this.currentProduct.id);
        if (index !== -1) {
          this.products.splice(index, 1, res.data);
        }
        this.closeEditForm();
      } catch (error) {
        console.error('Error al actualizar producto:', error);
      }
    },
    async deleteProduct(id) {
      try {
        await axios.delete(`/api/products/${id}`);
        this.products = this.products.filter(p => p.id !== id);
      } catch (error) {
        console.error('Error al eliminar producto:', error);
      }
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th {
  cursor: pointer;
  background-color: #eee;
}

td, th {
  border: 1px solid #ccc;
  padding: 8px;
}

form {
  margin-top: 10px;
}
</style>