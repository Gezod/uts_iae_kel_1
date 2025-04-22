<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">User Management</h1>

    <!-- Form -->
    <form @submit.prevent="saveUser" class="space-y-2 mb-4">
      <input v-model="form.name" placeholder="Name" class="input" />
      <input v-model="form.email" placeholder="Email" class="input" />
      <select v-model="form.role" class="input">
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
      </select>
      <button type="submit" class="btn">Save</button>
    </form>

    <!-- Table -->
    <table class="w-full text-left border">
      <thead>
        <tr>
          <th class="border px-2">Name</th>
          <th class="border px-2">Email</th>
          <th class="border px-2">Role</th>
          <th class="border px-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="border px-2">{{ user.name }}</td>
          <td class="border px-2">{{ user.email }}</td>
          <td class="border px-2">{{ user.role }}</td>
          <td class="border px-2">
            <button @click="editUser(user)" class="btn-sm">Edit</button>
            <button @click="deleteUser(user.id)" class="btn-sm text-red-500">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const users = ref([])
const form = ref({ name: '', email: '', role: 'customer', id: null })

const fetchUsers = async () => {
  const res = await axios.get('/api/users')
  users.value = res.data.data
}

const saveUser = async () => {
  if (form.value.id) {
    await axios.put(`/api/users/${form.value.id}`, form.value)
  } else {
    await axios.post('/api/users', form.value)
  }
  form.value = { name: '', email: '', role: 'customer', id: null }
  fetchUsers()
}

const editUser = (user) => {
  form.value = { ...user }
}

const deleteUser = async (id) => {
  await axios.delete(`/api/users/${id}`)
  fetchUsers()
}

onMounted(fetchUsers)
</script>

<style scoped>
.input { @apply border px-2 py-1 rounded w-full; }
.btn { @apply bg-blue-500 text-white px-4 py-1 rounded; }
.btn-sm { @apply bg-gray-200 px-2 py-1 rounded mr-1; }
</style>
