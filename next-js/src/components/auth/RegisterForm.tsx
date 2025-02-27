import { useState } from 'react';
import { Input } from '../common/Input';
import { Button } from '../common/Button';
import { useAuth } from '@/hooks/auth/useAuth';

export const RegisterForm = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    confirmPassword: ''
  });
  const { register, isLoading } = useAuth();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await register(formData);
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      <Input
        label="Full Name"
        required
        value={formData.name}
        onChange={(e) => setFormData(prev => ({
          ...prev,
          name: e.target.value
        }))}
      />
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
      <Input
        label="Confirm Password" 
        type="password"
        required
        value={formData.confirmPassword}
        onChange={(e) => setFormData(prev => ({
          ...prev,
          confirmPassword: e.target.value
        }))}
      />
      <Button type="submit" isLoading={isLoading}>
        Create Account
      </Button>
    </form>
  );
};