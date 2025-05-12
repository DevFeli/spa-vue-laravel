<template>
  <div class="bg-[#1E1E1E] min-h-screen">
    <Menu />
    <div class="px-8 py-6 text-white">
      <h2 class="text-3xl font-bold text-center mb-2">Editar Produto</h2>
      <p class="text-center text-gray-300 mb-8">
        Preencha os dados abaixo para editar o produto.
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
          <label class="block mb-1 text-gray-300">Status</label>
          <div class="flex gap-4">
            <label class="flex items-center gap-2 text-white">
              <input
                type="radio"
                value="1"
                v-model="form.is_active"
                class="accent-green-500"
              />
              Ativo
            </label>
            <label class="flex items-center gap-2 text-white">
              <input
                type="radio"
                value="0"
                v-model="form.is_active"
                class="accent-red-500"
              />
              Inativo
            </label>
          </div>
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
            >Adicionar novas imagens do produto ("Apenas com formato JPG ou
            PNG")</label
          >
          <input
            type="file"
            accept="image/jpeg, image/png"
            multiple
            @change="handleImageUpload"
            class="w-full p-3 rounded bg-[#2e2e2e] text-white outline-none focus:ring-2 focus:ring-green-500"
          />
        </div>

        <!-- Renderização das imagens e botões de excluir -->
        <div v-if="images.length > 0" class="mt-4">
          <h3 class="text-gray-300 mb-2">Imagens Salvas:</h3>
          <div class="flex flex-wrap gap-4">
            <div v-for="(image, index) in images" :key="index" class="relative">
              <img
                :src="image.url"
                alt="Imagem do produto"
                class="w-24 h-24 object-cover rounded"
              />
              <button
                @click="removeImage(index, image.id)"
                type="button"
                class="absolute top-1 right-1 bg-red-500 text-white rounded-full py-1 px-2 text-xs"
              >
                X
              </button>
            </div>
          </div>
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
import { ref } from "vue";
import Menu from "@/components/menu/MenuDashboard.vue";
import { useProductStore } from "@/stores/product.js";
import apiService from "@/services/apiService";
import { useRouter } from "vue-router";
const router = useRouter();
const productStore = useProductStore();

const images = ref(productStore.product.images);
const loading = ref(false);
const error = ref(false);
const success = ref(false);

const form = ref({
  name: productStore.product.title,
  sale_price: productStore.product.sale_price,
  cost_price: productStore.product.cost_price,
  description: productStore.product.description,
  images: [],
  is_active: productStore.product.is_active,
  id: productStore.product.id,
});

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

async function removeImage(index, id) {
  if (window.confirm("tem certeza que deseja deletar a imagem?")) {
    try {
      const { data } = await apiService.delete(`/image/${id}`);
      console.log(data);
      alert("Imagem deletada com sucesso!");
      images.value.splice(index, 1);
    } catch (error) {
      if (error?.response?.status == 401) {
        alert("Sua sessão expirou, por favor faça login novamente!");
        router.push("/login");
      }
      alert("Houve algum erro inexperado, tente novamente mais tarde.");
    }
  }
}

async function submitForm() {
  if (!handleValidatePrice()) return;
  loading.value = true;
  error.value = null;
  success.value = false;

  const formData = new FormData();
  formData.append("title", form.value.name);
  formData.append("sale_price", form.value.sale_price);
  formData.append("cost_price", form.value.cost_price);
  formData.append("description", form.value.description);
  formData.append("is_active", form.value.is_active);
  formData.append("id", form.value.id);

  form.value.images.forEach((file, index) => {
    formData.append("images[]", file);
  });

  try {
    const { data } = await apiService.postMidia("/products/edit", formData);
    alert("Produto Editado com sucesso!");
    router.push("/dashboard");
  } catch (error) {
    if (error?.response?.status == 401) {
      alert("Sua sessão expirou, por favor faça login novamente!");
      router.push("/login");
    }
    alert("Houve algum erro inexperado, tente novamente mais tarde.");
  }
}
</script>