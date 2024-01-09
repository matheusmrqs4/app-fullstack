<template>
  <div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-4 text-center mb-5">
            <h2>Notas</h2>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <form @submit.prevent="noteUpdate" class="col-md-4">
            <div class="mb-3">
                <label for="noteTitle" class="form-label">Título da Nota</label>
                <input v-model="title" type="text" class="form-control" id="noteTitle" placeholder="Título">
            </div>
            <div class="mb-3">
                <label for="noteDescription" class="form-label">Descrição da Nota</label>
                <textarea v-model="description" class="form-control" id="noteDescription" placeholder="Sua nota aqui"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Nota</button>
        </form>
    </div>
    
    <div class="row justify-content-center align-items-center text-center mt-3">
        <div v-if="message" :class="{ 'text-success': isSuccess, 'text-danger': !isSuccess }">
            {{ message }}
        </div>
        <div v-if="errorMessages.length" class="error-message">
            <p v-for="errorMessage in errorMessages" :key="errorMessage" class="text-danger">{{ errorMessage }}</p>
        </div>
    </div>
  </div>
</template>

<script setup>

  import { ref, onMounted } from 'vue';
  import http from '@/service/http.js';
  import { useRoute, useRouter } from 'vue-router';

  const errorMessages = ref([]);

  const noteID = ref('');
  const title = ref('');
  const description = ref('');
  
  const route = useRoute();
  const router = useRouter();

  const message = ref('');
  const isSuccess = ref(false);

  const noteData = async () => {
    try {
      if (noteID.value.trim() !== '') {
        const response = await http.get(`/notes/${noteID.value}`);

        const noteDetails = response.data;

        title.value = noteDetails ? noteDetails.title || '' : '';
        description.value = noteDetails ? noteDetails.description || '' : '';
      } else {
        errorMessages.value = [];

        isSuccess.value = false;
        message.value = "Nota não encontrada!";
      }
    } catch (error) {
      console.error(error);
    }
  };

  const noteUpdate = async () => {
    try {
      const response = await http.put(`/notes/${noteID.value}`, {
        title: title.value,
        description: description.value
      });

      errorMessages.value = [];

      isSuccess.value = true;
      message.value = "Nota editada com Sucesso!";

      setTimeout(async () => {
        await router.push({ name: 'notes-list' });
      }, 2000);

    } catch (error) {
      if (error.response && error.response.data && error.response.data.error) {
      errorMessages.value = Object.values(error.response.data.error);
    } else {
      isSuccess.value = false;
      message.value = "Erro ao editar nota, tente novamente!";
    }
    }
  };

  onMounted(() => {
  noteID.value = route.params.id || '';
  noteData();
});

</script>
