@extends('layouts.main.master')
@section('title')
    {{ $setting->company }}
@endsection
@section('description')
    {{ $setting->webname }}
@endsection
@section('image')
    @php
        $ogBanner = $banner->first();
        $ogImage = $ogBanner && $ogBanner->image ? url($ogBanner->image) : url($setting->logo ?? '');
    @endphp
    {{ $ogImage }}
@endsection
@section('css')
@endsection
@section('js')
@endsection
@section('content')
<div class="bodywrap">
  <h1 class="d-none">{{$setting->company}}</h1>
  <div class="box_slide_banner box_slide_banner--full">
     <div class="home-slider swiper-container">
        <div class="swiper-wrapper">
         @foreach ($banner as $item)
         <div class="swiper-slide">
           <div class="hero-banner">
             <div class="hero-banner__desktop d-none d-lg-block">
               <div class="hero-banner__media">
                 <img
                   src="{{ url($item->image) }}"
                   alt="{{ $item->title ?: 'Fio Coffee' }}"
                   class="hero-banner__img" />
               </div>
               <div class="container hero-banner__inner">
                 <div class="hero-banner__content">
                   <h2 class="hero-banner__title">{{ $item->title ?: 'Cà phê phin Việt tiện lợi cho mọi hành trình' }}</h2>
                   <p class="hero-banner__desc">{!! $item->description ?: 'Giữ trọn hương vị cà phê phin truyền thống trong một cách thưởng thức đơn giản và tiện lợi hơn.' !!}</p>
                   <div class="hero-banner__actions">
                     <a href="{{ $item->link ?: route('allProduct') }}" class="hero-banner__btn hero-banner__btn--primary" title="Mua ngay">MUA NGAY</a>
                     <a href="{{ route('aboutUs') }}" class="hero-banner__btn hero-banner__btn--outline" title="Khám phá Fio">KHÁM PHÁ FIO</a>
                   </div>
                 </div>
               </div>
             </div>
             @if (!empty($item->image_mobile))
             <div class="hero-banner__mobile d-lg-none">
               <div class="hero-banner__mobile-media">
                 <img
                   src="{{ url($item->image_mobile) }}"
                   alt="{{ $item->title ?: 'Fio Coffee' }}"
                   class="hero-banner__mobile-img" />
               </div>
               <div class="hero-banner__mobile-body">
                 <div class="hero-banner__mobile-content">
                   <h2 class="hero-banner__title">{{ $item->title ?: 'Cà phê phin Việt tiện lợi cho mọi hành trình' }}</h2>
                   <p class="hero-banner__desc">{!! $item->description ?: 'Giữ trọn hương vị cà phê phin truyền thống trong một cách thưởng thức đơn giản và tiện lợi hơn.' !!}</p>
                 </div>
                 <div class="hero-banner__mobile-actions">
                   <a href="{{ $item->link ?: route('allProduct') }}" class="hero-banner__btn hero-banner__btn--primary" title="Mua ngay">MUA NGAY</a>
                   <a href="{{ route('allProduct') }}" class="hero-banner__btn hero-banner__btn--outline" title="Khám phá sản phẩm">KHÁM PHÁ SẢN PHẨM</a>
                 </div>
               </div>
             </div>
             @endif
           </div>
        </div>
         @endforeach
        </div>
     </div>
  </div>
  <script>
     var swiper = new Swiper('.home-slider', {
         loop: true,
         autoHeight: true,
         autoplay: {
             delay: 4500,
         }
     });
  </script>
  <section class="section_cate container">
     <h2 class="title-module">
        <a href="javascript:;" title=" Tại sao FIO khác cà phê hòa tan và cà phê pha sẵn?">
          Tại sao FIO khác cà phê hòa tan và cà phê pha sẵn?
        </a>
     </h2>
     <div class="why-choise">
      @foreach ($whyChoose as $item)
      <div class="why-choise__item">
         <div class="why-choise__icon" aria-hidden="true">
            <img
               src="{{ url($item->image) }}"
               width="50"
               height="50"
               alt="" />
         </div>
         <div class="why-choise__content">
            <h3 class="why-choise__title">{{ $item->title }}</h3>
            <p class="why-choise__desc">{{ $item->description }}</p>
         </div>
      </div>
      @endforeach
     </div>
  </section>
  <section class="section_flash_sale container">
      <h2 class="title-module">
         <a href="javascript:;" title="Sản phẩm của chúng tôi">
         Sản phẩm của chúng tôi
         </a>
      </h2>
     <div class="box_flash_sale">
        <div class="row">
         @forelse ($homePro as $item)
         <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" style="margin-bottom: 10px;">
            @include('layouts.product.item', ['pro' => $item])
         </div>
         @endforeach
           {{-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
              <div class="product-flash-swiper swiper-container">
                 <div class="swiper-wrapper load-after" data-section="section_flash_sale">
                    @forelse ($homePro as $item)
                    <div class="swiper-slide">
                       
                    </div>
                    @empty
                    <div class="swiper-slide">
                       <p>Chưa có sản phẩm khuyến mãi.</p>
                    </div>
                    @endforelse
                 </div>
                 <div class="swiper-button-prev"></div>
                 <div class="swiper-button-next"></div>
              </div>
           </div> --}}
        </div>
     </div>
  </section>



  <section class="section_enjoy">
     <div class="container">
      <h2 class="title-module title-module--enjoy">
         <a href="javascript:;" title="Cách thưởng thức Fio">
            <span class="title-module__highlight">Cách</span> thưởng thức Fio
         </a>
      </h2>
      @if(isset($processSteps) && count($processSteps))
      <div class="enjoy-content">
         <div class="enjoy-steps">
            @foreach ($processSteps as $step)
            <div class="enjoy-step">
               <span class="enjoy-step__num">{{ $loop->iteration }}</span>
               <div class="enjoy-step__icon">
                  <img src="{{ $step->image ? url($step->image) : asset('frontend/images/lazy.png') }}" width="56" height="56" alt="{{ $step->title }}">
               </div>
               <p class="enjoy-step__label">{{ $step->title }}</p>
               <small class="enjoy-step__desc">{{ $step->description }}</small>
            </div>
            @if (!$loop->last)
            <span class="enjoy-step__arrow" aria-hidden="true">→</span>
            @endif
            @endforeach
         </div>
      </div>
      <div class="enjoy-content-mobile">
         <div class="enjoy-timeline">
            @foreach ($processSteps as $step)
            <div class="enjoy-timeline__item">
               <div class="enjoy-timeline__track">
                  <span class="enjoy-timeline__num">{{ $loop->iteration }}</span>
               </div>
               <div class="enjoy-timeline__card">
                  <div class="enjoy-timeline__icon">
                     <img src="{{ $step->image ? url($step->image) : asset('frontend/images/lazy.png') }}" width="40" height="40" alt="{{ $step->title }}">
                  </div>
                  <div class="enjoy-timeline__content">
                     <p class="enjoy-timeline__label">{{ $step->title }}</p>
                     <small class="enjoy-timeline__desc">{{ $step->description }}</small>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
      @endif
     </div>
  </section>
  
  <section class="section_why_choose">
     <div class="container">
        <div class="row">
         <div class="col-lg-4 col-md-4">
            <h2 class="title-module">
               <a href="javascript:;" title="Câu chuyện về Fio">
                  Câu chuyện về Fio
               </a>
            </h2>
            <p class="content_choose">{!!$gioithieu->description!!}
            </p>
            <a href="{{route('aboutUs')}}" class="hero-banner__btn hero-banner__btn--primary" title="Tìm hiểu thêm">Tìm hiểu thêm</a>
         </div>
           <div class="col-lg-8 col-md-8">
              <div class="img_thm">
                 <div class="box_img">
                    <img class="lazyload"
                       src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                       data-src="{{url(json_decode($gioithieu->image)[0])}}"
                       alt="Tại sao chọn chúng tôi" />
                 </div>
                 {{-- <div class="icon_video open_video" data-video="5RCh8JzLL5Y">
                    <span><i></i></span>
                 </div> --}}
              </div>
           </div>
           
        </div>
     </div>
     {{-- <div class="popup_video position-fixed w-100 h-100 justify-content-center align-items-center d-flex">
        <div class="position-relative max-100">
           <a href="javascript:;"
              class="close_video position-absolute d-flex m_white_bg_module justify-content-center align-items-center"
              title="Đóng"><img width="16" height="16" alt="Đóng"
              src="https://bizweb.dktcdn.net/100/509/495/themes/943203/assets/close.svg?1781227749084"></a>
           <div class="b_video p-2 p-md-3 m_white_bg_module rounded m-auto"></div>
        </div>
     </div> --}}
  </section>
 
  <section class="section_danh_gia lazyload">
     <div class="container">
      <h2 class="title-module">
         <a href="javascript:;" title="Khách hàng nói gì về Fio">
            Khách hàng nói gì về Fio
         </a>
      </h2>
        <div class="review-swiper-wrap">
           <div class="swiper_feedback swiper-container">
              <div class="swiper-wrapper">
               @foreach ($ReviewCus as $item)
               <div class="swiper-slide">
                  <div class="review-card">
                     <div class="review-card__header">
                        <div class="review-card__avatar">
                           <img width="56" height="56" class="lazyload"
                              src="{{ asset('frontend/images/lazy.png') }}"
                              data-src="{{ url($item->avatar) }}"
                              alt="{{ languageName($item->name) }}" />
                        </div>
                        <div class="review-card__stars" aria-label="5 sao">
                           @for ($i = 0; $i < 5; $i++)
                           <span class="review-card__star" aria-hidden="true">★</span>
                           @endfor
                        </div>
                     </div>
                     <div class="review-card__content">{!! languageName($item->content) !!}</div>
                     <div class="review-card__name">{{ languageName($item->name) }}</div>
                  </div>
               </div>
               @endforeach
              </div>
              <button type="button" class="swiper-button-prev review-swiper__nav" aria-label="Xem trước"></button>
              <button type="button" class="swiper-button-next review-swiper__nav" aria-label="Xem tiếp"></button>
           </div>
        </div>
     </div>
  </section>
  <script>
     var swiper_feedback = new Swiper('.swiper_feedback', {
         slidesPerView: 1,
         spaceBetween: 16,
         watchOverflow: true,
         slidesPerGroup: 1,
         grabCursor: true,
         navigation: {
             nextEl: '.swiper_feedback .swiper-button-next',
             prevEl: '.swiper_feedback .swiper-button-prev',
         },
         breakpoints: {
             640: {
                 slidesPerView: 1,
                 spaceBetween: 16
             },
             768: {
                 slidesPerView: 2,
                 spaceBetween: 20
             },
             992: {
                 slidesPerView: 3,
                 spaceBetween: 24
             }
         }
     });
  </script>
   <section class="section-faq">
      <div class="container">
         <h2 class="title-module title-module--faq">
            <a href="javascript:;" title="Câu hỏi thường gặp">
               <span class="title-module__highlight">Câu hỏi</span> thường gặp
            </a>
         </h2>
         @if(isset($homeFaqs) && count($homeFaqs))
         <div class="home-faq" id="home-faq">
            @foreach ($homeFaqs as $faq)
            <div class="home-faq__item">
               <button type="button" class="home-faq__question" aria-expanded="false">
                  <span class="home-faq__question-text">{{ $faq->question }}</span>
                  <span class="home-faq__icon" aria-hidden="true">
                     <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1.5L7 6.5L13 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     </svg>
                  </span>
               </button>
               <div class="home-faq__answer">
                  <div class="home-faq__answer-inner">{!! $faq->answer !!}</div>
               </div>
            </div>
            @endforeach
         </div>
         @endif
      </div>
   </section>
   <script>
      $(function () {
         $('#home-faq .home-faq__question').on('click', function () {
            var $btn = $(this);
            var $item = $btn.closest('.home-faq__item');
            var $answer = $item.find('.home-faq__answer');
            var isOpen = $item.hasClass('is-open');

            $item.toggleClass('is-open');
            $btn.attr('aria-expanded', !isOpen);
            $answer.stop(true, true).slideToggle(250);
         });
      });
   </script>
   <section class="tieuchi">
      <div class="container">
         <div class="tieuchi__list">
            <div class="tieuchi__item">
               <div class="tieuchi__icon" aria-hidden="true">
                  <img src="{{ asset('frontend/images/tieuchi/icon-shipping.svg') }}" width="40" height="40" alt="">
               </div>
               <div class="tieuchi__text">
                  <strong class="tieuchi__title">Giao hàng toàn quốc</strong>
                  <span class="tieuchi__desc">Miễn phí đơn từ 300.000đ</span>
               </div>
            </div>
            <div class="tieuchi__item">
               <div class="tieuchi__icon" aria-hidden="true">
                  <img src="{{ asset('frontend/images/tieuchi/icon-shield.svg') }}" width="40" height="40" alt="">
               </div>
               <div class="tieuchi__text">
                  <strong class="tieuchi__title">Thanh toán an toàn</strong>
                  <span class="tieuchi__desc">Bảo mật thông tin tuyệt đối</span>
               </div>
            </div>
            <div class="tieuchi__item">
               <div class="tieuchi__icon" aria-hidden="true">
                  <img src="{{ asset('frontend/images/tieuchi/icon-support.svg') }}" width="40" height="40" alt="">
               </div>
               <div class="tieuchi__text">
                  <strong class="tieuchi__title">Hỗ trợ nhanh chóng</strong>
                  <span class="tieuchi__desc">Tư vấn 24/7</span>
               </div>
            </div>
            <div class="tieuchi__item">
               <div class="tieuchi__icon" aria-hidden="true">
                  <img src="{{ asset('frontend/images/tieuchi/icon-quality.svg') }}" width="40" height="40" alt="">
               </div>
               <div class="tieuchi__text">
                  <strong class="tieuchi__title">Cam kết chất lượng</strong>
                  <span class="tieuchi__desc">Sản phẩm chính hãng</span>
               </div>
            </div>
         </div>
      </div>
   </section>
  <section class="section_blog">
     <div class="container">
        <h2 class="title-module">
           <a href="tin-tuc" title="Tin tức mới nhất">
              Tin tức mới nhất
           </a>
        </h2>
        <div class="swiper_blogs swiper-container">
           <div class="swiper-wrapper load-after" data-section="section_blog">
            @foreach ($hotnews as $item)
            <div class="swiper-slide">
               <div class="item-blog">
                  <div class="block-thumb">
                     <a class="thumb" href="{{route('detailBlog',['slug'=>$item->slug])}}"
                        title="{{languageName($item->title)}}">
                     <img width="600" height="380" class="lazyload"
                        src="/frontend/images/lazy.png"
                        data-src="{{url($item->image)}}"
                        alt="{{languageName($item->title)}}">
                     </a>
                  </div>
                  <div class="day_time">
                     <span class="day_item">{{date_format($item->created_at,'d')}}</span>
                     <span class="myear_item">{{date_format($item->created_at,'m/Y')}}</span>
                  </div>
                  <div class="block-content">
                     <h3><a href="{{route('detailBlog',['slug'=>$item->slug])}}"
                        title="{{languageName($item->title)}}">{{languageName($item->title)}}</a>
                     </h3>
                     <p class="justify">{!!languageName($item->description)!!}
                     </p>
                  </div>
               </div>
            </div>
            @endforeach
              
           </div>
           <div class="swiper-button-prev"></div>
           <div class="swiper-button-next"></div>
        </div>
        <div class="see-more">
           <a href="tin-tuc" title="Xem tất cả">Xem tất cả</a>
        </div>
     </div>
  </section>
  <script>
     $(document).ready(function($) {
         function runSwiperBlogs() {
             var blogs_pro = null;
     
             function initSwiperBlogs() {
                 blogs_pro = new Swiper('.swiper_blogs', {
                     slidesPerView: 4,
                     spaceBetween: 20,
                     watchOverflow: true,
                     slidesPerGroup: 1,
                     grabCursor: true,
                     navigation: {
                         nextEl: '.swiper_blogs .swiper-button-next',
                         prevEl: '.swiper_blogs .swiper-button-prev',
                     },
                     breakpoints: {
                         640: {
                             slidesPerView: 1,
                             spaceBetween: 15
                         },
                         768: {
                             slidesPerView: 2,
                             spaceBetween: 20
                         },
                         992: {
                             slidesPerView: 3,
                             spaceBetween: 20
                         },
                         1024: {
                             slidesPerView: 3,
                             spaceBetween: 20
                         },
                         1200: {
                             slidesPerView: 4,
                             spaceBetween: 20
                         },
                         1500: {
                             slidesPerView: 4,
                             spaceBetween: 20
                         }
                     }
                 });
             }
     
             function destroySwiperBlogs() {
                 if (blogs_pro) {
                     blogs_pro.destroy(true, true);
                     blogs_pro = null;
                 }
             }
     
             function toggleSwiperBlogs() {
                 if ($(window).width() <= 767 && blogs_pro) {
                     destroySwiperBlogs();
                 } else if ($(window).width() > 767 && !blogs_pro) {
                     initSwiperBlogs();
                 }
             }
             toggleSwiperBlogs();
             $(window).resize(toggleSwiperBlogs);
         }
         lazyBlockProduct('section_blog', '0px 0px -250px 0px', runSwiperBlogs);
     });
  </script>
  <div id="js-global-alert" class="alert alert-success" role="alert">
     <button type="button" class="close"><span aria-hidden="true"><span
        aria-hidden="true">&times;</span></span></button>
     <h5 class="alert-heading"></h5>
     <p class="alert-content"></p>
  </div>
</div>
@endsection
