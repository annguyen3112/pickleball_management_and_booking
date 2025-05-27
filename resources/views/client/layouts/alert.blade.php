{{-- Thông báo khi tác động --}}
@if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Thông báo nếu có lỗi đầu vào --}}
@if ($errors->any())
    @foreach ($errors->all() as $item)
        @if (!str_contains($item, 'address'))
            <div class="alert alert-danger">{{ $item }}</div>
        @endif
    @endforeach
@endif

