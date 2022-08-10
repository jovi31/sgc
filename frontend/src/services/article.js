import axios from 'axios'
import { baseApiUrl } from '../global'

const baseUri = baseApiUrl + '/article'

export const insert = article => axios.post(baseUri, article)
export const update = article => axios.put(`${baseUri}/${article.id}`, article)
export const remove = id => axios.delete(`${baseUri}/${id}`)
export const find = id => axios.get(`${baseUri}/${id}`)

export const findArticles = page => axios.get(baseUri, { params: { page }})

export default { insert, update, remove, findArticles }
