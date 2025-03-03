import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'

export function middleware(request: NextRequest) {
    // Lấy token từ cookies
    const token = request.cookies.get('token')?.value;
    
    // Danh sách các đường dẫn không cần xác thực
    const publicPaths = ['/', '/login', '/register', '/about'];
    
    const isPublicPath = publicPaths.some(path => 
      request.nextUrl.pathname === path || request.nextUrl.pathname.startsWith(path + '/')
    );
    
    // Nếu không có token và không phải là public path, chuyển hướng đến trang đăng nhập
    if (!token && !isPublicPath) {
      return NextResponse.redirect(new URL('/login', request.url));
    }
    
    // Nếu có token và đang ở trang đăng nhập, chuyển hướng đến dashboard
    if (token && request.nextUrl.pathname === '/login') {
      return NextResponse.redirect(new URL('/dashboard', request.url));
    }
    
    return NextResponse.next();
  }
  
  // Chỉ định các đường dẫn mà middleware sẽ chạy
  export const config = {
    matcher: [
      // Bảo vệ tất cả các đường dẫn trừ các đường dẫn công khai
      '/((?!api|_next/static|_next/image|favicon.ico).*)',
    ],
  };