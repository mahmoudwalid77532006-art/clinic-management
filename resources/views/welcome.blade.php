@extends('layouts.app')
@section('title', 'الرئيسية')
@section('container-class', 'wide')

@section('content')
@php
    $bookUrl = auth()->check()
        ? (auth()->user()->role === 'patient' ? route('appointment.create') : route('appointment.index'))
        : route('register');
@endphp

{{-- ================= Hero ================= --}}
<section class="hero">
    <span class="orb orb-1"></span><span class="orb orb-2"></span>
    <div class="hero-inner">
        <div>
            <span class="hero-tag"><i></i> نستقبل حالاتكم يوميًا — حجز أونلاين على مدار الساعة</span>
            <h1>صحتك تستحق <span>رعاية</span> بمستوى أعلى</h1>
            <p class="lead">فريق طبي متخصص في {{ $stats['departments'] ?: 'عدة' }} أقسام، حجز مواعيد في ثوانٍ، وسجل طبي وروشتات إلكترونية محفوظة بأمان في مكان واحد.</p>
            <div class="hero-cta">
                <a href="{{ $bookUrl }}" class="btn btn-accent btn-lg">📅 احجز موعدك الآن</a>
                <a href="#departments" class="btn btn-lg" style="background:rgba(255,255,255,.12);">استكشف الأقسام</a>
            </div>
            <div class="hero-mini">
                <div><b>+{{ $stats['doctors'] }}</b><span>طبيب متخصص</span></div>
                <div><b>{{ $stats['departments'] }}</b><span>قسم طبي</span></div>
                <div><b>+{{ $stats['services'] }}</b><span>خدمة علاجية</span></div>
            </div>
        </div>
        <div class="hero-art">
            <img src="{{ asset('images/hero-care.svg') }}" alt="رعاية طبية متكاملة">
        </div>
    </div>
</section>

{{-- ================= Quick features bar ================= --}}
<div class="quick-bar">
    <div class="quick-bar-inner">
        <div class="qb-item"><span class="ic">⚡</span><div><strong>حجز سريع</strong><span>موعدك في أقل من دقيقة</span></div></div>
        <div class="qb-item"><span class="ic">👨‍⚕️</span><div><strong>أطباء متخصصون</strong><span>خبرة وكفاءة عالية</span></div></div>
        <div class="qb-item"><span class="ic">💊</span><div><strong>روشتات إلكترونية</strong><span>سجلك دايمًا معاك</span></div></div>
        <div class="qb-item"><span class="ic">🔒</span><div><strong>خصوصية تامة</strong><span>بياناتك محمية بالكامل</span></div></div>
    </div>
</div>

{{-- ================= Departments ================= --}}
<section class="section" id="departments">
    <div class="section-head">
        <span class="eyebrow">أقسامنا الطبية</span>
        <h2>كل التخصصات تحت سقف واحد</h2>
        <p>أقسام مجهزة بأحدث الأجهزة وأطباء متخصصين لتغطية احتياجاتك وعائلتك الصحية.</p>
    </div>

    @if ($departments->isEmpty())
        <p class="empty-state">هتظهر الأقسام هنا بعد إضافتها من لوحة الإدارة.</p>
    @else
        <div class="dept-grid">
            @foreach ($departments as $department)
                <a href="{{ auth()->check() ? route('department.show', $department) : route('login') }}" class="dept-tile">
                    <div class="dept-icon">{{ $department->icon ?: '🏥' }}</div>
                    <h3>{{ $department->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($department->description, 90) ?: 'قسم طبي متكامل بأحدث الأجهزة.' }}</p>
                    <span class="meta">{{ $department->doctors_count }} طبيب · {{ $department->services_count }} خدمة ←</span>
                </a>
            @endforeach
        </div>
    @endif
</section>

{{-- ================= About ================= --}}
<section class="section">
    <div class="about">
        <div class="about-art">
            <img src="{{ asset('images/clinic-interior.svg') }}" alt="تصميم داخل العيادة">
            <div class="float-badge"><span style="font-size:30px;">🏆</span><div><b>+10</b><span>سنوات من الخبرة</span></div></div>
        </div>
        <div>
            <span class="eyebrow">من نحن</span>
            <h2>عيادة الشفاء… رعاية بتبدأ بالاهتمام</h2>
            <p>نؤمن أن التجربة العلاجية الجيدة تبدأ من لحظة الحجز وحتى المتابعة بعد الكشف. لذلك جمعنا الأطباء والخدمات والسجلات الطبية في منظومة واحدة سهلة وآمنة.</p>
            <ul class="check-list">
                <li>نخبة من الأطباء الاستشاريين والأخصائيين</li>
                <li>مواعيد دقيقة بدون انتظار طويل</li>
                <li>سجل طبي وروشتات محفوظة إلكترونيًا</li>
                <li>أسعار واضحة وشفافة لكل خدمة</li>
            </ul>
            <a href="{{ $bookUrl }}" class="btn btn-lg">ابدأ رحلتك العلاجية</a>
        </div>
    </div>
</section>

{{-- ================= Services ================= --}}
<section class="section" id="services">
    <div class="section-head">
        <span class="eyebrow">خدماتنا</span>
        <h2>خدمات طبية بأسعار واضحة</h2>
        <p>اختار الخدمة المناسبة واحجز موعدك مباشرة مع الطبيب المتخصص.</p>
    </div>

    @if ($services->isEmpty())
        <p class="empty-state">لا توجد خدمات متاحة حاليًا.</p>
    @else
        <div class="service-grid">
            @foreach ($services as $service)
                <div class="service-tile">
                    <span class="tag">{{ $service->department?->name ?? 'خدمة عامة' }}</span>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                    <div class="foot">
                        <div class="price">{{ number_format($service->price) }} <small>ج.م</small></div>
                        <span class="dur">⏱ {{ $service->duration_minutes }} دقيقة</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:30px;">
            <a href="{{ auth()->check() ? route('service.index') : route('login') }}" class="btn btn-outline">عرض كل الخدمات</a>
        </div>
    @endif
</section>

{{-- ================= How it works ================= --}}
<section class="section">
    <div class="section-head">
        <span class="eyebrow">إزاي تحجز؟</span>
        <h2>أربع خطوات بسيطة</h2>
    </div>
    <div class="steps">
        <div class="step"><div class="num">1</div><h3>أنشئ حسابك</h3><p>سجّل بياناتك مرة واحدة في أقل من دقيقة.</p></div>
        <div class="step"><div class="num">2</div><h3>اختار الخدمة والطبيب</h3><p>حدد القسم والطبيب والخدمة المناسبة لحالتك.</p></div>
        <div class="step"><div class="num">3</div><h3>حدد الميعاد</h3><p>اختار اليوم والوقت اللي يناسبك وأكّد الحجز.</p></div>
        <div class="step"><div class="num">4</div><h3>تابع روشتتك</h3><p>بعد الكشف هتلاقي الزيارة والروشتة في حسابك.</p></div>
    </div>
</section>

{{-- ================= Doctors ================= --}}
<section class="section" id="doctors">
    <div class="section-head">
        <span class="eyebrow">فريقنا الطبي</span>
        <h2>تعرّف على أطبائنا</h2>
        <p>أطباء بخبرات متنوعة يهتمون بكل تفصيلة في حالتك.</p>
    </div>

    @if ($doctors->isEmpty())
        <p class="empty-state">لا يوجد أطباء مسجلين حاليًا.</p>
    @else
        <div class="doctor-grid">
            @foreach ($doctors as $doctor)
                <div class="doc-tile">
                    <div class="doc-photo"><div class="initial">{{ mb_substr(ltrim(str_replace('د.', '', $doctor->user->name)), 0, 1) }}</div></div>
                    <div class="doc-body">
                        <h3>{{ $doctor->user->name }}</h3>
                        <div class="spec">{{ $doctor->specialty }}</div>
                        <p>{{ \Illuminate\Support\Str::limit($doctor->bio, 70) ?: 'طبيب متخصص في ' . $doctor->specialty }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

{{-- ================= Testimonials ================= --}}
<section class="section">
    <div class="section-head">
        <span class="eyebrow">آراء المرضى</span>
        <h2>ثقتكم هي أكبر إنجاز لنا</h2>
    </div>
    <div class="testi-grid">
        <div class="testi"><div class="stars">★★★★★</div><p>الحجز كان سهل جدًا والدكتور اهتم بكل تفاصيل حالتي، والروشتة لقيتها في حسابي على طول.</p><div class="who"><span class="av">أ</span><div><b>أحمد سمير</b><span>مريض باطنة</span></div></div></div>
        <div class="testi"><div class="stars">★★★★★</div><p>عيادة منظمة ومواعيدها دقيقة، وطفلي ارتاح جدًا مع دكتورة الأطفال. أنصح بيها.</p><div class="who"><span class="av">م</span><div><b>منى عبد الله</b><span>والدة مريض</span></div></div></div>
        <div class="testi"><div class="stars">★★★★★</div><p>أسعار واضحة وتعامل راقي، وقدرت أتابع زياراتي السابقة بدون ما أحتفظ بأي ورق.</p><div class="who"><span class="av">ع</span><div><b>عمر فاروق</b><span>مريض عظام</span></div></div></div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<div class="cta-band">
    <div class="cta-inner">
        <div>
            <h2>جاهز تحجز موعدك؟</h2>
            <p>انضم لمرضانا واحصل على رعاية طبية متكاملة بضغطة زر.</p>
        </div>
        <div class="hero-cta">
            <a href="{{ $bookUrl }}" class="btn btn-accent btn-lg">احجز الآن</a>
            @guest
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">تسجيل الدخول</a>
            @endguest
        </div>
    </div>
</div>
@endsection
