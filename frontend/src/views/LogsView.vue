<template>
  <div class="bg-[#1E1E1E] h-screen">
    <Menu />
    <div class="mt-8 max-w-6xl w-full m-auto">
      <div
        class="border-b border-b-green-500 mb-4 flex justify-between py-1 items-end"
      >
        <h2 class="text-2xl text-white">Logs</h2>
      </div>

      <div v-if="loading" class="text-[#42b883] animate-pulse">
        Carregando logs...
      </div>

      <div v-else>
        <div v-if="logs.length === 0" class="text-white">
          Nenhum log encontrado.
        </div>

        <table
          v-else
          class="min-w-full bg-[#2E2E2E] rounded-lg overflow-hidden"
        >
          <thead>
            <tr class="text-left text-white bg-[#3A3A3A]">
              <th class="p-3">#ID DO USUÁRIO</th>
              <th class="p-3">TIPO</th>
              <th class="p-3 text-center">ROTA</th>
            </tr>
          </thead>
          <tbody>
            <LogsRow v-for="log in logs" :key="log.id" :log="log" />
          </tbody>
        </table>

        <!-- pagination -->
        <div class="mt-4 flex justify-center gap-5" v-if="logs.length > 0">
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
  </div>
</template>

<script setup>
import Menu from "@/components/menu/MenuDashboard.vue";
import { ref, onMounted } from "vue";
import apiService from "@/services/apiService.js";
import LogsRow from "@/components/logs/LogsRow.vue";

const logs = ref([]);
const currentPage = ref(1);
const lastPage = ref(1);
const loading = ref(true);

const fetchLogs = async (page = 1) => {
  loading.value = true;
  try {
    const { data } = await apiService.get(`/logs?page=${page}`);
    logs.value = data.data;
    currentPage.value = data.current_page;
    lastPage.value = data.last_page;
  } catch (error) {
    console.error("Erro ao buscar logs:", error);
  } finally {
    loading.value = false;
  }
};

const changePage = (page) => {
  if (page >= 1 && page <= lastPage.value) {
    fetchLogs(page);
  }
};

onMounted(() => {
  fetchLogs();
});
</script>