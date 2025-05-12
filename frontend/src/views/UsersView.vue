<template>
  <div class="min-h-screen bg-[#1E1E1E]">
    <Menu />
    <main class="p-8 flex flex-col justify-center items-center">
      <h1 class="text-3xl font-semibold text-white">Usuários</h1>
      <p class="mt-4 text-white">Bem-vindo à área de usuários. Aqui você pode visualizar seus dados e interagir com a aplicação.</p>

        <UsersList/>
    </main>
  </div>
</template>

<script setup>
import Menu from '@/components/menu/MenuDashboard.vue'
import UsersList from '@/components/users/UsersList.vue'
</script>