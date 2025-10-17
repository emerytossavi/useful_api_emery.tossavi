<template>
  <div class="container">
    <form v-on:submit.prevent="action">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="name"
          v-model="email"
          aria-describedby="emailHelp"
        />
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label"> Password </label>
        <input
         type="password"
          class="form-control"
          id="exampleInputPassword1"
          v-model="password"/>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" />
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';

const email = ref('');
const password = ref('');

const auth = useAuthStore();

const action = async() => {

  auth.user = {
    email: email.value,
    password: password.value,
  };

  /*

  console.log(auth.user);

  const response = await auth.requester.post(`/login`, auth.user);

  console.log(response);
  */

  /* const response =  */

  await auth.login(auth.user)

}
</script>
