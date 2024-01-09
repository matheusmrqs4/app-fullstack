<template>
  <div>
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" role="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand decoration-none">NotesApp</a>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item" v-if="!isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
              </li>
              <li class="nav-item" v-if="!isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'login' }">Login</router-link>
              </li>
              <li class="nav-item" v-if="!isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'register' }">Registro</router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'notes-create' }">Criar Notas</router-link>
              </li>
              <li class="nav-item" v-if="isLoggedIn">
                <router-link class="nav-link" :to="{ name: 'profile' }">Meu Perfil</router-link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <router-view />
  </div>
</template>

<script>
import { isAuthenticated } from '@/utils/auth.js';

export default {
  data() {
    return {
      isLoggedIn: false,
    };
  },
  async created() {
    this.isLoggedIn = await isAuthenticated();
  },
};
</script>
