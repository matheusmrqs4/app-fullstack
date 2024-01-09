<template>
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6 text-center mb-5">
        <h2>Detalhes da Nota</h2>
      </div>
    </div>
    <div class="row justify-content-center align-items-center">
      <div class="col-md-6 text-center">
        <div>
          <h3>{{ title }}</h3>
          <p>{{ description }}</p>
          <p>{{ formatoData }}</p>
          <button @click="noteEdit" class="btn btn-primary m-2">Editar</button>
          <button @click="noteDelete" class="btn btn-danger m-2">Excluir</button>
        </div>
      </div>
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
  import { ref, onMounted, computed} from 'vue';
  import http from '@/service/http.js';
  import { useRoute, useRouter } from 'vue-router';
  import { format } from 'date-fns';

  const errorMessages = ref([]);

  const noteID = ref('');
  const title = ref('');
  const description = ref('');
  const created_at = ref('');
  
  const router = useRouter();
  const route = useRoute();

  const message = ref('');
  const isSuccess = ref(false);

  const showNote = async () => {
    try {
      if (noteID.value.trim() !== '') {
        const response = await http.get(`/notes/${noteID.value}`);

        const noteDetails = response.data;

        title.value = noteDetails ? noteDetails.title || '' : '';
        description.value = noteDetails ? noteDetails.description || '' : '';
        created_at.value = noteDetails ? noteDetails.created_at || '' : '';
      } else {
        errorMessages.value = [];

        isSuccess.value = false;
        message.value = "Nota não encontrada!";
      }
    } catch (error) {
      console.error(error);
    }
  };

  const formatoData = computed(() => {
    return created_at.value ? format(new Date(created_at.value), 'dd/MM/yyyy HH:mm') : '';
  });

  const noteEdit = () => {
    router.push({ name: 'notes-edit', params: { id: noteID.value } });
  };

  const noteDelete = async () => {
    try {
      await http.delete(`/notes/${noteID.value}`);
      await showNote();

      errorMessages.value = [];

      isSuccess.value = true;
      message.value = "Nota excluída com sucesso!";

      setTimeout(async () => {
        await router.push({ name: 'notes-list' });
      }, 2000);

    } catch (error) {
      errorMessages.value = [];

      isSuccess.value = false;
      message.value = "Erro ao excluir Nota, tente novamente!";
    }
  };
  
  onMounted(() => {
    noteID.value = route.params.id || '';
    showNote();
  });
</script>
