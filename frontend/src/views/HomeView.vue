<script setup>

async function teste(){
  console.log('fn')
  const teste = await fetch("http://localhost:80/api/login", {
    method: 'POST',
    credentials: 'include', 
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({ email:'admin@admin.com', password:'123' }),
  })

  const result = await teste.json()

  console.log(result)
}

</script>

<template>
  <main>
    <h1 class="text-red-500">teste 1</h1>
    <button @click="teste">Api</button>
  </main>
</template>
