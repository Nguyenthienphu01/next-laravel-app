'use client';

import { useState } from 'react';
import { login as apiLogin } from '@/services/api';
import { useRouter } from 'next/navigation';

interface Credentials {
  email: string;
  password: string;
}

export function useAuth() {
  const [user, setUser] = useState(null);
  const [token, setToken] = useState(null);
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  const login = async (credentials: Credentials) => {
    setIsLoading(true);
    setError(null);
    try {
      const { email, password } = credentials;
      const response = await apiLogin(email, password);

      const responses = response.data;

      const { token, user } = responses;

      localStorage.setItem('token', token);
      localStorage.setItem('user', JSON.stringify(user));
      router.push('/dashboard');
    } catch (err: unknown) {
      if (err instanceof Error) {
        setError(err.message || 'Login failed');
      } else {
        setError('Login failed');
      }
      throw err;
    } finally {
      setIsLoading(false);
    }
  };

  const logout = () => {
    setUser(null);
    setToken(null);
    setError(null);
    localStorage.removeItem('token');
    localStorage.removeItem('user');
  };

  return { user, token, login, logout, isLoading, error };
}