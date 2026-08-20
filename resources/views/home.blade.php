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
        <section class="section_why_choose">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <h2 class="title-module">
                            <a href="javascript:;" title="Câu chuyện về Fio">
                                Câu chuyện về Fio
                            </a>
                        </h2>
                        <p class="content_choose">{!! optional($gioithieu)->description !!}
                        </p>
                        <a href="{{ route('aboutUs') }}" class="hero-banner__btn hero-banner__btn--primary"
                            title="Tìm hiểu thêm">Tìm hiểu thêm</a>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="img_thm">
                            <div class="box_img">
                                @php
                                    $gioiImages = [];
                                    if (!empty($gioithieu) && !empty($gioithieu->image)) {
                                        $gioiImages = is_array($gioithieu->image)
                                            ? $gioithieu->image
                                            : (json_decode($gioithieu->image, true) ?:
                                            []);
                                    }
                                    $gioiThumb = $gioiImages[0] ?? '';
                                    if (is_array($gioiThumb)) {
                                        $gioiThumb = $gioiThumb['url'] ?? ($gioiThumb['path'] ?? '');
                                    } elseif (is_object($gioiThumb)) {
                                        $gioiThumb = $gioiThumb->url ?? ($gioiThumb->path ?? '');
                                    }
                                    $gioiThumb = is_string($gioiThumb) ? $gioiThumb : '';
                                @endphp
                                @if ($gioiThumb !== '')
                                    <img class="lazyload"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        data-src="{{ url($gioiThumb) }}" alt="Tại sao chọn chúng tôi" />
                                @endif
                            </div>
                            {{-- video play icon removed; use hero "Xem video" popup --}}
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section class="section_cate container">
            <h2 class="title-module">
                <a href="javascript:;" title="Điều gì khiến FIO khác biệt?">
                    Điều gì khiến FIO khác biệt?
                </a>
            </h2>
            <div class="why-choise">
                @foreach ($whyChoose as $item)
                    <div class="why-choise__item">
                        <div class="why-choise__icon" aria-hidden="true">
                            <img src="{{ url($item->image) }}" width="50" height="50" alt="" />
                        </div>
                        <div class="why-choise__content">
                            <h3 class="why-choise__title">{{ $item->title }}</h3>
                            <p class="why-choise__desc">{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="section_enjoy">
            <div class="container">
                <h2 class="title-module title-module--enjoy">
                    <a href="javascript:;" title="Hướng dẫn sử dụng">
                        <span class="title-module__highlight">Hướng</span> dẫn sử dụng
                    </a>
                </h2>
                @if (isset($processSteps) && count($processSteps))
                    <div class="enjoy-content">
                        <div class="enjoy-steps">
                            @foreach ($processSteps as $step)
                                <div class="enjoy-step">
                                    <span class="enjoy-step__num">{{ $loop->iteration }}</span>
                                    <div class="enjoy-step__icon">
                                        <img src="{{ $step->image ? url($step->image) : asset('frontend/images/lazy.png') }}"
                                            width="56" height="56" alt="{{ $step->title }}">
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
                                            <img src="{{ $step->image ? url($step->image) : asset('frontend/images/lazy.png') }}"
                                                width="40" height="40" alt="{{ $step->title }}">
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
        <section class="section_flash_sale container">
            <h2 class="title-module">
                <a href="javascript:;" title="Sản phẩm của chúng tôi">
                    Sản phẩm của chúng tôi
                </a>
            </h2>
            <div class="box_flash_sale">
                <div class="product-flash-swiper swiper-container">
                    <div class="swiper-wrapper">
                        @forelse ($homePro as $item)
                            <div class="swiper-slide">
                                @include('layouts.product.item', ['pro' => $item])
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <p>Chưa có sản phẩm.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </section>
        <script>
            var swiper_products = new Swiper('.product-flash-swiper', {
                slidesPerView: 1.3,
                spaceBetween: 14,
                watchOverflow: true,
                grabCursor: true,
                navigation: {
                    nextEl: '.product-flash-swiper .swiper-button-next',
                    prevEl: '.product-flash-swiper .swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1.5,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 24
                    }
                }
            });
        </script>







        
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
