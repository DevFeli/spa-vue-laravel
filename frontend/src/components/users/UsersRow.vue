<template>
  <tr class="border-t border-[#444] text-white hover:bg-[#383838]">
    <td class="p-3">{{ user.first_name }} {{ user.last_name }}</td>
    <td class="p-3">{{ user.email }}</td>
    <td class="p-3 space-x-2 text-center">
      <button
        @click="handleEdit"
        class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm"
      >
        Editar
      </button>
      <button
        @click="handleDelete(user.id)"
        class="px-3 py-1 rounded text-sm bg-red-600 hover:bg-red-700"
      >
        Excluir
      </button>
    </td>
  </tr>
</template>

<script setup>
import apiService from "@/services/apiService";
import { ref } from "vue";
import { useRouter } from "vue-router";
import { usersStore } from "@/stores/user.js";
const userStore = usersStore();
const router = useRouter();

const props = defineProps({
  user: Object,
});

const emit = defineEmits(["reload"]);

function handleReload() {
  emit("reload");
}

async function handleDelete(id) {
  if (window.confirm("Tem certeza que deseja excluir o usuário?")) {
    try {
      const { data } = await apiService.delete(`/users/${id}`);
      alert("Usuário deletado sucesso!");
      handleReload();
    } catch (error) {
      console.log(error);
      if (error?.response?.status == 401) {
        alert("Sua sessão expirou, por favor faça login novamente!");
        router.push("/login");
      }
      alert("Houve algum erro inexperado, tente novamente mais tarde.");
    }
  }
}

function handleEdit() {
  userStore.setUser(props.user);
  router.push('/users/edit');
}
</script>