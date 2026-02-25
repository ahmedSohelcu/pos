import axios from '@/js/plugins/axios'

export const TenantApi = {
  all() {
    return axios.get('/tenants')
  },
  create(data) {
    return axios.post('/tenants', data)
  },
  update(id, data) {
    return axios.put(`/tenants/${id}`, data)
  },
  plans() {
    return axios.get('/plans')
  },
  subscriptions() {
    return axios.get('/subscriptions')
  }
}