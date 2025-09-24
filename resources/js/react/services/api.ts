import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
  },
});

export const login = async (email, password) => {
  const response = await api.post('/login', { email, password });
  localStorage.setItem('token', response.data.token);
  localStorage.setItem('user', JSON.stringify(response.data.user));
  return response.data;
};

export const logout = async () => {
  await api.post('/logout', {}, {
    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
  });
  localStorage.removeItem('token');
  localStorage.removeItem('user');
};

export default api;
