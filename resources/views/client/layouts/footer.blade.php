<!-- ======= Footer ======= -->
<footer id="footer" class="bg-light rounded-top shadow mt-5" style="border-top: 4px solid #8DA49A;">
    <div class="container py-5">
        <div class="row justify-content-between">

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-success fw-bold">{{ config('app.name') }}</h5>
                <p class="text-dark mt-3">
                    <strong>Địa chỉ:</strong> Hà Nội, Việt Nam<br>
                    <strong>Điện thoại:</strong> 0329388562<br>
                    <strong>Email:</strong> picklecourt@gmail.com<br>
                </p>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-success fw-bold">Liên kết</h5>
                <ul class="list-unstyled mt-3">
                    <li><a href="{{ route('client.index') }}#hero" class="text-dark text-decoration-none">Trang chủ</a></li>
                    <li><a href="{{ route('client.index') }}#services" class="text-dark text-decoration-none">Dịch vụ</a></li>
                    <li><a href="{{ route('client.index') }}#portfolio" class="text-dark text-decoration-none">Sân bóng</a></li>
                    <li><a href="{{ route('client.index') }}#about" class="text-dark text-decoration-none">Về chúng tôi</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-success fw-bold">Mạng xã hội</h5>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" target="_blank" class="btn btn-outline-success btn-sm rounded-circle">
                        <i class="bx bxl-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm rounded-circle">
                        <i class="bx bxl-instagram"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="text-center py-3 border-top border-success-subtle small text-white" style="background-color: var(--background);">
        &copy; 2025 <strong class="text-white">{{ config('app.name') }}</strong>. All rights reserved.
    </div>

</footer>
