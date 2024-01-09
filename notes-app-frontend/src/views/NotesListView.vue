<template>
  <div class="container">
    <h2 class="text-center mb-4">Lista de Notas:</h2>
    <div class="table-responsive">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="note in filteredNotes" :key="note.id" class="note-item">
            <td>{{ note.title }}</td>
            <td>{{ note.description }}</td>
            <td>
              <button @click="noteEdit(note.id)" class="btn btn-primary m-2">Editar</button>
              <button @click="noteShow(note.id)" class="btn btn-info m-2">Detalhes</button>
              <button @click="noteDelete(note.id)" class="btn btn-danger m-2">Excluir</button>
            </td>
          </tr>
        </tbody>
      </table>
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
  import { ref, onMounted, computed } from 'vue';
  import http from '@/service/http.js';
  import { useRouter } from 'vue-router';

  const errorMessages = ref([]);

  const notes = ref([]);
  const router = useRouter();

  const message = ref('');
  const isSuccess = ref(false);

  const loadNotes = async () => {
    try {
      const response = await http.get('/notes');

      errorMessages.value = [];

      if (Array.isArray(response.data.data)) {
        notes.value = response.data.data;
      } else {
        isSuccess.value = false;
        message.value = "Erro ao exibir lista de Notas!";
        console.error(error);
      }
    } catch (error) {
      if (error.response && error.response.data && error.response.data.error) {
      errorMessages.value = Object.values(error.response.data.error);
    } else {
      isSuccess.value = false;
      message.value = "Erro ao exibir Notas, tente novamente!";
      console.error(error);
    }
    }
  };

  const filteredNotes = computed(() => {
    return notes.value.filter(note => note !== null);
  });

  const noteEdit = (noteId) => {
    router.push({ name: 'notes-edit', params: { id: noteId } });
  };

  const noteShow = (noteId) => {
    router.push({ name: 'notes-show', params: { id: noteId } });
  };

  const noteDelete = async (noteId) => {
    try {
      await http.delete(`/notes/${noteId}`);
      await loadNotes();
    } catch (error) {
      isSuccess.value = false;
      message.value = "Erro ao excluir Nota, tente novamente!";
    }
  };

  onMounted(() => {
    loadNotes();
});
</script>
