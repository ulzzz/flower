<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Products</h1>

    <div class="flex justify-between mb-4">
      <button @click="showForm = !showForm" class="bg-cyan-600 text-white px-4 py-2 rounded">
        {{ showForm ? 'Close' : 'Add Product' }}
      </button>

      <button @click="showOrdersModal = true" class="bg-emerald-600 text-white px-10 py-2 rounded">
        View Orders ({{ orders.length }})
      </button>
    </div>

    <div v-if="showForm" class="mb-4 p-4 border rounded-lg shadow-md">
      <h2 class="text-lg font-semibold">{{ isEditing ? 'Edit Product' : 'Add New Product' }}</h2>
      <form @submit.prevent="isEditing ? updateProduct() : addProduct()">
        <div class="mb-2">
          <label class="block text-gray-700">Product Name</label>
          <input
            v-model="newProduct.product_name"
            type="text"
            class="border rounded w-full px-3 py-2"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block text-gray-700">Price</label>
          <input
            v-model="newProduct.price"
            type="number"
            step="0.01"
            class="border rounded w-full px-3 py-2"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block text-gray-700">Quantity</label>
          <input
            v-model="newProduct.quantity"
            type="number"
            class="border rounded w-full px-3 py-2"
            required
          />
        </div>
        <div class="mb-2">
          <label class="block text-gray-700">Description</label>
          <textarea
            v-model="newProduct.product_description"
            class="border rounded w-full px-3 py-2"
            required
          ></textarea>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
          {{ isEditing ? 'Update Product' : 'Add Product' }}
        </button>
        <button @click="cancelEdit" class="ml-2 bg-red-500 text-white px-4 py-2 rounded">
          Cancel
        </button>
      </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
      <ProductCard
        v-for="product in products"
        :key="product.id"
        :product="product"
        :editProduct="() => editProduct(product)"
        :deleteProduct="() => deleteProduct(product.id)"
        :addToOrders="() => addToOrders(product)"
      />
    </div>

    <OrdersModal
      :show="showOrdersModal"
      :orders="orders"
      :closeModal="() => (showOrdersModal = false)"
      :deleteOrder="deleteOrder"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import ProductCard from '@/components/ProductCard.vue'
import OrdersModal from '@/components/OrdersModal.vue'
import { API_BASE_URL } from '@/config/config'

const products = ref([])
const showForm = ref(false)
const isEditing = ref(false)
const newProduct = ref({
  product_name: '',
  price: '',
  quantity: '',
  product_description: ''
})
const orders = ref(JSON.parse(localStorage.getItem('orders')) || [])
const showOrdersModal = ref(false)

const fetchProducts = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/products`)
    products.value = response.data
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

const addProduct = async () => {
  try {
    const response = await axios.post(`${API_BASE_URL}/products`, newProduct.value)
    products.value.unshift(response.data)
    resetForm()
  } catch (error) {
    console.error('Error adding product:', error)
  }
}

const updateProduct = async () => {
  try {
    await axios.put(`${API_BASE_URL}/products/${newProduct.value.id}`, newProduct.value)
    const index = products.value.findIndex((product) => product.id === newProduct.value.id)
    products.value.splice(index, 1, newProduct.value)
    resetForm()
  } catch (error) {
    console.error('Error updating product:', error)
  }
}

const addToOrders = (product) => {
  orders.value.push(product)
  saveOrders()
}

const editProduct = (product) => {
  isEditing.value = true
  newProduct.value = { ...product }
  showForm.value = true
}

const cancelEdit = () => {
  resetForm()
}

const deleteProduct = async (id) => {
  try {
    await axios.delete(`${API_BASE_URL}/products/${id}`)
    products.value = products.value.filter((product) => product.id !== id)
  } catch (error) {
    console.error('Error deleting product:', error)
  }
}

const resetForm = () => {
  newProduct.value = {
    product_name: '',
    price: '',
    quantity: '',
    product_description: ''
  }
  showForm.value = false
  isEditing.value = false
}

const saveOrders = () => {
  localStorage.setItem('orders', JSON.stringify(orders.value))
}

const deleteOrder = (id) => {
  orders.value = orders.value.filter((order) => order.id !== id)
  saveOrders()
}

onMounted(() => {
  fetchProducts()

  const storedOrders = JSON.parse(localStorage.getItem('orders'))
  if (storedOrders) {
    orders.value = storedOrders
  }
})
</script>

<style scoped></style>
