/**
 * DetaliVam - Main JS
 */
(function($) {
  'use strict';

  function dvText(key, fallback) {
    if (typeof dvConfig !== 'undefined' && dvConfig.i18n && dvConfig.i18n[key]) {
      return dvConfig.i18n[key];
    }
    return fallback || '';
  }

  function dvFormatText(template, value) {
    return String(template || '').replace('%s', value);
  }

  /* Toast */
  window.dvToast = function(msg, type) {
    var t = document.getElementById('dv-toast');
    var m = document.getElementById('dv-toast-msg');
    if (!t || !m) return;
    m.textContent = msg;
    t.style.borderLeft = '3px solid ' + (type === 'error' ? '#005FC2' : '#4ADE80');
    t.classList.add('show');
    clearTimeout(t._timer);
    t._timer = setTimeout(function() { t.classList.remove('show'); }, 3500);
  };

  function dvUpdateCartUi(data) {
    if (!data) return;

    var badge = document.getElementById('dv-cart-badge');
    var total = document.getElementById('dv-cart-total');
    var preview = document.getElementById('dv-cart-preview');

    if (badge && data.count !== undefined) {
      badge.textContent = data.count;
      badge.style.display = data.count > 0 ? 'flex' : 'none';
    }

    if (total && data.total) {
      total.innerHTML = data.total;
    }

    if (preview) {
      preview.removeAttribute('data-loaded');
    }
  }

  function dvUpdateCartButton(btn, inCart) {
    var label;

    if (!btn) return;

    btn.classList.toggle('is-in-cart', !!inCart);
    btn.setAttribute('data-in-cart', inCart ? '1' : '0');

    label = btn.querySelector('span');
    if (label && btn.hasAttribute('data-label-default') && btn.hasAttribute('data-label-in-cart')) {
      label.textContent = inCart ? btn.getAttribute('data-label-in-cart') : btn.getAttribute('data-label-default');
    }
  }

  function dvRefreshCartButtons(productId, inCart) {
    if (!productId) return;

    document.querySelectorAll('.dv-btn-cart[data-product-id="' + productId + '"]').forEach(function(btn) {
      dvUpdateCartButton(btn, inCart);
    });

    document.querySelectorAll('form.cart input[name="add-to-cart"]').forEach(function(input) {
      var form;
      var singleBtn;

      if (String(input.value) !== String(productId)) return;

      form = input.closest('form.cart');
      singleBtn = form ? form.querySelector('.single_add_to_cart_button') : null;

      if (!singleBtn) return;

      singleBtn.classList.toggle('is-in-cart', !!inCart);
      singleBtn.setAttribute('data-in-cart', inCart ? '1' : '0');
      singleBtn.textContent = inCart ? dvText('in_cart', 'В корзине') : dvText('to_cart', 'В корзину');
    });
  }

  function dvSubmitAddToCart(body, btn, productId) {
    var orig = btn ? btn.innerHTML : '';
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = dvText('adding', 'Добавляем...');
    }

    fetch(dvConfig.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: body
    })
      .then(function(r) { return r.json(); })
      .then(function(d) {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = orig;
        }

        if (d.success) {
          dvUpdateCartUi(d.data);
          dvRefreshCartButtons(productId, true);
          dvToast(dvText('added_to_cart', 'Товар добавлен в корзину'));
        } else {
          dvToast((d.data && d.data.message) || dvText('add_error', 'Ошибка добавления'), 'error');
        }
      })
      .catch(function() {
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = orig;
        }
        dvToast(dvText('connection_error', 'Ошибка соединения'), 'error');
      });
  }

  /* AJAX Add to Cart */
  window.dvAddToCart = function(id, btn, qty) {
    if (typeof dvConfig === 'undefined' || !id) return;

    if (btn && btn.classList && btn.classList.contains('is-in-cart') && dvConfig.cartUrl) {
      window.location.href = dvConfig.cartUrl;
      return;
    }

    qty = qty || 1;

    dvSubmitAddToCart(
      'action=dv_add_to_cart&product_id=' + encodeURIComponent(id) +
      '&quantity=' + encodeURIComponent(qty) +
      '&nonce=' + encodeURIComponent(dvConfig.nonce),
      btn,
      id
    );
  };

  /* AJAX add to cart for WooCommerce shortcode cards */
  $(document).on('click', '.woocommerce ul.products .add_to_cart_button', function(e) {
    var pid = $(this).data('product_id') || $(this).attr('data-product_id');
    if (!pid) return;
    e.preventDefault();
    window.dvAddToCart(pid, this, 1);
  });

  $(document).on('click', '.dv-btn-cart[data-product-id]', function(e) {
    var pid = this.getAttribute('data-product-id');
    if (!pid) return;
    e.preventDefault();
    window.dvAddToCart(pid, this, 1);
  });

  function dvCookieGet(name) {
    var match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
    return match ? decodeURIComponent(match.pop()) : '';
  }

  function dvCookieSet(name, value, days) {
    var maxAge = Math.max(1, Number(days || 30)) * 24 * 60 * 60;
    document.cookie = name + '=' + encodeURIComponent(value) + ';path=/;max-age=' + maxAge;
  }

  function dvCookieList(name) {
    var raw = dvCookieGet(name);

    if (!raw) return [];

    return raw
      .split(',')
      .map(function(x) { return parseInt(x, 10); })
      .filter(function(x, index, arr) {
        return x > 0 && arr.indexOf(x) === index;
      });
  }

  function dvWishlistHas(id) {
    return dvCookieList('dv_wishlist').indexOf(Number(id)) !== -1;
  }

  function dvCompareHas(id) {
    return dvCookieList('dv_compare').indexOf(Number(id)) !== -1;
  }

  function dvUpdateWishlistButton(btn, added) {
    var label;

    if (!btn) return;

    btn.setAttribute('aria-pressed', added ? 'true' : 'false');
    btn.classList.toggle('is-active', !!added);

    label = btn.querySelector('span');
    if (label && btn.hasAttribute('data-label-default') && btn.hasAttribute('data-label-active')) {
      label.textContent = added ? btn.getAttribute('data-label-active') : btn.getAttribute('data-label-default');
    }
  }

  function dvUpdateCompareButton(btn, added) {
    var label;

    if (!btn) return;

    btn.setAttribute('aria-pressed', added ? 'true' : 'false');
    btn.classList.toggle('is-active', !!added);

    label = btn.querySelector('span');
    if (label && btn.hasAttribute('data-label-default') && btn.hasAttribute('data-label-active')) {
      label.textContent = added ? btn.getAttribute('data-label-active') : btn.getAttribute('data-label-default');
    }
  }

  window.dvInitCompareView = function(scope) {
    var root = scope && scope.querySelector ? scope : document;
    var table = root.querySelector('.dv-compare-table');
    var toggle = root.querySelector('.dv-compare-diff-checkbox');
    var clearBtn = root.querySelector('[data-compare-action="clear"]');
    var removeButtons = root.querySelectorAll('[data-compare-action="remove"]');
    var storageKey = 'dv_compare_only_diff';

    function applyState(checked) {
      if (!table || !toggle) return;
      toggle.checked = !!checked;
      table.classList.toggle('is-only-diff', !!checked);
    }

    if (!table || !toggle) return;

    try {
      applyState(window.localStorage.getItem(storageKey) === '1');
    } catch (e) {
      applyState(false);
    }

    toggle.onchange = function() {
      var checked = !!this.checked;
      applyState(checked);
      try {
        window.localStorage.setItem(storageKey, checked ? '1' : '0');
      } catch (e) {}
    };

    if (clearBtn && !clearBtn.dataset.bound) {
      clearBtn.dataset.bound = '1';
      clearBtn.addEventListener('click', function() {
        dvCookieSet('dv_compare', '', -1);
        window.location.reload();
      });
    }

    removeButtons.forEach(function(btn) {
      if (btn.dataset.bound) return;
      btn.dataset.bound = '1';

      btn.addEventListener('click', function() {
        var id = parseInt(this.getAttribute('data-product-id'), 10) || 0;
        var list = dvCookieList('dv_compare');

        if (!id) return;

        list = list.filter(function(item) {
          return Number(item) !== id;
        });

        dvCookieSet('dv_compare', list.join(','), 30);
        window.location.reload();
      });
    });
  };

  function dvExtractProductId(btn) {
    var attr;

    if (!btn) return 0;

    attr = btn.getAttribute('data-product-id');
    if (attr) return parseInt(attr, 10) || 0;

    attr = btn.getAttribute('onclick') || '';
    attr = attr.match(/dvAdd(?:Wish|Compare)\((\d+)/);

    return attr ? parseInt(attr[1], 10) || 0 : 0;
  }

  window.dvRefreshActionButtons = function(scope) {
    var root = scope && scope.querySelectorAll ? scope : document;

    root.querySelectorAll('.dv-wishlist-btn').forEach(function(btn) {
      var id = dvExtractProductId(btn);
      if (id) dvUpdateWishlistButton(btn, dvWishlistHas(id));
    });

    root.querySelectorAll('.dv-compare-btn').forEach(function(btn) {
      var id = dvExtractProductId(btn);
      if (id) dvUpdateCompareButton(btn, dvCompareHas(id));
    });
  };

  window.dvUpdateHeaderBadges = function() {
    var wishlistBadge = document.getElementById('dv-wishlist-badge');
    var wishlistCount = dvCookieList('dv_wishlist').length;
    var compareBadge = document.getElementById('dv-compare-badge');
    var compareCount = dvCookieList('dv_compare').length;
    var wishlistPreview = document.getElementById('dv-wishlist-preview');
    var comparePreview = document.getElementById('dv-compare-preview');
    var cartPreview = document.getElementById('dv-cart-preview');

    if (wishlistBadge) {
      wishlistBadge.textContent = wishlistCount;
      wishlistBadge.style.display = wishlistCount > 0 ? 'flex' : 'none';
    }

    if (compareBadge) {
      compareBadge.textContent = compareCount;
      compareBadge.style.display = compareCount > 0 ? 'flex' : 'none';
    }

    if (wishlistPreview) wishlistPreview.removeAttribute('data-loaded');
    if (comparePreview) comparePreview.removeAttribute('data-loaded');
    if (cartPreview) cartPreview.removeAttribute('data-loaded');
  };

  (function() {
    var wrappers = document.querySelectorAll('[data-header-preview]');

    function loadPreview(preview) {
      var type;
      var ids;
      var requestBody;

      if (!preview || typeof dvConfig === 'undefined' || preview.getAttribute('data-loaded') === '1') {
        return;
      }

      type = preview.getAttribute('data-preview-type') || 'wishlist';
      ids = type === 'compare'
        ? dvCookieList('dv_compare')
        : (type === 'wishlist' ? dvCookieList('dv_wishlist') : []);

      if (type !== 'cart' && !ids.length) {
        preview.innerHTML = '<div class="dv-header-preview-empty">' +
          (type === 'compare'
            ? dvText('compare_empty', 'Список сравнения пуст')
            : dvText('wishlist_empty_short', 'В избранном пока пусто')) +
          '</div>';
        preview.setAttribute('data-loaded', '1');
        return;
      }

      requestBody = type === 'cart'
        ? 'action=dv_get_header_cart_preview&nonce=' + encodeURIComponent(dvConfig.nonce || '')
        : 'action=dv_get_header_list_preview&type=' + encodeURIComponent(type) + '&ids=' + encodeURIComponent(ids.join(',')) + '&nonce=' + encodeURIComponent(dvConfig.listsNonce || '');

      fetch(dvConfig.ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: requestBody
      })
        .then(function(r) { return r.json(); })
        .then(function(d) {
          if (!d.success || !d.data || !d.data.html) {
            preview.innerHTML = '<div class="dv-header-preview-empty">' + dvText('connection_error', 'Ошибка соединения') + '</div>';
            preview.setAttribute('data-loaded', '1');
            return;
          }

          preview.innerHTML = d.data.html;
          preview.setAttribute('data-loaded', '1');
        })
        .catch(function() {
          preview.innerHTML = '<div class="dv-header-preview-empty">' + dvText('connection_error', 'Ошибка соединения') + '</div>';
          preview.setAttribute('data-loaded', '1');
        });
    }

    wrappers.forEach(function(wrapper) {
      var preview = wrapper.querySelector('.dv-header-preview');

      if (!preview) return;

      wrapper.addEventListener('mouseenter', function() {
        wrapper.classList.add('is-open');
        loadPreview(preview);
      });

      wrapper.addEventListener('mouseleave', function() {
        wrapper.classList.remove('is-open');
      });

      wrapper.addEventListener('focusin', function() {
        wrapper.classList.add('is-open');
        loadPreview(preview);
      });

      wrapper.addEventListener('focusout', function(e) {
        if (wrapper.getAttribute('data-keep-open') === '1') {
          return;
        }
        if (!wrapper.contains(e.relatedTarget)) {
          wrapper.classList.remove('is-open');
        }
      });
    });
  })();

  $(document).on('click', '.dv-header-preview-qty-btn[data-cart-item-key]', function(e) {
    var btn = this;
    var preview = btn.closest('.dv-header-preview');
    var wrapper = preview ? preview.closest('.header-action-wrap') : null;
    var key = btn.getAttribute('data-cart-item-key');
    var productId = btn.getAttribute('data-product-id');
    var delta = parseInt(btn.getAttribute('data-cart-qty-delta') || '0', 10);

    if (!key || !delta || typeof dvConfig === 'undefined') return;

    e.preventDefault();
    if (wrapper) {
      wrapper.classList.add('is-open');
      wrapper.setAttribute('data-keep-open', '1');
    }
    btn.disabled = true;

    fetch(dvConfig.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=dv_update_header_cart_item_qty&cart_item_key=' + encodeURIComponent(key) + '&product_id=' + encodeURIComponent(productId || '') + '&delta=' + encodeURIComponent(delta) + '&nonce=' + encodeURIComponent(dvConfig.nonce || '')
    })
      .then(function(r) { return r.json(); })
      .then(function(d) {
        btn.disabled = false;

        if (!d.success || !d.data) {
          dvToast(dvText('connection_error', 'Ошибка соединения'), 'error');
          return;
        }

        if (preview && d.data.html) {
          preview.innerHTML = d.data.html;
          preview.setAttribute('data-loaded', '1');
        }

        if (wrapper) {
          wrapper.classList.add('is-open');
          window.setTimeout(function() {
            wrapper.removeAttribute('data-keep-open');
          }, 150);
        }

        dvUpdateCartUi(d.data);

        if (d.data.product_id && typeof window.dvRefreshCartButtons === 'function') {
          window.dvRefreshCartButtons(d.data.product_id, !!d.data.in_cart);
        }

        dvToast(delta > 0 ? dvText('cart_qty_increased', 'Количество увеличено') : dvText('cart_qty_decreased', 'Количество уменьшено'));
      })
      .catch(function() {
        btn.disabled = false;
        if (wrapper) {
          wrapper.classList.add('is-open');
          window.setTimeout(function() {
            wrapper.removeAttribute('data-keep-open');
          }, 150);
        }
        dvToast(dvText('connection_error', 'Ошибка соединения'), 'error');
      });
  });

  window.dvAddWish = function(id, btn) {
    if (typeof dvConfig === 'undefined' || !id) return;

    if (!btn && document.activeElement && document.activeElement.classList.contains('product-action-btn')) {
      btn = document.activeElement;
    }

    fetch(dvConfig.ajaxUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=dv_toggle_wishlist&product_id=' + encodeURIComponent(id) + '&nonce=' + encodeURIComponent(dvConfig.listsNonce || '')
    })
      .then(function(r) { return r.json(); })
      .then(function(d) {
        if (!d.success) {
          dvToast(dvText('wishlist_error', 'Ошибка избранного'), 'error');
          return;
        }

        if (d.data && Array.isArray(d.data.items)) {
          dvCookieSet('dv_wishlist', d.data.items.join(','), 30);
        }

        dvUpdateWishlistButton(btn, !!d.data.added);
        window.dvRefreshActionButtons(document);
        window.dvUpdateHeaderBadges();
        dvToast(
          d.data.added
            ? dvText('wishlist_added', 'Добавлено в избранное')
            : dvText('wishlist_removed', 'Удалено из избранного')
        );
      })
      .catch(function() {
        dvToast(dvText('connection_error', 'Ошибка соединения'), 'error');
      });
  };

  window.dvAddCompare = function(id, btn) {
    var list;
    var idx;

    id = Number(id) || 0;
    if (!id) return;

    if (!btn && document.activeElement && document.activeElement.classList.contains('product-action-btn')) {
      btn = document.activeElement;
    }

    list = dvCookieList('dv_compare');
    idx = list.indexOf(id);

    if (idx === -1) {
      if (list.length >= (Number(dvConfig && dvConfig.compareLimit) || 4)) {
        dvToast(dvText('compare_limit', 'Можно сравнивать не более 4 товаров'), 'error');
        return;
      }

      list.push(id);
      dvToast(dvText('compare_added', 'Добавлено к сравнению'));
    } else {
      list.splice(idx, 1);
      dvToast(dvText('compare_removed', 'Удалено из сравнения'));
    }

    dvCookieSet('dv_compare', list.join(','), 30);
    dvUpdateCompareButton(btn, idx === -1);
    window.dvRefreshActionButtons(document);
    window.dvUpdateHeaderBadges();
  };

  $(document).on('click', '.dv-wishlist-btn[data-product-id]', function(e) {
    var pid = this.getAttribute('data-product-id');
    if (!pid) return;
    e.preventDefault();
    window.dvAddWish(pid, this);
  });

  $(document).on('click', '.dv-compare-btn[data-product-id]', function(e) {
    var pid = this.getAttribute('data-product-id');
    if (!pid) return;
    e.preventDefault();
    window.dvAddCompare(pid, this);
  });

  $(document).on('click', '.js-open-reviews-tab', function(e) {
    var tab;
    e.preventDefault();
    tab = document.querySelector('[data-tab=reviews]');
    if (tab) tab.click();
  });

  function dvReviewStarValue(link) {
    var match;

    if (!link) return 0;

    match = String(link.className || '').match(/star-(\d)/);

    if (match) {
      return parseInt(match[1], 10) || 0;
    }

    return Array.prototype.indexOf.call(link.parentNode ? link.parentNode.children : [], link) + 1;
  }

  function dvPaintReviewStars(stars, rating, mode) {
    var links;

    if (!stars) return;

    links = stars.querySelectorAll('a');
    rating = parseInt(rating || 0, 10);

    links.forEach(function(link) {
      var value = dvReviewStarValue(link);
      var active = value > 0 && value <= rating;

      link.classList.toggle(mode === 'preview' ? 'is-preview' : 'is-active', active);
      link.setAttribute('aria-checked', active && value === rating ? 'true' : 'false');
    });
  }

  function dvClearReviewStarPreview(stars) {
    if (!stars) return;

    stars.querySelectorAll('a.is-preview').forEach(function(link) {
      link.classList.remove('is-preview');
    });
  }

  function dvSelectedReviewRating(stars) {
    var select;
    var active;

    if (!stars) return 0;

    select = document.getElementById('rating');
    if (select && select.value) {
      return parseInt(select.value, 10) || 0;
    }

    active = stars.querySelector('a.active');

    return active ? dvReviewStarValue(active) : 0;
  }

  function dvInitReviewStars(scope) {
    var root = scope && scope.querySelectorAll ? scope : document;

    root.querySelectorAll('#tab-reviews .comment-form-rating .stars').forEach(function(stars) {
      dvClearReviewStarPreview(stars);
      dvPaintReviewStars(stars, dvSelectedReviewRating(stars), 'active');
    });
  }

  function dvQueueReviewStarsInit() {
    window.setTimeout(function() {
      dvInitReviewStars(document);
    }, 0);
    window.setTimeout(function() {
      dvInitReviewStars(document);
    }, 160);
  }

  $(document).on('mouseenter focus', '#tab-reviews .comment-form-rating .stars a', function() {
    var stars = this.closest('.stars');

    dvClearReviewStarPreview(stars);
    dvPaintReviewStars(stars, dvReviewStarValue(this), 'preview');
  });

  $(document).on('mouseleave focusout', '#tab-reviews .comment-form-rating .stars', function() {
    dvClearReviewStarPreview(this);
    dvPaintReviewStars(this, dvSelectedReviewRating(this), 'active');
  });

  $(document).on('click', '#tab-reviews .comment-form-rating .stars a', function(e) {
    var stars = this.closest('.stars');
    var select = document.getElementById('rating');
    var rating = dvReviewStarValue(this);

    e.preventDefault();

    if (select) {
      select.value = String(rating);
      $(select).trigger('change');
    }

    dvClearReviewStarPreview(stars);
    dvPaintReviewStars(stars, rating, 'active');
  });

  $(document).on('change', '#rating', function() {
    dvInitReviewStars(document);
  });

  function dvSyncMobileFilterAccordions() {
    var isMobile = window.matchMedia('(max-width: 767px)').matches;

    document.querySelectorAll('[data-filter-widget]').forEach(function(widget) {
      var body = widget.querySelector('[data-filter-body]');
      var toggle = widget.querySelector('[data-filter-toggle]');

      if (!body || !toggle) return;

      if (!isMobile) {
        widget.classList.add('is-open');
        body.hidden = false;
        toggle.setAttribute('aria-expanded', 'true');
        return;
      }

      if (!widget.classList.contains('is-open')) {
        body.hidden = true;
        toggle.setAttribute('aria-expanded', 'false');
      } else {
        body.hidden = false;
        toggle.setAttribute('aria-expanded', 'true');
      }
    });
  }

  document.addEventListener('click', function(e) {
    var toggle = e.target.closest('[data-filter-toggle]');
    var widget;
    var body;
    var isOpen;

    if (!toggle || !window.matchMedia('(max-width: 767px)').matches) return;

    widget = toggle.closest('[data-filter-widget]');
    body = widget ? widget.querySelector('[data-filter-body]') : null;

    if (!widget || !body) return;

    e.preventDefault();
    isOpen = !widget.classList.contains('is-open');
    widget.classList.toggle('is-open', isOpen);
    body.hidden = !isOpen;
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  dvSyncMobileFilterAccordions();
  window.addEventListener('resize', dvSyncMobileFilterAccordions);

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      if (window.dvInitCompareView) window.dvInitCompareView(document);
      dvQueueReviewStarsInit();
    });
  } else if (window.dvInitCompareView) {
    window.dvInitCompareView(document);
    dvQueueReviewStarsInit();
  } else {
    dvQueueReviewStarsInit();
  }

  window.dvRefreshActionButtons(document);
  window.dvUpdateHeaderBadges();

  /* AJAX add to cart for single product forms */
  $(document).on('click', '.single_add_to_cart_button', function(e) {
    var form = this.closest('form.cart');
    var btn = this;
    var body;
    var productId;
    var quantity;
    var variationId;
    var buyNowFlag;

    if (!form || typeof dvConfig === 'undefined') return;

    productId = form.querySelector('input[name="add-to-cart"]');
    quantity = form.querySelector('input.qty');
    variationId = form.querySelector('input[name="variation_id"]');
    buyNowFlag = form.querySelector('input[name="dv_buy_now"]');

    productId = productId ? productId.value : (btn.value || btn.getAttribute('value'));
    quantity = quantity ? quantity.value : 1;
    variationId = variationId ? variationId.value : '';

    if (!productId) return;

    if (btn.classList.contains('is-in-cart') && dvConfig.cartUrl) {
      e.preventDefault();
      window.location.href = dvConfig.cartUrl;
      return;
    }

    e.preventDefault();

    if (buyNowFlag) {
      buyNowFlag.value = '0';
    }

    body = 'action=dv_add_to_cart' +
      '&product_id=' + encodeURIComponent(productId) +
      '&quantity=' + encodeURIComponent(quantity) +
      '&variation_id=' + encodeURIComponent(variationId) +
      '&nonce=' + encodeURIComponent(dvConfig.nonce);

    new FormData(form).forEach(function(value, key) {
      if (key.indexOf('attribute_') === 0) {
        body += '&' + encodeURIComponent(key) + '=' + encodeURIComponent(value);
      }
    });

    dvSubmitAddToCart(body, btn);
  });

  $(document).on('click', '.dv-buy-now-button', function() {
    var form = this.closest('form.cart');
    var mainButton;
    var buyNowFlag;
    var addToCartField;
    var productId;

    if (!form) return;

    mainButton = form.querySelector('.single_add_to_cart_button');
    buyNowFlag = form.querySelector('input[name="dv_buy_now"]');
    addToCartField = form.querySelector('input[name="add-to-cart"]');
    productId = addToCartField ? addToCartField.value : '';

    if (!buyNowFlag) {
      buyNowFlag = document.createElement('input');
      buyNowFlag.type = 'hidden';
      buyNowFlag.name = 'dv_buy_now';
      form.appendChild(buyNowFlag);
    }

    if (!addToCartField) {
      addToCartField = document.createElement('input');
      addToCartField.type = 'hidden';
      addToCartField.name = 'add-to-cart';
      form.appendChild(addToCartField);
    }

    if (mainButton && (mainButton.disabled || mainButton.classList.contains('disabled'))) {
      return;
    }

    if (!productId && mainButton) {
      productId = mainButton.value || mainButton.getAttribute('value') || '';
    }

    if (!productId) {
      return;
    }

    addToCartField.value = productId;
    buyNowFlag.value = '1';
    form.submit();
  });

  /* Variation buttons over native WooCommerce selects */
  (function() {
    function syncVariationUi(form) {
      form.querySelectorAll('select.dv-var-select').forEach(function(select) {
        var options = {};
        var ui = select.parentElement ? select.parentElement.querySelector('.dv-var-ui') : null;

        if (!ui) return;

        Array.prototype.forEach.call(select.options, function(option) {
          options[option.value] = option;
        });

        ui.querySelectorAll('.dv-var-btn').forEach(function(btn) {
          var option = options[btn.getAttribute('data-value')];
          var disabled = !option || option.disabled;

          btn.disabled = !!disabled;
          btn.classList.toggle('is-active', select.value === btn.getAttribute('data-value'));
        });
      });
    }

    function buildVariationUi(form) {
      var selects;

      if (!form || form.getAttribute('data-dv-var-ui') === '1') return;

      selects = form.querySelectorAll('table.variations select[name^="attribute_"]');
      if (!selects.length) return;

      form.setAttribute('data-dv-var-ui', '1');

      selects.forEach(function(select) {
        var row = select.closest('tr');
        var cell = select.closest('td.value') || select.parentElement;
        var label = row ? row.querySelector('label') : null;
        var ui = document.createElement('div');
        var title = document.createElement('div');
        var btns = document.createElement('div');

        if (!cell) return;

        select.classList.add('dv-var-select');

        ui.className = 'dv-var-ui';
        title.className = 'dv-var-label';
        title.textContent = label ? label.textContent.replace(/\s*:\s*$/, '').trim() : select.name.replace(/^attribute_/, '');
        btns.className = 'dv-var-btns';

        Array.prototype.forEach.call(select.options, function(option) {
          var btn;

          if (!option.value) return;

          btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'dv-var-btn';
          btn.setAttribute('data-value', option.value);
          btn.textContent = option.textContent.trim();
          btn.addEventListener('click', function() {
            if (btn.disabled) return;
            select.value = option.value;
            $(select).trigger('change');
            syncVariationUi(form);
          });
          btns.appendChild(btn);
        });

        ui.appendChild(title);
        ui.appendChild(btns);
        cell.appendChild(ui);
      });

      syncVariationUi(form);

      $(form).on('woocommerce_update_variation_values found_variation reset_data hide_variation show_variation', function() {
        setTimeout(function() {
          syncVariationUi(form);
        }, 0);
      });

      selects.forEach(function(select) {
        select.addEventListener('change', function() {
          syncVariationUi(form);
        });
      });
    }

    document.querySelectorAll('.variations_form').forEach(buildVariationUi);
  })();

  /* Cart quantity buttons */
  window.dvCartQty = function(btn, delta) {
    var wrap = btn ? btn.closest('.cart-qty-wrap') : null;
    var input = wrap ? wrap.querySelector('input.qty, input.cart-qty-input') : null;
    var current;
    var min;
    var max;
    var next;

    if (!input) return;

    current = parseInt(input.value, 10);
    min = parseInt(input.getAttribute('min') || '0', 10);
    max = parseInt(input.getAttribute('max') || '999', 10);

    if (isNaN(current)) current = Math.max(1, min || 1);
    if (isNaN(min)) min = 0;
    if (isNaN(max)) max = 999;

    next = current + Number(delta || 0);
    next = Math.max(min, Math.min(max, next));

    input.value = next;
    input.dispatchEvent(new Event('input', { bubbles: true }));
    input.dispatchEvent(new Event('change', { bubbles: true }));
  };

  $(document).on('click', '.cart-qty-btn[data-delta]', function() {
    var delta = parseInt(this.getAttribute('data-delta') || '0', 10);
    window.dvCartQty(this, delta);
  });

  /* Cart auto update on quantity change */
  (function() {
    var form = document.querySelector('.woocommerce-cart-form');
    var updateBtn = document.getElementById('dv-update-cart-btn');
    var updateField = null;
    var timer = 0;

    if (!form || !updateBtn) return;

    updateField = form.querySelector('input[name="update_cart"]');
    if (!updateField) {
      updateField = document.createElement('input');
      updateField.type = 'hidden';
      updateField.name = 'update_cart';
      updateField.value = updateBtn.value || '1';
      form.appendChild(updateField);
    }

    function submitCartUpdate() {
      if (form.classList.contains('is-updating')) return;

      form.classList.add('is-updating');
      updateBtn.textContent = dvText('recounting', 'Пересчитываем...');
      updateField.value = updateBtn.value || dvText('update_cart', 'Обновить корзину');

      if (typeof form.requestSubmit === 'function') {
        form.requestSubmit();
      } else {
        form.submit();
      }
    }

    function queueCartUpdate() {
      clearTimeout(timer);
      timer = setTimeout(submitCartUpdate, 450);
    }

    form.querySelectorAll('input.qty, input.cart-qty-input').forEach(function(input) {
      input.addEventListener('change', queueCartUpdate);
      input.addEventListener('input', queueCartUpdate);
    });
  })();

  /* Checkout payment highlight */
  (function() {
    function syncPaymentMethods() {
      document.querySelectorAll('#payment ul.payment_methods > li').forEach(function(item) {
        var input = item.querySelector('input[type="radio"]');
        item.classList.toggle('is-selected', !!(input && input.checked));
      });
    }

    if (!document.getElementById('payment')) return;

    syncPaymentMethods();

    document.addEventListener('change', function(e) {
      if (e.target && e.target.matches('#payment input[type="radio"]')) {
        syncPaymentMethods();
      }
    });

    $(document.body).on('updated_checkout', syncPaymentMethods);
  })();

  /* Sticky header */
  var header = document.getElementById('site-header');
  if (header) {
    var lastY = 0;
    window.addEventListener('scroll', function() {
      var y = window.scrollY;
      if (y > lastY && y > 100) {
        header.style.transform = 'translateY(-100%)';
      } else {
        header.style.transform = 'translateY(0)';
      }
      lastY = y;
    }, { passive: true });
    header.style.transition = 'transform 0.3s ease';
  }

  /* Single product gallery + tabs */
  (function() {
    var imgs = [];
    var cur = 0;
    var wrap = document.getElementById('dv-gallery-main');
    var mainImg = document.getElementById('dv-main-img');
    var lightbox = document.getElementById('dv-lightbox');
    var lightboxImg = document.getElementById('lb-img');
    var prevBtn = document.getElementById('lb-prev');
    var nextBtn = document.getElementById('lb-next');
    var closeBtn = document.getElementById('lb-close');

    if (wrap) {
      try { imgs = JSON.parse(wrap.dataset.images || '[]'); } catch (e) {}
    }

    if (lightbox && lightbox.parentNode !== document.body) {
      document.body.appendChild(lightbox);
    }

    function setActiveThumb(index) {
      document.querySelectorAll('.gallery-thumb').forEach(function(x) {
        x.classList.toggle('active', parseInt(x.dataset.index || 0, 10) === index);
      });
    }

    function showImage(index) {
      cur = index;
      if (mainImg && imgs[cur]) {
        mainImg.removeAttribute('srcset');
        mainImg.removeAttribute('sizes');
        mainImg.src = imgs[cur];
      }
      setActiveThumb(cur);
      if (wrap) {
        wrap.classList.remove('zoomed');
      }
    }

    function openLightbox(index) {
      if (!lightbox || !lightboxImg || !imgs.length) return;
      cur = index;
      lightboxImg.src = imgs[cur];
      lightbox.classList.add('open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      if (!lightbox) return;
      lightbox.classList.remove('open');
      lightbox.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    function stepLightbox(direction) {
      if (!imgs.length) return;
      cur = (cur + direction + imgs.length) % imgs.length;
      if (lightboxImg) {
        lightboxImg.src = imgs[cur];
      }
      showImage(cur);
    }

    document.querySelectorAll('.gallery-thumb').forEach(function(t) {
      t.addEventListener('click', function() {
        showImage(parseInt(this.dataset.index || 0, 10));
      });
    });

    if (wrap) {
      wrap.addEventListener('click', function(e) {
        e.preventDefault();
        openLightbox(cur);
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        stepLightbox(-1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        stepLightbox(1);
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        closeLightbox();
      });
    }

    if (lightbox) {
      lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
          closeLightbox();
        }
      });
    }

    document.querySelectorAll('.tab-nav-btn').forEach(function(btn) {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.tab-nav-btn').forEach(function(b) { b.classList.remove('active'); });
        document.querySelectorAll('.tab-pane').forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');
        var pane = document.getElementById('tab-' + this.dataset.tab);
        if (pane) {
          pane.classList.add('active');
        }
      });
    });
  })();

  /* Lightbox keyboard */
  document.addEventListener('keydown', function(e) {
    var lb = document.getElementById('dv-lightbox');
    if (!lb || !lb.classList.contains('open')) return;
    if (e.key === 'Escape') {
      lb.classList.remove('open');
      lb.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }
    if (e.key === 'ArrowLeft') document.getElementById('lb-prev') && document.getElementById('lb-prev').click();
    if (e.key === 'ArrowRight') document.getElementById('lb-next') && document.getElementById('lb-next').click();
  });

  /* Smooth scroll for anchor links */
  document.querySelectorAll('a[href^="#"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
      var target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* Live search */
  (function() {
    var form = document.getElementById('dv-search-form');
    var input = document.getElementById('dv-search-input');
    var results = document.getElementById('dv-live-results');
    var timer = null;
    var activeRequest = 0;
    var activeController = null;
    var lastQuery = '';
    var liveCache = {};
    var liveCacheKeys = [];
    var liveUrl;

    if (!form || !input || !results) return;

    liveUrl = form.getAttribute('data-live-search-url');
    if (!liveUrl) return;

    function escapeHtml(value) {
      return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }

    function escapeRegExp(value) {
      return String(value).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function highlight(text, query) {
      if (!query) return escapeHtml(text);
      return escapeHtml(text).replace(
        new RegExp('(' + escapeRegExp(query) + ')', 'gi'),
        '<mark class="dv-search-mark">$1</mark>'
      );
    }

    function hideResults() {
      results.style.display = 'none';
    }

    function showResults(html) {
      results.innerHTML = html;
      results.style.display = 'block';
    }

    function renderItems(data, query) {
      var items = data.items || [];
      var html = '';
      var totalLabel = data.total_label || String(Number(data.total || items.length));

      if (!items.length) {
        return '<div class="dv-search-empty">' + escapeHtml(dvFormatText(dvText('search_empty', 'Ничего не найдено по запросу «%s»'), query)) + '</div>';
      }

      html += '<div class="dv-search-meta">' + escapeHtml(dvText('search_found', 'Найдено:')) + ' ' + escapeHtml(totalLabel) + '</div>';

      items.forEach(function(item) {
        var stockHtml = item.in_stock
          ? '<span class="dv-search-stock is-in-stock">\u25cf ' + escapeHtml(dvText('search_in_stock', 'В наличии')) + (item.stock_q ? ' ' + escapeHtml(item.stock_q) + ' \u0448\u0442.' : '') + '</span>'
          : '<span class="dv-search-stock is-out-stock">' + escapeHtml(dvText('search_out_of_stock', 'Нет в наличии')) + '</span>';
        var skuHtml = item.sku
          ? '<span class="dv-search-sku">' + escapeHtml(item.sku) + '</span>'
          : '';

        html += '<a href="' + escapeHtml(item.url) + '" class="dv-search-item">' +
          '<img src="' + escapeHtml(item.img) + '" alt="" class="dv-search-thumb">' +
          '<div class="dv-search-main">' +
            '<div class="dv-search-name">' + highlight(item.name, query) + '</div>' +
            '<div class="dv-search-subline">' + stockHtml + (skuHtml ? '<span class="dv-search-dot">\u00b7</span>' + skuHtml : '') + '</div>' +
          '</div>' +
          '<div class="dv-search-price">' + escapeHtml(item.price) + '</div>' +
        '</a>';
      });

      if (items.length) {
        html += '<a href="' + escapeHtml(data.search_url || ('/?s=' + encodeURIComponent(query) + '&post_type=product')) + '" class="dv-search-all">' + escapeHtml(dvText('search_all_results_link', '\u0421\u043c\u043e\u0442\u0440\u0435\u0442\u044c \u0432\u0441\u0435')) + '</a>';
      }

      return html;
    }

    input.addEventListener('input', function() {
      var query = this.value.trim();
      var cacheKey = query.toLowerCase();
      var requestId;
      var requestController = null;

      clearTimeout(timer);

      if (query.length < 2) {
        activeRequest++;
        if (activeController && typeof activeController.abort === 'function') {
          activeController.abort();
        }
        lastQuery = '';
        hideResults();
        return;
      }

      if (query === lastQuery) return;
      lastQuery = query;
      requestId = ++activeRequest;

      if (liveCache[cacheKey]) {
        if (activeController && typeof activeController.abort === 'function') {
          activeController.abort();
        }
        showResults(renderItems(liveCache[cacheKey], query));
        return;
      }

      if (activeController && typeof activeController.abort === 'function') {
        activeController.abort();
      }

      if (window.AbortController) {
        requestController = new AbortController();
        activeController = requestController;
      }

      showResults('<div class="dv-search-loading">' + escapeHtml(dvText('search_loading', 'Поиск...')) + '</div>');

      timer = setTimeout(function() {
        fetch(
          liveUrl + '?action=dv_live_search&q=' + encodeURIComponent(query),
          requestController ? { signal: requestController.signal } : {}
        )
          .then(function(r) { return r.json(); })
          .then(function(d) {
            if (requestId !== activeRequest) return;
            if (!d.success) {
              hideResults();
              return;
            }
            liveCache[cacheKey] = d.data || {};
            liveCacheKeys.push(cacheKey);
            if (liveCacheKeys.length > 30) {
              delete liveCache[liveCacheKeys.shift()];
            }
            showResults(renderItems(d.data || {}, query));
          })
          .catch(function(error) {
            if (error && error.name === 'AbortError') return;
            if (requestId !== activeRequest) return;
            hideResults();
          });
      }, 160);
    });

    input.addEventListener('focus', function() {
      if (this.value.trim().length >= 2 && results.innerHTML) {
        results.style.display = 'block';
      }
    });

    input.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        hideResults();
        this.blur();
      }
    });

    form.addEventListener('submit', function() {
      hideResults();
    });

    document.addEventListener('click', function(e) {
      if (!results.contains(e.target) && !form.contains(e.target)) {
        hideResults();
      }
    });
  })();

  /* Wishlist page */
  (function() {
    var wrap = document.getElementById('dv-wishlist-wrap');
    var container;
    var empty;
    var loading;
    var ajaxUrl;

    if (!wrap) return;

    container = document.getElementById('dv-wishlist-container');
    empty = document.getElementById('dv-wishlist-empty');
    loading = document.getElementById('dv-wishlist-loading');
    ajaxUrl = wrap.getAttribute('data-ajax-url');

    if (!container || !empty || !loading || !ajaxUrl) return;

    function getCookie(name) {
      var match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
      return match ? decodeURIComponent(match.pop()) : '';
    }

    function showEmpty() {
      loading.style.display = 'none';
      container.classList.add('is-hidden');
      empty.classList.remove('is-hidden');
    }

    function loadWishlist() {
      var raw = getCookie('dv_wishlist');
      var ids = raw ? raw.split(',').map(Number).filter(function(x) { return x > 0; }) : [];

      if (!ids.length) {
        showEmpty();
        return;
      }

      fetch(ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=dv_get_wishlist_products&ids=' + encodeURIComponent(ids.join(',')) + '&nonce=' + encodeURIComponent((window.dvConfig && dvConfig.listsNonce) || '')
      })
        .then(function(response) { return response.json(); })
        .then(function(data) {
          loading.style.display = 'none';
          if (data.success && data.data && data.data.html) {
            container.innerHTML = data.data.html;
            container.classList.remove('is-hidden');
            empty.classList.add('is-hidden');
            if (window.dvRefreshActionButtons) window.dvRefreshActionButtons(container);
            if (window.dvUpdateHeaderBadges) window.dvUpdateHeaderBadges();
          } else {
            showEmpty();
          }
        })
        .catch(function() {
          loading.style.display = 'none';
          container.innerHTML = '<div class="dv-compare-error">' + dvText('wishlist_load_error', 'Ошибка загрузки. Обновите страницу.') + '</div>';
          container.classList.remove('is-hidden');
          empty.classList.add('is-hidden');
        });
    }

    loadWishlist();
  })();

  /* Compare page */
  (function() {
    var container = document.getElementById('dv-compare-container');
    var ajaxUrl;
    var shopUrl;

    if (!container) return;

    ajaxUrl = container.getAttribute('data-ajax-url');
    shopUrl = container.getAttribute('data-shop-url') || '/';

    if (!ajaxUrl) return;

    function getCookie(name) {
      var match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
      return match ? decodeURIComponent(match.pop()) : '';
    }

    function renderEmpty() {
      container.innerHTML =
        '<div class="dv-compare-empty">' +
          '<p class="dv-compare-empty-title">' + dvText('compare_empty', 'Список сравнения пуст') + '</p>' +
          '<a href="' + shopUrl + '" class="dv-compare-empty-link">' + dvText('go_catalog', 'Перейти в каталог') + '</a>' +
        '</div>';
    }

    function loadCompare() {
      var raw = getCookie('dv_compare');
      var ids = raw ? raw.split(',').map(Number).filter(Boolean) : [];

      if (!ids.length) {
        renderEmpty();
        return;
      }

      fetch(ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=dv_get_compare_table&ids=' + encodeURIComponent(ids.join(',')) + '&nonce=' + encodeURIComponent((window.dvConfig && dvConfig.listsNonce) || '')
      })
        .then(function(response) { return response.json(); })
        .then(function(data) {
          if (data.success && data.data && data.data.html) {
            container.innerHTML = data.data.html;
            if (window.dvInitCompareView) window.dvInitCompareView(container);
          } else {
            renderEmpty();
          }
        })
        .catch(function() {
          container.innerHTML = '<div class="dv-compare-error">' + dvText('compare_load_error', 'Не удалось загрузить сравнение.') + '</div>';
        });
    }

    loadCompare();
  })();

  window.dvApplyFilter = function(key, val, checked) {
    var url = new URL(window.location.href);

    if (checked) {
      url.searchParams.set(key, val);
    } else {
      url.searchParams.delete(key);
    }

    url.searchParams.delete('paged');
    window.location.href = url.toString();
  };

  window.dvApplyPrice = function() {
    var url = new URL(window.location.href);
    var min = document.getElementById('price-min');
    var max = document.getElementById('price-max');
    var minValue = min ? min.value : '';
    var maxValue = max ? max.value : '';

    if (minValue) {
      url.searchParams.set('min_price', minValue);
    } else {
      url.searchParams.delete('min_price');
    }

    if (maxValue) {
      url.searchParams.set('max_price', maxValue);
    } else {
      url.searchParams.delete('max_price');
    }

    url.searchParams.delete('paged');
    window.location.href = url.toString();
  };

  $(document).on('change', '.js-filter-marka', function() {
    window.dvApplyFilter('marka', this.value, this.checked);
  });

  $(document).on('change', '.js-filter-stock', function() {
    window.dvApplyFilter('stock', this.checked ? 'instock' : '', this.checked);
  });

  $(document).on('click', '.js-filter-price', function() {
    window.dvApplyPrice();
  });

})(jQuery);
