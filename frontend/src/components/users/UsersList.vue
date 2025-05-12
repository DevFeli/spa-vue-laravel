<template>
  <div class="mt-8 max-w-6xl w-full">
    <div
      class="border-b border-b-green-500 mb-4 flex justify-between py-1 items-end"
    >
      <h2 class="text-2xl text-white">Usuários</h2>
      <router-link
        to="/users/create"
        class="bg-green-500 px-4 py-2 rounded-lg text-xl text-black hover:bg-green-700 hover:text-white"
      >
        +
      </router-link>
    </div>

    <div v-if="loading" class="text-[#42b883] animate-pulse">
      Carregando usuários...
    </div>

    <div v-else>
      <div v-if="users.length === 0" class="text-white">
        Nenhum usuário encontrado.
      </div>

      <table v-else class="min-w-full bg-[#2E2E2E] rounded-lg overflow-hidden">
        <thead>
          <tr class="text-left text-white bg-[#3A3A3A]">
            <th class="p-3">Nome</th>
            <th class="p-3">Email</th>
            <th class="p-3 text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <UsersRow
            v-for="user in users"
            :key="user.id"
            :user="user"
            @reload="reload"
          />
        </tbody>
      </table>

      <!-- pagination -->
      <div class="mt-4 flex justify-center gap-5" v-if="users.length > 0">
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
import UsersRow from './UsersRow.vue'

const users = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const loading = ref(true);

const fetchProducts = async (page = 1) => {
  loading.value = true;
  try {
    const { data } = await apiService.get(`/users?page=${page}`);
    users.value = data.data;
    currentPage.value = data.current_page;
    lastPage.value = data.last_page;
  } catch (error) {
    console.error("Erro ao buscar usuários:", error);
  } finally {
    loading.value = false;
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchProducts(page);
  }
};

function reload(){
    console.log('reload')
    fetchProducts();
}

onMounted(() => {
  fetchProducts();
});
</script>