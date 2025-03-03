'use client';

import React from 'react';
import { useAuth } from '@/hooks/auth/useAuth';

const Dashboard = () => {
    
  const { logout, isLoading, error } = useAuth();

  const handleLogout = async () => {
    await logout();
  };

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div className="px-4 py-6 sm:px-0">
          <div className="bg-white shadow rounded-lg p-6">
            <div className="flex justify-between items-center mb-6">
              <h1 className="text-2xl font-bold text-gray-900">Dashboard</h1>
              <button
                onClick={handleLogout}
                className="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200"
              >
                Log out
              </button>
            </div>
            
            <div className="border-t border-gray-200 pt-4">
              <p className="text-gray-600">
                Welcome back, {'User'}!
              </p>
              
              <div className="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div className="bg-gray-50 p-4 rounded-lg">
                  <h3 className="text-lg font-medium text-gray-900">Profile Info</h3>
                  <p className="mt-1 text-gray-600">Email:</p>
                </div>
                {/* Add more dashboard content here */}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;