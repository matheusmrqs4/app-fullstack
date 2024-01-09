import { checkToken } from '@/service/http.js';

export async function isAuthenticated() {
  const token = localStorage.getItem('token');
  if (token) {
    return await checkToken();
  }
  return false;
}
