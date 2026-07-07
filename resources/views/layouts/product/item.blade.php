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

    $originalPrice = (float) $pro->price;
    $salePrice = (float) $pro->discount;
    $variantMinPrice = isset($pro->variant_min_price) ? (float) $pro->variant_min_price : null;
    $variantMaxPrice = isset($pro->variant_max_price) ? (float) $pro->variant_max_price : null;
    $hasVariant = (int) $pro->status_variant === 1;
    $hasVariantPrice = $hasVariant && !is_null($variantMinPrice) && $variantMinPrice > 0;

    $currentPriceLabel = null;
    $showComparePrice = false;

    if ($hasVariantPrice) {
        if (!is_null($variantMaxPrice) && $variantMaxPrice > 0 && $variantMinPrice != $variantMaxPrice) {
            $currentPriceLabel = number_format($variantMinPrice) . '₫ - ' . number_format($variantMaxPrice) . '₫';
        } else {
            $currentPriceLabel = number_format($variantMinPrice) . '₫';
        }
        $showComparePrice = $originalPrice > 0 && $originalPrice > $variantMinPrice;
    } elseif ($salePrice > 0 || $originalPrice > 0) {
        $displayPrice = ($salePrice > 0 && ($originalPrice <= 0 || $salePrice < $originalPrice))
            ? $salePrice
            : $originalPrice;
        $currentPriceLabel = $displayPrice > 0 ? number_format($displayPrice) . '₫' : null;
        $showComparePrice = $originalPrice > 0 && $salePrice > 0 && $salePrice < $originalPrice;
    }

    $priceForDiscount = $hasVariantPrice
        ? $variantMinPrice
        : (($salePrice > 0 && ($originalPrice <= 0 || $salePrice < $originalPrice)) ? $salePrice : $originalPrice);

    $discountPercent = 0;
    if ($originalPrice > 0 && $priceForDiscount > 0 && $priceForDiscount < $originalPrice) {
        $discountPercent = 100 - ceil(($priceForDiscount / $originalPrice) * 100);
    }

    $cartPrice = $hasVariantPrice
        ? $variantMinPrice
        : ($salePrice > 0 ? $salePrice : $originalPrice);
@endphp
<div class="item_product_main item_product_main--fio">
    <div class="product-thumbnail">
       <a class="image_thumb" href="{{ $productUrl }}" title="{{ $productName }}">
          <img width="480" height="480" class="lazyload image1"
             src="{{ $lazySrc }}"
             data-src="{{ url($thumb) }}"
             alt="{{ $productName }}">
       </a>
       @if ($discountPercent > 0)
       <div class="smart"><span>-{{ $discountPercent }}%</span></div>
       @endif
    </div>
    <div class="product-info">
       <div class="product-info__text">
          <h3 class="product-name">
             <a class="line-clamp line-clamp-2" href="{{ $productUrl }}" title="{{ $productName }}">{{ $productName }}</a>
          </h3>
          <div class="price-box">
             @if ($currentPriceLabel)
                <span class="price-current">{{ $currentPriceLabel }}</span>
                @if ($showComparePrice)
                <span class="compare-price">{{ number_format($originalPrice) }}₫</span>
                @endif
             @else
                Liên hệ
             @endif
          </div>
       </div>
       <div class="product-info__action">
          @if ($hasVariant)
          <a href="{{ $productUrl }}" class="product-add-btn" title="Tùy chọn" aria-label="Tùy chọn">
             <span aria-hidden="true">+</span>
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
             <button class="product-add-btn add_to_cart" title="Thêm vào giỏ" type="button" aria-label="Thêm vào giỏ" @if($cartPrice <= 0) disabled @endif>
                <span aria-hidden="true">+</span>
             </button>
          </form>
          @endif
       </div>
    </div>
</div>
