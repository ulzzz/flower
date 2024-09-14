<template>
  <nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
      <div>
        <RouterLink to="/" class="text-white text-lg font-bold">Flower Test</RouterLink>
      </div>
      <div>
        <RouterLink to="/" class="text-gray-300 hover:text-white mx-2">All Products</RouterLink>
        <RouterLink to="/orders" class="text-gray-300 hover:text-white mx-2">Orders</RouterLink>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { RouterLink } from 'vue-router'
</script>

<style scoped></style>
