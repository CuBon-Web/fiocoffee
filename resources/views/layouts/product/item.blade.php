@php
    $img = json_decode($pro->images, true) ?? [];
    $productUrl = route('detailProduct', [
        'cate' => $pro->cate_slug,
        'type' => $pro->type_slug ? $pro->type_slug : 'loai',
        'id' => $pro->slug,
    ]);

    $productName = languageName($pro->name);
    $thumb = $img[0] ?? '';
    $lazySrc = asset('frontend/images/lazy.png');

    $productPrice = (float) $pro->price;
    $cupPrice = (float) $pro->discount; // Giá 1 ly
    $variantMinPrice = isset($pro->variant_min_price) ? (float) $pro->variant_min_price : null;
    $variantMaxPrice = isset($pro->variant_max_price) ? (float) $pro->variant_max_price : null;
    $hasVariant = (int) $pro->status_variant === 1;
    $hasVariantPrice = $hasVariant && !is_null($variantMinPrice) && $variantMinPrice > 0;

    $currentPriceLabel = null;
    if ($hasVariantPrice) {
        if (!is_null($variantMaxPrice) && $variantMaxPrice > 0 && $variantMinPrice != $variantMaxPrice) {
            $currentPriceLabel = number_format($variantMinPrice, 0, ',', '.') . 'đ - ' . number_format($variantMaxPrice, 0, ',', '.') . 'đ';
        } else {
            $currentPriceLabel = number_format($variantMinPrice, 0, ',', '.') . 'đ';
        }
    } elseif ($productPrice > 0) {
        $currentPriceLabel = number_format($productPrice, 0, ',', '.') . 'đ';
    }

    $cupPriceLabel = $cupPrice > 0
        ? '(' . number_format($cupPrice, 0, ',', '.') . 'đ / ly)'
        : null;

    $size = json_decode($pro->size, true) ?? [];

    $cartPrice = $hasVariantPrice
        ? $variantMinPrice
        : $productPrice;
@endphp
@once
<style>
   .product-feature-list {
       margin: 10px 0 0;
       padding: 0;
       list-style: none;
   }

   .product-feature-list__item {
       position: relative;
       margin-bottom: 8px;
       padding-left: 18px;
       color: #3C2618;
       font-size: 14px;
       line-height: 1;
       font-weight: 500;
   }

   .product-feature-list__item:last-child {
       margin-bottom: 15px;
   }

   .product-feature-list__item::before {
       content: "✓";
       position: absolute;
       top: 0;
       left: 0;
       color: #3C2618;
       font-size: 14px;
       line-height: 1.35;
       font-weight: 700;
   }

@media (max-width: 767px) {
   .product-feature-list__item {
       font-size: 16px;
       padding-left: 24px;
   }
}
</style>
@endonce
<div class="item_product_main item_product_main--fio">
    <div class="product-thumbnail">
       <a class="image_thumb" href="{{ $productUrl }}" title="{{ $productName }}">
          <img width="480" height="480" class="lazyload image1"
             src="{{ $lazySrc }}"
             data-src="{{ url($thumb) }}"
             alt="{{ $productName }}">
       </a>
    </div>
    <div class="product-info">
       <div class="product-info__text">
          <h3 class="product-name">
             <a class="line-clamp line-clamp-2" href="{{ $productUrl }}" title="{{ $productName }}">{{ $productName }}</a>
          </h3>
          <ul class="product-feature-list">
            @foreach ($size as $item)
            <li class="product-feature-list__item">{{ $item['title'] }}</li>
            @endforeach
          </ul>
          <div class="price-box">
             <div class="price-box__info">
                @if ($currentPriceLabel)
                   <span class="price-current">{{ $currentPriceLabel }}</span>
                   @if ($cupPriceLabel)
                   <span class="price-cup">{{ $cupPriceLabel }}</span>
                   @endif
                @else
                   <span class="price-contact">Liên hệ</span>
                @endif
             </div>
             <div class="product-info__action">
               @if ($hasVariant)
               <a href="{{ $productUrl }}" class="product-add-btn" title="Mua ngay" aria-label="Mua ngay">
                  <span class="product-add-btn__icon" aria-hidden="true">
                     <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3h2l1.6 9.2a2 2 0 0 0 2 1.8h7.7a2 2 0 0 0 2-1.6L20 7H7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="10" cy="20" r="1.4" fill="currentColor"/>
                        <circle cx="17" cy="20" r="1.4" fill="currentColor"/>
                     </svg>
                  </span>
                  <span>MUA NGAY</span>
               </a>
               @else
               <form action="{{ route('add.to.cart') }}" method="post"
                  class="variants product-action" data-cart-form
                  data-add-cart-url="{{ route('add.to.cart') }}"
                  data-id="product-actions-{{ $pro->id }}" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $pro->id }}">
                  <input type="hidden" name="quantity" value="1">
                  <input type="hidden" name="price" value="{{ $cartPrice }}">
                  <button class="product-add-btn add_to_cart" title="Mua ngay" type="button" aria-label="Mua ngay" @if($cartPrice <= 0) disabled @endif>
                     <span class="product-add-btn__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M3 3h2l1.6 9.2a2 2 0 0 0 2 1.8h7.7a2 2 0 0 0 2-1.6L20 7H7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                           <circle cx="10" cy="20" r="1.4" fill="currentColor"/>
                           <circle cx="17" cy="20" r="1.4" fill="currentColor"/>
                        </svg>
                     </span>
                     <span>MUA NGAY</span>
                  </button>
               </form>
               @endif
            </div>
          </div>
       </div>
    </div>
</div>
