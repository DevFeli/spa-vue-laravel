<template>
  <div class="mt-8 max-w-6xl w-full">
    <div
      class="border-b border-b-green-500 mb-4 flex justify-between py-1 items-end"
    >
      <h2 class="text-2xl text-white">Produtos</h2>
      <router-link
        to="/products/create"
        class="bg-green-500 px-4 py-2 rounded-lg text-xl text-black hover:bg-green-700 hover:text-white"
      >
        +
      </router-link>
    </div>

    <div v-if="loading" class="text-[#42b883] animate-pulse">
      Carregando produtos...
    </div>

    <div v-else>
      <div v-if="products.length === 0" class="text-white">
        Nenhum produto encontrado.
      </div>

      <table v-else class="min-w-full bg-[#2E2E2E] rounded-lg overflow-hidden">
        <thead>
          <tr class="text-left text-white bg-[#3A3A3A]">
            <th class="p-3">Imagem</th>
            <th class="p-3">Título</th>
            <th class="p-3">Custo</th>
            <th class="p-3">Preço de Venda</th>
            <th class="p-3">Descrição</th>
            <th class="p-3 text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <ProductRow
            v-for="product in products"
            :key="product.id"
            :product="product"
          />
        </tbody>
      </table>

      <!-- pagination -->
      <div class="mt-4 flex justify-center gap-5" v-if="products.length > 0">
        <button
          @click="changePage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          Anterior
        </button>

        <button
          @click="changePage(currentPage + 1)"
          :disabled="currentPage === lastPage"
          class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
        >
          Próxima
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiService from "@/services/apiService.js";
import ProductRow from "./ProductRow.vue";

const products = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const loading = ref(true);

const fetchProducts = async (page = 1) => {
  loading.value = true;
  try {
    const { data } = await apiService.get(`/products?page=${page}`);
    products.value = data.data;
    currentPage.value = data.current_page;
    lastPage.value = data.last_page;
  } catch (error) {
    console.error("Erro ao buscar produtos:", error);
  } finally {
    loading.value = false;
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchProducts(page);
  }
};

onMounted(() => {
  fetchProducts();
});
</script>