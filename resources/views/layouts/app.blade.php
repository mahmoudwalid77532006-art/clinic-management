<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — عيادة الشفاء</title>
    <link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/clinic.css') }}">
    @yield('head')
</head>
<body>

    <header class="topnav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('images/logo.svg') }}" alt="عيادة الشفاء">
                <span class="brand-text">
                    <span class="brand-name">عيادة الشفاء</span>
                    <span class="brand-sub">رعاية طبية متكاملة</span>
                </span>
            </a>

            <button class="nav-toggle" type="button" aria-label="القائمة" onclick="document.getElementById('navlinks').classList.toggle('open')">☰</button>

            <nav class="nav-links" id="navlinks">
                <a href="{{ route('home') }}" class="navlink {{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>

                @auth
                    @php($role = auth()->user()->role)
                    <a href="{{ route('appointment.index') }}" class="navlink {{ request()->routeIs('appointment.*') ? 'active' : '' }}">المواعيد</a>
                    <a href="{{ route('doctor.index') }}" class="navlink {{ request()->routeIs('doctor.*') ? 'active' : '' }}">الأطباء</a>
                    <a href="{{ route('department.index') }}" class="navlink {{ request()->routeIs('department.*') ? 'active' : '' }}">الأقسام</a>
                    <a href="{{ route('service.index') }}" class="navlink {{ request()->routeIs('service.*') ? 'active' : '' }}">الخدمات</a>

                    @if ($role === 'admin')
                        <a href="{{ route('patient.index') }}" class="navlink {{ request()->routeIs('patient.*') ? 'active' : '' }}">المرضى</a>
                        <a href="{{ route('user.index') }}" class="navlink {{ request()->routeIs('user.*') ? 'active' : '' }}">المستخدمين</a>
                    @endif

                    @if (in_array($role, ['doctor', 'admin']))
                        <a href="{{ route('visit.index') }}" class="navlink {{ request()->routeIs('visit.*') ? 'active' : '' }}">الزيارات</a>
                        <a href="{{ route('prescription.index') }}" class="navlink {{ request()->routeIs('prescription.*') ? 'active' : '' }}">الروشتات</a>
                    @endif

                    <div class="nav-actions">
                        <span class="user-pill">
                            <span class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                            <span>{{ auth()->user()->name }}<small>{{ ['admin' => 'مدير النظام', 'doctor' => 'طبيب', 'patient' => 'مريض'][$role] ?? $role }}</small></span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="nav-form">
                            @csrf
                            <button type="submit" class="logout-btn">خروج</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('home') }}#departments" class="navlink">الأقسام</a>
                    <a href="{{ route('home') }}#services" class="navlink">الخدمات</a>
                    <a href="{{ route('home') }}#doctors" class="navlink">الأطباء</a>
                    <div class="nav-actions">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-muted">تسجيل دخول</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-accent">احجز الآن</a>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container @yield('container-class')">
        @include('partials.flash')
        @include('partials.errors')

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <div>
                <a href="{{ route('home') }}" class="brand" style="margin-bottom:16px;">
                    <img src="{{ asset('images/logo.svg') }}" alt="">
                    <span class="brand-text"><span class="brand-name">عيادة الشفاء</span><span class="brand-sub">رعاية طبية متكاملة</span></span>
                </a>
                <p>نقدّم رعاية صحية بمعايير عالية وفريق طبي متخصص، مع حجز سهل وسجل طبي إلكتروني آمن لكل مريض.</p>
            </div>
            <div>
                <h4>روابط سريعة</h4>
                <a href="{{ route('home') }}">الرئيسية</a>
                @auth
                    <a href="{{ route('department.index') }}">الأقسام</a>
                    <a href="{{ route('service.index') }}">الخدمات</a>
                    <a href="{{ route('doctor.index') }}">الأطباء</a>
                @else
                    <a href="{{ route('login') }}">تسجيل الدخول</a>
                    <a href="{{ route('register') }}">إنشاء حساب</a>
                @endauth
            </div>
            <div>
                <h4>مواعيد العمل</h4>
                <p style="margin-bottom:6px;">السبت – الخميس</p>
                <p style="color:#fff;font-weight:700;margin-bottom:12px;">9:00 ص — 10:00 م</p>
                <p>الجمعة: بالحجز المسبق</p>
            </div>
            <div class="footer-contact">
                <h4>تواصل معنا</h4>
                <div>📍 <span>الزقازيق، محافظة الشرقية</span></div>
                <div>📞 <span dir="ltr">0100 000 0000</span></div>
                <div>✉️ <span>info@alshifa-clinic.test</span></div>
            </div>
        </div>
        <div class="footer-bottom">© {{ date('Y') }} عيادة الشفاء — جميع الحقوق محفوظة</div>
    </footer>

</body>
</html>
