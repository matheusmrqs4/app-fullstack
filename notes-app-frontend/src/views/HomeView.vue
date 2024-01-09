<template>
  <div>
    <main v-if="isLoggedIn">
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
    </main>
    <div v-else class="row justify-content-center align-items-center text-center mt-3">
      <div class="card" style="width: 50rem; height: 30rem;">
        <div class="card-body p-2">
          <h5 class="card-title">NotesApp</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">Sua Ferramenta para Organização Instantânea</h6>
          <p class="card-text">Em um mundo agitado e dinâmico, a capacidade de capturar ideias e informações instantaneamente é crucial. O aplicativo "Notas Rápidas" surge como uma solução intuitiva e eficiente para usuários que buscam uma maneira prática de registrar pensamentos, tarefas e inspirações no momento em que surgem.</p>
          <p class="card-text">Com uma interface limpa e amigável, o aplicativo oferece uma plataforma fácil de usar, permitindo que os usuários criem, editem e organizem suas notas de maneira eficiente. Seja uma ideia genial que surge durante uma reunião, uma lista de compras inesperada ou um lembrete importante, o "NotesApp" está sempre à mão para garantir que nada seja esquecido.</p>
          <p class="cadr-text">Seja você um estudante, profissional ocupado ou alguém que busca uma maneira eficaz de organizar seus pensamentos, o "Notas Rápidas" é o seu companheiro confiável para garantir que suas ideias sejam capturadas e preservadas, sempre prontas para quando você precisar delas. Simplifique sua vida e liberte sua mente com o "NotesApp".</p>
          <router-link class="nav-link" :to="{ name: 'register' }">
            <a class="card-link btn btn-primary mb-2">Crie Sua Conta</a>
          </router-link>
          <router-link class="nav-link" :to="{ name: 'login' }">
            <a class="card-link btn btn-primary">Acesse sua Conta</a>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, onMounted, computed } from 'vue';
  import http from '@/service/http.js';
  import { isAuthenticated } from '@/utils/auth.js';
  import { useRouter } from 'vue-router';

  const errorMessages = ref([]);
  const notes = ref([]);
  const router = useRouter();
  const message = ref('');
  const isSuccess = ref(false);
  const isLoggedIn = ref(false);

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

  onMounted(async () => {
    isLoggedIn.value = await isAuthenticated();
    if (isLoggedIn.value) {
      loadNotes();
    }
  });
</script>
