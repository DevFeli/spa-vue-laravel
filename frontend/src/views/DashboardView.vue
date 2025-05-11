<template>
  <div class="min-h-screen bg-[#1E1E1E]">
    <Menu />
    <main class="p-8 flex flex-col justify-center items-center">
      <h1 class="text-3xl font-semibold text-white">Dashboard</h1>
      <p class="mt-4 text-white">Bem-vindo à área do dashboard. Aqui você pode visualizar seus dados e interagir com a aplicação.</p>

      <ProductList />
    </main>
  </div>
</template>

<script setup>
import Menu from '@/components/menu/MenuDashboard.vue'
import ProductList from '@/components/product/ProductList.vue'
</script>