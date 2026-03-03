import axios from '@/js/plugins/axios'

export const ProductApi = {
  all() { return axios.get('/product') },
  create(data) { return axios.post('/product', data) },
  update(id, data) { return axios.put('/product/' + id, data) },
  delete(id) { return axios.delete('/product/' + id) }
}