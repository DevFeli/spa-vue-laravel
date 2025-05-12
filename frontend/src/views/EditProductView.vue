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
        <!-- Campos de entrada omitidos para simplicidade -->

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

        <!-- Renderização das imagens e botões de excluir -->
        <div v-if="images.length > 0" class="mt-4">
          <h3 class="text-gray-300 mb-2">Imagens Selecionadas:</h3>
          <div class="flex flex-wrap gap-4">
            <div
              v-for="(image, index) in images"
              :key="index"
              class="relative"
            >
              <img
                :src="image"
                alt="Imagem do produto"
                class="w-24 h-24 object-cover rounded"
              />
              <button
                @click="removeImage(index)"
                type="button"
                class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs"
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
import { ref } from 'vue'
import Menu from "@/components/menu/MenuDashboard.vue";
import { useProductStore } from "@/stores/product.js";
const productStore = useProductStore();

const images = ref([])
const loading = ref(false)
const error = ref(false)
const success = ref(false)

console.log(productStore.product.images[0])

async function submitForm(){

}

async function handleImageUpload(){

}

</script>