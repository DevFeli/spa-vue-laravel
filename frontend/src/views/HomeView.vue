<script setup>

async function teste(){
  console.log('fn')
  const teste = await fetch("http://localhost:80/api/teste", {
    method: 'GET',
    credentials: 'include', 
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
    },
  })

  const result = await teste.json()

  console.log(result)
}

</script>

<template>
  <main>
    <h1>teste</h1>
    <button @click="teste">Api</button>
  </main>
</template>
