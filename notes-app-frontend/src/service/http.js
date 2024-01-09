import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  headers: {
    'Content-Type': 'application/json',
  }
});

export async function checkToken() {
  try {
    const token = localStorage.getItem('token');
    if (token) {
      axiosInstance.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
      return false;
    }

    await axiosInstance.get('/user');
    return true;
  } catch (error) {
    return false;
  }
}

export default axiosInstance;
