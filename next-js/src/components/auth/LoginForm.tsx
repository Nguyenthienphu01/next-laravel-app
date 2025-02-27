'use client'
import { useState } from 'react';
import { Input } from '../common/Input';
import { Button } from '../common/Button';
import { useAuth } from '@/hooks/auth/useAuth';

export const LoginForm = () => {
  const [formData, setFormData] = useState({
    email: '',
    password: ''
  });
  const { login, isLoading } = useAuth();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await login(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      <Input
        label="Email"
        type="email"
        required
        value={formData.email}
        onChange={(e) => setFormData(prev => ({
          ...prev,
          email: e.target.value
        }))}
      />
      <Input
        label="Password"
        type="password"
        required
        value={formData.password}
        onChange={(e) => setFormData(prev => ({
          ...prev,
          password: e.target.value
        }))}
      />
      <Button type="submit" isLoading={isLoading}>
        Sign in
      </Button>
    </form>
  );
};