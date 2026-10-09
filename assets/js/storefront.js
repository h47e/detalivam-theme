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

  function init() {
    if (document.body.matches('.single-product, .woocommerce-shop, .post-type-archive-product, .tax-product_cat, .tax-product_tag')) {
      var siteHeader = document.getElementById('site-header');
      var mainHeader = siteHeader && siteHeader.querySelector('.header-main');
      if (mainHeader) {
        var headerPlaceholder = document.createElement('div');
        headerPlaceholder.className = 'dv-header-main-placeholder';
        headerPlaceholder.hidden = true;
        mainHeader.before(headerPlaceholder);
        siteHeader.classList.add('dv-product-sticky-header');
        var headerTick = false;
        function syncPinnedHeader() {
          headerTick = false;
          var adminBar = document.getElementById('wpadminbar');
          var offset = adminBar ? Math.max(0, adminBar.getBoundingClientRect().bottom) : 0;
          var anchor = headerPlaceholder.hidden ? mainHeader : headerPlaceholder;
          var pinned = anchor.getBoundingClientRect().top < offset;
          headerPlaceholder.style.height = mainHeader.offsetHeight + 'px';
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
      button.hidden = false;
      extra.forEach(function (item) { item.hidden = true; });
      button.addEventListener('click', function () {
        var open = button.getAttribute('aria-expanded') !== 'true';
        button.setAttribute('aria-expanded', String(open));
        button.textContent = open ? '\u0421\u043a\u0440\u044b\u0442\u044c' : '\u0412\u0441\u0435 \u043c\u0430\u0440\u043a\u0438';
        extra.forEach(function (item) { item.hidden = !open; });
      });
    });
    var checkout = document.querySelector('form.checkout');
    if (checkout) {
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
      categoryOpener.addEventListener('click', function (event) {
        if (!mobile.matches) return;
        event.preventDefault();
        categoryDialog.showModal();
        categoryOpener.setAttribute('aria-expanded', 'true');
        document.body.classList.add('dv-categories-open');
      });
      categoryOpener.addEventListener('keydown', function (event) {
        if (mobile.matches && event.key === ' ') {
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
        if (mobile.matches) {
          categoryOpener.setAttribute('aria-expanded', 'false');
          categoryOpener.focus();
        }
      });
      function syncCategories() {
        if (categoryDialog.open) categoryDialog.close();
        categoryBranches.forEach(function (branch) { branch.sync(); });
        if (mobile.matches) {
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
      mobile.addEventListener('change', syncCategories);
      syncCategories();
    }
    var sidebar = document.querySelector('.catalog-sidebar');
    var controls = document.querySelector('.catalog-mobile-controls');
    if (sidebar && controls && typeof HTMLDialogElement !== 'undefined' && HTMLDialogElement.prototype.showModal) {
      var anchor = document.createComment('catalog sidebar');
      sidebar.before(anchor);
      var dialog = document.createElement('dialog');
      dialog.id = 'dv-catalog-filters';
      dialog.className = 'catalog-filter-dialog';
      dialog.setAttribute('aria-labelledby', 'dv-catalog-filters-title');
      dialog.innerHTML = '<header><h2 id="dv-catalog-filters-title">\u0424\u0438\u043b\u044c\u0442\u0440\u044b</h2><button type="button" aria-label="\u0417\u0430\u043a\u0440\u044b\u0442\u044c">&times;</button></header>';
      document.body.append(dialog);
      var opener = controls.querySelector('button');
      function closeFilters() {
        dialog.close();
      }
      opener.addEventListener('click', function () {
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
        opener.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('dv-filters-open');
        if (mobile.matches) opener.focus();
      });
      function syncFilters() {
        if (dialog.open) closeFilters();
        controls.hidden = !mobile.matches;
        if (mobile.matches) dialog.append(sidebar);
        else anchor.after(sidebar);
      }
      mobile.addEventListener('change', syncFilters);
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
    function syncBar() {
      var variationPrice = panel.querySelector('.woocommerce-variation-price .price');
      var source = variationPrice && variationPrice.textContent.trim() ? variationPrice : panel.querySelector('.price');
      var discounted = source && source.querySelector('ins');
      price.textContent = (discounted || source) ? (discounted || source).textContent.replace(/\s+/g, ' ').trim() : '';
      bar.hidden = !mobile.matches || formVisible || !price.textContent || purchaseButton.classList.contains('wc-variation-is-unavailable');
      document.body.classList.toggle('dv-mobile-purchase-enabled', mobile.matches);
    }
    jump.addEventListener('click', function () {
      form.scrollIntoView({ block: 'center', behavior: 'auto' });
      var control = form.querySelector('select, input.qty, .single_add_to_cart_button');
      if (control) control.focus({ preventScroll: true });
    });
    new IntersectionObserver(function (entries) {
      formVisible = entries[0].isIntersecting;
      syncBar();
    }).observe(form);
    new MutationObserver(syncBar).observe(panel, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: ['class'] });
    mobile.addEventListener('change', syncBar);
    syncBar();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
}());
