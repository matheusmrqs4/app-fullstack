<template>
    <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-4 text-center mb-5">
            <h2>Crie sua Conta Grátis</h2>
          </div>
        </div>
        <div class="row justify-content-center align-items-center">
          <form @submit.prevent="register" class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Seu Nome</label>
              <input v-model="name" type="text" class="form-control" placeholder="Seu Nome">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Seu E-mail</label>
              <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu E-mail">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Sua Senha</label>
              <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Sua Senha">
            </div>
            <button type="submit" class="btn btn-primary">Criar Conta</button>
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
  import { ref } from 'vue';
  import http from '@/service/http.js';
  import { useRouter } from 'vue-router';

  const errorMessages = ref([]);

  const name = ref('');
  const email = ref('');
  const password = ref('');
  const router = useRouter();

  const message = ref('');
  const isSuccess = ref(false);

  async function register() {
    try {
      const response = await http.post('/auth/register', {
        name: name.value,
        email: email.value,
        password: password.value,
      });

      errorMessages.value = [];

      isSuccess.value = true;
      message.value = "Usuário Registrado com Sucesso!";

      setTimeout(() => {
        router.push({ name: 'login' });
      }, 2000);
    } catch (error) {
      if (error.response && error.response.data && error.response.data.error) {
        errorMessages.value = Object.values(error.response.data.error);
      } else {
        isSuccess.value = false;
        message.value = "Erro ao criar usuário, tente novamente!";
      }
    }
  }
</script>
