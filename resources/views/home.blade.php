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
    @php
        $ytRaw = trim((string) ($setting->linkpopup ?? ''));
        $ytId = null;
        if ($ytRaw !== '') {
            if (preg_match('/(?:youtu\.be\/|v=|\/embed\/|\/shorts\/)([A-Za-z0-9_-]{6,})/', $ytRaw, $m)) {
                $ytId = $m[1];
            } elseif (preg_match('/^[A-Za-z0-9_-]{6,}$/', $ytRaw)) {
                $ytId = $ytRaw;
            }
        }
    @endphp
    <div class="bodywrap container">
        <h1 class="d-none">{{ $setting->company }}</h1>
        <div class="box_slide_banner box_slide_banner--full">
            <div class="home-slider swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($banner as $item)
                        <div class="swiper-slide">
                            <div class="hero-banner">
                                @if (!empty($item->image))
                                    <div class="hero-banner__desktop d-none d-lg-block">
                                        <div class="hero-banner__media">
                                            <img src="{{ url($item->image) }}"
                                                alt="{{ is_string($item->title) && $item->title !== '' ? $item->title : 'Fio Coffee' }}"
                                                class="hero-banner__img" />
                                        </div>
                                    </div>
                                @endif
                                @php
                                    $mobileBanner = !empty($item->image_mobile)
                                        ? $item->image_mobile
                                        : $item->image ?? '';
                                @endphp
                                @if (!empty($mobileBanner))
                                    <div class="hero-banner__mobile d-lg-none">
                                        <div class="hero-banner__mobile-media">
                                            <img src="{{ url($mobileBanner) }}"
                                                alt="{{ is_string($item->title) && $item->title !== '' ? $item->title : 'Fio Coffee' }}"
                                                class="hero-banner__mobile-img" />
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
                loop: false,
                autoHeight: true,
                autoplay: false
            });
        </script>
        







        <section class="section_danh_gia lazyload">
            <div class="container">
                <h2 class="title-module">
                    <a href="javascript:;" title="Đánh giá khách hàng">
                        Đánh giá khách hàng
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
                        <button type="button" class="swiper-button-prev review-swiper__nav"
                            aria-label="Xem trước"></button>
                        <button type="button" class="swiper-button-next review-swiper__nav"
                            aria-label="Xem tiếp"></button>
                    </div>
                </div>
            </div>
        </section>
        <script>
            var swiper_feedback = new Swiper('.swiper_feedback', {
                slidesPerView: 1.3,
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
                        slidesPerView: 1.3,
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
                @if (isset($homeFaqs) && count($homeFaqs))
                    <div class="home-faq" id="home-faq">
                        @foreach ($homeFaqs as $faq)
                            <div class="home-faq__item">
                                <button type="button" class="home-faq__question" aria-expanded="false">
                                    <span class="home-faq__question-text">{{ $faq->question }}</span>
                                    <span class="home-faq__icon" aria-hidden="true">
                                        <svg width="14" height="8" viewBox="0 0 14 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 1.5L7 6.5L13 1.5" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
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
            $(function() {
                $('#home-faq .home-faq__question').on('click', function() {
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
        {{-- <section class="tieuchi">
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
   </section> --}}
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
                                        <a class="thumb" href="{{ route('detailBlog', ['slug' => $item->slug]) }}"
                                            title="{{ languageName($item->title) }}">
                                            <img width="600" height="380" class="lazyload"
                                                src="/frontend/images/lazy.png" data-src="{{ url($item->image) }}"
                                                alt="{{ languageName($item->title) }}">
                                        </a>
                                    </div>
                                    <div class="day_time">
                                        <span class="day_item">{{ date_format($item->created_at, 'd') }}</span>
                                        <span class="myear_item">{{ date_format($item->created_at, 'm/Y') }}</span>
                                    </div>
                                    <div class="block-content">
                                        <h3><a href="{{ route('detailBlog', ['slug' => $item->slug]) }}"
                                                title="{{ languageName($item->title) }}">{{ languageName($item->title) }}</a>
                                        </h3>
                                        <p class="justify">{!! languageName($item->description) !!}
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
                    <a href="https://fiocoffee.com.vn/tin-tuc/danh-muc/news.html" title="Xem tất cả">Xem tất cả</a>
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

        <div class="popup_video position-fixed w-100 h-100 justify-content-center align-items-center d-flex"
            aria-hidden="true">
            <div class="position-relative max-100">
                <a href="javascript:void(0)"
                    class="close_video position-absolute d-flex m_white_bg_module justify-content-center align-items-center"
                    title="Đóng" aria-label="Đóng video">
                    <img width="16" height="16" alt="Đóng" src="{{ asset('frontend/images/close.svg') }}">
                </a>
                <div class="b_video p-2 p-md-3 m_white_bg_module rounded m-auto"></div>
            </div>
        </div>
        <script>
            (function($) {
                function closeYoutubePopup() {
                    var $popup = $('.popup_video');
                    $popup.removeClass('open').attr('aria-hidden', 'true');
                    $popup.find('.b_video').empty();
                    $('body').css('overflow', '');
                }

                $(document).on('click', '.open_video', function(e) {
                    e.preventDefault();
                    var videoId = String($(this).data('video') || '').trim();
                    if (!videoId) return;

                    var embed = '' +
                        '<div class="embed-responsive embed-responsive-16by9">' +
                        '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0"' +
                        ' title="YouTube video"' +
                        ' allow="autoplay; encrypted-media; picture-in-picture"' +
                        ' allowfullscreen loading="lazy"></iframe>' +
                        '</div>';

                    var $popup = $('.popup_video').first();
                    $popup.find('.b_video').html(embed);
                    $popup.addClass('open').attr('aria-hidden', 'false');
                    $('body').css('overflow', 'hidden');
                });

                $(document).on('click', '.close_video', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeYoutubePopup();
                });

                $(document).on('click', '.popup_video', function(e) {
                    if (e.target === this) {
                        closeYoutubePopup();
                    }
                });

                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape' && $('.popup_video.open').length) {
                        closeYoutubePopup();
                    }
                });
            })(jQuery);
        </script>
    </div>
@endsection
