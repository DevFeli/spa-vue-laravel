<template>
  <div class="bg-[#1E1E1E] h-screen">
    <Menu />
    <div class="px-8 py-6 text-white">
      <h2 class="text-3xl font-bold text-center mb-2">Adicionar Produto</h2>
      <p class="text-center text-gray-300 mb-8">
        Preencha os dados abaixo para cadastrar um novo produto
      </p>

      <form
        @submit.prevent="submitForm"
        class="space-y-6 max-w-xl mx-auto bg-[#1f1f1f] p-6 rounded-xl shadow-md border border-[#2e2e2e]"
      >
        <div>
          <label class="block mb-1 text-gray-300">Nome do Produto</label>
          <input
            v-model="form.name"
            type="text"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300">Preço de Custo</label>
          <input
            v-model.number="form.cost_price"
            type="number"
            step="0.01"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300">Preço de Venda</label>
          <input
            v-model.number="form.sale_price"
            type="number"
            step="0.01"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300"
            >Descrição (aceita tags
            <code>&lt;p&gt;, &lt;br&gt;, &lt;b&gt; e &lt;strong&gt;</code
            >)</label
          >
          <textarea
            @input="sanitizeHtml"
            v-model="form.description"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-gray-300"
            >Imagens do Produto ("Apenas com formato JPG ou PNG")</label
          >
          <input
            type="file"
            accept="image/jpeg, image/png"
            multiple
            @change="handleImageUpload"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
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
          Produto adicionado com sucesso!
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import Menu from "@/components/menu/MenuDashboard.vue";
import { ref } from "vue";
import apiService from "@/services/apiService";
import axios from 'axios';
import { useAuthStore } from '@/stores/auth.js'
const authStore = useAuthStore()

const axiosInstance = axios.create({
    baseURL: 'http://localhost/api',
    headers:{
        'Content-Type': 'multipart/form-data',
        'Authorization': `Bearer ${authStore.token}`,
    }
})

const form = ref({
  name: "",
  sale_price: null,
  cost_price: null,
  description: "",
  images: [],
});

const loading = ref(false);
const error = ref("");
const success = ref(false);

function handleImageUpload(event) {
  const allowedTypes = ["image/jpeg", "image/png"];
  const selectedFiles = Array.from(event.target.files);

  const validFiles = [];
  const invalidFiles = [];

  selectedFiles.forEach((file) => {
    if (allowedTypes.includes(file.type)) {
      validFiles.push(file);
    } else {
      invalidFiles.push(file.name);
    }
  });

  if (invalidFiles.length > 0) {
    alert(
      `Os seguintes arquivos foram ignorados por não serem JPEG ou PNG:\n\n- ${invalidFiles.join(
        "\n- "
      )}`
    );
  }

  form.value.images = validFiles;
}

function handleValidatePrice() {
  const minValue = form.value.cost_price * 1.1;
  if (form.value.sale_price < minValue) {
    alert(`O preço de venda deve ser no mínimo R$ ${minValue.toFixed(2)}`);
    return false;
  }
  return true;
}

function sanitizeHtml() {
  form.value.description = form.value.description.replace(
    /<(?!\/?(p|br|b|strong)\b)[^>]*>/gi,
    ""
  );
}

async function submitForm() {
    console.log("Imagens:", form.value.images);
  if (!handleValidatePrice()) return;
  loading.value = true;
  error.value = null;
  success.value = false;

  const formData = new FormData();
  formData.append("title", form.value.name);
  formData.append("sale_price", form.value.sale_price);
  formData.append("cost_price", form.value.cost_price);
  formData.append("description", form.value.description);

  form.value.images.forEach((file, index) => {
    console.log('file images', file)
    formData.append("images[]", file);
  });

  try {
    const { data } = await axiosInstance.post("/products", formData);

    console.log(data);
  } catch (error) {
    console.log(error);
  }
}
</script>