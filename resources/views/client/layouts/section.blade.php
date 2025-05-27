<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

  <div class="container">
    <div class="row">
      
      <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1 text-center text-lg-start" data-aos="fade-up" data-aos-delay="200">
          <h1>Cho thuê sân pickleball một cách tốt nhất</h1>
          <h2>Chúng tôi cung cấp các sân bóng tốt với giá cạnh tranh</h2>
        <div class="d-flex justify-content-center justify-content-lg-start gap-3">
          <a href="#portfolio" class="btn btn-light btn-lg px-4 rounded-pill fw-semibold custom-btn">Thuê ngay</a>
          @guest
          <a href="{{ route('client.login') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill fw-semibold custom-btn-outline">Đăng nhập</a>
          @endguest
        </div>
      </div>

      <div class="col-lg-6 order-1 order-lg-2 text-center hero-img" data-aos="zoom-in" data-aos-delay="200">
        <img src="{{ asset('storage/images/Pickleball_Court_Top_View.png') }}" class="img-fluid animated" alt="Pickleball Court">
      </div>

    </div>
  </div>

</section><!-- End Hero -->
