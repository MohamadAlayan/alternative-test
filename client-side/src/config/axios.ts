import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    'Content-Type': 'application/json'
  }
});

// Request Interceptors
api.interceptors.request.use(
  function (config) {
    // Add token to request headers
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  function (error) {
    // Handle request error
    return Promise.reject(error);
  }
);

// Response Interceptors
api.interceptors.response.use(
  function (response) {
    return response;
  },
  function (error) {
    // Handle 401 error (unauthorized)
    if (error.response && error.response.status === 401) {
      localStorage.removeItem('token');
      // Redirect to login page
    }
    return Promise.reject(error.response);
  }
);

export default api;
