(function ($) {
	'use strict';

	var swiper = null;
	var isSubmitting = false;
	var state = {
		productId: null,
		variants: [],
		options: [],
		selectedVariantId: null,
		salePrice: 0,
		originalPrice: 0
	};

	function $popup() {
		return $('#quick-view-product');
	}

	function $box() {
		return $popup().children('.quick-view-product');
	}

	function csrf() {
		return $('meta[name="csrf-token"]').attr('content') || '';
	}

	function escapeHtml(text) {
		return $('<div>').text(text || '').html();
	}

	function formatMoney(value) {
		return new Intl.NumberFormat('vi-VN').format(Math.round(value || 0)) + '₫';
	}

	function open() {
		$popup().fadeIn(200);
		$('body').addClass('quickview-open');
	}

	function close() {
		$popup().fadeOut(200);
		$('body').removeClass('quickview-open');
		if (swiper) {
			swiper.destroy(true, true);
			swiper = null;
		}
	}

	function getOptions(data) {
		if (data.variant_options && data.variant_options.length) {
			return data.variant_options;
		}
		if (!data.variants || !data.variants.length) {
			return [];
		}
		return [{
			name: 'Phân loại',
			values: data.variants.map(function (v) { return v.version; }).filter(Boolean)
		}];
	}

	function findVariant(labels) {
		if (!state.variants.length) return null;
		if (!labels.length) return state.variants[0];

		return state.variants.find(function (item) {
			var version = (item.version || '').trim();
			if (!version) return false;
			if (labels.length === 1) return version === labels[0];
			var parts = version.split(/\s+-\s+/);
			return parts.length === labels.length && parts.every(function (p, i) { return p === labels[i]; });
		}) || state.variants[0];
	}

	function setPrice(sale, original) {
		var $content = $box();
		sale = parseFloat(sale) || 0;
		original = parseFloat(original) || 0;

		if (sale > 0) {
			$content.find('.price.product-price').html(formatMoney(sale));
			if (original > sale) {
				$content.find('.old-price').html(formatMoney(original)).show();
			} else {
				$content.find('.old-price').hide();
			}
		} else if (original > 0) {
			$content.find('.price.product-price').html(formatMoney(original));
			$content.find('.old-price').hide();
		} else {
			$content.find('.price.product-price').html('Liên hệ');
			$content.find('.old-price').hide();
		}
	}

	function getSelectedLabels() {
		var labels = [];
		var $content = $box();
		state.options.forEach(function (_, i) {
			var val = $content.find('.swatch[data-option-index="' + i + '"] :radio:checked').val();
			if (val) {
				labels.push(val);
				$content.find('.swatch[data-option-index="' + i + '"] .value-roperties').text(val);
			}
		});
		return labels;
	}

	function updateVariant() {
		var variant = findVariant(getSelectedLabels());
		if (!variant) return;
		state.selectedVariantId = variant.id;
		state.salePrice = parseFloat(variant.price) || state.salePrice;
		setPrice(state.salePrice, state.originalPrice);
	}

	function buildVariants(data) {
		var $content = $box();
		state.options = getOptions(data);
		var $wrap = $content.find('#qv-variant-wrap').empty();

		if (parseInt(data.status_variant, 10) !== 1 || !state.options.length) return;

		state.options.forEach(function (option, i) {
			var html = '<div class="swatch clearfix" data-option-index="' + i + '">' +
				'<div class="header">' + escapeHtml(option.name) + ': <span class="value-roperties"></span></div>' +
				'<div class="thump-swatch">';

			(option.values || []).forEach(function (value, j) {
				var id = 'qv-opt-' + i + '-' + j;
				html += '<div class="swatch-element available">' +
					'<input id="' + id + '" type="radio" name="qv-option-' + i + '" value="' + escapeHtml(value) + '"' + (j === 0 ? ' checked' : '') + '>' +
					'<label for="' + id + '">' + escapeHtml(value) + '</label></div>';
			});

			html += '</div></div>';
			$wrap.append(html);
		});

		updateVariant();
	}

	function buildThumbs(images) {
		var $content = $box();
		var $list = $content.find('#thumblist_quickview').empty();
		var $wrapper = $content.find('.more-view-wrapper');

		if (!images || images.length <= 1) {
			$wrapper.addClass('d-none');
			return;
		}

		images.forEach(function (img, i) {
			$list.append(
				'<li class="swiper-slide' + (i === 0 ? ' active' : '') + '">' +
					'<a href="javascript:void(0)" data-image="' + escapeHtml(img) + '">' +
						'<img src="' + escapeHtml(img) + '" alt="">' +
					'</a></li>'
			);
		});
		$wrapper.removeClass('d-none');

		if (swiper) swiper.destroy(true, true);
		if (typeof Swiper !== 'undefined' && $content.find('#thumbs_list_quickview').length) {
			swiper = new Swiper($content.find('#thumbs_list_quickview')[0], {
					slidesPerView: 4,
					spaceBetween: 15,
					navigation: {
					nextEl: $content.find('.swiper-button-next')[0],
					prevEl: $content.find('.swiper-button-prev')[0]
				}
			});
		}
	}

	function render(data) {
		$box().html($('#quickview-modal').html());

		var $content = $box();
		var images = data.images || [];
		var salePrice = parseFloat(data.sale_price) || 0;
		var originalPrice = parseFloat(data.original_price) || 0;

		if (!salePrice && originalPrice > 0) {
			salePrice = originalPrice;
		}

		$content.find('#product-featured-image-quickview').attr({ src: images[0] || '', alt: data.name || '' });
		$content.find('.qwp-name').html('<a href="' + escapeHtml(data.detail_url) + '">' + escapeHtml(data.name) + '</a>');
		$content.find('.sku_').text(data.sku || 'Đang cập nhật');
		$content.find('.rte').text(data.description || 'Thông tin sản phẩm đang được cập nhật.');
		$content.find('.qv-quantity').val(1);

		state.productId = data.id;
		state.variants = data.variants || [];
		state.salePrice = salePrice;
		state.originalPrice = originalPrice;
		state.selectedVariantId = state.variants.length ? state.variants[0].id : null;

		setPrice(salePrice, originalPrice);
		buildVariants(data);
		buildThumbs(images);
	}

	function getCartPayload() {
		var $content = $box();
		var quantity = parseInt($content.find('.qv-quantity').val(), 10) || 1;
		var price = state.salePrice || state.originalPrice || 0;
		var variant = '';

		if (state.selectedVariantId && state.variants.length) {
			var selected = state.variants.find(function (v) { return v.id === state.selectedVariantId; });
			if (selected) {
				price = parseFloat(selected.price) || price;
				variant = selected.version || '';
			}
		}

		return {
			_token: csrf(),
			product_id: state.productId,
			quantity: quantity,
			price: price,
			variant: variant
		};
	}

	function setButtonsLoading(loading) {
		$box().find('.qv-add-cart, .qv-buy-now').toggleClass('is-loading', loading);
	}

	function updateCartCount(count) {
		if (typeof count === 'undefined' || count === null) return;
		$('.count_item_pr').text(count);
	}

	function showNotify(message) {
		var $notify = $('#qv-cart-notify');
		if (!$notify.length) return;
		$notify.text(message || 'Đã thêm vào giỏ hàng').addClass('show');
		clearTimeout(showNotify._timer);
		showNotify._timer = setTimeout(function () {
			$notify.removeClass('show');
		}, 3000);
	}

	function addToCart(redirectToCheckout) {
		if (!state.productId || isSubmitting) return;

		var payload = getCartPayload();

		isSubmitting = true;
		setButtonsLoading(true);

		$.ajax({
			url: $popup().data('add-cart-url') || '/add-to-cart',
			method: 'POST',
			dataType: 'json',
			data: payload
		}).done(function (res) {
			updateCartCount(res.cart_count);

			if (redirectToCheckout) {
				window.location.href = res.redirect_checkout || $popup().data('checkout-url') || '/thanh-toan.html';
				return;
			}

			close();
			showNotify(res.message || 'Đã thêm vào giỏ hàng');
		}).fail(function (xhr) {
			var message = 'Không thể thêm sản phẩm vào giỏ hàng.';
			if (xhr.responseJSON && xhr.responseJSON.message) {
				message = xhr.responseJSON.message;
			}
			alert(message);
		}).always(function () {
			isSubmitting = false;
			setButtonsLoading(false);
		});
	}

	function load(url) {
		open();
		$box().html('<div class="text-center py-5">Đang tải sản phẩm...</div>');

		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
			headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
		}).done(render).fail(function () {
			$box().html('<div class="text-center py-5 text-danger">Không thể tải thông tin sản phẩm.</div>');
		});
	}

	$(document).on('click', '.quick-view, .quick-view-trigger', function (e) {
		e.preventDefault();
		var url = $(this).data('quickview-url');
		if (url) load(url);
	});

	$(document).on('click', '#quick-view-product > .quickview-overlay', function (e) {
		e.preventDefault();
		close();
	});

	$(document).on('click', '#quick-view-product .quickview-close', function (e) {
			e.preventDefault();		
		e.stopPropagation();
		close();
	});

	$(document).on('keyup', function (e) {
		if (e.key === 'Escape') close();
	});

	$(document).on('click', '#quick-view-product .quick-view-product #thumblist_quickview a', function (e) {
		e.preventDefault();
		var image = $(this).data('image');
		var $content = $box();
		$content.find('#thumblist_quickview li').removeClass('active');
		$(this).closest('li').addClass('active');
		if (image) $content.find('#product-featured-image-quickview').attr('src', image);
	});

	$(document).on('change', '#quick-view-product .swatch :radio', updateVariant);

	$(document).on('click', '#quick-view-product .qv-qty-minus', function (e) {
		e.preventDefault();
		e.stopPropagation();
		var $input = $box().find('.qv-quantity');
		var qty = parseInt($input.val(), 10) || 1;
		if (qty > 1) $input.val(qty - 1);
	});

	$(document).on('click', '#quick-view-product .qv-qty-plus', function (e) {
		e.preventDefault();
		e.stopPropagation();
		var $input = $box().find('.qv-quantity');
		$input.val((parseInt($input.val(), 10) || 1) + 1);
	});

	$(document).on('click', '#quick-view-product .qv-add-cart', function (e) {
		e.preventDefault();
		e.stopPropagation();
		addToCart(false);
	});

	$(document).on('click', '#quick-view-product .qv-buy-now', function (e) {
		e.preventDefault();
		e.stopPropagation();
		addToCart(true);
	});

})(jQuery);
