<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Orders</h1>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Order ID</th>
          <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Product Name</th>
          <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in ordersWithProduct" :key="order.id" class="hover:bg-gray-100">
          <td class="py-3 px-4">{{ order.id }}</td>
          <td class="py-3 px-4 capitalize">{{ order.product_name }}</td>
          <td class="py-3 px-4">${{ order.price }}</td>
        </tr>
      </tbody>
      <tfoot class="bg-gray-100">
        <tr>
          <td class="py-3 px-4 font-semibold">Total Items: {{ totalItems }}</td>
          <td></td>
          <td class="py-3 px-4 font-semibold">Total Cost: ${{ totalCost.toFixed(2) }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { API_BASE_URL } from '@/config/config'

const orders = ref([])
const ordersWithProduct = ref([])

// Fetch orders and products
const fetchOrders = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/orders`)
    orders.value = response.data

    const promises = orders.value.map(async (order) => {
      const productResponse = await axios.get(`${API_BASE_URL}/products/${order.product_id}`)
      const product = productResponse.data

      return {
        ...order,
        product_name: product.product_name
      }
    })

    ordersWithProduct.value = await Promise.all(promises)
  } catch (error) {
    console.error('Error fetching orders or products:', error)
  }
}

onMounted(() => {
  fetchOrders()
})

const totalCost = computed(() => {
  return ordersWithProduct.value.reduce((sum, order) => sum + parseFloat(order.price), 0)
})

const totalItems = computed(() => {
  return ordersWithProduct.value.length
})
</script>

<style scoped></style>
