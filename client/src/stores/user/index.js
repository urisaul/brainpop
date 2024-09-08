import { defineStore } from 'pinia'
export const useUserStore = defineStore('user', {
  state: () => ({
    loggedIn: false
  }),
  getters: {
    isLoggedIn: state => {
      let loggedIn = window.localStorage.getItem('loggedIn')
      return loggedIn || state.loggedIn
    }
  },
  actions: {
    async login(email, password, callback) {
      try {
        const response = await fetch('http://localhost:3000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({ email, password })
        });

        // Check response status
        if (response.ok) {
          const data = await response.json();
          this.loggedIn = true;
          window.localStorage.setItem('loggedIn', 'true');
          window.localStorage.setItem('token', data.access_token);
          callback(true);
        } else {
          // error in the response status (possibly wrong credentials)
          this.loggedIn = false;
          window.localStorage.removeItem('loggedIn');
          callback(false);
        }
      } catch (error) {
        // if other errors occur - logout & log the errors
        this.loggedIn = false;
        window.localStorage.removeItem('loggedIn');
        callback(false);
        console.error('Login error:', error);
      }
    },

    logout() {
      this.loggedIn = false;
      window.localStorage.removeItem('loggedIn');
      window.localStorage.removeItem('token');
    }
  }
})
