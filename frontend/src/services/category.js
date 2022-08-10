import axios from 'axios'
import { baseApiUrl } from '../global'

const baseUri = baseApiUrl + '/category'

export const insert = category => axios.post(baseUri, category)
export const update = category => axios.put(`${baseUri}/${category.id}`, category)
export const remove = id => axios.delete(`${baseUri}/${id}`)

export const findCategories = () => axios.get(baseUri)

export const getArticles = category => axios.get(`${baseUri}/${category.id}/articles`)
export const tree = () => axios.get(`${baseUri}/tree`)

export default { insert, update, remove, findCategories }
