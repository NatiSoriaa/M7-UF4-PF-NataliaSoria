import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
        tailwindcss(),
    ],
    
    resolve: {
      alias: {
        vue: 'vue/dist/vue.esm-bundler.js',
        '@': path.resolve(__dirname, 'resources/js'),
      },
    },

    server: {
      proxy: {
        '/api': 'http://localhost', // Asegúrate de que las rutas de la API estén bien configuradas
      },
    },
});

// export default defineConfig({
//     plugins: [vue()],
//     resolve: {
//       alias: {
//         vue: 'vue/dist/vue.esm-bundler.js',
//         '@': path.resolve(__dirname, 'resources/js'),
//       },
//     },
//   });


  // OPCION 2

//   // frontend/vite.config.js
// import { defineConfig } from 'vite'
// import vue from '@vitejs/plugin-vue'

// export default defineConfig({
//   plugins: [vue()],
//   server: {
//     proxy: {
//       '/api': {
//         target: 'http://localhost:8080', // port del backend Laravel
//         changeOrigin: true,
//         rewrite: path => path.replace(/^\/api/, '')
//       }
//     }
//   }
// })

