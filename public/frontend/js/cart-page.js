(function ($) {
    'use strict';

    var routes = window.cartPageRoutes || {};

    function csrfToken() {
        return $('meta[name="csrf-token"]').attr('content') || '';
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(Math.round(amount)) + '₫';
    }

    function updateHeaderCount(count) {
        $('.count_item_pr').text(count);
    }

    function setLoading($item, loading) {
        $item.toggleClass('is-loading', loading);
    }

    function updateTotals(data) {
        if (typeof data.total !== 'undefined') {
            $('.js-cart-total').text(formatMoney(data.total));
        }
        if (typeof data.cart_count !== 'undefined') {
            updateHeaderCount(data.cart_count);
            $('.js-cart-count-label').text('(' + data.cart_count + ' sản phẩm)');
        }
    }

    function updateLineTotal($item, lineTotal) {
        $item.find('.js-line-total').text(formatMoney(lineTotal));
    }

    function postCart(url, payload, $item) {
        if ($item) {
            setLoading($item, true);
        }

        return $.ajax({
            url: url,
            method: 'POST',
            data: Object.assign({ _token: csrfToken() }, payload),
            dataType: 'json'
        }).always(function () {
            if ($item) {
                setLoading($item, false);
            }
        });
    }

    function changeQuantity($item, delta) {
        var cartKey = $item.data('cart-key');
        var $input = $item.find('.js-quantity');
        var current = parseInt($input.val(), 10) || 1;
        var next = Math.max(1, current + delta);

        if (next === current) {
            return;
        }

        postCart(routes.update, { id: cartKey, quantity: next }, $item)
            .done(function (res) {
                if (!res.success) {
                    return;
                }
                $input.val(res.quantity);
                updateLineTotal($item, res.line_total);
                updateTotals(res);
            })
            .fail(function () {
                alert('Không thể cập nhật số lượng. Vui lòng thử lại.');
            });
    }

    function removeItem($item) {
        if (!window.confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            return;
        }

        var cartKey = $item.data('cart-key');

        postCart(routes.remove, { id: cartKey }, $item)
            .done(function (res) {
                if (!res.success) {
                    return;
                }
                $item.slideUp(200, function () {
                    $(this).remove();
                    updateTotals(res);
                    if ($('.cart-item').length === 0) {
                        window.location.reload();
                    }
                });
            })
            .fail(function () {
                alert('Không thể xóa sản phẩm. Vui lòng thử lại.');
            });
    }

    function clearCart() {
        if (!window.confirm('Bạn có chắc muốn xóa tất cả sản phẩm trong giỏ hàng?')) {
            return;
        }

        postCart(routes.clear, {})
            .done(function (res) {
                if (res.success) {
                    window.location.reload();
                }
            })
            .fail(function () {
                alert('Không thể xóa giỏ hàng. Vui lòng thử lại.');
            });
    }

    $(function () {
        $(document).on('click', '.cart-qty__btn--minus', function () {
            changeQuantity($(this).closest('.cart-item'), -1);
        });

        $(document).on('click', '.cart-qty__btn--plus', function () {
            changeQuantity($(this).closest('.cart-item'), 1);
        });

        $(document).on('click', '.cart-item__remove', function () {
            removeItem($(this).closest('.cart-item'));
        });

        $(document).on('click', '.js-clearcart', function (e) {
            e.preventDefault();
            clearCart();
        });
    });
})(jQuery);
