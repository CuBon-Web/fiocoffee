document.addEventListener('DOMContentLoaded', function () {
    var checkoutRoot = document.getElementById('checkout-page');
    if (!checkoutRoot) return;

    var csrf = document.querySelector('meta[name="csrf-token"]');
    var csrfToken = csrf ? csrf.getAttribute('content') : '';
    var updateUrl = checkoutRoot.getAttribute('data-update-url');
    var removeUrl = checkoutRoot.getAttribute('data-remove-url');
    var cartUrl = checkoutRoot.getAttribute('data-cart-url');
    var shippingFee = Number(checkoutRoot.getAttribute('data-shipping-fee') || 30000);
    var subtotalDisplay = document.getElementById('checkout-subtotal-display');
    var shippingDisplay = document.getElementById('checkout-shipping-display');
    var totalDisplay = document.getElementById('checkout-total-display');
    var totalMoneyInput = document.getElementById('checkout-total-money');
    var shippingMethodInput = document.getElementById('checkout-shipping-method');
    var paymentMethodInput = document.getElementById('checkout-payment-method');

    function formatMoney(value) {
        return new Intl.NumberFormat('vi-VN').format(Number(value || 0)) + '₫';
    }

    function postForm(url, data) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams(data).toString()
        }).then(function (res) {
            if (!res.ok) throw new Error('Request failed');
            return res.json();
        });
    }

    function recalculate() {
        var total = 0;
        var rows = document.querySelectorAll('#checkout-products .single-product');
        rows.forEach(function (row) {
            var id = row.getAttribute('data-id');
            var price = Number(row.getAttribute('data-price') || 0);
            var qtyInput = document.querySelector('.js-qty-input[data-id="' + id + '"]');
            var qty = Number(qtyInput ? qtyInput.value : 1);
            if (!qty || qty < 1) qty = 1;
            if (qtyInput) qtyInput.value = qty;

            var line = price * qty;
            var lineEl = document.getElementById('line-total-' + id);
            if (lineEl) lineEl.textContent = formatMoney(line);
            total += line;
        });
        var finalTotal = total + shippingFee;
        if (subtotalDisplay) subtotalDisplay.textContent = formatMoney(total);
        if (shippingDisplay) shippingDisplay.textContent = formatMoney(shippingFee);
        if (totalDisplay) totalDisplay.textContent = formatMoney(finalTotal);
        if (totalMoneyInput) totalMoneyInput.value = finalTotal;
        if (shippingMethodInput) shippingMethodInput.value = shippingFee;
        if (rows.length === 0 && cartUrl) window.location.href = cartUrl;
    }

    document.addEventListener('click', function (event) {
        var plus = event.target.closest('.js-qty-plus');
        var minus = event.target.closest('.js-qty-minus');
        var remove = event.target.closest('.js-remove-item');

        if (plus || minus) {
            event.preventDefault();
            var btn = plus || minus;
            var id = btn.getAttribute('data-id');
            var input = document.querySelector('.js-qty-input[data-id="' + id + '"]');
            if (!input) return;
            var qty = Number(input.value || 1);
            qty = plus ? qty + 1 : Math.max(1, qty - 1);
            input.value = qty;
            recalculate();
            postForm(updateUrl, { id: id, quantity: qty }).catch(function () {
                alert('Không thể cập nhật số lượng.');
            });
        }

        if (remove) {
            event.preventDefault();
            var removeId = remove.getAttribute('data-id');
            postForm(removeUrl, { id: removeId }).then(function () {
                var row = document.getElementById('checkout-item-' + removeId);
                if (row) row.remove();
                recalculate();
            }).catch(function () {
                alert('Không thể xóa sản phẩm.');
            });
        }
    });

    document.addEventListener('change', function (event) {
        if (event.target.classList.contains('js-qty-input')) {
            var id = event.target.getAttribute('data-id');
            var qty = Number(event.target.value || 1);
            if (!qty || qty < 1) qty = 1;
            event.target.value = qty;
            recalculate();
            postForm(updateUrl, { id: id, quantity: qty }).catch(function () {
                alert('Không thể cập nhật số lượng.');
            });
        }

        if (event.target.classList.contains('js-payment-choice') && paymentMethodInput) {
            paymentMethodInput.value = event.target.value;
        }
    });

    recalculate();
});
