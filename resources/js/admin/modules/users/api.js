import axios from '@/js/plugins/axios'

export const UsersApi = {
  all() { return axios.get('/users') },
  create(data) { return axios.post('/users', data) },
  update(id, data) { return axios.put('/users/' + id, data) },
  delete(id) { return axios.delete('/users/' + id) }
}