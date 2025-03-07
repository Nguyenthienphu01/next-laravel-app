interface AuthLayoutProps {
    children: React.ReactNode;
    title: string;
  }
  
  export const AuthLayout = ({ children, title }: AuthLayoutProps) => {
    return (
      <div className="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div className="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
          <div>
            <h2 className="text-center text-3xl font-bold text-gray-900">
              {title}
            </h2>
          </div>
          {children}
        </div>
      </div>
    );
  };