import axios from 'axios'
import { baseApiUrl } from '../global'

const baseUri = baseApiUrl + '/user'

export const insert = user => axios.post(baseUri, user)
export const update = user => axios.put(`${baseUri}/${user.id}`, user)
export const remove = id => axios.delete(`${baseUri}/${id}`)

export const findUsers = page => axios.get(baseUri, { params: { page }})

export default { insert, update, remove, findUsers }
