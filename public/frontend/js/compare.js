(function ($) {
	'use strict';

	var $sidebar = $('.compare-sidebar');
	var removeUrl = $sidebar.data('remove-url') || $('#pageCompare').data('remove-url') || '/san-pham/remove-compare';
	var addUrl = $sidebar.data('add-url') || '/san-pham/compare';

	function csrf() {
		return $('meta[name="csrf-token"]').attr('content') || '';
	}

	function updateCount(qty) {
		$('.js-compare-count, .compareCount').text(qty || 0);
	}

	function openSidebar() {
		$('.sidebarAllMainCompare').addClass('active');
	}

	function closeSidebar() {
		$('.sidebarAllMainCompare').removeClass('active');
	}

	function markActive(slugs) {
		$('.js-compare-product-add').removeClass('active').attr('title', 'So sánh');
		(slugs || []).forEach(function (slug) {
			$('.js-compare-product-add[data-compare="' + slug + '"]')
				.addClass('active')
				.attr('title', 'Đã so sánh');
		});
	}

	function renderSidebar(html, qty, slugs) {
		if (!$sidebar.length) return;
		$('.sidebarAllMainCompare .sidebarAllBody').html(html);
		$sidebar.attr('data-compare-slugs', JSON.stringify(slugs || []));
		updateCount(qty);
		markActive(slugs);

		var $footer = $('.sidebarAllMainCompare .sidebarAllFooter');
		if (qty > 0) {
			if (!$footer.length) {
				$('.box_sidebar_compare').append(
					'<div class="sidebarAllFooter">' +
						'<a href="' + ($sidebar.data('compare-page') || '/san-pham/so-sanh-san-pham') + '" class="mainCompareButton">So sánh ngay</a>' +
					'</div>'
				);
			}
			openSidebar();
		} else {
			$footer.remove();
			closeSidebar();
		}
	}

	function notify(message, isError) {
		var $toast = $('#qv-cart-notify');
		if (!$toast.length) {
			alert(message);
			return;
		}
		$toast.text(message).css('background', isError ? '#dc3545' : '#28a745').addClass('show');
		clearTimeout(notify._timer);
		notify._timer = setTimeout(function () {
			$toast.removeClass('show').css('background', '#28a745');
		}, 3000);
	}

	function handleResponse(res) {
		if (res.html !== undefined) {
			renderSidebar(res.html, res.qty, res.slugs);
		} else if (res.slugs) {
			markActive(res.slugs);
			updateCount(res.qty || 0);
		}
		if (res.message === 'exist') {
			notify('Sản phẩm đã có trong danh sách so sánh');
			openSidebar();
			return;
		}
		if (res.message === 'error') {
			notify('Chỉ so sánh được sản phẩm cùng danh mục', true);
			return;
		}
		if (res.message === 'limit3') {
			notify('Chỉ so sánh tối đa 3 sản phẩm', true);
			return;
		}
		if (res.message === 'success') {
			notify('Đã thêm vào so sánh');
			return;
		}
		if (res.message === 'removed') {
			return;
		}
	}

	function addProduct(productId) {
		$.ajax({
			url: addUrl,
			method: 'POST',
			dataType: 'json',
			data: {
				_token: csrf(),
				id: productId
			}
		}).done(handleResponse).fail(function () {
			notify('Không thể thêm sản phẩm so sánh', true);
		});
	}

	function removeProduct(productId, reloadPage) {
		$.ajax({
			url: removeUrl,
			method: 'POST',
			dataType: 'json',
			data: {
				_token: csrf(),
				id: productId
			}
		}).done(function (res) {
			handleResponse(res);
			if (reloadPage) {
				window.location.reload();
			}
		}).fail(function () {
			notify('Không thể xóa sản phẩm so sánh', true);
		});
	}

	window.refreshCompareMarks = function () {
		var slugs = [];
		$('.compare-sidebar .itemMainCompare').each(function () {
			var slug = $(this).data('compare');
			if (slug) slugs.push(slug);
		});
		if (!slugs.length && $sidebar.length) {
			try {
				slugs = JSON.parse($sidebar.attr('data-compare-slugs') || '[]');
			} catch (e) {
				slugs = [];
			}
		}
		markActive(slugs);
		updateCount(slugs.length);
	};

	if ($sidebar.length) {
		$('body').off('click', '.setCompare:not(.active)');
		$('body').off('click', '.itemMainCompare .removeItem');
		$('body').off('click', '.closeSidebar');

		if (typeof Cookies !== 'undefined') {
			Cookies.remove('compare_products', { path: '/' });
			Cookies.remove('compare_type', { path: '/' });
		}

		var initialSlugs = [];
		try {
			initialSlugs = JSON.parse($sidebar.attr('data-compare-slugs') || '[]');
		} catch (e) {
			initialSlugs = [];
		}
		markActive(initialSlugs);
		updateCount($('.compare-sidebar .itemMainCompare').length || initialSlugs.length);
	}

	$(document).on('click', '.js-compare-product-add:not(.active)', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		var productId = $(this).data('product-id');
		if (!productId) return;
		addProduct(productId);
	});

	$(document).on('click', '.compare-sidebar .removeItem', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		var productId = $(this).data('id');
		if (!productId) return;
		removeProduct(productId);
	});

	$(document).on('click', '.compare-sidebar .closeSidebar', function (e) {
		e.preventDefault();
		closeSidebar();
	});

	$(document).on('click', '#pageCompare .removeItem2', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		var productId = $(this).data('id');
		if (!productId) return;
		removeProduct(productId, true);
	});

})(jQuery);
