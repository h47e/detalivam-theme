(function () {
  'use strict';

  const fields = [
    {
      selector: '#dv-seo-title, #dv-term-seo-title',
      min: 45,
      max: 70,
      label: 'SEO Title',
    },
    {
      selector: '#dv-seo-description, #dv-term-seo-description',
      min: 120,
      max: 170,
      label: 'SEO Description',
    },
    {
      selector: '#dv-term-seo-h1',
      min: 20,
      max: 90,
      label: 'SEO H1',
    },
  ];

  function getStatus(length, min, max) {
    if (length === 0) {
      return {
        className: 'is-empty',
        text: 'пусто, будет использован автоматический вариант',
      };
    }

    if (length < min) {
      return {
        className: 'is-short',
        text: 'коротко',
      };
    }

    if (length > max) {
      return {
        className: 'is-long',
        text: 'длинно, может обрезаться',
      };
    }

    return {
      className: 'is-good',
      text: 'нормально',
    };
  }

  function attachCounter(field, config) {
    const counter = document.createElement('div');
    counter.className = 'dv-seo-field-counter';
    field.insertAdjacentElement('afterend', counter);

    const update = () => {
      const length = field.value.trim().length;
      const status = getStatus(length, config.min, config.max);

      counter.className = `dv-seo-field-counter ${status.className}`;
      counter.textContent = `${config.label}: ${length} символов, ${status.text}. Рекомендация: ${config.min}-${config.max}.`;
    };

    field.addEventListener('input', update);
    update();
  }

  function setupCategoryTableTools() {
    const table = document.querySelector('[data-dv-seo-category-table]');
    const controls = document.querySelector('[data-dv-seo-category-controls]');

    if (!table || !controls) {
      return;
    }

    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr[data-ready]'));
    const emptyRow = tbody.querySelector('[data-dv-seo-category-empty]');
    const search = controls.querySelector('[data-dv-seo-category-search]');
    const filter = controls.querySelector('[data-dv-seo-category-filter]');
    const sort = controls.querySelector('[data-dv-seo-category-sort]');
    const count = controls.querySelector('[data-dv-seo-category-count]');

    if (!tbody || !rows.length || !emptyRow || !search || !filter || !sort || !count) {
      return;
    }

    const getVisibleRows = () => rows.filter((row) => !row.hidden);

    const apply = () => {
      const query = search.value.trim().toLowerCase();
      const mode = filter.value;

      rows.forEach((row) => {
        const ready = Number(row.dataset.ready || 0);
        const name = row.dataset.name || '';
        const matchesSearch = !query || name.includes(query);
        let matchesFilter = true;

        if (mode === 'incomplete') {
          matchesFilter = ready < 100;
        } else if (mode === 'almost') {
          matchesFilter = ready >= 75 && ready < 100;
        } else if (mode === 'ready') {
          matchesFilter = ready === 100;
        }

        row.hidden = !(matchesSearch && matchesFilter);
      });

      const sortedRows = getVisibleRows().sort((a, b) => {
        const sortMode = sort.value;
        const aReady = Number(a.dataset.ready || 0);
        const bReady = Number(b.dataset.ready || 0);
        const aProducts = Number(a.dataset.products || 0);
        const bProducts = Number(b.dataset.products || 0);

        if (sortMode === 'ready-asc') {
          return aReady - bReady || bProducts - aProducts;
        }

        if (sortMode === 'ready-desc') {
          return bReady - aReady || bProducts - aProducts;
        }

        if (sortMode === 'name-asc') {
          return (a.dataset.name || '').localeCompare(b.dataset.name || '', 'ru');
        }

        return bProducts - aProducts || aReady - bReady;
      });

      sortedRows.forEach((row) => tbody.insertBefore(row, emptyRow));

      const visibleCount = sortedRows.length;
      emptyRow.hidden = visibleCount > 0;
      count.textContent = `Показано: ${visibleCount} из ${rows.length}`;
    };

    search.addEventListener('input', apply);
    filter.addEventListener('change', apply);
    sort.addEventListener('change', apply);
    apply();
  }

  function setupSeoToolsNav() {
    const nav = document.querySelector('.dv-seo-tools-nav');

    if (!nav) {
      return;
    }

    nav.querySelectorAll('a[href^="#"]').forEach((link) => {
      link.addEventListener('click', (event) => {
        const target = document.querySelector(link.getAttribute('href'));

        if (!target) {
          return;
        }

        event.preventDefault();

        if (target.tagName.toLowerCase() === 'details') {
          target.open = true;
        }

        const adminBar = document.getElementById('wpadminbar');
        const offset = (adminBar ? adminBar.offsetHeight : 0) + nav.offsetHeight + 18;
        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;

        window.history.pushState(null, '', link.getAttribute('href'));
        window.scrollTo({
          top: Math.max(0, top),
          behavior: 'smooth',
        });
      });
    });
  }

  function openHashDetails() {
    if (!window.location.hash) {
      return;
    }

    const target = document.querySelector(window.location.hash);

    if (target && target.tagName.toLowerCase() === 'details') {
      target.open = true;
    }
  }

  function setupActionQueueToggle() {
    const button = document.querySelector('[data-dv-seo-actions-toggle]');

    if (!button) {
      return;
    }

    const panel = button.closest('#dv-seo-actions');

    if (!panel) {
      return;
    }

    const update = () => {
      const isOpen = panel.classList.contains('is-showing-all');
      button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      button.textContent = isOpen ? button.dataset.closeLabel : button.dataset.openLabel;
    };

    button.addEventListener('click', () => {
      panel.classList.toggle('is-showing-all');
      update();
    });

    update();
  }

  function setupActionQueueFilters() {
    const panel = document.getElementById('dv-seo-actions');

    if (!panel) {
      return;
    }

    const buttons = Array.from(panel.querySelectorAll('[data-dv-seo-action-filter]'));
    const actions = Array.from(panel.querySelectorAll('[data-dv-seo-action-level]'));

    if (!buttons.length || !actions.length) {
      return;
    }

    const applyFilter = (filter) => {
      panel.classList.toggle('is-filtering', filter !== 'all');

      buttons.forEach((button) => {
        const isActive = button.dataset.dvSeoActionFilter === filter;
        button.classList.toggle('is-active', isActive);
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
      });

      actions.forEach((action) => {
        const isMatch = filter === 'all' || action.dataset.dvSeoActionLevel === filter;
        action.classList.toggle('is-hidden-by-filter', !isMatch);
      });
    };

    buttons.forEach((button) => {
      button.addEventListener('click', () => {
        applyFilter(button.dataset.dvSeoActionFilter || 'all');
      });
    });

    applyFilter('all');
  }

  function setupTemplateGenerator() {
    const root = document.querySelector('[data-dv-seo-template-generator]');

    if (!root) {
      return;
    }

    let config = null;

    try {
      config = JSON.parse(root.dataset.dvSeoTemplateGenerator || '{}');
    } catch (error) {
      config = null;
    }

    if (!config || !config.presets) {
      return;
    }

    const typeSelect = root.querySelector('[data-dv-template-type]');
    const variantSelect = root.querySelector('[data-dv-template-variant]');
    const fields = {
      entity: root.querySelector('[data-dv-template-entity]'),
      sku: root.querySelector('[data-dv-template-sku]'),
      category: root.querySelector('[data-dv-template-category]'),
      city: root.querySelector('[data-dv-template-city]'),
      shop: root.querySelector('[data-dv-template-shop]'),
    };
    const titleOutput = root.querySelector('[data-dv-template-title]');
    const descriptionOutput = root.querySelector('[data-dv-template-description]');
    const titleCount = root.querySelector('[data-dv-template-title-count]');
    const descriptionCount = root.querySelector('[data-dv-template-description-count]');

    if (!typeSelect || !variantSelect || !titleOutput || !descriptionOutput) {
      return;
    }

    function getType() {
      return config.presets[typeSelect.value] ? typeSelect.value : Object.keys(config.presets)[0];
    }

    function getVariant(type) {
      const variants = config.presets[type].variants || {};
      return variants[variantSelect.value] ? variantSelect.value : Object.keys(variants)[0];
    }

    function fillDefaults(type) {
      const defaults = config.presets[type].defaults || {};

      Object.entries(fields).forEach(([key, field]) => {
        if (!field || field.value.trim()) {
          return;
        }

        if (Object.prototype.hasOwnProperty.call(defaults, key)) {
          field.value = defaults[key] || '';
        } else if (config.tokens && Object.prototype.hasOwnProperty.call(config.tokens, key)) {
          field.value = config.tokens[key] || '';
        }
      });
    }

    function syncVariants() {
      const type = getType();
      const variants = config.presets[type].variants || {};
      const previous = variantSelect.value;

      variantSelect.innerHTML = '';

      Object.entries(variants).forEach(([key, variant]) => {
        const option = document.createElement('option');
        option.value = key;
        option.textContent = variant.label || key;
        variantSelect.appendChild(option);
      });

      if (variants[previous]) {
        variantSelect.value = previous;
      }

      fillDefaults(type);
    }

    function applyTokens(template) {
      const values = Object.fromEntries(
        Object.entries(fields).map(([key, field]) => [key, field ? field.value.trim() : ''])
      );

      return String(template || '')
        .replace(/\{entity\}/g, values.entity || 'Название товара')
        .replace(/\{sku\}/g, values.sku || 'артикул')
        .replace(/\{category\}/g, values.category || 'категория')
        .replace(/\{city\}/g, values.city || 'город')
        .replace(/\{shop\}/g, values.shop || 'магазин')
        .replace(/\s+/g, ' ')
        .replace(/\s+([,.:;])/g, '$1')
        .trim();
    }

    function countLabel(text, min, max) {
      const length = text.length;
      const status = getStatus(length, min, max);
      return {
        className: status.className,
        text: `${length} символов`,
      };
    }

    function setCounter(node, value) {
      if (!node) {
        return;
      }

      node.className = `dv-seo-template-count ${value.className}`;
      node.textContent = value.text;
    }

    function update() {
      const type = getType();
      const variantKey = getVariant(type);
      const variant = config.presets[type].variants[variantKey] || {};
      const title = applyTokens(variant.title);
      const description = applyTokens(variant.description);

      titleOutput.textContent = title;
      descriptionOutput.textContent = description;
      setCounter(titleCount, countLabel(title, 45, 70));
      setCounter(descriptionCount, countLabel(description, 120, 170));
    }

    function copyText(text, button) {
      const done = () => {
        const original = button.textContent;
        button.textContent = 'Скопировано';
        window.setTimeout(() => {
          button.textContent = original;
        }, 1400);
      };

      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text).then(done).catch(() => {});
        return;
      }

      const textarea = document.createElement('textarea');
      textarea.value = text;
      textarea.setAttribute('readonly', 'readonly');
      textarea.style.position = 'fixed';
      textarea.style.left = '-9999px';
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand('copy');
      textarea.remove();
      done();
    }

    typeSelect.addEventListener('change', () => {
      Object.values(fields).forEach((field) => {
        if (field && (field === fields.entity || field === fields.sku || field === fields.category)) {
          field.value = '';
        }
      });
      syncVariants();
      update();
    });

    variantSelect.addEventListener('change', update);
    Object.values(fields).forEach((field) => {
      if (field) {
        field.addEventListener('input', update);
      }
    });

    root.querySelectorAll('[data-dv-template-copy]').forEach((button) => {
      button.addEventListener('click', () => {
        const target = button.dataset.dvTemplateCopy === 'description' ? descriptionOutput : titleOutput;
        copyText(target.textContent || '', button);
      });
    });

    syncVariants();
    update();
  }

  function setupProductAuditBatch() {
    const form = document.querySelector('[data-dv-seo-product-audit-form]');
    const config = window.dvSeoTools || {};

    if (!form || !config.ajaxUrl || !config.productAuditScheduleNonce || !config.productAuditStatusNonce || !window.fetch) {
      return;
    }

    const button = form.querySelector('input[type="submit"], button[type="submit"]');
    const progress = form.querySelector('[data-dv-seo-product-audit-progress]');
    const status = form.querySelector('[data-dv-seo-product-audit-status]');
    const bar = progress ? progress.querySelector('i') : null;

    if (!button || !progress || !status || !bar) {
      return;
    }

    function setProgress(percent, text) {
      const safePercent = Math.max(0, Math.min(100, Number(percent) || 0));
      progress.hidden = false;
      status.textContent = text;
      bar.style.width = `${safePercent}%`;
    }

    function requestAuditAction(action, nonce) {
      const body = new URLSearchParams();
      body.set('action', action);
      body.set('nonce', nonce);

      return fetch(config.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
        },
        body: body.toString(),
      }).then((response) => response.json());
    }

    function progressText(state) {
      const total = Number(state.total || 0);
      const processed = Number(state.processed || 0);

      if (state.status === 'completed') {
        return 'Фоновый аудит готов. Обновляю страницу...';
      }

      if (total > 0) {
        return `Фоновый аудит: проверено ${processed} из ${total} товаров...`;
      }

      return 'Фоновый аудит запущен, ожидаю WP-Cron...';
    }

    function applyState(state) {
      if (!state) {
        return;
      }

      setProgress(Number(state.percent || 0), progressText(state));
    }

    function finish() {
      setProgress(100, 'Фоновый аудит готов. Обновляю страницу...');
      const url = new URL(window.location.href);
      url.searchParams.set('dv_seo_notice', 'product_audit_refreshed');
      url.hash = 'dv-seo-products';
      window.location.assign(url.toString());
    }

    function fail() {
      button.disabled = false;
      setProgress(0, 'Не удалось запустить или проверить фоновый аудит. Попробуйте ещё раз.');
    }

    function pollStatus() {
      requestAuditAction('dv_seo_tools_product_audit_status', config.productAuditStatusNonce)
        .then((response) => {
          if (!response || !response.success || !response.data) {
            throw new Error('Bad audit status response');
          }

          applyState(response.data);

          if (response.data.status === 'completed') {
            finish();
            return;
          }

          window.setTimeout(pollStatus, 3000);
        })
        .catch(fail);
    }

    function scheduleAudit() {
      requestAuditAction('dv_seo_tools_schedule_product_audit', config.productAuditScheduleNonce)
        .then((response) => {
          if (!response || !response.success || !response.data) {
            throw new Error('Bad audit schedule response');
          }

          applyState(response.data);
          window.setTimeout(pollStatus, 2500);
        })
        .catch(fail);
    }

    if (config.productAuditState && config.productAuditState.status === 'running') {
      button.disabled = true;
      applyState(config.productAuditState);
      window.setTimeout(pollStatus, 1000);
    }

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      button.disabled = true;
      setProgress(0, 'Запускаю фоновый SEO-аудит товаров...');
      scheduleAudit();
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    fields.forEach((config) => {
      document.querySelectorAll(config.selector).forEach((field) => {
        if (field.dataset.dvSeoCounter === '1') {
          return;
        }

        field.dataset.dvSeoCounter = '1';
        attachCounter(field, config);
      });
    });

    setupCategoryTableTools();
    setupTemplateGenerator();
    setupSeoToolsNav();
    setupActionQueueToggle();
    setupActionQueueFilters();
    setupProductAuditBatch();
    openHashDetails();
    window.addEventListener('hashchange', openHashDetails);
  });
})();
