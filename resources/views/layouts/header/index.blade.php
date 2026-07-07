<div class="topbarhea">
  <div class="container">
     <div class="row ">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 d-none d-md-block">
           <div class="topbar-slider swiper-container">
              <div class="swiper-wrapper">
                 <div class="swiper-slide text-white"> <span class="pulsingButton rounded-circle"></span> Giảm 5% cho
                    tất cả đơn hàng
                 </div>
                 <div class="swiper-slide text-white"> <span class="pulsingButton rounded-circle"></span> Miễn phí vận
                    chuyển đơn hàng trên 1tr5
                 </div>
              </div>
           </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 text-hea-right">
           <div class="box_top_hea">
              <a title="1900 6750" href="tel:{{$setting->phone1}}" class="opaci_href"></a>
              <span>Hotline</span> <b>{{$setting->phone1}}</b>
           </div>
        </div>
     </div>
  </div>
</div>
<div class="header-top">
  <div class="container">
     <div class="row align-items-center">
        <div class="col-lg-2 col-12 logo_mobile col-3-fix">
           <div class="menu-bar d-lg-none d-inline-block">
              <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="bars" role="img"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                 class="svg-inline--fa fa-bars fa-w-14">
                 <path fill="#ffffff"
                    d="M436 124H12c-6.627 0-12-5.373-12-12V80c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12zm0 160H12c-6.627 0-12-5.373-12-12v-32c0-6.627 5.373-12 12-12h424c6.627 0 12 5.373 12 12v32c0 6.627-5.373 12-12 12z"
                    class=""></path>
              </svg>
           </div>
           <a href="{{ route('home') }}" class="logo" title="Logo">
           <img width="378" height="96"
              src="{{$setting->logo}}"
              alt="{{$setting->company}}">
           </a>
           <div class="box_poy_mb d-lg-none d-inline-block">
              <div class="item_poly_mb">
                 <a href="{{route('listCart')}}" title="Giỏ hàng" class="opaci_href">
                 <img width="32" height="32" class="lazyload"
                    src="{{asset('frontend/images/lazy.png')}}"
                    data-src="/frontend/images/icon_poly_hea_4.png"
                    alt="Giỏ hàng" />
                 <span class="count count_item_pr">{{ collect($cartcontent ?? [])->sum('quantity') }}</span>
               </a>
              </div>
           </div>
        </div>
        <div class="col-lg-10 col-12 col-9-fix">
           <div class="header-menu header-menu-right">
            <div class="search-smart">
              <form action="{{ route('search_result') }}" method="get" class="header-search-form input-group search-bar" role="search">
                 <input type="text" name="keyword" required
                    class="input-group-field form-control"
                    placeholder="Nhập tên sản phẩm..."
                    value="{{ request('keyword') }}">
                 <button type="submit" class="btn icon-fallback-text" aria-label="Tìm kiếm" title="Tìm kiếm">
                    <svg class="icon">
                       <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use>
                    </svg>
                 </button>
              </form>
           </div>
              <div class="box_poly_hea hid-mb">
                 <a href="{{ route('compareList') }}" title="So sánh" class="opaci_href"></a>
                 <p class="box_icon_hea">
                    <img width="32" height="32" class="lazyload"
                       src="{{asset('frontend/images/lazy.png')}}"
                       data-src="/frontend/images/icon_poly_hea_2.png"
                       alt="So sánh" />
                 </p>
                 <div class="item-policy-content">
                    <p>So sánh</p>
                    <span class="sub-text"><span class="count-text js-compare-count">{{ count($compare ?? []) }}</span> sản
                    phẩm</span>
                 </div>
              </div>
              <div class="box_poly_hea hid-mb">
                 <a href="{{route('listCart')}}" title="Giỏ hàng" class="opaci_href"></a>
                 <p class="box_icon_hea">
                    <img width="32" height="32" class="lazyload"
                       src="{{asset('frontend/images/lazy.png')}}"
                       data-src="/frontend/images/icon_poly_hea_4.png"
                       alt="Giỏ hàng" />
                 </p>
                 <div class="item-policy-content">
                    <p>Giỏ hàng</p>
                    <span class="sub-text">
                    <span class="count-text count count_item_pr">{{ collect($cartcontent ?? [])->sum('quantity') }}</span> sản phẩm
                    </span>
                 </div>
              </div>
              
           </div>
        </div>
     </div>
  </div>
</div>
<header class="header">
  <div class="container">
     <div class="row align-items-center">
        <div class="col-lg-3 col-12 header-menu col-3-fix">
           <div class="menu_mega indexs">
              <div class="title_menu">
                 <div class="bg_menu_bar">
                    <div class="menu_bar"></div>
                 </div>
                 <span class="title_">Danh mục sản phẩm</span>
              </div>
              <div class="blog-aside">
                 <div class="aside-content">
                    <div class="ul_menu">
                      @foreach ($categoryhome as $item)
                      <div class="nav_item nav-item lv1 li_check">
                        <a href="{{route('allListProCate',['danhmuc'=>$item->slug])}}" title="{{languageName($item->name)}}"
                           style="background-image: url('{{$item->avatar}}')">
                           {{languageName($item->name)}}
                           @if (count($item->typeCate) > 0)
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"></path></svg>
                        @endif
                          </a>
                        @if (count($item->typeCate) > 0)
                        <div class="ul_content_right_1">
                           <div class="row">
                            @foreach ($item->typeCate as $type)
                              <div class="nav_item nav-item lv2 col-lg-4 col-md-4">
                                 <a href="{{route('allListType',['danhmuc'=>$item->slug,'loaidanhmuc'=>$type->slug])}}" title="{{languageName($type->name)}}">{{languageName($type->name)}}</a>
                                 
                              </div>
                              @endforeach
                           </div>
                        </div>
                        @endif
                     </div>
                      @endforeach
                       
                    </div>
                 </div>
              </div>
              <div class="menu_mobs">
                 <ul id="nav-mobile" class="nav">
                  @foreach ($categoryhome as $item)
                  <li class="nav-item{{ count($item->typeCate) > 0 ? ' has-childs' : '' }}">
                    <div class="nav-mobile__row">
                       <a href="{{ route('allListProCate', ['danhmuc' => $item->slug]) }}" class="nav-link navlink-level1{{ $item->avatar ? '' : ' no-img' }}"
                          title="{{ languageName($item->name) }}"
                          @if ($item->avatar) style="background-image: url('{{ url($item->avatar) }}')" @endif>
                          {{ languageName($item->name) }}
                       </a>
                       @if (count($item->typeCate) > 0)
                       <button type="button" class="nav-mobile__toggle" aria-expanded="false" aria-label="Mở danh mục con {{ languageName($item->name) }}">
                          <svg width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true">
                             <path d="M1 1.5L7 6.5L13 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                       </button>
                       @endif
                    </div>
                    @if (count($item->typeCate) > 0)
                    <ul class="dropdown-menu nav-mobile__sub">
                      @foreach ($item->typeCate as $type)
                      <li class="nav-item-lv2">
                        <a class="nav-link" href="{{ route('allListType', ['danhmuc' => $item->slug, 'loaidanhmuc' => $type->slug]) }}"
                           title="{{ languageName($type->name) }}">{{ languageName($type->name) }}</a>
                      </li>
                      @endforeach
                    </ul>
                    @endif
                 </li>
                  @endforeach
                 </ul>
              </div>
           </div>
        </div>
        <div class="col-lg-9 col-12 col-9-fix">
           <div class=" header-menu header-menu-left">
              <div class="header-menu-des">
                 <nav class="header-nav header-nav--fio">
                    <div class="title_menu">
                       <span class="title_">Menu</span>
                    </div>
                    <ul class="item_big">
                       <li class="nav-item{{ request()->routeIs('home') ? ' active' : '' }}">
                          <div class="nav-item__row nav-item__row--solo">
                             <a class="nav-item__link" href="{{ route('home') }}" title="Trang chủ">Trang chủ</a>
                          </div>
                       </li>
                       <li class="nav-item{{ request()->routeIs('aboutUs') ? ' active' : '' }}">
                          <div class="nav-item__row nav-item__row--solo">
                             <a class="nav-item__link" href="{{ route('aboutUs') }}" title="Về chúng tôi">Về chúng tôi</a>
                          </div>
                       </li>
                       <li class="nav-item nav-item--label">
                          <span class="nav-label">Danh mục sản phẩm</span>
                       </li>
                       @foreach ($categoryhome as $item)
                       <li class="nav-item{{ count($item->typeCate) > 0 ? ' has-childs' : '' }}">
                          <div class="nav-item__row">
                             <a class="nav-item__link{{ $item->avatar ? ' nav-cate-link' : '' }}"
                                href="{{ route('allListProCate', ['danhmuc' => $item->slug]) }}"
                                title="{{ languageName($item->name) }}"
                                @if ($item->avatar) style="background-image: url('{{ url($item->avatar) }}')" @endif>
                                {{ languageName($item->name) }}
                             </a>
                             @if (count($item->typeCate) > 0)
                             <button type="button" class="nav-item__toggle" aria-expanded="false" aria-label="Mở danh mục con {{ languageName($item->name) }}">
                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true">
                                   <path d="M1 1.5L7 6.5L13 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                             </button>
                             @endif
                          </div>
                          @if (count($item->typeCate) > 0)
                          <ul class="item_small nav-submenu">
                             @foreach ($item->typeCate as $type)
                             <li>
                                <a href="{{ route('allListType', ['danhmuc' => $item->slug, 'loaidanhmuc' => $type->slug]) }}"
                                   title="{{ languageName($type->name) }}">
                                   {{ languageName($type->name) }}
                                </a>
                             </li>
                             @endforeach
                          </ul>
                          @endif
                       </li>
                       @endforeach
                       <li class="nav-item nav-item--label">
                          <span class="nav-label">Khám phá thêm</span>
                       </li>
                       <li class="nav-item{{ request()->routeIs('allListBlog', 'listCateBlog', 'detailBlog', 'listTypeBlog') ? ' active' : '' }}{{ ($blogCate ?? collect())->count() > 0 ? ' has-childs' : '' }}">
                          <div class="nav-item__row">
                             <a class="nav-item__link" href="javascript:void(0)" title="Tin tức">Tin tức</a>
                             @if (($blogCate ?? collect())->count() > 0)
                             <button type="button" class="nav-item__toggle" aria-expanded="false" aria-label="Mở danh mục tin tức">
                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none" aria-hidden="true">
                                   <path d="M1 1.5L7 6.5L13 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                             </button>
                             @endif
                          </div>
                          @if (($blogCate ?? collect())->count() > 0)
                          <ul class="item_small nav-submenu">
                             @foreach ($blogCate as $blogItem)
                             <li>
                                <a href="{{ route('listCateBlog', ['slug' => $blogItem->slug]) }}"
                                   title="{{ languageName($blogItem->name) }}">
                                   {{ languageName($blogItem->name) }}
                                </a>
                             </li>
                             @endforeach
                          </ul>
                          @endif
                       </li>
                       <li class="nav-item{{ request()->routeIs('fag') ? ' active' : '' }}">
                          <div class="nav-item__row nav-item__row--solo">
                             <a class="nav-item__link" href="{{ route('fag') }}" title="Câu hỏi thường gặp">Câu hỏi thường gặp</a>
                          </div>
                       </li>
                       <li class="nav-item{{ request()->routeIs('lienHe') ? ' active' : '' }}">
                          <div class="nav-item__row nav-item__row--solo">
                             <a class="nav-item__link" href="{{ route('lienHe') }}" title="Liên hệ">Liên hệ</a>
                          </div>
                       </li>
                    </ul>
                 </nav>
              </div>
           </div>
        </div>
     </div>
  </div>
</header>