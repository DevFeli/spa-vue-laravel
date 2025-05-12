<template>
  <div class="bg-[#1E1E1E] h-screen">
    <Menu />
    <div class="px-8 py-6 text-white">
      <h2 class="text-3xl font-bold text-center mb-2">Editar Usuário</h2>
      <p class="text-center text-gray-300 mb-8">
        Preencha os dados abaixo para editar o usuário.
      </p>

      <form
        @submit.prevent="submitForm"
        class="space-y-6 max-w-xl mx-auto bg-[#1f1f1f] p-6 rounded-xl shadow-md border border-[#2e2e2e]"
      >
        <div>
          <label class="block mb-1 text-gray-300">Nome</label>
          <input
            v-model="form.first_name"
            type="text"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300">Sobre nome</label>
          <input
            v-model="form.last_name"
            type="text"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300">E-mail</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300">Senha</label>
          <input
            v-model="form.password"
            type="text"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <button
          type="submit"
          class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded w-full font-semibold transition-all duration-300"
          :disabled="loading"
        >
          {{ loading ? "Salvando..." : "Salvar Produto" }}
        </button>

        <div v-if="error" class="text-red-400 text-center mt-4">
          {{ error }}
        </div>
        <div v-if="success" class="text-green-400 text-center mt-4">
          Usuário adicionado com sucesso!
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import Menu from "@/components/menu/MenuDashboard.vue";
import { ref } from "vue";
import apiService from "@/services/apiService";
import { usersStore } from '@/stores/user.js'
import { useRouter } from "vue-router";

const router = useRouter();
const useStore = usersStore()

const form = ref({
  first_name: useStore.user.first_name,
  last_name: useStore.user.last_name,
  email: useStore.user.email,
  id: useStore.user.id,
  password: "",
});

const loading = ref(false);
const error = ref("");
const success = ref(false);

async function submitForm() {
  loading.value = true;
  error.value = null;
  success.value = false;

  const formData = new FormData();
  formData.append("first_name", form.value.first_name);
  formData.append("last_name", form.value.last_name);
  formData.append("email", form.value.email);
  formData.append("password", form.value.password);
  formData.append("id", form.value.id);

  try {
    const { data } = await apiService.put("/users", formData);

    alert("Usuário Atualizado com sucesso!");
    router.push("/users");
  } catch (error) {
    if (error?.response?.status == 401) {
      alert("Sua sessão expirou, por favor faça login novamente!");
      router.push("/login");
    }
    alert("Houve algum erro inexperado, tente novamente mais tarde.");
  }
}
</script>