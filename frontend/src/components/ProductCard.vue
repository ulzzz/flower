<template>
  <div class="border p-4 rounded-lg shadow-md">
    <h2 class="text-xl text-gray-800 font-semibold capitalize">{{ product.product_name }}</h2>
    <p class="text-gray-700">Price: ${{ product.price }}</p>
    <p class="text-gray-500">Description: {{ product.product_description }}</p>
    <p class="text-gray-500">Quantity: {{ product.quantity }}</p>
    <div class="mt-4">
      <button @click="editProduct" class="bg-amber-500 text-white px-2 py-1 rounded">Edit</button>
      <button @click="deleteProduct" class="bg-red-500 text-white px-2 py-1 rounded ml-2">
        Delete
      </button>
      <button
        @click="addToOrders"
        :disabled="product.status === 0"
        :class="{
          'bg-blue-500 text-white': product.status !== 0,
          'bg-gray-400 text-gray-200 cursor-not-allowed': product.status === 0
        }"
        class="px-2 py-1 rounded ml-2"
      >
        Add to Orders
      </button>
      <button @click="toggleProductStatus" class="bg-purple-500 text-white px-2 py-1 rounded ml-2">
        {{ product.status === 0 ? 'Enable' : 'Disable' }}
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import axios from 'axios'
import { API_BASE_URL } from '@/config/config'

const props = defineProps({
  product: {
    type: Object,
    required: true
  },
  editProduct: {
    type: Function,
    required: true
  },
  deleteProduct: {
    type: Function,
    required: true
  },
  addToOrders: {
    type: Function,
    required: true
  }
})

const toggleProductStatus = async () => {
  try {
    const response = await axios.patch(`${API_BASE_URL}/products/${props.product.id}/status`)
    props.product.status = response.data.status // Update status based on the response
  } catch (error) {
    console.error('Error toggling product status:', error)
  }
}
</script>

<style scoped></style>
