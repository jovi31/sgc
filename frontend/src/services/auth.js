import axios from 'axios'
import { baseApiUrl } from '../global'

export const signIn = credentials => axios.post(baseApiUrl + '/signIn', credentials)
export const signUp = user => axios.post(baseApiUrl + '/signUp', user)
export const validateToken = token => axios.post(baseApiUrl + '/validateToken', { token })

export default { signIn, signUp, validateToken }
