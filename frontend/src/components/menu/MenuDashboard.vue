<template>
  <header class="bg-[#3c9b7c] p-4 flex justify-between items-center">
    <div class="text-white text-xl font-semibold">
      Bem-vindo, {{ userName }}
    </div>
    <div class="flex gap-3">
      <router-link to="/dashboard"
        class="px-4 py-2 bg-slate-700 text-white rounded-md hover:bg-slate-900 transition duration-200 font-semibold"
      >
        Dashboard
      </router-link>
      <router-link to="/users"
        class="px-4 py-2 bg-slate-700 text-white rounded-md hover:bg-slate-900 transition duration-200 font-semibold"
      >
        Usuários
      </router-link>
      <router-link to="/logs"
        class="px-4 py-2 bg-slate-700 text-white rounded-md hover:bg-slate-900 transition duration-200 font-semibold"
      >
        Logs
      </router-link>
      <button
        @click="logout"
        class="px-4 py-2 bg-slate-700 text-white rounded-md hover:bg-slate-900 transition duration-200 font-semibold"
      >
        Logout
      </button>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth.js";

const auth = useAuthStore();

const userName = ref(auth?.user?.firstName);

function logout() {
  console.log("Usuário deslogado");

  window.location.href = "/";
}
</script>