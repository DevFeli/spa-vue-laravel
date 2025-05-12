<template>
  <tr class="border-t border-[#444] text-white hover:bg-[#383838]">
    <td class="p-3">
      <img
        :src="product.images[0]?.url"
        alt="Imagem do produto"
        class="w-16 h-16 object-cover rounded"
      />
    </td>
    <td class="p-3">{{ product.title }}</td>
    <td class="p-3">R$ {{ product.cost_price }}</td>
    <td class="p-3">R$ {{ product.sale_price }}</td>
    <td class="p-3" v-html="product.description"></td>
    <td class="p-3 space-x-2 text-center">
      <button
        @click="handleEdit"
        class="bg-yellow-500 hover:bg-yellow-600 px-3 py-1 rounded text-sm"
      >
        Editar
      </button>
      <button
        :disabled="!inactive"
        @click="handleInactive(product.id)"
        class="px-3 py-1 rounded text-sm"
        :class="!inactive ? 'bg-gray-600' : 'bg-red-600 hover:bg-red-700'"
      >
        {{ !inactive ? "Inativo" : "Inativar" }}
      </button>
    </td>
  </tr>
</template>

<script setup>
import apiService from "@/services/apiService";
import { useProductStore } from "@/stores/product.js";
import { ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const productStore = useProductStore();

const props = defineProps({
  product: Object,
});

const inactive = ref(props.product.is_active);

async function handleInactive(id) {
  if (window.confirm("Tem certeza que deseja inativar o item?")) {
    try {
      const { data } = apiService.put("/products", {
        id,
        is_active: 0,
      });
      alert("Produto desativado com sucesso!");
      inactive.value = false;
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
  productStore.setProduct(props.product);
  router.push('/products/edit');
}
</script>