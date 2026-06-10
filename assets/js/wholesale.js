(function () {
  'use strict';

  var config = window.dvWholesale || {};
  var labels = config.i18n || {};

  function text(key, fallback) {
    return labels[key] || fallback;
  }

  function toast(message, type) {
    var node = document.createElement('div');
    node.className = 'dv-wholesale-toast' + (type ? ' is-' + type : '');
    node.textContent = message;
    document.body.appendChild(node);

    window.setTimeout(function () {
      node.remove();
    }, 2200);
  }

  function getRow(target) {
    return target ? target.closest('.dv-wholesale-row[data-product-id]') : null;
  }

  function getQtyInput(row) {
    return row ? row.querySelector('.dv-wholesale-qty input') : null;
  }

  function normalizeQty(value) {
    var qty = parseInt(value, 10);
    return Number.isFinite(qty) && qty > 0 ? qty : 1;
  }

  function setQty(input, qty) {
    if (!input) return;
    input.value = String(normalizeQty(qty));
  }

  function updateCartCount(count) {
    var node = document.querySelector('[data-dv-wholesale-cart-count]');
    if (!node || typeof count === 'undefined') return;
    node.textContent = String(count);
  }

  function addProduct(row, button) {
    var input = getQtyInput(row);
    var productId = row ? row.getAttribute('data-product-id') : '';
    var qty = normalizeQty(input ? input.value : 1);
    var body;
    var original;

    if (!productId || !config.ajaxUrl || !config.nonce) return;

    original = button.textContent;
    button.disabled = true;
    button.textContent = text('adding', 'Добавляем...');

    body = new URLSearchParams();
    body.set('action', 'dv_add_to_cart');
    body.set('product_id', productId);
    body.set('quantity', String(qty));
    body.set('nonce', config.nonce);

    fetch(config.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body.toString()
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        button.disabled = false;

        if (!data || !data.success) {
          button.textContent = original;
          toast((data && data.data && data.data.message) || text('add_error', 'Не удалось добавить'), 'error');
          return;
        }

        updateCartCount(data.data ? data.data.count : undefined);
        button.textContent = text('added', 'Добавлено');
        button.classList.add('is-added');
        setQty(input, 1);
        toast(text('added', 'Добавлено'));

        window.setTimeout(function () {
          button.textContent = original;
          button.classList.remove('is-added');
        }, 1400);
      })
      .catch(function () {
        button.disabled = false;
        button.textContent = original;
        toast(text('connection_error', 'Ошибка соединения'), 'error');
      });
  }

  document.addEventListener('click', function (event) {
    var qtyButton = event.target.closest('[data-dv-qty]');
    var addButton = event.target.closest('.dv-wholesale-add[data-product-id]');
    var row;
    var input;
    var delta;

    if (qtyButton) {
      row = getRow(qtyButton);
      input = getQtyInput(row);
      delta = parseInt(qtyButton.getAttribute('data-dv-qty'), 10) || 0;
      setQty(input, normalizeQty(input ? input.value : 1) + delta);
      return;
    }

    if (addButton) {
      event.preventDefault();
      addProduct(getRow(addButton), addButton);
    }
  });

  document.addEventListener('change', function (event) {
    if (event.target.matches('.dv-wholesale-qty input')) {
      setQty(event.target, event.target.value);
    }
  });

  document.addEventListener('keydown', function (event) {
    var row;
    var button;

    if (event.key !== 'Enter' || !event.target.matches('.dv-wholesale-qty input')) {
      return;
    }

    row = getRow(event.target);
    button = row ? row.querySelector('.dv-wholesale-add[data-product-id]') : null;

    if (!button) return;

    event.preventDefault();
    addProduct(row, button);
  });
})();
