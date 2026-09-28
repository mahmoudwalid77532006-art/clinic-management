@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-error"><ul><li>{{ session('error') }}</li></ul></div>
@endif
