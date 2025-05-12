<template>
  <div
    class="bg-[#1E1E1E] p-8 rounded-lg shadow-lg w-96 transition-shadow duration-300 hover:shadow-[0px_0px_10px_4px_#42b883]"
  >
    <h2 class="text-2xl font-semibold text-[#42b883] mb-6 text-center">
      Login
    </h2>

    <form @submit.prevent="login" class="space-y-4">
      <div>
        <label for="email" class="block text-sm font-medium text-white"
          >Email</label
        >
        <input
          type="email"
          id="email"
          v-model="form.email"
          required
          class="mt-1 p-2 w-full bg-[#3A3A3A] text-white border border-transparent rounded-md focus:ring-[#42b883] focus:border-[#42b883] focus:outline-none"
          placeholder="Digite seu email"
        />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-white"
          >Senha</label
        >
        <input
          type="password"
          id="password"
          v-model="form.password"
          required
          class="mt-1 p-2 w-full bg-[#3A3A3A] text-white border border-transparent rounded-md focus:ring-[#42b883] focus:border-[#42b883] focus:outline-none"
          placeholder="Digite sua senha"
        />
      </div>

      <div v-if="form.showError">
        <p class="text-center text-[#42b883]">
          <strong>{{ message }}</strong>
        </p>
      </div>

      <div v-if="form.load">
        <p class="text-center text-[#42b883] animate-pulse">
          <strong>Carregando...</strong>
        </p>
      </div>

      <button
        type="submit"
        class="w-full py-2 bg-[#42b883] text-white font-semibold rounded-md hover:bg-[#3c9b7c] focus:outline-none"
      >
        Entrar
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import http from "@/services/http.js";
import { useAuthStore } from "@/stores/auth.js";
import { useRouter } from "vue-router";

const auth = useAuthStore();
const router = useRouter();

const form = reactive({
  email: "",
  password: "",
  showError: false,
  load: false,
  message: "",
});

async function login() {
  form.load = true;
  form.showError = false;

  try {
    const { data } = await http.post("/login", {
      email: form.email,
      password: form.password,
    });

    auth.setToken(data.access_token);
    auth.setUser(data.user);
    router.push("/dashboard");
  } catch (error) {
    form.load = false;
    form.showError = true;
    if (error?.response?.status == 401) {
      form.message = "Email ou senha inválidos.";
    } else {
      form.message = "Ocorreu um erro inesperado, tente novamente mais tarde.";
    }
  } finally {
    form.load = false;
  }
}
</script>
