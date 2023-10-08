<template>
  <div>
    <!-- <v-img
      class="mx-auto my-6"
      max-width="228"
      src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/ZDF_logo%21_Logo_2021.svg/1200px-ZDF_logo%21_Logo_2021.svg.png"
    ></v-img> -->

    <v-card
      class="mx-auto pa-12 pb-8 mt-28"
      elevation="8"
      max-width="448"
      rounded="lg"
    >
      <div class="text-subtitle-1 text-medium-emphasis">Email</div>

       <form @submit.prevent="submit">
      <v-text-field
        density="compact"
        placeholder="Email address"
        prepend-inner-icon="mdi-email-outline"
        variant="outlined"
         v-model="form.email"
        :error-messages="errors.email"
      ></v-text-field>

      <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
        Password

        <a
          class="text-caption text-decoration-none text-blue"
          href="Javascript:void(0)"
          rel="noopener noreferrer"
        >
          Forgot login password?</a>
      </div>

      <v-text-field
        :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
        :type="visible ? 'text' : 'password'"
        density="compact"
        placeholder="Enter your password"
        prepend-inner-icon="mdi-lock-outline"
        variant="outlined"
        v-model="form.password"
        :error-messages="errors.password"
        @click:append-inner="visible = !visible"
      ></v-text-field>

      <v-card
        class="mb-12"
        color="surface-variant"
        variant="tonal"
      >
      
      </v-card>

      <v-btn
        block
        class="mb-8"
        color="blue"
        size="large"
        :loading="form.processing"
        variant="tonal"
        type="submit"
      >
        Log In
      </v-btn>

      </form>

      <v-card-text class="text-center">
        <Link :href="route('signUp')"
          class="text-blue text-decoration-none"
          rel="noopener noreferrer"
          target="_blank"
        >
          Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
        </Link>
      </v-card-text>
    </v-card>
  </div>
</template>


<script setup>

import { reactive, ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const visible = ref(false);

const form = useForm({
  email: null,
  password: null,
})

defineProps({
  errors:Object
})

function submit() {
  form.post(route('login'));
}


</script>