document.addEventListener('DOMContentLoaded', function () {
  var page = document.querySelector('.dv-store-settings-page');
  var expandButton = document.getElementById('dv-store-expand');
  var collapseButton = document.getElementById('dv-store-collapse');
  var search = document.getElementById('dv-store-settings-search');
  var searchClear = document.getElementById('dv-store-settings-search-clear');
  var searchCount = document.getElementById('dv-store-settings-search-count');
  var filterButtons = Array.prototype.slice.call(document.querySelectorAll('[data-dv-store-filter]'));
  var emptySummaryNode = document.getElementById('dv-store-empty-summary');
  var emptyJumpButton = document.getElementById('dv-store-empty-jump');
  var config = window.dvStoreAdmin || {};
  var storageKey = config.storageKey || 'dvStoreProfileSectionState';

  if (!page) {
    return;
  }

  var sections = Array.prototype.slice.call(page.querySelectorAll('[data-dv-store-section]'));
  var rows = Array.prototype.slice.call(page.querySelectorAll('.dv-store-settings-section .form-table tr'));
  var mediaFields = Array.prototype.slice.call(page.querySelectorAll('[data-dv-store-media-field]'));
  var overviewCards = Array.prototype.slice.call(page.querySelectorAll('.dv-store-overview-card[href^="#"]'));
  var activeStoreFilter = 'all';

  function readState() {
    try {
      var raw = window.localStorage.getItem(storageKey);
      return raw ? JSON.parse(raw) : {};
    } catch (e) {
      return {};
    }
  }

  function writeState(state) {
    try {
      window.localStorage.setItem(storageKey, JSON.stringify(state));
    } catch (e) {}
  }

  function setSectionCollapsed(section, isCollapsed) {
    var toggle = section.querySelector('.dv-store-section-toggle');

    section.classList.toggle('is-collapsed', isCollapsed);
    section.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');

    if (toggle) {
      toggle.setAttribute('aria-expanded', isCollapsed ? 'false' : 'true');
      toggle.textContent = isCollapsed
        ? (toggle.getAttribute('data-closed-label') || 'Open')
        : (toggle.getAttribute('data-open-label') || 'Close');
    }
  }

  function restoreState() {
    var state = readState();

    sections.forEach(function (section) {
      if (!section.id || typeof state[section.id] === 'undefined') {
        return;
      }

      setSectionCollapsed(section, !!state[section.id]);
    });
  }

  function persistState() {
    var state = readState();

    sections.forEach(function (section) {
      if (!section.id) {
        return;
      }

      state[section.id] = section.classList.contains('is-collapsed');
    });

    writeState(state);
  }

  function getFieldLabel(count) {
    return count + ' полей';
  }

  function getEmptyFieldLabel(count) {
    return count ? count + ' пустых' : 'заполнено';
  }

  function getRowControl(row) {
    return row ? row.querySelector('input, textarea, select') : null;
  }

  function isControlFilled(control) {
    if (!control) {
      return false;
    }

    if (control.matches('input[type="checkbox"]')) {
      return control.checked;
    }

    return String(control.value || '').trim() !== '';
  }

  function getStoreFieldKey(row) {
    return row ? (row.getAttribute('data-dv-store-field') || '') : '';
  }

  function marketplaceGroupIsActive(groupName) {
    if (!groupName) {
      return false;
    }

    return rows.some(function (row) {
      var control = getRowControl(row);

      return row.getAttribute('data-dv-store-marketplace-group') === groupName && isControlFilled(control);
    });
  }

  function rowNeedsValue(row) {
    var key = getStoreFieldKey(row);
    var groupName = row ? row.getAttribute('data-dv-store-marketplace-group') : '';

    if (!row) {
      return false;
    }

    if (row.getAttribute('data-dv-store-required') === '1') {
      return true;
    }

    if (groupName && /^marketplace_[23]_(name|url)$/.test(key)) {
      return marketplaceGroupIsActive(groupName);
    }

    return false;
  }

  function rowIsActionable(row) {
    return rowNeedsValue(row) || isControlFilled(getRowControl(row));
  }

  function refreshRowState(row) {
    var control = getRowControl(row);
    var isFilled = isControlFilled(control);
    var needsValue = rowNeedsValue(row);
    var badge = row.querySelector('.dv-store-field-state');

    if (!badge) {
      badge = document.createElement('span');
      badge.className = 'dv-store-field-state';
      row.insertBefore(badge, row.firstChild);
    }

    row.classList.toggle('is-store-field-filled', isFilled);
    row.classList.toggle('is-store-field-empty', needsValue && !isFilled);
    row.classList.toggle('is-store-field-optional', !needsValue && !isFilled);
    badge.textContent = isFilled ? 'Заполнено' : (needsValue ? 'Пусто' : 'Опционально');
  }

  function refreshAllRowStates() {
    rows.forEach(refreshRowState);
  }

  function setupFieldStates() {
    rows.forEach(function (row) {
      var control = getRowControl(row);

      if (!control) {
        return;
      }

      refreshRowState(row);

      control.addEventListener('input', function () {
        refreshAllRowStates();
        updateStoreCounters();
        if ((search && search.value.trim()) || activeStoreFilter !== 'all') {
          applySearch();
        }
      });

      control.addEventListener('change', function () {
        refreshAllRowStates();
        updateStoreCounters();
        if ((search && search.value.trim()) || activeStoreFilter !== 'all') {
          applySearch();
        }
      });
    });
  }

  function setupSectionCounters() {
    sections.forEach(function (section) {
      var title = section.querySelector('.dv-store-settings-section-title');
      var count = section.querySelectorAll('.form-table tr').length;
      var meta;
      var empty;

      if (!title || title.querySelector('.dv-store-section-meta')) {
        return;
      }

      meta = document.createElement('span');
      meta.className = 'dv-store-section-meta';
      meta.textContent = getFieldLabel(count);

      empty = document.createElement('span');
      empty.className = 'dv-store-section-empty';

      title.appendChild(meta);
      title.appendChild(empty);
    });
  }

  function setupNavCounters() {
    var links = Array.prototype.slice.call(page.querySelectorAll('.dv-store-settings-toolbar nav a[href^="#"]'));

    links.forEach(function (link) {
      var targetId = (link.getAttribute('href') || '').replace('#', '');
      var target = targetId ? document.getElementById(targetId) : null;
      var count;
      var meta;
      var empty;

      if (!target || link.querySelector('.dv-store-nav-count')) {
        return;
      }

      count = target.querySelectorAll('.form-table tr').length;

      meta = document.createElement('span');
      meta.className = 'dv-store-nav-count';
      meta.textContent = count;
      meta.setAttribute('aria-label', getFieldLabel(count));

      empty = document.createElement('span');
      empty.className = 'dv-store-nav-empty';
      empty.setAttribute('data-dv-store-nav-empty-target', targetId);

      link.appendChild(meta);
      link.appendChild(empty);

      link.addEventListener('click', function () {
        setSectionCollapsed(target, false);
        persistState();
      });
    });
  }

  function updateOverviewCards() {
    overviewCards.forEach(function (card) {
      var targetId = (card.getAttribute('href') || '').replace('#', '');
      var target = targetId ? document.getElementById(targetId) : null;
      var targetRows = target ? Array.prototype.slice.call(target.querySelectorAll('.form-table tr')).filter(rowIsActionable) : [];
      var total = targetRows.length;
      var emptyCount = targetRows.filter(function (row) {
        return row.classList.contains('is-store-field-empty');
      }).length;
      var filled = Math.max(0, total - emptyCount);
      var percent = total ? Math.round((filled / total) * 100) : 100;
      var value = card.querySelector('strong');
      var bar = card.querySelector('i b');

      if (value) {
        value.textContent = filled + ' / ' + total;
      }

      if (bar) {
        bar.style.width = percent + '%';
      }

      card.classList.toggle('has-store-empty', emptyCount > 0);
      card.classList.toggle('is-store-ok', emptyCount === 0);
    });
  }

  function updateStoreCounters() {
    var totalEmpty = rows.filter(function (row) {
      return row.classList.contains('is-store-field-empty');
    }).length;

    sections.forEach(function (section) {
      var emptyCount = section.querySelectorAll('.form-table tr.is-store-field-empty').length;
      var actionableCount = Array.prototype.slice.call(section.querySelectorAll('.form-table tr')).filter(rowIsActionable).length;
      var empty = section.querySelector('.dv-store-section-empty');
      var meta = section.querySelector('.dv-store-section-meta');

      section.classList.toggle('has-store-empty', emptyCount > 0);
      section.classList.toggle('is-store-ok', emptyCount === 0);

      if (meta) {
        meta.textContent = getFieldLabel(actionableCount);
      }

      if (empty) {
        empty.textContent = getEmptyFieldLabel(emptyCount);
        empty.classList.toggle('has-empty', emptyCount > 0);
        empty.classList.toggle('is-ok', emptyCount === 0);
      }
    });

    if (emptySummaryNode) {
      emptySummaryNode.textContent = getEmptyFieldLabel(totalEmpty);
      emptySummaryNode.classList.toggle('has-empty', totalEmpty > 0);
      emptySummaryNode.classList.toggle('is-ok', totalEmpty === 0);
    }

    if (emptyJumpButton) {
      emptyJumpButton.disabled = totalEmpty === 0;
      emptyJumpButton.classList.toggle('is-disabled', totalEmpty === 0);
    }

    page.querySelectorAll('[data-dv-store-nav-empty-target]').forEach(function (badge) {
      var target = document.getElementById(badge.getAttribute('data-dv-store-nav-empty-target'));
      var emptyCount = target ? target.querySelectorAll('.form-table tr.is-store-field-empty').length : 0;
      var actionableCount = target ? Array.prototype.slice.call(target.querySelectorAll('.form-table tr')).filter(rowIsActionable).length : 0;
      var link = badge.closest('a');
      var count = link ? link.querySelector('.dv-store-nav-count') : null;

      if (count) {
        count.textContent = actionableCount;
        count.setAttribute('aria-label', getFieldLabel(actionableCount));
      }

      badge.textContent = emptyCount ? emptyCount + ' пустых' : 'OK';
      badge.classList.toggle('has-empty', emptyCount > 0);
      badge.classList.toggle('is-ok', emptyCount === 0);

      if (link) {
        link.classList.toggle('has-store-empty', emptyCount > 0);
        link.classList.toggle('is-store-ok', emptyCount === 0);
      }
    });

    updateOverviewCards();
  }

  function rowMatchesStoreFilter(row) {
    if (activeStoreFilter === 'empty') {
      return row.classList.contains('is-store-field-empty');
    }

    if (activeStoreFilter === 'filled') {
      return row.classList.contains('is-store-field-filled') || row.classList.contains('is-store-field-optional');
    }

    return true;
  }

  function updateFilterButtons() {
    filterButtons.forEach(function (button) {
      var isActive = button.getAttribute('data-dv-store-filter') === activeStoreFilter;

      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    });
  }

  function setStoreFilter(filter) {
    activeStoreFilter = filter || 'all';
    updateFilterButtons();
    applySearch();
  }

  function focusFirstEmptyField() {
    var row = rows.filter(function (item) {
      return item.classList.contains('is-store-field-empty');
    })[0];
    var section;
    var control;

    if (!row) {
      return;
    }

    activeStoreFilter = 'empty';
    updateFilterButtons();

    if (search) {
      search.value = '';
    }

    section = row.closest('[data-dv-store-section]');
    if (section) {
      section.hidden = false;
      setSectionCollapsed(section, false);
    }

    applySearch();

    row.hidden = false;
    row.classList.add('is-store-field-target');
    row.scrollIntoView({ behavior: 'smooth', block: 'center' });

    control = getRowControl(row);
    if (control) {
      window.setTimeout(function () {
        control.focus();
      }, 250);
    }

    window.setTimeout(function () {
      row.classList.remove('is-store-field-target');
    }, 1800);
  }

  function setAllSectionsCollapsed(isCollapsed) {
    sections.forEach(function (section) {
      setSectionCollapsed(section, isCollapsed);
    });

    persistState();
  }

  function clearSearch() {
    page.classList.remove('is-searching-store');

    rows.forEach(function (row) {
      row.hidden = false;
      row.classList.remove('is-store-search-match');
    });

    sections.forEach(function (section) {
      section.hidden = false;
    });

    if (searchCount) {
      searchCount.textContent = '';
    }

    restoreState();
  }

  function applySearch() {
    var query = search ? search.value.trim().toLowerCase() : '';
    var hasFilter = activeStoreFilter !== 'all';

    if (!query && !hasFilter) {
      clearSearch();
      return;
    }

    var matchedRows = 0;

    page.classList.add('is-searching-store');

    rows.forEach(function (row) {
      var termMatch = !query || row.textContent.trim().toLowerCase().indexOf(query) !== -1;
      var isMatch = termMatch && rowMatchesStoreFilter(row);

      row.hidden = !isMatch;
      row.classList.toggle('is-store-search-match', isMatch);

      if (isMatch) {
        matchedRows += 1;
      }
    });

    sections.forEach(function (section) {
      var hasMatches = Boolean(section.querySelector('.is-store-search-match'));

      section.hidden = !hasMatches;

      if (hasMatches) {
        setSectionCollapsed(section, false);
      }
    });

    if (searchCount) {
      searchCount.textContent = matchedRows
        ? (config.countLabel || 'Found') + ': ' + matchedRows
        : (config.emptyText || 'Nothing found');
    }
  }

  setupFieldStates();
  setupSectionCounters();
  setupNavCounters();
  updateFilterButtons();
  updateStoreCounters();
  restoreState();

  sections.forEach(function (section) {
    var toggle = section.querySelector('.dv-store-section-toggle');

    if (!toggle) {
      return;
    }

    toggle.addEventListener('click', function () {
      setSectionCollapsed(section, !section.classList.contains('is-collapsed'));
      persistState();
    });
  });

  if (expandButton) {
    expandButton.addEventListener('click', function () {
      setAllSectionsCollapsed(false);
    });
  }

  if (collapseButton) {
    collapseButton.addEventListener('click', function () {
      setAllSectionsCollapsed(true);
    });
  }

  if (search) {
    search.addEventListener('input', applySearch);
    search.addEventListener('keydown', function (event) {
      if (event.key === 'Enter') {
        event.preventDefault();
      }

      if (event.key === 'Escape') {
        search.value = '';
        applySearch();
      }
    });
  }

  if (searchClear) {
    searchClear.addEventListener('click', function () {
      if (search) {
        search.value = '';
        applySearch();
        search.focus();
      }
    });
  }

  filterButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      setStoreFilter(button.getAttribute('data-dv-store-filter'));
    });
  });

  if (emptyJumpButton) {
    emptyJumpButton.addEventListener('click', focusFirstEmptyField);
  }

  function updateMediaPreview(field) {
    var input = field.querySelector('[data-dv-store-media-input]');
    var preview = field.querySelector('[data-dv-store-media-preview]');
    var value = input ? input.value.trim() : '';

    if (!preview) {
      return;
    }

    preview.classList.toggle('is-empty', !value);
    preview.innerHTML = '';

    if (value) {
      var image = document.createElement('img');
      image.src = value;
      image.alt = '';
      preview.appendChild(image);
    }
  }

  mediaFields.forEach(function (field) {
    var input = field.querySelector('[data-dv-store-media-input]');
    var selectButton = field.querySelector('[data-dv-store-media-select]');
    var clearButton = field.querySelector('[data-dv-store-media-clear]');
    var frame = null;

    if (input) {
      input.addEventListener('input', function () {
        updateMediaPreview(field);
      });
    }

    if (selectButton) {
      selectButton.addEventListener('click', function () {
        if (!window.wp || !window.wp.media || !input) {
          return;
        }

        if (!frame) {
          frame = window.wp.media({
            title: config.mediaTitle || 'Select image',
            button: {
              text: config.mediaButton || 'Use image'
            },
            multiple: false,
            library: {
              type: 'image'
            }
          });

          frame.on('select', function () {
            var attachment = frame.state().get('selection').first();
            var data = attachment ? attachment.toJSON() : {};
            var url = data.url || '';

            if (!url) {
              return;
            }

            input.value = url;
            input.dispatchEvent(new window.Event('input', { bubbles: true }));
            input.dispatchEvent(new window.Event('change', { bubbles: true }));
            updateMediaPreview(field);
          });
        }

        frame.open();
      });
    }

    if (clearButton) {
      clearButton.addEventListener('click', function () {
        if (!input) {
          return;
        }

        input.value = '';
        input.dispatchEvent(new window.Event('input', { bubbles: true }));
        input.dispatchEvent(new window.Event('change', { bubbles: true }));
        updateMediaPreview(field);
        input.focus();
      });
    }

    updateMediaPreview(field);
  });
});
