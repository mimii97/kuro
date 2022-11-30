@extends('layouts.master')


@section('title')

  

@endsection


@section('css')



@endsection




@section('content')


<section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">We offer modern solutions for growing your business</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">We are team of talented designers making websites with Bootstrap</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Get Started</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="{{asset('storage/assets/img/hero-img.png')}}" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">



    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <!-- <h2>Testimonials</h2> -->
          <p>Home</p>
        </header>
        @foreach ($slides as $slide)
            
       
        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
              
                    <div class="profile pt-5">
                <a href="#">  <img src="storage/{{$slide->image}}" class="testimonial-img" alt=""></a>
                  <h3>{{$slide->Page_Name}}</h3>
                    
                    </div>

                <p>
                
                </p>
               
              </div>
            </div><!-- End testimonial item -->
            @endforeach

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- End Testimonials Section -->


 


    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Vote To Earn</p>
          <h2>Check our Pricing</h2>
          
        </header>

        <div class="row gy-4" data-aos="fade-left">
          @foreach ($vote_planes as $plan)
              
          
          <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
            <div class="box">
              <h3 style="color: {{$plan->color}};">Free Plan</h3>
              <div class="price"><sup>$</sup>{{$plan->price}}<span> / mo</span></div>
              <img src="'storage/'{{$plan->image}}" class="img-fluid" alt="">
             
              <a href="{{$plan->url}}" class="btn-buy">Buy Now</a>
            </div>
          </div>
@endforeach

      </div>

    </section><!-- End Pricing Section -->



    <!-- ======= Team Section ======= -->
    <section id="team" class="team">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
        
          <p>WhitePaper</p>
        </header>

        <div class="row gy-4">
@foreach ($banners as $banner)
<div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
  <div class="member">
    <div class="member-img">
      <img src="storage/{{$banner->image}}" class="img-fluid" alt="">
      <div class="social">
        <a href=""><i class="bi bi-twitter"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
    <div class="member-info">
     
      <p>{{$banner->image}}</p>
    </div>
  </div>
</div>
    
@endforeach



          
        </div>

      </div>

    </section><!-- End Team Section -->



    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>Our Partners</p>
       
        </header>

        <div class="clients-slider swiper">
          <div class="swiper-wrapper align-items-center">
            @foreach ($infos as $info)
                
            <div class="swiper-slide"><a href="{{$info->url}}"><img src="storage/{{$info->logo}}" class="img-fluid" alt=""> </a></div>
            @endforeach

          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </section><!-- End Clients Section -->







    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </header>

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>A108 Adam Street,<br>New York, NY 535022</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p>info@example.com<br>contact@example.com</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>

          </div>

        </div>

      </div>

    </section><!-- End Contact Section -->

  </main><!-- End #main -->




@endsection

@section('js')
<script src="yall.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", yall);
</script>

    <script>

        $(document).ready(function(){

            $('#most_registed').owlCarousel({
                loop: false,
                rtl: true,
                items: 3,
                nav: true,
                dots: false,
                smartSpeed: 500,
                autoplay: false,
                margin: 30,
                navText: ["<i class='la la-arrow-left'></i>", "<i class='la la-arrow-right'></i>"],
                responsive:{
                    320:{
                        items: 1,
                    },
                    992:{
                        items: 3,
                    }
                }
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                let business_active = $('#business').hasClass('active');
                let design_active = $('#design').hasClass('active');
                let development_active = $('#development').hasClass('active');
                let drawing_active = $('#drawing').hasClass('active');

                $('#browse_all_cources').prop('hidden', !business_active);
                $('#browse_all_qual_progs').prop('hidden', !design_active);
                $('#browse_all_agency_progs').prop('hidden', !development_active);
                $('#browse_all_trading_progs').prop('hidden', !drawing_active);


            });

      

        });





    
        $('.carousel').carousel({
  interval:5000
})

$('.carousel .carousel-item').each(function(){
    var minPerSlide = 1;
    var next = $(this).next();
    if (!next.length) {
    next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));
    
    for (var i=0;i<minPerSlide;i++) {
        next=next.next();
        if (!next.length) {
        	next = $(this).siblings(':first');
      	}
        
        next.children(':first-child').clone().appendTo($(this));
      }
});







    </script>

@endsection
