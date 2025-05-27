@extends('client.extend')

@section('client_content')
    <main id="main">
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                {{ Breadcrumbs::render('client-order-by-me') }}
                <h2>Yêu cầu đặt sân của tôi</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="container">
            @include('client.layouts.alert')

            <div class="row">
                @foreach ($orders as $item)
                    <div class="col-lg-12">
                        <div class="card shadow-sm mb-4 border-0 bg-light">
                            <div class="card-body">
                                <div class="row align-items-center">

                                    <div class="col-md-3">
                                        <span class="fw-bold text-uppercase">Trạng thái:</span>
                                        @if ($item->status == 0)
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @elseif ($item->status == 1)
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                        @elseif ($item->status == 2)
                                            <span class="badge bg-success">Thành công</span>
                                        @else
                                            <span class="badge bg-primary">Đã thanh toán</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4">
                                        <span class="fw-bold text-uppercase">Tên sân:</span>
                                        <p class="mb-0">{{ $item->footballPitch->name }} - {{ $item->footballPitch->pitchType->description }}</p>
                                    </div>

                                    <div class="col-md-3">
                                        <span class="fw-bold text-uppercase">Tổng tiền:</span>
                                        <p class="text-danger mb-0">{{ $item->total() }} </p>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="fw-bold text-uppercase">Tiền cọc:</span>
                                        <p class="text-success mb-0">{{ $item->deposit() }} </p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="fw-bold text-uppercase">Thời gian thuê:</span>
                                        <p class="mb-0">
                                            <i class="bi bi-clock"></i> {{ date('H:i', strtotime($item->start_at)) }} - {{ date('H:i', strtotime($item->end_at)) }}
                                        </p>
                                        <p class="mb-0"><i class="bi bi-calendar"></i> {{ date('d/m/Y', strtotime($item->start_at)) }}</p>
                                    </div>

                                    <div class="col-md-3">
                                        <span class="fw-bold text-uppercase">Tổng thời gian thuê:</span>
                                        <p class="mb-0">{{ $item->totalTime() }}</p>
                                    </div>

                                    <div class="col-md-3">
                                        <span class="fw-bold text-uppercase">Mã đặt sân:</span>
                                        <p class="text-primary mb-0">{{ $item->code }}</p>
                                    </div>

                                    <div class="col-md-2">
                                        <span class="fw-bold text-uppercase">Đặt lúc:</span>
                                        <p class="mb-0">{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</p>
                                    </div>
                                </div>

                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="fw-bold text-uppercase">Dịch vụ đi kèm:</span>
                                        <ul class="list-unstyled mt-2">
                                            @foreach ($item->equipments as $equipment)
                                                {{ $equipment->name }} ({{ $equipment->pivot->quantity }} x {{ number_format($equipment->pivot->price, 0, ',', '.') }} đ) <br>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                @if ($item->status == 1)
                                    <div class="text-end">
                                        <form action="{{ route('order.cancelOrder', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đặt sân này không?');">
                                            @csrf
                                            @method('put')
                                            <button class="btn btn-danger">Hủy sân</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $orders->links() }}
        </section>
    </main><!-- End #main -->

    <script>
        document.querySelector('#header').classList.add('header-inner-pages');
    </script>
@endsection
