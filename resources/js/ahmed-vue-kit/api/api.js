import axios from "axios"

const api = axios.create({
  baseURL: "/api",
  headers: {
    "X-Requested-With": "XMLHttpRequest",
    "Content-Type": "application/json",
  },
  withCredentials: true, // for Laravel Sanctum
})

/*
|--------------------------------------------------------------------------
| Request Interceptor (token attach)
|--------------------------------------------------------------------------
*/
api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token")
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

/*
|--------------------------------------------------------------------------
| Response Interceptor (error handling)
|--------------------------------------------------------------------------
*/
api.interceptors.response.use(
  (res) => res,
  (error) => {
    if (error.response?.status === 401) {
      window.location.href = "/login"
    }
    return Promise.reject(error)
  }
)

export default api
