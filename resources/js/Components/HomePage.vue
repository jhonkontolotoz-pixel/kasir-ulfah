<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6 center-screen">
        <div class="card animated fadeIn w-90 p-4 text-center">

          <h2>{{ appName }}</h2>
          <p>{{ appDescription }}</p>

          <div class="mt-4">
            <!-- Tombol utama -->
            <button @click="goLogin" class="btn main-btn w-100 mb-2">Mulai</button>
            <button @click="showAbout = true" class="btn main-btn w-100">About</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal About -->
    <div v-if="showAbout" class="modal-backdrop" @click="showAbout=false">
      <div class="modal-card p-4 animated fadeIn" @click.stop>
        <h4>About Aplikasi</h4>
        <p class="neon-text">
          Aplikasi Point of Sale berbasis Vue + Laravel. Kelola produk, kategori, customer, penjualan, dan laporan secara mudah.
        </p>
        <button class="btn modal-close-btn mt-3" @click="showAbout=false">Tutup</button>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const showAbout = ref(false);

const appName = "POS Software";

const goLogin = () => {
  router.push('/login');
};
</script>

<style scoped>
.center-screen { 
  height: 100vh; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
}

.card {
  border-radius: 12px;
  box-shadow: 0 0 15px rgba(0,0,0,0.2);
  padding: 30px;
}

/* Tombol utama (Mulai & About) */
.main-btn {
  background-color: #007bff; /* biru solid */
  color: white;
  font-weight: normal;
  border: none;
  padding: 12px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  transition: all 0.2s ease-in-out;
  border-radius: 6px;
}

.main-btn:hover {
  background-color: #0056b3; /* biru lebih gelap saat hover */
  box-shadow: 0 6px 10px rgba(0,0,0,0.3);
  transform: translateY(-2px);
}

/* Modal */
.modal-backdrop { 
  position: fixed; 
  top:0; left:0; width:100%; height:100%; 
  background: rgba(0,0,0,0.6); 
  display:flex; 
  align-items:center; 
  justify-content:center; 
  z-index: 1000;
}

.modal-card { 
  background:black; 
  border-radius:12px; 
  max-width:400px; 
  width:90%; 
  text-align: center;
  padding: 20px;
  box-shadow: 0 0 20px rgba(0,0,0,0.5);
}

/* Neon tipis untuk teks modal */
.neon-text {
  color: #00ffff; 
  text-shadow: 0 0 3px #00ffff, 0 0 6px #00ffff;
  font-weight: normal;
}

/* Tombol Tutup modal */
.modal-close-btn {
  background-color: #007bff; /* biru solid */
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 6px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.2);
  transition: all 0.2s ease-in-out;
}

.modal-close-btn:hover {
  background-color: #0056b3;
  box-shadow: 0 6px 10px rgba(0,0,0,0.3);
  transform: translateY(-2px);
}
</style>



