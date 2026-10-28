(function () {
  'use strict';

  function setupCartSelection() {
    var selectionForm = document.getElementById('dv-cart-selection-form');
    if (selectionForm) {
      var selectionBoxes = Array.from(document.querySelectorAll('[data-dv-cart-select]'));
      if (!selectionBoxes.length || selectionBoxes[0].dataset.dvSelectionReady) return;
      selectionBoxes.forEach(function (box) { box.dataset.dvSelectionReady = '1'; });
      var selectAll = document.querySelector('[data-dv-select-all]');
      var quantityPending = false;
      var previewPending = false;
      var previewRequest = null;
      var previewVersion = 0;
      var previewUrl = selectionForm.dataset.dvSelectionUrl;
      var preview = document.querySelector('[data-dv-selected-summary]');
      var selectionStorage = 'dvCartSelection';
      try {
        var savedSelection = JSON.parse(sessionStorage.getItem(selectionStorage) || '{}');
        selectionBoxes.forEach(function (box) {
          if (typeof savedSelection[box.value] === 'boolean') box.checked = savedSelection[box.value];
        });
      } catch (error) {}
      function syncSelection() {
        var count = selectionBoxes.filter(function (box) { return box.checked; }).length;
        if (selectAll) {
          selectAll.checked = count === selectionBoxes.length && count > 0;
          selectAll.indeterminate = count > 0 && count < selectionBoxes.length;
        }
        var selectionState = {};
        selectionBoxes.forEach(function (box) {
          var row = box.closest('.cart-item');
          if (row) row.classList.toggle('is-dv-unselected', !box.checked);
          selectionState[box.value] = box.checked;
        });
        try { sessionStorage.setItem(selectionStorage, JSON.stringify(selectionState)); } catch (error) {}
        document.querySelectorAll('[data-dv-selected-checkout]').forEach(function (button) { button.disabled = count === 0 || quantityPending || previewPending; });
        document.querySelectorAll('[data-dv-selection-status]').forEach(function (node) { node.textContent = '\u0412\u044b\u0431\u0440\u0430\u043d\u043e: ' + count + ' / ' + selectionBoxes.length; });
        // The full-cart total must not be presented as the total of a partial selection.
        document.querySelectorAll('.cart-page .cart_totals .shop_table').forEach(function (table) { table.hidden = Boolean(previewUrl && preview) || count !== selectionBoxes.length; });
      }
      function updatePreview() {
        syncSelection();
        if (!previewUrl || !preview) return;
        var version = ++previewVersion;
        if (previewRequest) previewRequest.abort();
        preview.hidden = false;
        if (quantityPending) {
          preview.textContent = '\u041e\u0431\u043d\u043e\u0432\u043b\u044f\u0435\u043c \u043a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e\u2026';
          return;
        }
        previewPending = true;
        syncSelection();
        preview.setAttribute('aria-busy', 'true');
        preview.textContent = '\u041f\u0435\u0440\u0435\u0441\u0447\u0438\u0442\u044b\u0432\u0430\u0435\u043c\u2026';
        previewRequest = new AbortController();
        var data = new URLSearchParams();
        data.set('action', 'dv_cart_selection_preview');
        var nonce = selectionForm.querySelector('[name="dv_selection_nonce"]');
        data.set('nonce', nonce ? nonce.value : '');
        selectionBoxes.filter(function (box) { return box.checked; }).forEach(function (box) { data.append('keys[]', box.value); });
        fetch(previewUrl, { method: 'POST', credentials: 'same-origin', body: data, signal: previewRequest.signal })
          .then(function (response) { if (!response.ok) throw new Error('preview'); return response.json(); })
          .then(function (response) {
            if (version !== previewVersion || !preview.isConnected) return;
            if (!response.success || !response.data || typeof response.data.html !== 'string') throw new Error('preview');
            preview.innerHTML = response.data.html;
            previewPending = false;
            preview.removeAttribute('aria-busy');
            syncSelection();
          }).catch(function (error) {
            if (version !== previewVersion || error.name === 'AbortError' || !preview.isConnected) return;
            preview.textContent = '\u041d\u0435 \u0443\u0434\u0430\u043b\u043e\u0441\u044c \u043f\u0435\u0440\u0435\u0441\u0447\u0438\u0442\u0430\u0442\u044c \u0441\u0443\u043c\u043c\u0443. ';
            var retry = document.createElement('button');
            retry.type = 'button';
            retry.className = 'dv-cart-preview-retry';
            retry.textContent = '\u041f\u043e\u0432\u0442\u043e\u0440\u0438\u0442\u044c';
            retry.addEventListener('click', updatePreview);
            preview.append(retry);
            preview.removeAttribute('aria-busy');
          });
      }
      selectionBoxes.forEach(function (box) { box.addEventListener('change', updatePreview); });
      if (selectAll) selectAll.addEventListener('change', function () { selectionBoxes.forEach(function (box) { box.checked = selectAll.checked; }); updatePreview(); });
      document.querySelectorAll('.woocommerce-cart-form input.qty, .woocommerce-cart-form input.cart-qty-input').forEach(function (input) {
        input.addEventListener('input', function () { quantityPending = true; updatePreview(); });
        input.addEventListener('change', function () { quantityPending = true; updatePreview(); });
      });
      updatePreview();
    }
  }

  function setupMobileCommerce() {
    var viewport = window.matchMedia('(max-width: 767px)');
    var checkout = document.querySelector('form.checkout');
    var injected = [];
    var autocomplete = {
      first_name: 'given-name', last_name: 'family-name', company: 'organization',
      country: 'country', address_1: 'address-line1', address_2: 'address-line2',
      city: 'address-level2', state: 'address-level1', postcode: 'postal-code',
      phone: 'tel', email: 'email'
    };
    function addAttribute(field, name, value) {
      if (field.hasAttribute(name)) return;
      field.setAttribute(name, value);
      injected.push({ field: field, name: name, value: value });
    }
    function syncMobileFields() {
      if (!viewport.matches) {
        injected.forEach(function (item) {
          if (item.field.getAttribute(item.name) === item.value) item.field.removeAttribute(item.name);
        });
        injected = [];
        return;
      }
      injected = injected.filter(function (item) { return item.field.isConnected; });
      if (checkout) {
        ['billing', 'shipping'].forEach(function (section) {
          Object.keys(autocomplete).forEach(function (key) {
            var field = checkout.querySelector('[name="' + section + '_' + key + '"]');
            if (!field || !field.matches('input:not([type="hidden"]), select, textarea')) return;
            addAttribute(field, 'autocomplete', section + ' ' + autocomplete[key]);
            if (key === 'phone' || key === 'email') addAttribute(field, 'inputmode', key === 'phone' ? 'tel' : 'email');
          });
        });
      }
      document.querySelectorAll('.cart-page .qty, .cart-page .cart-qty-input').forEach(function (field) {
        var step = field.getAttribute('step') || '1';
        addAttribute(field, 'inputmode', step === 'any' || step.indexOf('.') !== -1 ? 'decimal' : 'numeric');
      });
    }
    function focusCheckoutError() {
      if (!viewport.matches || !checkout) return;
      requestAnimationFrame(function () {
        if (!viewport.matches) return;
        var target;
        checkout.querySelectorAll('.woocommerce-error li').forEach(function (item) {
          if (target) return;
          var link = item.querySelector('a[href*="#"]');
          var id = item.getAttribute('data-id') || (link ? link.getAttribute('href').split('#').pop() : '');
          var field = id && document.getElementById(id);
          if (field && checkout.contains(field) && !field.disabled && field.getClientRects().length && field.matches('input, select, textarea')) target = field;
        });
        if (!target) target = Array.from(checkout.querySelectorAll('.woocommerce-invalid input, .woocommerce-invalid select, [aria-invalid="true"]')).find(function (field) {
          return !field.disabled && field.getClientRects().length;
        });
        if (!target) {
          target = checkout.querySelector('.woocommerce-error');
          if (target) addAttribute(target, 'tabindex', '-1');
        }
        if (target) {
          target.scrollIntoView({ block: 'center', behavior: 'auto' });
          target.focus({ preventScroll: true });
        }
      });
    }
    viewport.addEventListener('change', syncMobileFields);
    if (window.jQuery) {
      window.jQuery(document.body).on('updated_checkout updated_wc_div', syncMobileFields);
      window.jQuery(document.body).on('checkout_error', focusCheckoutError);
    }
    syncMobileFields();
  }

  function setupMobileCatalogIntro() {
    var description = document.querySelector('.catalog-heading .catalog-heading-desc');
    var panel = document.querySelector('.catalog-main .catalog-results-panel');
    if (!description || !panel || !description.textContent.trim() || panel.querySelector('.catalog-results-context')) return;
    var mobile = window.matchMedia('(max-width: 767px)');
    var anchor = null;
    var details = null;
    function syncIntro() {
      if (mobile.matches && !details) {
        anchor = document.createComment('catalog introduction');
        description.before(anchor);
        details = document.createElement('details');
        details.className = 'dv-mobile-catalog-intro';
        var summary = document.createElement('summary');
        summary.textContent = '\u041e \u0440\u0430\u0437\u0434\u0435\u043b\u0435';
        details.append(summary, description);
        panel.append(details);
      } else if (!mobile.matches && details) {
        anchor.replaceWith(description);
        details.remove();
        anchor = null;
        details = null;
      }
    }
    mobile.addEventListener('change', syncIntro);
    syncIntro();
  }

  function setupMobileCatalogReturn() {
    if (!document.querySelector('.catalog-main')) return;
    var viewport = window.matchMedia('(max-width: 767px)');
    var storageKey = 'dvMobileCatalogReturn';
    function readPositions() {
      try {
        var positions = JSON.parse(sessionStorage.getItem(storageKey) || '{}');
        return positions && typeof positions === 'object' && !Array.isArray(positions) ? positions : {};
      } catch (error) { return {}; }
    }
    function savePosition() {
      if (!viewport.matches) return;
      try {
        var state = history.state;
        if (state !== null && (typeof state !== 'object' || Array.isArray(state))) return;
        var key = state && state.dvMobileCatalogEntry;
        if (typeof key !== 'string' || !/^[a-z0-9]{8,64}$/.test(key)) {
          key = Date.now().toString(36) + Math.random().toString(36).slice(2);
          history.replaceState(Object.assign({}, state, {dvMobileCatalogEntry: key}), '');
        }
        var positions = readPositions();
        positions[key] = {y: window.scrollY, at: Date.now()};
        Object.keys(positions).sort(function(a, b) { return positions[b].at - positions[a].at; }).slice(20).forEach(function(old) { delete positions[old]; });
        sessionStorage.setItem(storageKey, JSON.stringify(positions));
      } catch (error) {}
    }
    function restorePosition(event) {
      if (!viewport.matches || (event && event.persisted)) return;
      var navigation = performance.getEntriesByType('navigation')[0];
      if (!navigation || navigation.type !== 'back_forward') return;
      var key = history.state && history.state.dvMobileCatalogEntry;
      if (typeof key !== 'string' || !/^[a-z0-9]{8,64}$/.test(key)) return;
      var position = readPositions()[key];
      if (!position || !Number.isFinite(position.y) || position.y <= 0 || !Number.isFinite(position.at) || Date.now() - position.at > 30 * 60 * 1000) return;
      // Let native history/BFCache restoration win; only replace a lost position.
      requestAnimationFrame(function() {
        requestAnimationFrame(function() {
          if (viewport.matches && window.scrollY <= 1) window.scrollTo(0, Math.min(position.y, document.documentElement.scrollHeight - window.innerHeight));
        });
      });
    }
    document.addEventListener('click', function(event) {
      var link = event.target.closest('.catalog-main .dv-card-img-link, .catalog-main .dv-card-name');
      if (link && event.button === 0 && !event.ctrlKey && !event.metaKey && !event.shiftKey && !event.altKey) savePosition();
    }, true);
    window.addEventListener('pagehide', savePosition);
    window.addEventListener('pageshow', restorePosition);
  }

  function setupMobileFilterDraft(sidebar, dialog) {
    var mobile = window.matchMedia('(max-width: 767px)');
    var selector = '.js-filter-marka, .js-filter-stock, #price-min, #price-max';
    var snapshot = null;
    var actions = null;
    var resetAll = false;
    function restore() {
      if (!snapshot) return;
      snapshot.forEach(function(item) {
        item.field.value = item.value;
        item.field.checked = item.checked;
        item.field.setCustomValidity('');
        var row = item.field.closest('.filter-item, .filter-check');
        if (row) row.classList.toggle(item.field.matches('.js-filter-marka') ? 'is-selected' : 'is-active', item.checked);
      });
      snapshot = null;
    }
    function close() {
      restore();
      if (actions) actions.remove();
      actions = null;
      dialog.classList.remove('dv-filter-draft');
    }
    function apply() {
      var min = sidebar.querySelector('#price-min');
      var max = sidebar.querySelector('#price-max');
      if (max) max.setCustomValidity('');
      if (min && max && min.value && max.value && Number(min.value) > Number(max.value)) max.setCustomValidity('Цена до должна быть не меньше цены от.');
      var invalid = Array.from(sidebar.querySelectorAll(selector)).find(function(field) { return !field.checkValidity(); });
      if (invalid) { invalid.reportValidity(); return; }
      var url = new URL(window.location.href);
      var brands = sidebar.querySelectorAll('.js-filter-marka');
      if (brands.length) {
        var selected = resetAll ? [] : (url.searchParams.get('marka') || '').split(',').filter(Boolean);
        brands.forEach(function(field) {
          selected = selected.filter(function(value) { return value !== field.value; });
          if (field.checked) selected.push(field.value);
        });
        if (selected.length) url.searchParams.set('marka', selected.join(','));
        else url.searchParams.delete('marka');
      }
      var stock = sidebar.querySelector('.js-filter-stock');
      if (stock) {
        if (stock.checked) url.searchParams.set('stock', 'instock');
        else url.searchParams.delete('stock');
      }
      [[min, 'min_price'], [max, 'max_price']].forEach(function(pair) {
        if (!pair[0]) return;
        if (pair[0].value) url.searchParams.set(pair[1], pair[0].value);
        else url.searchParams.delete(pair[1]);
      });
      url.searchParams.delete('paged');
      url.pathname = url.pathname.replace(/\/page\/\d+\/?$/, '/');
      window.location.href = url.toString();
    }
    function open() {
      if (!mobile.matches) return;
      snapshot = Array.from(sidebar.querySelectorAll(selector)).map(function(field) { return {field: field, value: field.value, checked: field.checked}; });
      resetAll = false;
      actions = document.createElement('footer');
      actions.className = 'dv-filter-actions';
      actions.innerHTML = '<button type="button" data-dv-filter-reset>Сбросить</button><button type="button" data-dv-filter-apply>Применить</button>';
      actions.querySelector('[data-dv-filter-apply]').addEventListener('click', apply);
      actions.querySelector('[data-dv-filter-reset]').addEventListener('click', function() {
        resetAll = true;
        snapshot.forEach(function(item) {
          if (item.field.type === 'checkbox') item.field.checked = false;
          else item.field.value = '';
          item.field.setCustomValidity('');
          var row = item.field.closest('.filter-item, .filter-check');
          if (row) row.classList.remove('is-selected', 'is-active');
        });
      });
      dialog.append(actions);
      dialog.classList.add('dv-filter-draft');
    }
    sidebar.addEventListener('change', function(event) {
      if (mobile.matches && snapshot && event.target.matches('.js-filter-stock')) event.stopPropagation();
    }, true);
    sidebar.addEventListener('input', function(event) {
      if (mobile.matches && snapshot && event.target.matches('#price-min, #price-max')) {
        var max = sidebar.querySelector('#price-max');
        if (max) max.setCustomValidity('');
      }
    });
    sidebar.addEventListener('click', function(event) {
      if (!mobile.matches || !snapshot || !event.target.closest('.js-filter-price, .js-filter-marka-apply')) return;
      event.preventDefault(); event.stopPropagation(); apply();
    }, true);
    sidebar.addEventListener('keydown', function(event) {
      if (mobile.matches && snapshot && event.key === 'Enter' && event.target.matches('#price-min, #price-max')) {
        event.preventDefault(); event.stopPropagation(); apply();
      }
    }, true);
    mobile.addEventListener('change', function() {
      if (!mobile.matches && snapshot) { dialog.close(); close(); }
    });
    return {open: open, close: close};
  }

  function setupMobileFooter() {
    var footer = document.querySelector('.site-footer');
    if (!footer) return;
    var mobile = window.matchMedia('(max-width: 767px)');
    var groups = [];
    var description = footer.querySelector('.footer-desc');
    var originalDescription = description ? description.textContent : '';
    function sync() {
      if (mobile.matches && !groups.length) {
        footer.querySelectorAll('.footer-catalog, .footer-customers, .footer-company').forEach(function(group, index) {
          var title = group.querySelector('.footer-col-title');
          var links = group.querySelector('.footer-links');
          if (!title || !links || !links.querySelector('a')) return;
          var original = document.createDocumentFragment();
          var label = title.textContent;
          while (title.firstChild) original.append(title.firstChild);
          var button = document.createElement('button');
          button.type = 'button';
          button.className = 'dv-footer-toggle';
          button.textContent = label;
          var id = links.id;
          var hidden = links.hidden;
          if (!id) links.id = 'dv-footer-links-' + index;
          button.setAttribute('aria-controls', links.id);
          button.setAttribute('aria-expanded', 'false');
          links.hidden = true;
          button.addEventListener('click', function() {
            var expanded = button.getAttribute('aria-expanded') !== 'true';
            button.setAttribute('aria-expanded', String(expanded));
            links.hidden = !expanded;
          });
          title.append(button);
          groups.push({title: title, original: original, button: button, links: links, id: id, hidden: hidden});
        });
        footer.classList.add('dv-footer-compact');
        if (description) {
          var standardDescription = originalDescription.match(/^Интернет-магазин автозапчастей в (.+?) с доставкой по России\./);
          if (standardDescription) description.textContent = 'Автозапчасти · ' + standardDescription[1] + ' · Доставка по России';
        }
      } else if (!mobile.matches) {
        groups.forEach(function(item) {
          if (item.title.contains(document.activeElement) || item.links.contains(document.activeElement)) document.activeElement.blur();
          item.button.remove(); item.title.append(item.original);
          item.links.hidden = item.hidden;
          if (!item.id) item.links.removeAttribute('id');
        });
        groups = [];
        footer.classList.remove('dv-footer-compact');
        if (description && description.textContent !== originalDescription) description.textContent = originalDescription;
      }
    }
    mobile.addEventListener('change', sync);
    sync();
  }

  function setupMobileProductQuantity() {
    var panel = document.querySelector('.product-purchase-panel');
    if (!panel) return;
    var inputs = panel.querySelectorAll('form.cart input.qty');
    if (inputs.length !== 1) return;
    var input = inputs[0];
    var quantity = input.closest('.quantity');
    if (!quantity || input.type !== 'number' || quantity.querySelector('button')) return;
    var mobile = window.matchMedia('(max-width: 767px)');
    var minus = null, plus = null;
    function update() {
      if (!minus) return;
      var value = Number(input.value);
      minus.disabled = input.disabled || input.readOnly || (input.min !== '' && value <= Number(input.min));
      plus.disabled = input.disabled || input.readOnly || (input.max !== '' && value >= Number(input.max));
    }
    function makeButton(direction, label) {
      var button = document.createElement('button');
      button.type = 'button'; button.className = 'dv-product-qty-step';
      button.textContent = direction < 0 ? '\u2212' : '+';
      button.setAttribute('aria-label', label);
      button.addEventListener('click', function() {
        if (input.disabled || input.readOnly) return;
        try { if (direction < 0) input.stepDown(); else input.stepUp(); } catch (error) { return; }
        input.dispatchEvent(new Event('input', {bubbles: true}));
        input.dispatchEvent(new Event('change', {bubbles: true}));
        update();
      });
      return button;
    }
    function sync() {
      if (mobile.matches && !minus) {
        minus = makeButton(-1, 'Уменьшить количество'); plus = makeButton(1, 'Увеличить количество');
        quantity.prepend(minus); quantity.append(plus); quantity.classList.add('dv-product-qty'); update();
      } else if (!mobile.matches && minus) {
        minus.remove(); plus.remove(); minus = null; plus = null; quantity.classList.remove('dv-product-qty');
      }
    }
    input.addEventListener('input', update); input.addEventListener('change', update);
    new MutationObserver(update).observe(input, {attributes: true, attributeFilter: ['min', 'max', 'step', 'disabled', 'readonly', 'value']});
    mobile.addEventListener('change', sync); sync();
  }

  function setupMobileCartControls() {
    if (!document.querySelector('.woocommerce-cart-form')) return;
    var mobile = window.matchMedia('(max-width: 767px)');
    var managed = new Map();
    var observedForm = null;
    var observer = new MutationObserver(function(entries) {
      if (entries.some(function(entry) { return entry.target.matches('input.qty, input.cart-qty-input'); })) sync();
    });
    function restore() {
      observer.disconnect(); observedForm = null;
      managed.forEach(function(state, button) {
        if (button.disabled === state.applied) button.disabled = state.original;
      });
      managed.clear();
    }
    function sync() {
      if (!mobile.matches) { restore(); return; }
      var currentForm = document.querySelector('.woocommerce-cart-form');
      if (currentForm !== observedForm) {
        observer.disconnect(); observedForm = currentForm;
        if (currentForm) observer.observe(currentForm, {subtree: true, attributes: true, attributeFilter: ['min', 'max', 'step', 'readonly', 'disabled', 'value']});
      }
      managed.forEach(function(state, button) { if (!button.isConnected) managed.delete(button); });
      document.querySelectorAll('.woocommerce-cart-form .cart-qty-wrap').forEach(function(wrap) {
        var input = wrap.querySelector('input.qty, input.cart-qty-input');
        if (!input || input.type !== 'number' || input.step === 'any') return;
        wrap.querySelectorAll('.cart-qty-btn[data-delta]').forEach(function(button) {
          var state = managed.get(button);
          if (!state) { state = {original: button.disabled, applied: button.disabled}; managed.set(button, state); }
          else if (button.disabled !== state.applied) state.original = button.disabled;
          var down = Number(button.dataset.delta) < 0;
          var limit = down ? input.min : input.max;
          var blocked = limit !== '' && input.value !== '' && (down ? Number(input.value) <= Number(limit) : Number(input.value) >= Number(limit));
          state.applied = state.original || input.disabled || input.readOnly || blocked;
          button.disabled = state.applied;
        });
      });
    }
    document.addEventListener('click', function(event) {
      if (!mobile.matches) return;
      var button = event.target.closest('.woocommerce-cart-form .cart-qty-btn[data-delta]');
      if (!button) return;
      var input = button.closest('.cart-qty-wrap').querySelector('input.qty, input.cart-qty-input');
      if (!input || input.type !== 'number' || input.step === 'any') return;
      event.preventDefault(); event.stopPropagation();
      if (button.disabled || input.disabled || input.readOnly) return;
      var previous = input.value;
      try { if (Number(button.dataset.delta) < 0) input.stepDown(); else input.stepUp(); } catch (error) { return; }
      if (input.value !== previous) {
        input.dispatchEvent(new Event('input', {bubbles: true}));
        input.dispatchEvent(new Event('change', {bubbles: true}));
      }
      sync();
    }, true);
    document.addEventListener('input', function(event) { if (event.target.matches('.woocommerce-cart-form input.qty, .woocommerce-cart-form input.cart-qty-input')) sync(); });
    document.addEventListener('change', function(event) { if (event.target.matches('.woocommerce-cart-form input.qty, .woocommerce-cart-form input.cart-qty-input')) sync(); });
    if (window.jQuery) window.jQuery(document.body).on('updated_wc_div updated_cart_totals', sync);
    mobile.addEventListener('change', sync); sync();
  }

  function setupMobilePickupDetails(fulfilment, source) {
    var mobile = window.matchMedia('(max-width: 767px)');
    var details = null;
    var signature = '';
    function sync() {
      var mode = fulfilment.querySelector('[name="dv_fulfilment"]:checked');
      var select = fulfilment.querySelector('[name="dv_pickup_key"]');
      var option = select && select.options[select.selectedIndex];
      var valid = mobile.matches && mode && mode.value === 'pickup' && option && option.value;
      var nextSignature = valid ? JSON.stringify([option.value, option.textContent, option.dataset.hours, option.dataset.phone]) : '';
      if (nextSignature && nextSignature === signature && details && details.isConnected) return;
      if (details) details.remove();
      details = null; signature = ''; source.classList.remove('dv-pickup-details-source');
      if (!valid) return;
      signature = nextSignature;
      details = document.createElement('div');
      details.className = 'dv-mobile-pickup-details';
      details.setAttribute('role', 'group');
      details.setAttribute('aria-label', 'Выбранный пункт самовывоза');
      var address = document.createElement('p');
      address.className = 'dv-pickup-address'; address.textContent = option.textContent.trim(); details.append(address);
      if (option.dataset.hours) {
        var hours = document.createElement('p'); hours.textContent = 'График работы: ' + option.dataset.hours; details.append(hours);
      }
      if (option.dataset.phone) {
        var phone = option.dataset.phone.trim();
        var contact = document.createElement(/^\+?[\d\s()\-]+$/.test(phone) ? 'a' : 'p');
        contact.textContent = phone;
        if (contact.tagName === 'A') { contact.href = 'tel:' + phone.replace(/[^\d+]/g, ''); contact.setAttribute('aria-label', 'Позвонить в пункт самовывоза: ' + phone); }
        details.append(contact);
      }
      source.classList.add('dv-pickup-details-source'); source.after(details);
    }
    fulfilment.addEventListener('change', sync);
    mobile.addEventListener('change', sync);
    if (window.jQuery) window.jQuery(document.body).on('updated_checkout', sync);
    sync();
  }

  function init() {
    setupMobileCartControls();
    setupMobileProductQuantity();
    setupMobileFooter();
    setupMobileCatalogReturn();
    setupMobileCatalogIntro();
    setupMobileCommerce();
    var mobileNav = document.querySelector('.dv-mobile-nav');
    if (mobileNav) {
      function syncMobileCounts() {
        mobileNav.querySelectorAll('[data-dv-mobile-count]').forEach(function (badge) {
          var source = document.getElementById('dv-' + badge.dataset.dvMobileCount + '-badge');
          var count = source ? Math.max(0, parseInt(source.textContent, 10) || 0) : 0;
          badge.textContent = count > 99 ? '99+' : String(count);
          badge.hidden = !count;
          var link = badge.closest('a');
          link.setAttribute('aria-label', link.lastElementChild.textContent + (count ? ': ' + count : ''));
        });
      }
      var headerIcons = document.querySelector('.header-icons');
      if (headerIcons) new MutationObserver(syncMobileCounts).observe(headerIcons, { childList: true, subtree: true, characterData: true });
      syncMobileCounts();
      // Do not put fixed controls over the on-screen keyboard or focused fields.
      function syncKeyboard() {
        var field = document.activeElement;
        var editing = field && field.matches('input:not([type="checkbox"]):not([type="radio"]):not([type="button"]):not([type="submit"]), textarea, select, [contenteditable="true"]');
        document.body.classList.toggle('dv-mobile-editing', Boolean(editing));
      }
      document.addEventListener('focusin', syncKeyboard);
      document.addEventListener('focusout', function () { requestAnimationFrame(syncKeyboard); });
      if (window.visualViewport) window.visualViewport.addEventListener('resize', syncKeyboard);
    }
    var pinOnDesktop = document.body.matches('.single-product, .woocommerce-shop, .post-type-archive-product, .tax-product_cat, .tax-product_tag');
    if (mobileNav || pinOnDesktop) {
      var siteHeader = document.getElementById('site-header');
      var mainHeader = siteHeader && siteHeader.querySelector('.header-main');
      if (mainHeader) {
        var headerPlaceholder = document.createElement('div');
        headerPlaceholder.className = 'dv-header-main-placeholder';
        headerPlaceholder.hidden = true;
        mainHeader.before(headerPlaceholder);
        var expandedHeaderHeight = mainHeader.offsetHeight;
        var headerViewportWidth = window.innerWidth;
        var headerTick = false;
        function syncPinnedHeader() {
          headerTick = false;
          var pinEnabled = pinOnDesktop || window.matchMedia('(max-width: 767px)').matches;
          siteHeader.classList.toggle('dv-product-sticky-header', pinEnabled);
          var adminBar = document.getElementById('wpadminbar');
          var offset = adminBar ? Math.max(0, adminBar.getBoundingClientRect().bottom) : 0;
          var anchor = headerPlaceholder.hidden ? mainHeader : headerPlaceholder;
          var pinned = pinEnabled && anchor.getBoundingClientRect().top < offset;
          // Reserve the full header even when its fixed version is compact.
          if (headerViewportWidth !== window.innerWidth) {
            mainHeader.classList.remove('is-dv-pinned');
            expandedHeaderHeight = mainHeader.offsetHeight;
            headerViewportWidth = window.innerWidth;
          }
          if (!pinned) expandedHeaderHeight = mainHeader.offsetHeight;
          headerPlaceholder.style.height = expandedHeaderHeight + 'px';
          mainHeader.style.setProperty('--dv-header-pinned-offset', offset + 'px');
          mainHeader.classList.toggle('is-dv-pinned', pinned);
          headerPlaceholder.hidden = !pinned;
        }
        function queuePinnedHeader() {
          if (!headerTick) { headerTick = true; requestAnimationFrame(syncPinnedHeader); }
        }
        window.addEventListener('scroll', queuePinnedHeader, {passive: true});
        window.addEventListener('resize', queuePinnedHeader);
        if (window.ResizeObserver) new ResizeObserver(queuePinnedHeader).observe(mainHeader);
        syncPinnedHeader();
      }
    }
    setupCartSelection();
    if (window.jQuery) window.jQuery(document.body).on('updated_wc_div', setupCartSelection);
    document.querySelectorAll('[data-dv-brand-more]').forEach(function (button) {
      var widget = button.closest('.filter-widget');
      var extra = Array.from(widget.querySelectorAll('[data-dv-extra-brand]'));
      if (!extra.length) return;
      function hasSelection() {
        return !!widget.querySelector('.js-filter-marka:checked');
      }
      function setExpanded(open) {
        button.setAttribute('aria-expanded', String(open));
        button.textContent = open ? '\u0421\u043a\u0440\u044b\u0442\u044c' : '\u0412\u0441\u0435 \u043c\u0430\u0440\u043a\u0438';
        extra.forEach(function (item) { item.hidden = !open; });
      }
      setExpanded(hasSelection());
      button.hidden = hasSelection();
      widget.addEventListener('change', function (event) {
        if (!event.target.matches('.js-filter-marka')) return;
        var selected = hasSelection();
        if (selected) setExpanded(true);
        button.hidden = selected;
      });
      button.addEventListener('click', function () {
        setExpanded(hasSelection() || button.getAttribute('aria-expanded') !== 'true');
      });
    });
    var checkout = document.querySelector('form.checkout');
    if (checkout) {
      var fulfilment = checkout.querySelector('[data-dv-fulfilment]');
      if (fulfilment) {
        var pickupSelect = fulfilment.querySelector('[name="dv_pickup_key"]');
        var pickupFields = fulfilment.querySelector('[data-dv-pickup-fields]');
        var pickupDetails = fulfilment.querySelector('[data-dv-pickup-details]');
        var customerDetails = checkout.querySelector('#customer_details');
        var customerSection = customerDetails && customerDetails.closest('.checkout-section');
        var customerTitle = customerSection && customerSection.querySelector('.checkout-section-title');
        var otherTitle = checkout.querySelector('#ship-to-different-address');
        otherTitle = otherTitle && otherTitle.closest('.checkout-section') ? otherTitle.closest('.checkout-section').querySelector('.checkout-section-title') : null;
        var pickupTitles = [
          {element: customerTitle, label: '\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u043d\u044b\u0435 \u0434\u0430\u043d\u043d\u044b\u0435'},
          {element: otherTitle, label: '\u041a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439 \u043a \u0437\u0430\u043a\u0430\u0437\u0443'}
        ].map(function (item) {
          var node = item.element && Array.from(item.element.childNodes).find(function (child) { return child.nodeType === Node.TEXT_NODE && child.textContent.trim(); });
          return node ? {node: node, original: node.nodeValue, label: item.label} : null;
        }).filter(Boolean);
        var addressFields = ['billing_country', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode'];
        function syncFulfilment(updateTotals) {
          var mode = fulfilment.querySelector('[name="dv_fulfilment"]:checked');
          var pickup = mode && mode.value === 'pickup';
          pickupTitles.forEach(function (item) { item.node.nodeValue = pickup ? ' ' + item.label : item.original; });
          checkout.classList.toggle('is-dv-pickup', Boolean(pickup));
          pickupFields.hidden = !pickup;
          pickupSelect.required = Boolean(pickup);
          var option = pickupSelect.options[pickupSelect.selectedIndex];
          pickupDetails.textContent = option ? [option.dataset.hours, option.dataset.phone].filter(Boolean).join(' · ') : '';
          addressFields.forEach(function (name) {
            var field = checkout.querySelector('[name="' + name + '"]');
            var row = field && field.closest('.form-row');
            if (!row) return;
            if (!row.hasAttribute('data-dv-was-required')) row.dataset.dvWasRequired = field.dataset.dvDeliveryRequired || (row.classList.contains('validate-required') ? '1' : '0');
            row.hidden = Boolean(pickup);
            var required = !pickup && row.dataset.dvWasRequired === '1';
            row.classList.toggle('validate-required', required);
            field.required = required;
            field.setAttribute('aria-required', required ? 'true' : 'false');
          });
          var otherAddress = checkout.querySelector('#ship-to-different-address');
          if (otherAddress) {
            otherAddress.hidden = Boolean(pickup);
            var checkbox = otherAddress.querySelector('input');
            if (pickup && checkbox && checkbox.checked) {
              checkbox.checked = false;
              if (window.jQuery) window.jQuery(checkbox).trigger('change');
            }
          }
          if (updateTotals && window.jQuery) window.jQuery(document.body).trigger('update_checkout');
        }
        fulfilment.addEventListener('change', function () { syncFulfilment(true); });
        if (window.jQuery) window.jQuery(document.body).on('updated_checkout', function () { syncFulfilment(false); });
        syncFulfilment(false);
        if (pickupDetails) setupMobilePickupDetails(fulfilment, pickupDetails);
      }
      function cleanBillingPrefix(text) {
        return (text || '').replace(/^\s*\u0412\u044b\u0441\u0442\u0430\u0432\u043b\u0435\u043d\u0438\u0435 \u0441\u0447[\u0435\u0451]\u0442\u0430\s+/i, '');
      }
      function syncFieldErrors() {
        var activeFields = [];
        checkout.querySelectorAll('ul.woocommerce-error').forEach(function (list) {
          var fieldCount = 0;
          var termsCount = 0;
          Array.from(list.querySelectorAll(':scope > li:not([data-dv-validation-summary])')).forEach(function (item) {
            var link = item.querySelector('a[href*="#"]');
            var id = item.getAttribute('data-id') || (link ? link.getAttribute('href').split('#').pop() : '');
            var field = id ? document.getElementById(id) : null;
            var row = field && checkout.contains(field) ? field.closest('.form-row') : null;
            var message = cleanBillingPrefix(item.textContent).replace(/\s+/g, ' ').trim();
            var terms = id === 'terms' || /\u043f\u0440\u0430\u0432\u0438\u043b\u0430.*\u0443\u0441\u043b\u043e\u0432\u0438.*\u0441\u043e\u0433\u043b\u0430\u0441|terms.*conditions/i.test(message);
            if (row && !terms && field.matches('input, select, textarea')) {
              var inline = Array.from(row.querySelectorAll('p, span, div')).find(function (node) {
                return !node.contains(field) && !node.closest('label') && cleanBillingPrefix(node.textContent).replace(/\s+/g, ' ').trim() === message;
              });
              if (!inline) {
                inline = Array.from(row.querySelectorAll('[data-dv-field-error]')).find(function (node) { return node.getAttribute('data-dv-field-error') === field.id; });
                if (inline && inline.textContent !== message) inline.textContent = message;
              }
              if (!inline) {
                inline = document.createElement('span');
                inline.className = 'dv-checkout-field-error';
                inline.id = field.id + '-dv-error';
                inline.setAttribute('data-dv-field-error', field.id);
                inline.textContent = message;
                row.append(inline);
                var descriptions = (field.getAttribute('aria-describedby') || '').split(/\s+/).filter(Boolean);
                if (descriptions.indexOf(inline.id) === -1) descriptions.push(inline.id);
                field.setAttribute('aria-describedby', descriptions.join(' '));
              } else {
                var walker = document.createTreeWalker(inline, NodeFilter.SHOW_TEXT);
                while (walker.nextNode()) {
                  var cleaned = cleanBillingPrefix(walker.currentNode.nodeValue);
                  if (cleaned !== walker.currentNode.nodeValue) walker.currentNode.nodeValue = cleaned;
                }
              }
              if (inline.hasAttribute('data-dv-field-error')) activeFields.push(field.id);
              item.hidden = true;
              item.setAttribute('data-dv-condensed-error', 'true');
              fieldCount++;
            } else if (terms) {
              item.hidden = true;
              item.setAttribute('data-dv-condensed-error', 'true');
              termsCount++;
            } else if (item.hasAttribute('data-dv-condensed-error')) {
              item.hidden = false;
              item.removeAttribute('data-dv-condensed-error');
            }
          });
          var summary = list.querySelector('[data-dv-validation-summary]');
          if (fieldCount || termsCount) {
            if (!summary) {
              summary = document.createElement('li');
              summary.setAttribute('data-dv-validation-summary', 'true');
              list.prepend(summary);
            }
            summary.textContent = fieldCount
              ? (termsCount ? '\u0417\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435 \u043e\u0431\u044f\u0437\u0430\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u043e\u043b\u044f \u0438 \u043f\u043e\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0435 \u0441\u043e\u0433\u043b\u0430\u0441\u0438\u0435.' : '\u041f\u0440\u043e\u0432\u0435\u0440\u044c\u0442\u0435 \u043f\u043e\u043b\u044f, \u043e\u0442\u043c\u0435\u0447\u0435\u043d\u043d\u044b\u0435 \u043e\u0448\u0438\u0431\u043a\u043e\u0439.')
              : '\u041f\u0440\u043e\u0447\u0438\u0442\u0430\u0439\u0442\u0435 \u043f\u0440\u0430\u0432\u0438\u043b\u0430 \u0438 \u0443\u0441\u043b\u043e\u0432\u0438\u044f \u0438 \u043f\u043e\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u0435 \u0441\u043e\u0433\u043b\u0430\u0441\u0438\u0435.';
          } else if (summary) summary.remove();
        });
        checkout.querySelectorAll('[data-dv-field-error]').forEach(function (node) {
          var id = node.getAttribute('data-dv-field-error');
          if (activeFields.indexOf(id) !== -1) return;
          var field = document.getElementById(id);
          if (field) field.setAttribute('aria-describedby', (field.getAttribute('aria-describedby') || '').split(/\s+/).filter(function (value) { return value && value !== node.id; }).join(' '));
          node.remove();
        });
      }
      function syncDuplicateTermsError() {
        function normalize(text) { return (text || '').replace(/\s+/g, ' ').trim(); }
        var notices = Array.from(checkout.querySelectorAll('.woocommerce-error li')).filter(function (item) {
          return item.getAttribute('data-id') === 'terms' || item.querySelector('a[href="#terms"]') || /\u043f\u0440\u0430\u0432\u0438\u043b\u0430.*\u0443\u0441\u043b\u043e\u0432\u0438.*\u0441\u043e\u0433\u043b\u0430\u0441|terms.*conditions/i.test(item.textContent);
        }).map(function (item) { return normalize(item.textContent); });
        var payment = checkout.querySelector('#payment .place-order');
        if (!payment) return;
        payment.querySelectorAll('p, span, div').forEach(function (item) {
          if (item.closest('label, .woocommerce-privacy-policy-text, ul.woocommerce-error') || item.querySelector('input, button, select, textarea, p, div')) return;
          var text = normalize(item.textContent);
          var duplicate = text && notices.indexOf(text) !== -1;
          if (duplicate && !item.hidden) {
            item.hidden = true;
            item.setAttribute('data-dv-duplicate-error', 'true');
          } else if (!duplicate && item.hasAttribute('data-dv-duplicate-error')) {
            item.hidden = false;
            item.removeAttribute('data-dv-duplicate-error');
          }
        });
      }
      var errorObserver = new MutationObserver(function () {
        errorObserver.disconnect();
        syncFieldErrors();
        syncDuplicateTermsError();
        errorObserver.observe(checkout, { childList: true, subtree: true, characterData: true });
      });
      syncFieldErrors();
      syncDuplicateTermsError();
      errorObserver.observe(checkout, { childList: true, subtree: true, characterData: true });
    }
    var mobile = window.matchMedia('(max-width: 767px)');
    var compactCatalog = window.matchMedia('(max-width: 1023px)');
    if (typeof HTMLDialogElement !== 'undefined' && HTMLDialogElement.prototype.showModal) {
      var zoomDialog = document.createElement('dialog');
      zoomDialog.className = 'dv-card-zoom-dialog';
      zoomDialog.setAttribute('aria-label', '\u0424\u043e\u0442\u043e \u0442\u043e\u0432\u0430\u0440\u0430');
      zoomDialog.innerHTML = '<button type="button" aria-label="\u0417\u0430\u043a\u0440\u044b\u0442\u044c">&times;</button><img alt="">';
      document.body.append(zoomDialog);
      var zoomImage = zoomDialog.querySelector('img');
      document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-dv-card-zoom]');
        if (!trigger || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        zoomImage.src = trigger.href;
        var card = trigger.closest('.dv-card');
        var name = card && card.querySelector('.dv-card-name');
        zoomImage.alt = name ? name.textContent.trim() : '';
        zoomDialog.showModal();
        document.body.classList.add('dv-card-zoom-open');
      });
      zoomDialog.querySelector('button').addEventListener('click', function () { zoomDialog.close(); });
      zoomDialog.addEventListener('click', function (event) {
        if (event.target !== zoomDialog) return;
        var rect = zoomDialog.getBoundingClientRect();
        if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) zoomDialog.close();
      });
      zoomDialog.addEventListener('close', function () {
        document.body.classList.remove('dv-card-zoom-open');
        zoomImage.removeAttribute('src');
      });
    }
    var categoryOpener = document.querySelector('.nav-cats-dropdown .all-cats');
    var categoryPanel = document.querySelector('.nav-cats-panel');
    if (categoryOpener && categoryPanel && typeof HTMLDialogElement !== 'undefined' && HTMLDialogElement.prototype.showModal) {
      var categoryAnchor = document.createComment('header categories');
      categoryPanel.before(categoryAnchor);
      var categoryDialog = document.createElement('dialog');
      categoryDialog.id = 'dv-mobile-categories';
      categoryDialog.className = 'catalog-filter-dialog category-menu-dialog';
      categoryDialog.setAttribute('aria-labelledby', 'dv-mobile-categories-title');
      categoryDialog.innerHTML = '<header><h2 id="dv-mobile-categories-title">\u0412\u0441\u0435 \u043a\u0430\u0442\u0435\u0433\u043e\u0440\u0438\u0438</h2><button type="button" aria-label="\u0417\u0430\u043a\u0440\u044b\u0442\u044c">&times;</button></header>';
      document.body.append(categoryDialog);
      var categoryBranches = [];
      var categoryReturnFocus = categoryOpener;
      categoryPanel.querySelectorAll('.dv-cat-tree-item.has-children').forEach(function (item, index) {
        var link = item.querySelector(':scope > .dv-cat-tree-link');
        var children = item.querySelector(':scope > .dv-cat-tree');
        if (!link || !children) return;
        var toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'category-branch-toggle';
        toggle.setAttribute('aria-label', '\u041f\u043e\u0434\u043a\u0430\u0442\u0435\u0433\u043e\u0440\u0438\u0438: ' + (link.querySelector('.dv-cat-tree-name') || link).textContent.trim());
        children.id = children.id || 'dv-mobile-category-branch-' + index;
        toggle.setAttribute('aria-controls', children.id);
        link.after(toggle);
        var branch = { children: children, toggle: toggle, open: item.classList.contains('is-active') || Boolean(children.querySelector('.is-active')) };
        function updateBranch() {
          children.hidden = !branch.open;
          toggle.hidden = false;
          toggle.setAttribute('aria-expanded', branch.open ? 'true' : 'false');
          toggle.textContent = branch.open ? '\u2212' : '+';
        }
        toggle.addEventListener('click', function () {
          branch.open = !branch.open;
          updateBranch();
        });
        branch.sync = updateBranch;
        categoryBranches.push(branch);
      });
      function openCategories(event) {
        if (!compactCatalog.matches || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        event.preventDefault();
        categoryReturnFocus = event.currentTarget;
        categoryDialog.showModal();
        categoryOpener.setAttribute('aria-expanded', 'true');
        if (mobileCatalog) mobileCatalog.setAttribute('aria-expanded', 'true');
        document.body.classList.add('dv-categories-open');
      }
      categoryOpener.addEventListener('click', openCategories);
      var mobileCatalog = mobileNav && mobileNav.querySelector('[data-dv-mobile-destination="catalog"]');
      if (mobileCatalog) {
        mobileCatalog.setAttribute('aria-haspopup', 'dialog');
        mobileCatalog.setAttribute('aria-controls', categoryDialog.id);
        mobileCatalog.setAttribute('aria-expanded', 'false');
        mobileCatalog.addEventListener('click', openCategories);
      }
      categoryOpener.addEventListener('keydown', function (event) {
        if (compactCatalog.matches && event.key === ' ') {
          event.preventDefault();
          categoryOpener.click();
        }
      });
      categoryDialog.querySelector('button').addEventListener('click', function () { categoryDialog.close(); });
      categoryDialog.addEventListener('click', function (event) {
        if (event.target !== categoryDialog) return;
        var rect = categoryDialog.getBoundingClientRect();
        if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) categoryDialog.close();
      });
      categoryDialog.addEventListener('close', function () {
        document.body.classList.remove('dv-categories-open');
        if (mobileCatalog) mobileCatalog.setAttribute('aria-expanded', 'false');
        if (compactCatalog.matches) {
          categoryOpener.setAttribute('aria-expanded', 'false');
          categoryReturnFocus.focus();
        }
      });
      function syncCategories() {
        if (categoryDialog.open) categoryDialog.close();
        categoryBranches.forEach(function (branch) { branch.sync(); });
        if (compactCatalog.matches) {
          categoryDialog.append(categoryPanel);
          categoryOpener.setAttribute('role', 'button');
          categoryOpener.setAttribute('aria-haspopup', 'dialog');
          categoryOpener.setAttribute('aria-controls', categoryDialog.id);
          categoryOpener.setAttribute('aria-expanded', 'false');
        } else {
          categoryAnchor.after(categoryPanel);
          ['role', 'aria-haspopup', 'aria-controls', 'aria-expanded'].forEach(function (name) { categoryOpener.removeAttribute(name); });
        }
      }
      compactCatalog.addEventListener('change', syncCategories);
      syncCategories();
    }
    var sidebar = document.querySelector('.catalog-sidebar');
    var controls = document.querySelector('.catalog-mobile-controls');
    if (sidebar && controls && typeof HTMLDialogElement !== 'undefined' && HTMLDialogElement.prototype.showModal) {
      var controlsAnchor = document.createComment('catalog mobile controls');
      controls.before(controlsAnchor);
      var toolbar = document.querySelector('.catalog-toolbar');
      var anchor = document.createComment('catalog sidebar');
      sidebar.before(anchor);
      var dialog = document.createElement('dialog');
      dialog.id = 'dv-catalog-filters';
      dialog.className = 'catalog-filter-dialog';
      dialog.setAttribute('aria-labelledby', 'dv-catalog-filters-title');
      dialog.innerHTML = '<header><h2 id="dv-catalog-filters-title">\u0424\u0438\u043b\u044c\u0442\u0440\u044b</h2><button type="button" aria-label="\u0417\u0430\u043a\u0440\u044b\u0442\u044c">&times;</button></header>';
      document.body.append(dialog);
      var opener = controls.querySelector('button');
      var filterDraft = setupMobileFilterDraft(sidebar, dialog);
      function closeFilters() {
        dialog.close();
      }
      opener.addEventListener('click', function () {
        filterDraft.open();
        dialog.showModal();
        opener.setAttribute('aria-expanded', 'true');
        document.body.classList.add('dv-filters-open');
      });
      dialog.querySelector('button').addEventListener('click', closeFilters);
      dialog.addEventListener('click', function (event) {
        if (event.target !== dialog) return;
        var rect = dialog.getBoundingClientRect();
        if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) closeFilters();
      });
      dialog.addEventListener('close', function () {
        filterDraft.close();
        opener.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('dv-filters-open');
        if (compactCatalog.matches) opener.focus();
      });
      function syncFilters() {
        if (dialog.open) closeFilters();
        controls.hidden = !compactCatalog.matches;
        if (compactCatalog.matches && toolbar) toolbar.prepend(controls);
        else controlsAnchor.after(controls);
        if (compactCatalog.matches) dialog.append(sidebar);
        else anchor.after(sidebar);
      }
      compactCatalog.addEventListener('change', syncFilters);
      syncFilters();
    }

    var layout = document.querySelector('.product-layout');
    var title = layout && layout.querySelector('h1.product-title');
    if (title) {
      var titleAnchor = document.createComment('product title');
      title.before(titleAnchor);
      function syncTitle() {
        if (mobile.matches) layout.prepend(title);
        else titleAnchor.after(title);
      }
      mobile.addEventListener('change', syncTitle);
      syncTitle();
    }

    var panel = document.querySelector('.product-purchase-panel');
    var form = panel && panel.querySelector('form.cart');
    var purchaseButton = form && form.querySelector('.single_add_to_cart_button');
    if (!purchaseButton || !('IntersectionObserver' in window)) return;
    var bar = document.createElement('div');
    bar.className = 'product-mobile-purchase';
    bar.hidden = true;
    var price = document.createElement('span');
    price.className = 'product-mobile-price';
    var jump = document.createElement('button');
    jump.type = 'button';
    jump.textContent = '\u041a \u043f\u043e\u043a\u0443\u043f\u043a\u0435';
    bar.append(price, jump);
    document.body.append(bar);
    var formVisible = false;
    var footerVisible = false;
    var productType = panel.dataset.dvProductType || (form.classList.contains('variations_form') ? 'variable' : 'unknown');
    function isStandardPurchaseField(field) {
      if (!field.matches('input, select, textarea') || field.disabled) return true;
      if (field.name === 'quantity') return field.matches('input.qty[type="number"]');
      return field.type === 'hidden' && ['add-to-cart', 'product_id', 'variation_id', 'dv_buy_now', '_wpnonce', '_wp_http_referer'].indexOf(field.name) !== -1;
    }
    function canPurchaseDirectly() {
      return productType === 'simple' && Array.from(form.elements).every(isStandardPurchaseField);
    }
    function focusPurchaseForm() {
      form.scrollIntoView({ block: 'center', behavior: 'auto' });
      var control = Array.from(form.elements).find(function(field) {
        return !isStandardPurchaseField(field) && field.type !== 'hidden' && field.getClientRects().length;
      }) || form.querySelector('select, input.qty, .single_add_to_cart_button');
      if (control) control.focus({ preventScroll: true });
    }
    function syncBar() {
      var directPurchase = canPurchaseDirectly();
      var variationPrice = panel.querySelector('.woocommerce-variation-price .price');
      var source = variationPrice && variationPrice.textContent.trim() ? variationPrice : panel.querySelector('.price');
      var discounted = source && source.querySelector('ins');
      price.textContent = (discounted || source) ? (discounted || source).textContent.replace(/\s+/g, ' ').trim() : '';
      var busy = purchaseButton.classList.contains('loading') || purchaseButton.getAttribute('aria-busy') === 'true';
      var unavailable = purchaseButton.disabled || purchaseButton.classList.contains('disabled') || busy;
      jump.textContent = directPurchase
        ? (busy ? '\u0414\u043e\u0431\u0430\u0432\u043b\u044f\u0435\u043c\u2026' : purchaseButton.classList.contains('is-in-cart') ? '\u0412 \u043a\u043e\u0440\u0437\u0438\u043d\u0435' : '\u0412 \u043a\u043e\u0440\u0437\u0438\u043d\u0443')
        : productType === 'variable' ? '\u0412\u044b\u0431\u0440\u0430\u0442\u044c \u0432\u0430\u0440\u0438\u0430\u043d\u0442' : '\u041a \u043f\u043e\u043a\u0443\u043f\u043a\u0435';
      jump.disabled = directPurchase && unavailable;
      jump.setAttribute('aria-busy', String(busy));
      bar.hidden = !mobile.matches || formVisible || footerVisible || !price.textContent || purchaseButton.classList.contains('wc-variation-is-unavailable');
      document.body.classList.toggle('dv-mobile-purchase-enabled', mobile.matches);
      document.body.classList.toggle('dv-mobile-purchase-visible', !bar.hidden);
    }
    jump.addEventListener('click', function () {
      if (!canPurchaseDirectly()) { focusPurchaseForm(); return; }
      if (!form.checkValidity()) {
        focusPurchaseForm();
        form.reportValidity();
        return;
      }
      purchaseButton.click();
    });
    new IntersectionObserver(function (entries) {
      formVisible = entries[0].isIntersecting;
      syncBar();
    }).observe(form);
    var footer = document.querySelector('.site-footer');
    if (footer) {
      new IntersectionObserver(function (entries) {
        footerVisible = entries[0].isIntersecting;
        syncBar();
      }).observe(footer);
    }
    new MutationObserver(syncBar).observe(panel, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: ['class', 'disabled', 'aria-busy', 'name', 'type', 'required', 'form'] });
    mobile.addEventListener('change', syncBar);
    syncBar();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
}());
