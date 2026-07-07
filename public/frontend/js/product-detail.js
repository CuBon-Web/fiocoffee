(function ($) {
	'use strict';

	var isSubmitting = false;
	var state = {
		productId: null,
		variants: [],
		options: [],
		selectedVariantId: null,
		salePrice: 0,
		originalPrice: 0,
		statusVariant: 0
	};

	function $form() {
		return $('#product-purchase-form');
	}

	function csrf() {
		return $('meta[name="csrf-token"]').attr('content') || '';
	}

	function formatMoney(value) {
		return new Intl.NumberFormat('vi-VN').format(Math.round(value || 0)) + '₫';
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
		sale = parseFloat(sale) || 0;
		original = parseFloat(original) || 0;
		var $current = $('#pd-price-current');
		var $old = $('#pd-price-old');

		if (sale > 0) {
			$current.text(formatMoney(sale));
			if (original > sale) {
				$old.text(formatMoney(original)).show();
			} else {
				$old.hide();
			}
		} else if (original > 0) {
			$current.text(formatMoney(original));
			$old.hide();
		} else {
			$current.text('Liên hệ');
			$old.hide();
		}
	}

	function getSelectedLabels() {
		var labels = [];
		$form().find('.pd-variant-group').each(function () {
			var index = $(this).data('option-index');
			var val = $(this).find('input[type="radio"]:checked').val();
			if (val) {
				labels.push(val);
				$(this).find('.pd-variant-selected').text(val);
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

	function initPurchaseForm() {
		var $f = $form();
		if (!$f.length) return;

		var variants = [];
		var variantOptions = [];
		try {
			variants = JSON.parse($f.attr('data-variants') || '[]');
			variantOptions = JSON.parse($f.attr('data-variant-options') || '[]');
		} catch (e) {
			variants = [];
			variantOptions = [];
		}

		state.productId = parseInt($f.data('product-id'), 10) || null;
		state.variants = variants;
		state.options = getOptions({ variants: variants, variant_options: variantOptions });
		state.originalPrice = parseFloat($f.data('original-price')) || 0;
		state.salePrice = parseFloat($f.data('sale-price')) || 0;
		state.statusVariant = parseInt($f.data('status-variant'), 10) || 0;
		state.selectedVariantId = variants.length ? variants[0].id : null;

		$f.find('.pd-variant-group').each(function () {
			var $group = $(this);
			var checked = $group.find('input[type="radio"]:checked').val();
			if (checked) {
				$group.find('.pd-variant-selected').text(checked);
			}
		});

		if (state.statusVariant === 1 && state.variants.length) {
			updateVariant();
		}
	}

	function getCartPayload() {
		var quantity = parseInt($form().find('.pd-quantity-input').val(), 10) || 1;
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
		$form().find('.pd-btn--cart, .pd-btn--buy').toggleClass('is-loading', loading);
	}

	function updateCartCount(count) {
		if (typeof count === 'undefined' || count === null) return;
		$('.count_item_pr').text(count);
	}

	function showNotify(message) {
		var $notify = $('#qv-cart-notify');
		if (!$notify.length) {
			alert(message);
			return;
		}
		$notify.text(message || 'Đã thêm vào giỏ hàng').addClass('show');
		clearTimeout(showNotify._timer);
		showNotify._timer = setTimeout(function () {
			$notify.removeClass('show');
		}, 3000);
	}

	function addToCart(redirectToCheckout) {
		if (!state.productId || isSubmitting) return;

		if (state.statusVariant === 1 && state.variants.length && !state.selectedVariantId) {
			alert('Vui lòng chọn phân loại sản phẩm.');
			return;
		}

		var payload = getCartPayload();
		isSubmitting = true;
		setButtonsLoading(true);

		$.ajax({
			url: $form().data('add-cart-url') || '/add-to-cart',
			method: 'POST',
			dataType: 'json',
			data: payload
		}).done(function (res) {
			updateCartCount(res.cart_count);

			if (redirectToCheckout) {
				window.location.href = res.redirect_checkout || $form().data('checkout-url') || '/thanh-toan.html';
				return;
			}

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

	function initProductDetailGallery() {
		var mainEl = document.querySelector('.product-detail-gallery-main');
		if (!mainEl || typeof Swiper === 'undefined') return;

		var thumbsEl = document.querySelector('.product-detail-gallery-thumbs');
		var thumbsSwiper = null;
		if (thumbsEl) {
			thumbsSwiper = new Swiper(thumbsEl, {
				spaceBetween: 10,
				slidesPerView: 4,
				freeMode: true,
				watchSlidesProgress: true,
				breakpoints: {
					0: { slidesPerView: 3 },
					576: { slidesPerView: 4 },
					992: { slidesPerView: 5 }
				}
			});
		}

		new Swiper(mainEl, {
			spaceBetween: 10,
			speed: 500,
			navigation: {
				nextEl: '.product-detail-gallery-next',
				prevEl: '.product-detail-gallery-prev'
			},
			thumbs: thumbsSwiper ? { swiper: thumbsSwiper } : undefined
		});
	}

	function initProductDetailTabs() {
		var nav = document.querySelector('.product-detail-tabs__nav');
		if (!nav) return;
		nav.addEventListener('click', function (e) {
			var btn = e.target.closest('button[data-tab]');
			if (!btn) return;
			var targetId = btn.getAttribute('data-tab');
			nav.querySelectorAll('button').forEach(function (el) {
				el.classList.toggle('active', el === btn);
			});
			document.querySelectorAll('.product-detail-tabs__panel').forEach(function (panel) {
				panel.classList.toggle('active', panel.id === targetId);
			});
		});
	}

	$(function () {
		initProductDetailGallery();
		initProductDetailTabs();
		initPurchaseForm();

		$(document).on('change', '#product-purchase-form .pd-variant-group input[type="radio"]', updateVariant);

		$(document).on('click', '#product-purchase-form .pd-qty-minus', function (e) {
			e.preventDefault();
			var $input = $form().find('.pd-quantity-input');
			var qty = parseInt($input.val(), 10) || 1;
			if (qty > 1) $input.val(qty - 1);
		});

		$(document).on('click', '#product-purchase-form .pd-qty-plus', function (e) {
			e.preventDefault();
			var $input = $form().find('.pd-quantity-input');
			$input.val((parseInt($input.val(), 10) || 1) + 1);
		});

		$(document).on('click', '#product-purchase-form .pd-btn--cart', function (e) {
			e.preventDefault();
			addToCart(false);
		});

		$(document).on('click', '#product-purchase-form .pd-btn--buy', function (e) {
			e.preventDefault();
			addToCart(true);
		});
	});

})(jQuery);
