@extends('client.extend')
@section('client_content')
    <main id="main">
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
                {{ Breadcrumbs::render('client-footballPitch') }}
                <h2>Thông tin đặt sân</h2>
            </div>
        </section><!-- End Breadcrumbs -->
        <section class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="border p-3 mt-4 mt-lg-0 rounded bg-white">
                        <h4 class="header-title mb-3 fw-bold">Thông tin đặt sân</h4>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>Tên sân :</td>
                                        <td>{{ $order->footballPitch->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mã đặt sân :</td>
                                        <td>{{ $order->code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Người đặt :</td>
                                        <td>{{ $order->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại : </td>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email : </td>
                                        <td>{{ $order->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Thời gian đặt :</td>
                                        <td>{{ $order->start_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Thời gian kết thúc : </td>
                                        <td>{{ $order->end_at }}</td>
                                    </tr>                      
                                    <tr>
                                        <td>Dịch vụ đi kèm:</td>
                                        <td>
                                            @foreach ($order->equipments as $equipment)
                                                {{ $equipment->name }} ({{ $equipment->pivot->quantity }} x {{ number_format($equipment->pivot->price, 0, ',', '.') }} đ) <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng tiền (bao gồm dịch vụ đi kèm):</th>
                                        <th>{{ $order->total() }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="border p-3 mt-3 rounded bg-white text-center">
                        <p class="text-danger">Đơn đặt sân của bạn còn được giữ chỗ trong <span id="countdown">05:00</span></p>
                        <button id="confirm-payment" class="btn btn-success">Xác nhận thanh toán</button>
                    </div>
                    <div class="alert alert-info mt-2">
                        <i class="bi bi-info-circle"></i>
                        Sau khi đã chuyển khoản thành công, bạn có thể xem trạng thái thanh toán của mình trong mục "Yêu cầu đã đặt" trong tab "Tài khoản"
                         hoặc bạn có thể tra cứu yêu cầu đặt sân của bạn theo "Mã đặt sân" ở trên.
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="border p-3 mt-4 mt-lg-0 rounded bg-white">
                        <h4 class="header-title mb-3 fw-bold">Thông tin chuyển khoản
                        </h4>

                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td>Số tiền :</td>
                                        <td>{{ $order->deposit() }} - {{ $order->total() }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nội dung :</td>
                                        <td>tien coc {{ $order->id }}</td>
                                    </tr>
                                    @foreach ($bankInfo as $item)
                                        <tr>
                                            <td>Tên chủ thẻ :</td>
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Số tài khoản :</td>
                                            <td>{{ $item->bank_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Ngân hàng :</td>
                                            <td>{{ $item->bank }}</td>
                                        </tr>
                                        @if ($item->image)
                                            <tr align="center">
                                                <td colspan="2"><img src="{{ asset("storage/$item->image") }}"
                                                        width="300" class="img-fluid" alt=""></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
    <script>
        document.querySelector('#header').classList.add('header-inner-pages');
    
        let countdownElem = document.getElementById('countdown');
        let confirmButton = document.getElementById('confirm-payment');
        let bookingTime = 300;
        let isLoggedIn = @json(auth()->check());
        
        // Lấy thời gian hết hạn từ localStorage
        let expiryTime = localStorage.getItem('expiryTime');
    
        if (!expiryTime) {
            expiryTime = Date.now() + bookingTime * 1000;
            localStorage.setItem('expiryTime', expiryTime);
        }
    
        function updateCountdown() {
            let now = Date.now();
            let timeLeft = Math.floor((expiryTime - now) / 1000);
    
            if (timeLeft <= 0) {
                countdownElem.textContent = "00:00";
                clearInterval(timer);
                localStorage.removeItem('expiryTime');
                document.getElementById('cancel-form').submit();
                return;
            }
    
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            countdownElem.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }
    
        // cap nhat dong ho moi giay
        let timer = setInterval(updateCountdown, 1000);
        updateCountdown();
    
        confirmButton.addEventListener('click', function() {
            clearInterval(timer); // dung dong ho
            localStorage.removeItem('expiryTime');
            if (isLoggedIn) {
                window.location.href = "{{ route('order.success', ['id' => $order->id]) }}";
            } else {
                window.location.href = "{{ route('client.guest.success', ['id' => $order->id]) }}";
            } 
        });
    </script>
    
    <!-- Form hủy đơn bằng PUT -->
    <form id="cancel-form" action="{{ auth()->check() ? route('order.cancel', ['id' => $order->id]) : route('client.guest.cancel', ['id' => $order->id]) }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>    
@endsection
