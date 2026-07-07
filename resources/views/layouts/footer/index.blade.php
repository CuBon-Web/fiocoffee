<footer class="footer">
  <div class="mid-footer">
     <div class="container">
        <div class="row">
           <div class="col-12 col-lg-4 ft-info">
              <a href="/" class="logo_foo" title="Logo">
              <img width="378" height="96"
                 src="{{$setting->logo_footer}}"
                 alt="{{$setting->company}}">
              </a>
              <div class="des_foo">
                 {!!$setting->webname!!} <br>
              </div>
              <div class="list_phone_foo">
                 <a href="tel:{{$setting->phone1}}" title="{{$setting->phone1}}">
                 Tư vấn mua hàng <span>{{$setting->phone1}}</span>
                 </a>
              </div>
           </div>
           <div class="col-12 col-lg-5 ft-menu">
              <div class="row">
                 <div class="col-12 col-sm-6 link-list col-footer footer-click">
                    <h4 class="title-menu title-menu2">
                      Hỗ trợ
                    </h4>
                    <ul class="list-menu hidden-mobile">
                      @foreach ($pageContent as $item)
                      
                          @if ($item->type === 'ho-tro-khanh-hang')
                          <li><a href="{{route('pagecontent',['slug'=>$item->slug])}}" title="{{$item->title}}">{{$item->title}}</a>
                          </li>
                          @endif
                      @endforeach
                    </ul>
                 </div>
                 <div class="col-12 col-sm-6 link-list col-footer footer-click">
                    <h4 class="title-menu title-menu2">
                       Về FIO
                    </h4>
                    <ul class="list-menu hidden-mobile">
                     <li><a href="{{route('aboutUs')}}" title="Sản phẩm">Câu chuyện FIO</a>
                     <li><a href="{{route('allProduct')}}" title="Sản phẩm">Sản phẩm</a>
                     </li>
                       <li><a href="{{route('fag')}}" title="Câu hỏi thường gặp">Câu hỏi thường
                          gặp</a>
                       </li>
                       <li><a href="{{route('lienHe')}}" title="Liên hệ">Liên hệ</a></li>
                    </ul>
                 </div>
              </div>
           </div>
           <div class="col-12 col-lg-3">
              <h4 class="title-menu">
                 Liên hệ
              </h4>
              <div class="list-menu toggle-mn">
                 <div class="content-contact clearfix">
                    <span class="list_footer">
                    <b>
                       <svg class="footer-contact-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M12 21.5C12 21.5 18.5 15.2 18.5 10C18.5 6.41 15.59 3.5 12 3.5C8.41 3.5 5.5 6.41 5.5 10C5.5 15.2 12 21.5 12 21.5Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <circle cx="12" cy="10" r="2.75" stroke="#fff" stroke-width="1.5"/>
                       </svg>
                       Địa chỉ:
                    </b>
                    {!!$setting->address1!!}
                    </span>
                 </div>
                 <div class="content-contact clearfix">
                    <span class="list_footer">
                    <b>
                       <svg class="footer-contact-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M8 3.5h8a2.5 2.5 0 0 1 2.5 2.5v12a2.5 2.5 0 0 1-2.5 2.5H8a2.5 2.5 0 0 1-2.5-2.5V6A2.5 2.5 0 0 1 8 3.5Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M10 17.5h4" stroke="#fff" stroke-width="1.5" stroke-linecap="round"/>
                       </svg>
                       Điện thoại:
                    </b>
                    <a title="{{$setting->phone1}}" href="tel:{{$setting->phone1}}">
                    {{$setting->phone1}}
                    </a>
                    </span>
                 </div>
                 <div class="content-contact clearfix">
                    <span class="list_footer">
                    <b>
                       <svg class="footer-contact-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path d="M4.5 6.5h15a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-15a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2Z" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M4.5 8.5 12 14l7.5-5.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                       </svg>
                       Email:
                    </b>
                    <a title="{{$setting->email}}"
                       href="mailto:{{$setting->email}}">
                    {{$setting->email}}
                    </a>
                    </span>
                 </div>
              </div>
           </div>
        </div>
     </div>
  </div>
  <div id="copyright" class="copyright">
     <div class="container">
        <div class="row">
           <div class="col-12 col-lg-12">
              <span class="copy-right">© Bản quyền thuộc về <b>FIO Coffee</b></span>
              <span class="opacity1"> <span class="dash hidden-xs">|</span> Cung cấp bởi
              <a href=""
                 rel="noopener" title="Tuấn Anh Dev" target="_blank">Tuấn Anh Dev</a>
              </span>
           </div>
        </div>
     </div>
  </div>
</footer>