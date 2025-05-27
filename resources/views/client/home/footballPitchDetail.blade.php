@extends('client.extend')
@section('client_content')
    <main id="main">
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                {{ Breadcrumbs::render('client-footballPitch') }}
                @if ($footballPitch['is_maintenance'])
                    <h2 class="card-title text-danger">Thông tin - {{ $footballPitch->name }} - Đang bảo trì</h2>
                @else
                    <h2>Thông tin - {{ $footballPitch->name }}</h2>
                @endif
            </div>
        </section><!-- End Breadcrumbs -->
        <!-- ======= Portfolio Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-7">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">

                                @if ($footballPitch->images->count() > 0)
                                    @foreach ($footballPitch->images as $item)
                                        <div class="swiper-slide">
                                            <img src="{{ asset("storage/$item->image") }}" alt="image">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img src="{{ config('app.image') . 'images/football_pitches/default_football_pitch.png' }}"
                                            alt="">
                                    </div>
                                @endif
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="portfolio-info">
                            <h3>Thông tin</h3>
                            <ul>
                                <li><strong>Tên</strong>: {{ $footballPitch->name }}</li>
                                <li>
                                    <strong>Tình trạng</strong>:
                                    @if ($footballPitch->is_maintenance)
                                        <span class="badge bg-danger">Đang bảo trì</span>
                                    @else
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    @endif
                                </li>
                                <li><strong>Giá tiền</strong>: {{ $footballPitch->pricePerHour() }} -
                                    {{ $footballPitch->pricePerPeakHour() }}</li>
                                <li><strong>Thời gian mở - đóng</strong>: {{ $footballPitch->timeStart() }} -
                                    {{ $footballPitch->timeEnd() }}</li>
                                <li><strong>Số lần đặt</strong>: {{ $footballPitch->countOrderSuccess() }}</li>
                                {{-- <li><strong>Sân liên kết</strong>: {{ $footballPitch->nameFootBallPitchLink() }}</li> --}}
                                <li>
                                    <button @if ($footballPitch->is_maintenance) disabled @endif class="btn btn-success"
                                        data-bs-toggle="modal" data-bs-target="#orderModal">Đặt
                                        ngay</button>
                                </li>
                                <li>
                                    <button @if ($footballPitch->is_maintenance) disabled @endif class="btn btn-success"
                                        data-bs-toggle="modal" data-bs-target="#findTimeModal">Xem thời gian sân đã
                                        đặt</button>
                                </li>
                            </ul>
                        </div>
                        <div class="portfolio-info">
                            <h2>Mô tả</h2>
                            <p>
                                {{ $footballPitch->description }}
                            </p>
                        </div>
                        <div class="portfolio-info">
                            <h3>Bình luận</h3>
                                <!-- Form nhập bình luận -->
                                <div class="card shadow-sm p-3 bg-white rounded">
                                    <h4 class="mb-3">Để lại bình luận</h4>
                                    <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="football_pitch_id" value="{{ $footballPitch->id }}">

                                        <div class="mb-3">
                                            <label for="content" class="form-label fw-bold">Nội dung</label>
                                            <textarea id="comment-text" class="form-control" name="content" rows="3" placeholder="Nhập bình luận của bạn..." required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="rating" class="form-label fw-bold">Đánh giá</label>
                                            <select class="form-select" name="rating">
                                                <option value="1">⭐</option>
                                                <option value="2">⭐⭐</option>
                                                <option value="3">⭐⭐⭐</option>
                                                <option value="4">⭐⭐⭐⭐</option>
                                                <option value="5">⭐⭐⭐⭐⭐</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100">Gửi bình luận</button>
                                    </form>
                                </div>

                                <!-- Danh sách bình luận -->
                            <h4 class="mt-4">Danh sách bình luận</h4>
                                <div class="list-group">
                                    @foreach($footballPitch->comments->sortByDesc('created_at') as $comment)
                                        <div class="list-group-item list-group-item-action d-flex align-items-start p-3 border rounded mb-2 shadow-sm">
                                            <img src="https://i.pravatar.cc/40?u={{ $comment->user->id }}" class="rounded-circle me-3" width="40" height="40" alt="Avatar">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">
                                                    {{ $comment->user->name }} 
                                                    <span class="text-muted fs-6"> - {{ $comment->created_at->format('d/m/Y') }}</span>
                                                </h6>
                                                <p class="mb-1 text-warning">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $comment->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </p>                                                
                                                <p class="mb-0">{{ $comment->content }}</p>
                                            </div>

                                            @if (auth()->check() && (auth()->user()->role == \App\Enums\UserRole::Employee || auth()->user()->role == \App\Enums\UserRole::CourtOwner || auth()->user()->id == $comment->user_id))
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="ms-3">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                                        🗑 Xóa
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Portfolio Details Section -->
    </main><!-- End #main -->
    @include('client.modal.order')
    @include('client.modal.findTime')
    <script>
        document.querySelector('#header').classList.add('header-inner-pages');
    </script>
@endsection
