interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
    variant?: 'primary' | 'secondary';
    isLoading?: boolean;
  }
  
  export const Button = ({
    children,
    variant = 'primary',
    isLoading,
    className,
    ...props
  }: ButtonProps) => {
    return (
      <button
        className={`
          w-full px-4 py-2 rounded-lg font-medium transition-colors
          ${variant === 'primary' 
            ? 'bg-blue-500 text-white hover:bg-blue-600' 
            : 'bg-gray-200 text-gray-800 hover:bg-gray-300'}
          ${isLoading && 'opacity-50 cursor-not-allowed'}
          ${className}
        `}
        disabled={isLoading}
        {...props}
      >
        {isLoading ? 'Loading...' : children}
      </button>
    );
  };