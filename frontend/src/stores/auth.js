// import { ref, computed } from 'vue'
import axios from 'axios'
import { defineStore } from 'pinia'

import Swal from 'sweetalert2';

// import { useUsualStore } from './usual';

const axiosInst = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Authorization: `Bearer ${import.meta.env.VITE_APP_API_TOKEN} `,
  },
});

const handleApiCall = async (apiCall) => {
      try {
        const response = await apiCall()
        return response.data
      } catch (error) {
        console.error('API call failed:', error)
        showAlert(
          '',
          error?.response?.data ||
          'Une erreur est survenue. Veuillez réessayer plus tard.',
        )
      }
    };

  const showAlert = (title, message, icon = 'error') => {
        Swal.fire({
          icon: icon,
          title: title,
          text: message,
          showConfirmButton: false,
          timer: 2000,
          timerProgressBar: true,
          toast: true,
          position: 'top-end',
        })
      };

export const useAuthStore = defineStore('auth', {
  state: () => ({
    // count: 0,
    // name: 'Eduardo'

    token: "",
    user_id: null,

    user: {},

  }),


  getters: {
    // doubleCount: (state) => state.count * 2,
  },

  persist: true,


  actions: {

    async login(user) {
      console.log(user);
      // console.log(this.requester);

      const response = await handleApiCall(() => axiosInst.post(`/login`, user));

      // const response = await axiosInst.post(`/login`, user);

      console.log(response);

      this.token = response.token;
      this.user_id = response.user_id;

      console.log(this.token)
      console.log(this.user_id)

      localStorage.setItem('user.token', this.token)
      localStorage.setItem('user.user_id', this.user_id)

    },




  },
})
