<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
  >
    <div class="bg-white rounded-lg p-4 w-96">
      <h2 class="text-xl font-semibold">Cart Items</h2>
      <ul class="my-2">
        <li
          v-for="(item, index) in groupedOrders"
          :key="index"
          class="flex justify-between border-b py-2"
        >
          <span class="capitalize"
            >(ID: {{ item.id }}) {{ item.product_name }} (x{{ item.quantity }})</span
          >
          <span>${{ item.totalPrice.toFixed(2) }}</span>
          <button @click="deleteOrder(item.id)" class="text-red-600">Delete</button>
        </li>
      </ul>
      <div class="mt-4 flex justify-between">
        <span class="font-semibold">Total Price:</span>
        <span>${{ totalPrice.toFixed(2) }}</span>
      </div>
      <div class="mt-2 flex justify-between">
        <span class="font-semibold">Total Quantity:</span>
        <span>{{ totalQuantity }}</span>
      </div>
      <div class="mt-4 flex justify-between">
        <button @click="closeModal" class="bg-red-500 text-white px-4 py-2 rounded">Close</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  show: Boolean,
  orders: Array,
  closeModal: Function,
  deleteOrder: Function
})

const groupedOrders = computed(() => {
  const orderMap = {}
  props.orders.forEach((item) => {
    if (orderMap[item.id]) {
      orderMap[item.id].quantity += item.quantity
    } else {
      orderMap[item.id] = {
        ...item,
        quantity: item.quantity,
        totalPrice: item.price * item.quantity
      }
    }
  })
  return Object.values(orderMap)
})

const totalPrice = computed(() => {
  return groupedOrders.value.reduce((total, item) => total + item.totalPrice, 0)
})

const totalQuantity = computed(() => {
  return groupedOrders.value.reduce((total, item) => total + item.quantity, 0)
})
</script>
