import axios from '@/js/plugins/axios'

export const Js/usersApi = {
  all() { return axios.get('/js/users') },
  create(data) { return axios.post('/js/users', data) },
  update(id, data) { return axios.put('/js/users/' + id, data) },
  delete(id) { return axios.delete('/js/users/' + id) }
}