import axios from 'axios'

// Base URL untuk API Laravel
const API_BASE_URL = 'http://localhost:8000/api'

// Create axios instance
const api = axios.create({
  baseURL: API_BASE_URL,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Request interceptor untuk menambahkan token
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor untuk handle errors
api.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    if (error.response?.status === 401) {
      // Token expired atau invalid
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      // Redirect ke login jika diperlukan
      // window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

// API Functions
export const apiService = {
  // Auth endpoints
  auth: {
    register: (userData) => api.post('/auth/register', userData),
    login: (credentials) => api.post('/auth/login', credentials),
    logout: () => api.post('/auth/logout')
  },

  // Kendaraan endpoints
  kendaraan: {
    getAll: (params = {}) => api.get('/kendaraan', { params }),
    getById: (id) => api.get(`/kendaraan/${id}`)
  },

  // Pemesanan endpoints
  pemesanan: {
    create: (bookingData) => api.post('/pemesanan', bookingData),
    getUserBookings: () => api.get('/pemesanan/user'),
    getById: (id) => api.get(`/pemesanan/${id}`),
    cancel: (id) => api.put(`/pemesanan/${id}/cancel`)
  },

  // User profile endpoints
  user: {
    getProfile: () => api.get('/user/profile'),
    updateProfile: (profileData) => api.put('/user/profile', profileData),
    updatePassword: (passwordData) => api.put('/user/password', passwordData)
  },

  // Pembayaran endpoints
  pembayaran: {
    create: (paymentData) => api.post('/pembayaran', paymentData)
  },

  // Health check
  health: () => api.get('/health')
}

export default api