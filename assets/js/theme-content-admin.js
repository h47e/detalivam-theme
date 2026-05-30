document.addEventListener('DOMContentLoaded', function () {
  var input = document.getElementById('dv-theme-content-search');
  var clearButton = document.getElementById('dv-theme-content-search-clear');
  var expandButton = document.getElementById('dv-theme-content-expand');
  var collapseButton = document.getElementById('dv-theme-content-collapse');
  var countNode = document.getElementById('dv-theme-content-search-count');
  var filterButtons = Array.prototype.slice.call(document.querySelectorAll('[data-dv-content-filter]'));
  var emptySummaryNode = document.getElementById('dv-theme-content-empty-summary');
  var emptyJumpButton = document.getElementById('dv-theme-content-empty-jump');
  var progressLabelNode = document.getElementById('dv-theme-content-progress-label');
  var progressBarNode = document.getElementById('dv-theme-content-progress-bar');
  var overviewCards = Array.prototype.slice.call(document.querySelectorAll('.dv-theme-content-overview-card[href^="#"]'));
  var config = window.dvThemeContentAdmin || {};
  var storageKey = config.storageKey || 'dvThemeContentAccordionState';
  var mediaFields = Array.prototype.slice.call(document.querySelectorAll('[data-dv-content-media-field]'));

  if (!input) {
    return;
  }

  var sections = Array.prototype.slice.call(document.querySelectorAll('.dv-theme-section'));
  var subsections = Array.prototype.slice.call(document.querySelectorAll('.dv-theme-subsection'));
  var rows = Array.prototype.slice.call(document.querySelectorAll('.dv-theme-section .form-table tr'));
  var contentGroups = [];
  var isSearching = false;
  var activeContentFilter = 'all';

  function updateMediaPreview(field) {
    var mediaInput = field.querySelector('[data-dv-content-media-input]');
    var preview = field.querySelector('[data-dv-content-media-preview]');
    var value = mediaInput ? mediaInput.value.trim() : '';

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

  function initMediaFields() {
    mediaFields.forEach(function (field) {
      var mediaInput = field.querySelector('[data-dv-content-media-input]');
      var selectButton = field.querySelector('[data-dv-content-media-select]');
      var clearMediaButton = field.querySelector('[data-dv-content-media-clear]');
      var frame = null;

      if (mediaInput) {
        mediaInput.addEventListener('input', function () {
          updateMediaPreview(field);
        });
      }

      if (selectButton) {
        selectButton.addEventListener('click', function () {
          if (!window.wp || !window.wp.media || !mediaInput) {
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

              mediaInput.value = url;
              mediaInput.dispatchEvent(new window.Event('input', { bubbles: true }));
              mediaInput.dispatchEvent(new window.Event('change', { bubbles: true }));
              updateMediaPreview(field);
            });
          }

          frame.open();
        });
      }

      if (clearMediaButton) {
        clearMediaButton.addEventListener('click', function () {
          if (!mediaInput) {
            return;
          }

          mediaInput.value = '';
          mediaInput.dispatchEvent(new window.Event('input', { bubbles: true }));
          mediaInput.dispatchEvent(new window.Event('change', { bubbles: true }));
          updateMediaPreview(field);
        });
      }

      updateMediaPreview(field);
    });
  }

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

  function restoreAccordionState() {
    var state = readState();

    sections.concat(subsections).forEach(function (node) {
      if (!node.id || typeof node.open === 'undefined') {
        return;
      }

      if (typeof state[node.id] !== 'undefined') {
        node.open = !!state[node.id];
      }
    });
  }

  function persistAccordionState() {
    if (isSearching) {
      return;
    }

    var state = readState();

    sections.concat(subsections).forEach(function (node) {
      if (!node.id || typeof node.open === 'undefined') {
        return;
      }

      state[node.id] = !!node.open;
    });

    writeState(state);
  }

  function getAllFieldCount() {
    return rows.length;
  }

  function updateCount(term, count) {
    if (!countNode) {
      return;
    }

    var label = (term || activeContentFilter !== 'all') ? (config.countFoundLabel || '') : (config.countAllLabel || '');
    countNode.textContent = label + count;
  }

  function rowMatchesContentFilter(row) {
    if (activeContentFilter === 'empty') {
      return row.classList.contains('is-content-field-empty');
    }

    if (activeContentFilter === 'filled') {
      return row.classList.contains('is-content-field-filled');
    }

    return true;
  }

  function showAllRows() {
    isSearching = false;

    sections.forEach(function (section) {
      section.hidden = false;
    });

    subsections.forEach(function (subsection) {
      subsection.hidden = false;
    });

    rows.forEach(function (row) {
      row.hidden = false;
      row.classList.remove('is-theme-content-search-match');
    });

    contentGroups.forEach(function (group) {
      group.hidden = false;
      if (!group.hasAttribute('data-dv-content-user-open')) {
        group.open = group.classList.contains('is-default-open');
      }
    });

    restoreAccordionState();
    updateCount('', getAllFieldCount());
  }

  function applyCurrentFilters() {
    var term = (input.value || '').trim().toLowerCase();

    if (!term && activeContentFilter === 'all') {
      showAllRows();
      return;
    }

    var matchedRows = 0;

    isSearching = true;

    rows.forEach(function (row) {
      var termMatch = !term || (row.textContent || '').toLowerCase().indexOf(term) !== -1;
      var filterMatch = rowMatchesContentFilter(row);
      var match = termMatch && filterMatch;

      row.hidden = !match;
      row.classList.toggle('is-theme-content-search-match', Boolean(term && termMatch));

      if (match) {
        matchedRows += 1;
      }
    });

    subsections.forEach(function (subsection) {
      var subsectionRows = Array.prototype.slice.call(subsection.querySelectorAll('.form-table tr'));
      var hasMatches = subsectionRows.some(function (row) {
        return !row.hidden;
      });
      var summary = subsection.querySelector('summary');
      var summaryMatch = ((summary ? summary.textContent : '') || '').toLowerCase().indexOf(term) !== -1;

      subsection.hidden = !(hasMatches || summaryMatch);

      if (!subsection.hidden && typeof subsection.open !== 'undefined') {
        subsection.open = true;
      }
    });

    contentGroups.forEach(function (group) {
      var groupRows = Array.prototype.slice.call(group.querySelectorAll('.form-table tr'));
      var hasMatches = groupRows.some(function (row) {
        return !row.hidden;
      });

      group.hidden = !hasMatches;

      if (hasMatches && typeof group.open !== 'undefined') {
        group.open = true;
      }
    });

    sections.forEach(function (section) {
      var sectionRows = Array.prototype.slice.call(section.querySelectorAll(':scope > .dv-theme-section-body > .form-table tr'));
      var ownRowMatches = sectionRows.some(function (row) {
        return !row.hidden;
      });
      var visibleSubsections = Array.prototype.slice.call(section.querySelectorAll('.dv-theme-subsection')).some(function (subsection) {
        return !subsection.hidden;
      });
      var summary = section.querySelector(':scope > summary');
      var summaryMatch = ((summary ? summary.textContent : '') || '').toLowerCase().indexOf(term) !== -1;

      section.hidden = !(ownRowMatches || visibleSubsections || summaryMatch);

      if (!section.hidden && typeof section.open !== 'undefined') {
        section.open = true;
      }
    });

    updateCount(term, matchedRows);
  }

  function clearSearch() {
    input.value = '';
    applyCurrentFilters();
  }

  function applySearch() {
    applyCurrentFilters();
  }

  function updateFilterButtons() {
    filterButtons.forEach(function (button) {
      var isActive = button.getAttribute('data-dv-content-filter') === activeContentFilter;
      button.classList.toggle('is-active', isActive);
      button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
    });
  }

  function setContentFilter(filter) {
    activeContentFilter = filter || 'all';
    updateFilterButtons();
    applyCurrentFilters();
  }

  function focusFirstEmptyField() {
    var row = rows.find(function (item) {
      return item.classList.contains('is-content-field-empty');
    });
    var control;
    var parentDetails;

    if (!row) {
      return;
    }

    setContentFilter('empty');

    parentDetails = row.closest('details');
    while (parentDetails) {
      parentDetails.open = true;
      parentDetails = parentDetails.parentElement ? parentDetails.parentElement.closest('details') : null;
    }

    row.classList.add('is-content-field-target');
    window.setTimeout(function () {
      row.classList.remove('is-content-field-target');
    }, 1800);

    row.scrollIntoView({
      behavior: 'smooth',
      block: 'center'
    });

    control = row.querySelector('input:not([type="hidden"]), textarea, select');
    if (control && typeof control.focus === 'function') {
      window.setTimeout(function () {
        control.focus({
          preventScroll: true
        });
      }, 250);
    }
  }

  function setAccordionOpen(isOpen) {
    sections.concat(subsections).forEach(function (node) {
      if (typeof node.open === 'undefined' || node.hidden) {
        return;
      }

      node.open = isOpen;
    });

    persistAccordionState();
  }

  function getFieldLabel(count) {
    return count + ' полей';
  }

  function getEmptyFieldLabel(count) {
    return count ? count + ' пустых' : 'заполнено';
  }

  function setupNavCounters() {
    var links = Array.prototype.slice.call(document.querySelectorAll('.dv-theme-nav a[href^="#"]'));

    links.forEach(function (link) {
      var targetId = (link.getAttribute('href') || '').replace('#', '');
      var target = targetId ? document.getElementById(targetId) : null;
      var count;
      var counter;
      var emptyCounter;

      if (!target || link.querySelector('.dv-theme-nav-count')) {
        return;
      }

      count = target.querySelectorAll('.form-table tr').length;
      counter = document.createElement('span');
      counter.className = 'dv-theme-nav-count';
      counter.textContent = count;
      counter.setAttribute('aria-label', getFieldLabel(count));
      link.appendChild(counter);

      emptyCounter = document.createElement('span');
      emptyCounter.className = 'dv-theme-nav-empty';
      emptyCounter.setAttribute('data-dv-nav-empty-target', targetId);
      link.appendChild(emptyCounter);

      link.addEventListener('click', function () {
        if (typeof target.open !== 'undefined') {
          target.open = true;
        }
      });
    });
  }

  function setupSectionBadges() {
    sections.concat(subsections).forEach(function (node) {
      var summary = node.querySelector(':scope > summary');
      var count;
      var meta;

      if (!summary || summary.querySelector('.dv-theme-section-meta')) {
        return;
      }

      count = node.querySelectorAll('.form-table tr').length;
      meta = document.createElement('span');
      meta.className = 'dv-theme-section-meta';
      meta.textContent = getFieldLabel(count);
      summary.appendChild(meta);
    });
  }

  function updateEmptyCounters() {
    var totalEmpty = rows.filter(function (row) {
      return row.classList.contains('is-content-field-empty');
    }).length;
    var totalFields = rows.length;
    var filledFields = Math.max(0, totalFields - totalEmpty);
    var progressPercent = totalFields ? Math.round((filledFields / totalFields) * 100) : 100;

    sections.concat(subsections).forEach(function (node) {
      var badge = node.querySelector(':scope > summary .dv-theme-section-empty');
      var emptyCount;

      if (!badge) {
        return;
      }

      emptyCount = node.querySelectorAll('.form-table tr.is-content-field-empty').length;
      badge.textContent = getEmptyFieldLabel(emptyCount);
      badge.classList.toggle('is-ok', emptyCount === 0);
      badge.classList.toggle('has-empty', emptyCount > 0);
    });

    contentGroups.forEach(function (group) {
      var badge = group.querySelector(':scope > summary .dv-content-field-group-empty');
      var emptyCount;

      if (!badge) {
        return;
      }

      emptyCount = group.querySelectorAll('.form-table tr.is-content-field-empty').length;
      badge.textContent = getEmptyFieldLabel(emptyCount);
      badge.classList.toggle('is-ok', emptyCount === 0);
      badge.classList.toggle('has-empty', emptyCount > 0);
    });

    document.querySelectorAll('[data-dv-nav-empty-target]').forEach(function (badge) {
      var target = document.getElementById(badge.getAttribute('data-dv-nav-empty-target'));
      var emptyCount = target ? target.querySelectorAll('.form-table tr.is-content-field-empty').length : 0;
      var link = badge.closest('a');

      badge.textContent = emptyCount ? emptyCount + ' пустых' : 'OK';
      badge.classList.toggle('is-ok', emptyCount === 0);
      badge.classList.toggle('has-empty', emptyCount > 0);

      if (link) {
        link.classList.toggle('is-content-section-ok', emptyCount === 0);
        link.classList.toggle('has-content-section-empty', emptyCount > 0);
      }
    });

    if (emptySummaryNode) {
      emptySummaryNode.textContent = getEmptyFieldLabel(totalEmpty);
      emptySummaryNode.classList.toggle('is-ok', totalEmpty === 0);
      emptySummaryNode.classList.toggle('has-empty', totalEmpty > 0);
    }

    if (emptyJumpButton) {
      emptyJumpButton.disabled = totalEmpty === 0;
      emptyJumpButton.classList.toggle('is-disabled', totalEmpty === 0);
    }

    if (progressLabelNode) {
      progressLabelNode.textContent = 'Готовность ' + progressPercent + '% (' + filledFields + '/' + totalFields + ')';
    }

    if (progressBarNode) {
      progressBarNode.style.width = progressPercent + '%';
    }

    updateOverviewCards();
  }

  function updateOverviewCards() {
    overviewCards.forEach(function (card) {
      var targetId = (card.getAttribute('href') || '').replace('#', '');
      var target = targetId ? document.getElementById(targetId) : null;
      var sectionRows = target ? Array.prototype.slice.call(target.querySelectorAll('.form-table tr')) : [];
      var total = sectionRows.length;
      var emptyCount = sectionRows.filter(function (row) {
        return row.classList.contains('is-content-field-empty');
      }).length;
      var filled = Math.max(0, total - emptyCount);
      var percent = total ? Math.round((filled / total) * 100) : 100;
      var valueNode = card.querySelector('strong');
      var barNode = card.querySelector('i b');

      if (valueNode) {
        valueNode.textContent = filled + ' / ' + total;
      }

      if (barNode) {
        barNode.style.width = percent + '%';
      }

      card.classList.toggle('is-content-overview-ok', emptyCount === 0);
      card.classList.toggle('has-content-overview-empty', emptyCount > 0);
    });
  }

  function setupEmptyCounters() {
    sections.concat(subsections).forEach(function (node) {
      var summary = node.querySelector(':scope > summary');
      var badge;

      if (!summary || summary.querySelector('.dv-theme-section-empty')) {
        return;
      }

      badge = document.createElement('span');
      badge.className = 'dv-theme-section-empty';
      summary.appendChild(badge);
    });

    contentGroups.forEach(function (group) {
      var summary = group.querySelector(':scope > summary');
      var badge;

      if (!summary || summary.querySelector('.dv-content-field-group-empty')) {
        return;
      }

      badge = document.createElement('span');
      badge.className = 'dv-content-field-group-empty';
      summary.appendChild(badge);
    });

    updateEmptyCounters();
  }

  function setupFieldGroups() {
    sections.concat(subsections).forEach(function (container) {
      var fieldRows = Array.prototype.slice.call(container.querySelectorAll(':scope > .dv-theme-section-body > .form-table tr, :scope > .dv-theme-subsection-body > .form-table tr, :scope > .dv-theme-section-body > .dv-content-field-group-panel .form-table tr, :scope > .dv-theme-subsection-body > .dv-content-field-group-panel .form-table tr'));
      var previousGroup = '';

      fieldRows.forEach(function (row) {
        var group = row.getAttribute('data-dv-content-group') || '';
        var label;

        row.classList.remove('is-content-group-start');

        if (!group) {
          previousGroup = '';
          return;
        }

        if (group !== previousGroup) {
          row.classList.add('is-content-group-start');
          label = row.querySelector('.dv-content-field-group-label');

          if (!label) {
            label = document.createElement('span');
            label.className = 'dv-content-field-group-label';
            row.insertBefore(label, row.firstChild);
          }

          label.textContent = group;
        }

        previousGroup = group;
      });
    });
  }

  function setupCollapsibleFieldGroups() {
    sections.concat(subsections).forEach(function (container) {
      var body = container.querySelector(':scope > .dv-theme-section-body, :scope > .dv-theme-subsection-body');
      var table = body ? body.querySelector(':scope > .form-table') : null;
      var tbody = table ? table.querySelector(':scope > tbody') : null;
      var fieldRows = tbody ? Array.prototype.slice.call(tbody.querySelectorAll(':scope > tr')) : [];
      var chunks = [];
      var current = null;

      if (!body || !table || fieldRows.length < 7 || table.closest('.dv-custom-page-panel')) {
        return;
      }

      fieldRows.forEach(function (row) {
        var group = row.getAttribute('data-dv-content-group') || 'Общее';

        if (!current || current.name !== group) {
          current = {
            name: group,
            rows: []
          };
          chunks.push(current);
        }

        current.rows.push(row);
      });

      if (chunks.length < 2) {
        return;
      }

      table.remove();

      chunks.forEach(function (chunk, index) {
        var details = document.createElement('details');
        var summary = document.createElement('summary');
        var title = document.createElement('strong');
        var count = document.createElement('span');
        var groupTable = table.cloneNode(false);
        var groupBody = document.createElement('tbody');

        details.className = 'dv-content-field-group-panel';
        details.id = (container.id || 'dv-content-section') + '-group-' + index;
        details.open = index === 0;
        details.classList.toggle('is-default-open', index === 0);

        title.textContent = chunk.name;
        count.className = 'dv-content-field-group-count';
        count.textContent = getFieldLabel(chunk.rows.length);
        summary.appendChild(title);
        summary.appendChild(count);
        details.appendChild(summary);

        groupTable.appendChild(groupBody);
        chunk.rows.forEach(function (row) {
          groupBody.appendChild(row);
        });

        details.appendChild(groupTable);
        body.appendChild(details);
        contentGroups.push(details);

        details.addEventListener('toggle', function () {
          if (!isSearching) {
            details.setAttribute('data-dv-content-user-open', details.open ? '1' : '0');
          }
        });
      });
    });
  }

  function setupFieldStates() {
    rows.forEach(function (row) {
      var control = row.querySelector('input, textarea, select');
      var badge = row.querySelector('.dv-content-field-state-label');

      if (!control) {
        return;
      }

      if (!badge) {
        badge = document.createElement('span');
        badge.className = 'dv-content-field-state-label';
        row.insertBefore(badge, row.firstChild);
      }

      function updateState() {
        var isCheckbox = control.matches('input[type="checkbox"]');
        var isActive = isCheckbox ? control.checked : String(control.value || '').trim() !== '';
        var stateLabel = isCheckbox ? (isActive ? 'Включено' : 'Выключено') : (isActive ? 'Заполнено' : 'Пусто');

        row.classList.toggle('is-content-field-filled', isActive);
        row.classList.toggle('is-content-field-empty', !isActive);
        row.setAttribute('data-dv-content-state', stateLabel);
        badge.textContent = stateLabel;
        updateEmptyCounters();

        if (activeContentFilter !== 'all') {
          applyCurrentFilters();
        }
      }

      control.addEventListener('input', updateState);
      control.addEventListener('change', updateState);
      updateState();
    });
  }

  function setupCustomPageSlugValidation() {
    var reservedSlugs = Array.isArray(config.reservedSlugs) ? config.reservedSlugs : [];
    var conflictText = config.slugConflictText || 'Slug is already used. Change URL slug.';
    var makeSlugLabel = config.makeSlugLabel || 'Generate from H1';
    var copyUrlLabel = config.copyUrlLabel || 'Copy URL';
    var copiedLabel = config.copiedLabel || 'Copied';
    var homeUrl = String(config.homeUrl || window.location.origin + '/').replace(/\/+$/, '/') ;
    var inputs = [];

    function normalizeSlug(value) {
      return String(value || '')
        .trim()
        .toLowerCase()
        .replace(/^\/+|\/+$/g, '')
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9_-]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
    }

    function transliterate(value) {
      var map = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
        'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c',
        'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ъ': '', 'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu',
        'я': 'ya'
      };

      return String(value || '').toLowerCase().split('').map(function (char) {
        return Object.prototype.hasOwnProperty.call(map, char) ? map[char] : char;
      }).join('');
    }

    function makeSlugFromTitle(value) {
      return normalizeSlug(transliterate(value));
    }

    function getSlotInput(slot) {
      return document.getElementById('dv-theme-content-custom_page_' + slot + '_slug');
    }

    function getTitleInput(slot) {
      return document.getElementById('dv-theme-content-custom_page_' + slot + '_title');
    }

    function getFullUrl(slug) {
      var cleanSlug = normalizeSlug(slug);
      return cleanSlug ? homeUrl + cleanSlug + '/' : '';
    }

    function copyText(value, button) {
      var originalText = button.textContent;
      var done = function () {
        button.textContent = copiedLabel;
        window.setTimeout(function () {
          button.textContent = originalText;
        }, 1200);
      };

      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(value).then(done).catch(function () {});
        return;
      }

      try {
        var textarea = document.createElement('textarea');
        textarea.value = value;
        textarea.setAttribute('readonly', 'readonly');
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        done();
      } catch (error) {}
    }

    function setupActions(item) {
      var cell = item.input.closest('td');
      var titleInput = getTitleInput(item.slot);
      var actions;
      var makeButton;
      var copyButton;

      if (!cell || cell.querySelector('.dv-custom-page-slug-actions')) {
        return;
      }

      actions = document.createElement('div');
      actions.className = 'dv-custom-page-slug-actions';

      makeButton = document.createElement('button');
      makeButton.type = 'button';
      makeButton.className = 'button';
      makeButton.textContent = makeSlugLabel;
      makeButton.addEventListener('click', function () {
        if (!titleInput) {
          return;
        }

        item.input.value = makeSlugFromTitle(titleInput.value);
        item.input.dispatchEvent(new Event('input', { bubbles: true }));
        item.input.focus();
      });

      copyButton = document.createElement('button');
      copyButton.type = 'button';
      copyButton.className = 'button';
      copyButton.textContent = copyUrlLabel;
      copyButton.addEventListener('click', function () {
        var url = getFullUrl(item.input.value);

        if (url) {
          copyText(url, copyButton);
        }
      });

      actions.appendChild(makeButton);
      actions.appendChild(copyButton);
      cell.appendChild(actions);
    }

    function getWarning(input) {
      var cell = input.closest('td');
      var warning;

      if (!cell) {
        return null;
      }

      warning = cell.querySelector('.dv-custom-page-live-warning');
      if (!warning) {
        warning = document.createElement('p');
        warning.className = 'dv-custom-page-live-warning';
        warning.textContent = conflictText;
        warning.hidden = true;
        cell.appendChild(warning);
      }

      return warning;
    }

    function applyValidation() {
      var counts = {};

      inputs.forEach(function (item) {
        var slug = normalizeSlug(item.input.value);
        item.normalizedSlug = slug;

        if (slug) {
          counts[slug] = (counts[slug] || 0) + 1;
        }
      });

      inputs.forEach(function (item) {
        var hasConflict = Boolean(
          item.normalizedSlug &&
          (reservedSlugs.indexOf(item.normalizedSlug) !== -1 || counts[item.normalizedSlug] > 1)
        );
        var row = item.input.closest('tr');
        var details = item.input.closest('.dv-theme-subsection');
        var card = document.querySelector('[data-dv-custom-page-card="' + item.slot + '"]');
        var warning = getWarning(item.input);

        item.input.classList.toggle('has-slug-conflict', hasConflict);

        if (row) {
          row.classList.toggle('has-slug-conflict', hasConflict);
        }

        if (details) {
          details.classList.toggle('has-slug-conflict', hasConflict);
        }

        if (card) {
          if (!card.hasAttribute('data-dv-initial-ready')) {
            card.setAttribute('data-dv-initial-ready', card.classList.contains('is-ready') ? '1' : '0');
          }

          card.classList.toggle('has-conflict', hasConflict);
          card.classList.toggle('is-ready', !hasConflict && card.getAttribute('data-dv-initial-ready') === '1');
        }

        if (warning) {
          warning.hidden = !hasConflict;
        }
      });
    }

    for (var index = 1; index <= 5; index += 1) {
      var slotInput = getSlotInput(index);

      if (slotInput) {
        inputs.push({
          slot: index,
          input: slotInput,
          normalizedSlug: normalizeSlug(slotInput.value)
        });
      }
    }

    if (!inputs.length) {
      return;
    }

    inputs.forEach(function (item) {
      setupActions(item);
      item.input.addEventListener('input', applyValidation);
      item.input.addEventListener('change', applyValidation);
    });

    applyValidation();
  }

  function setupCustomPageCtaPresets() {
    var presets = Array.isArray(config.customPageCtaPresets) ? config.customPageCtaPresets : [];

    if (!presets.length) {
      return;
    }

    function setInputValue(node, value) {
      if (!node) {
        return;
      }

      node.value = value;
      node.dispatchEvent(new Event('input', { bubbles: true }));
      node.dispatchEvent(new Event('change', { bubbles: true }));
    }

    [1, 2, 3, 4, 5].forEach(function (slot) {
      var labelInput = document.getElementById('dv-theme-content-custom_page_' + slot + '_cta_label');
      var urlInput = document.getElementById('dv-theme-content-custom_page_' + slot + '_cta_url');
      var cell = urlInput ? urlInput.closest('td') : null;
      var actions;

      if (!labelInput || !urlInput || !cell || cell.querySelector('.dv-custom-page-cta-actions')) {
        return;
      }

      actions = document.createElement('div');
      actions.className = 'dv-custom-page-cta-actions';

      presets.forEach(function (preset) {
        var button = document.createElement('button');

        button.type = 'button';
        button.className = 'button';
        button.textContent = preset.name || preset.label || 'CTA';
        button.addEventListener('click', function () {
          setInputValue(labelInput, preset.label || '');
          setInputValue(urlInput, preset.url || '');
          urlInput.focus();
        });

        actions.appendChild(button);
      });

      cell.appendChild(actions);
    });
  }

  function setupCustomPageSeoPreview() {
    var previews = Array.prototype.slice.call(document.querySelectorAll('[data-dv-custom-seo-preview]'));
    var siteName = config.siteName || 'ДеталиВам';
    var emptyLabel = config.seoEmptyLabel || 'Пока не заполнено';

    function getValue(id) {
      var node = id ? document.getElementById(id) : null;
      return node ? String(node.value || '').trim() : '';
    }

    function setValue(id, value) {
      var node = id ? document.getElementById(id) : null;

      if (!node) {
        return;
      }

      node.value = value;
      node.dispatchEvent(new Event('input', { bubbles: true }));
      node.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function normalizeText(value) {
      return String(value || '')
        .replace(/<[^>]+>/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    }

    function truncateText(value, limit) {
      var text = normalizeText(value);

      if (!limit || text.length <= limit) {
        return text;
      }

      var sliced = text.slice(0, limit - 3);
      var lastSpace = sliced.lastIndexOf(' ');

      if (lastSpace > 40) {
        sliced = sliced.slice(0, lastSpace);
      }

      return sliced.replace(/[.,;:\-\s]+$/g, '') + '...';
    }

    function buildGeneratedSeo(preview) {
      var heading = normalizeText(getValue(preview.getAttribute('data-heading-input')));
      var intro = normalizeText(getValue(preview.getAttribute('data-intro-input')));
      var body = normalizeText(getValue(preview.getAttribute('data-body-input')));
      var titleBase = heading || intro || body || '';
      var descriptionBase = intro || body || heading || '';
      var title = titleBase ? titleBase + ' | ' + siteName : '';

      if (title.length > 70 && titleBase) {
        title = titleBase;
      }

      return {
        title: truncateText(title, 70),
        description: truncateText(descriptionBase, 160)
      };
    }

    function getPreviewText(preview, type) {
      var explicit = getValue(preview.getAttribute(type === 'title' ? 'data-title-input' : 'data-description-input'));

      if (explicit) {
        return explicit;
      }

      if (type === 'title') {
        var heading = getValue(preview.getAttribute('data-heading-input'));
        return heading ? heading + ' | ' + siteName : emptyLabel;
      }

      return getValue(preview.getAttribute('data-intro-input')) || emptyLabel;
    }

    function updatePreview(preview) {
      var titleNode = preview.querySelector('[data-dv-seo-title]');
      var titleCount = preview.querySelector('[data-dv-seo-title-count]');
      var descNode = preview.querySelector('[data-dv-seo-description]');
      var descCount = preview.querySelector('[data-dv-seo-description-count]');
      var titleText = getPreviewText(preview, 'title');
      var descText = getPreviewText(preview, 'description');

      if (titleNode) {
        titleNode.textContent = titleText;
      }

      if (titleCount) {
        titleCount.textContent = String(titleText.length);
        titleCount.classList.toggle('is-warning', titleText.length > 70 || titleText === emptyLabel);
      }

      if (descNode) {
        descNode.textContent = descText;
      }

      if (descCount) {
        descCount.textContent = String(descText.length);
        descCount.classList.toggle('is-warning', descText.length > 170 || descText === emptyLabel);
      }
    }

    previews.forEach(function (preview) {
      [
        preview.getAttribute('data-title-input'),
        preview.getAttribute('data-description-input'),
        preview.getAttribute('data-heading-input'),
        preview.getAttribute('data-intro-input'),
        preview.getAttribute('data-body-input')
      ].forEach(function (id) {
        var inputNode = id ? document.getElementById(id) : null;

        if (inputNode) {
          inputNode.addEventListener('input', function () {
            updatePreview(preview);
          });
        }
      });

      var fillButton = preview.querySelector('[data-dv-fill-seo]');

      if (fillButton) {
        fillButton.addEventListener('click', function () {
          var generated = buildGeneratedSeo(preview);

          if (generated.title) {
            setValue(preview.getAttribute('data-title-input'), generated.title);
          }

          if (generated.description) {
            setValue(preview.getAttribute('data-description-input'), generated.description);
          }

          updatePreview(preview);
        });
      }

      updatePreview(preview);
    });
  }

  function setupCustomPageCardPreview() {
    var previews = Array.prototype.slice.call(document.querySelectorAll('[data-dv-custom-card-preview]'));
    var emptyLabel = config.cardEmptyLabel || 'Карточка пока не заполнена';
    var presets = Array.isArray(config.customPageCardPresets) ? config.customPageCardPresets : [];

    function getNodeValue(id) {
      var node = id ? document.getElementById(id) : null;
      return node ? String(node.value || '').trim() : '';
    }

    function getNode(id) {
      return id ? document.getElementById(id) : null;
    }

    function setNodeValue(node, value) {
      if (!node) {
        return;
      }

      node.value = value;
      node.dispatchEvent(new Event('input', { bubbles: true }));
      node.dispatchEvent(new Event('change', { bubbles: true }));
    }

    function getSelectLabel(id) {
      var node = id ? document.getElementById(id) : null;

      if (!node || !node.options || typeof node.selectedIndex === 'undefined') {
        return '';
      }

      return node.options[node.selectedIndex] ? String(node.options[node.selectedIndex].text || '').trim() : '';
    }

    function updateItem(item) {
      var iconNode = item.querySelector('[data-dv-card-preview-icon]');
      var titleNode = item.querySelector('[data-dv-card-preview-title]');
      var textNode = item.querySelector('[data-dv-card-preview-text]');
      var iconLabel = getSelectLabel(item.getAttribute('data-icon-input'));
      var titleText = getNodeValue(item.getAttribute('data-title-input'));
      var bodyText = getNodeValue(item.getAttribute('data-text-input'));
      var isEmpty = !titleText && !bodyText;

      item.classList.toggle('is-empty', isEmpty);

      if (iconNode) {
        iconNode.textContent = iconLabel || 'Иконка';
      }

      if (titleNode) {
        titleNode.textContent = titleText || emptyLabel;
      }

      if (textNode) {
        textNode.textContent = bodyText || '';
      }
    }

    previews.forEach(function (preview) {
      var items = Array.prototype.slice.call(preview.querySelectorAll('[data-dv-card-preview-item]'));
      var fillButton = preview.querySelector('[data-dv-fill-cards]');

      items.forEach(function (item) {
        [
          item.getAttribute('data-icon-input'),
          item.getAttribute('data-title-input'),
          item.getAttribute('data-text-input')
        ].forEach(function (id) {
          var inputNode = id ? document.getElementById(id) : null;

          if (inputNode) {
            inputNode.addEventListener('input', function () {
              updateItem(item);
            });
            inputNode.addEventListener('change', function () {
              updateItem(item);
            });
          }
        });

        updateItem(item);
      });

      if (fillButton && presets.length) {
        fillButton.addEventListener('click', function () {
          items.forEach(function (item, index) {
            var preset = presets[index] || {};
            var iconInput = getNode(item.getAttribute('data-icon-input'));
            var titleInput = getNode(item.getAttribute('data-title-input'));
            var textInput = getNode(item.getAttribute('data-text-input'));
            var hasContent = Boolean(getNodeValue(item.getAttribute('data-title-input')) || getNodeValue(item.getAttribute('data-text-input')));

            if (hasContent) {
              return;
            }

            setNodeValue(iconInput, preset.icon || 'request');
            setNodeValue(titleInput, preset.title || '');
            setNodeValue(textInput, preset.text || '');
            updateItem(item);
          });
        });
      }
    });
  }

  function setupCustomPageReadinessPreview() {
    var reservedSlugs = Array.isArray(config.reservedSlugs) ? config.reservedSlugs : [];
    var cardsLabelFallback = 'Карточки';
    var cards = Array.prototype.slice.call(document.querySelectorAll('[data-dv-custom-page-card]'));
    var homeUrl = String(config.homeUrl || window.location.origin + '/').replace(/\/+$/, '/');

    function normalizeSlug(value) {
      return String(value || '')
        .trim()
        .toLowerCase()
        .replace(/^\/+|\/+$/g, '')
        .replace(/\s+/g, '-')
        .replace(/[^a-z0-9_-]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
    }

    function getInput(slot, suffix) {
      return document.getElementById('dv-theme-content-custom_page_' + slot + '_' + suffix);
    }

    function getInputValue(slot, suffix) {
      var node = getInput(slot, suffix);
      return node ? String(node.value || '').trim() : '';
    }

    function isInputChecked(slot, suffix) {
      var node = getInput(slot, suffix);
      return Boolean(node && node.checked);
    }

    function getFullUrl(slug) {
      return slug ? homeUrl + slug + '/' : '';
    }

    function getSlugMap() {
      var counts = {};

      cards.forEach(function (card) {
        var slot = card.getAttribute('data-dv-custom-page-card');
        var slug = normalizeSlug(getInputValue(slot, 'slug'));

        if (slug) {
          counts[slug] = (counts[slug] || 0) + 1;
        }
      });

      return counts;
    }

    function getCardCount(slot) {
      var count = 0;

      [1, 2, 3].forEach(function (index) {
        if (getInputValue(slot, 'card_' + index + '_title') || getInputValue(slot, 'card_' + index + '_text')) {
          count += 1;
        }
      });

      return count;
    }

    function toggleStatus(node, isReady, text) {
      if (!node) {
        return;
      }

      node.classList.toggle('is-on', isReady);
      node.classList.toggle('is-off', !isReady);
      node.textContent = text;
    }

    function updatePageUrlNodes(slot, card, slug, hasConflict) {
      var nodes = [card.querySelector('[data-dv-custom-page-url]')].concat(
        Array.prototype.slice.call(document.querySelectorAll('[data-dv-custom-page-summary-url="' + slot + '"]'))
      );

      nodes.forEach(function (node) {
        var emptyText;
        var conflictText;
        var text;

        if (!node) {
          return;
        }

        emptyText = node.getAttribute('data-empty') || '';
        conflictText = node.getAttribute('data-conflict') || '';
        text = hasConflict ? conflictText : (slug ? getFullUrl(slug) : emptyText);
        node.textContent = text;
      });
    }

    function updatePageStatus(card, hasTitle, hasSlug, hasConflict) {
      var status = card.querySelector('[data-dv-page-status]');
      var isReady = Boolean(hasTitle && hasSlug && !hasConflict);
      var text;

      if (!status) {
        return;
      }

      text = hasConflict
        ? status.getAttribute('data-conflict')
        : (isReady ? status.getAttribute('data-ready') : status.getAttribute('data-missing'));

      status.classList.toggle('is-error', hasConflict);
      status.classList.toggle('is-on', !hasConflict && isReady);
      status.classList.toggle('is-off', !hasConflict && !isReady);
      status.textContent = text || '';
    }

    function updateOpenAction(card, slug, isEnabled, hasConflict) {
      var action = card.querySelector('[data-dv-open-page]');
      var canOpen = Boolean(isEnabled && slug && !hasConflict);

      if (!action) {
        return;
      }

      action.hidden = !canOpen;
      action.setAttribute('aria-disabled', canOpen ? 'false' : 'true');
      action.href = canOpen ? getFullUrl(slug) : '#';
    }

    function updateCard(card, slugCounts) {
      var slot = card.getAttribute('data-dv-custom-page-card');
      var slug = normalizeSlug(getInputValue(slot, 'slug'));
      var hasSlug = Boolean(slug);
      var hasTitle = Boolean(getInputValue(slot, 'title'));
      var isEnabled = isInputChecked(slot, 'enabled');
      var hasConflict = Boolean(hasSlug && (reservedSlugs.indexOf(slug) !== -1 || slugCounts[slug] > 1));
      var cardsCount = getCardCount(slot);
      var ctaReady = Boolean(getInputValue(slot, 'cta_label') && getInputValue(slot, 'cta_url'));
      var seoReady = Boolean(getInputValue(slot, 'seo_title') && getInputValue(slot, 'seo_description'));
      var checks = [
        hasTitle,
        Boolean(hasSlug && !hasConflict),
        Boolean(getInputValue(slot, 'intro')),
        Boolean(getInputValue(slot, 'body')),
        cardsCount > 0,
        ctaReady,
        seoReady
      ];
      var percent = Math.round((checks.filter(Boolean).length / checks.length) * 100);
      var percentNode = card.querySelector('[data-dv-readiness-percent]');
      var barNode = card.querySelector('[data-dv-readiness-bar]');
      var readinessNode = card.querySelector('[data-dv-custom-page-readiness]');
      var cardsStatus = card.querySelector('[data-dv-cards-status]');
      var ctaStatus = card.querySelector('[data-dv-cta-status]');
      var seoStatus = card.querySelector('[data-dv-seo-status]');
      var cardsLabel = cardsStatus ? (cardsStatus.getAttribute('data-label') || cardsLabelFallback) : cardsLabelFallback;

      card.classList.toggle('has-conflict', hasConflict);
      card.classList.toggle('is-ready', Boolean(isEnabled && hasTitle && hasSlug && !hasConflict));

      if (percentNode) {
        percentNode.textContent = percent + '%';
      }

      if (barNode) {
        barNode.style.width = percent + '%';
      }

      if (readinessNode) {
        readinessNode.setAttribute('aria-label', 'Готовность: ' + percent + '%');
      }

      toggleStatus(cardsStatus, cardsCount > 0, cardsLabel + ': ' + cardsCount);
      toggleStatus(ctaStatus, ctaReady, ctaStatus ? (ctaReady ? ctaStatus.getAttribute('data-ready') : ctaStatus.getAttribute('data-empty')) : '');
      toggleStatus(seoStatus, seoReady, seoStatus ? (seoReady ? seoStatus.getAttribute('data-ready') : seoStatus.getAttribute('data-empty')) : '');
      updatePageUrlNodes(slot, card, slug, hasConflict);
      updatePageStatus(card, hasTitle, hasSlug, hasConflict);
      updateOpenAction(card, slug, isEnabled, hasConflict);
    }

    function updateAll() {
      var slugCounts = getSlugMap();

      cards.forEach(function (card) {
        updateCard(card, slugCounts);
      });
    }

    if (!cards.length) {
      return;
    }

    cards.forEach(function (card) {
      var slot = card.getAttribute('data-dv-custom-page-card');
      var suffixes = [
        'title',
        'enabled',
        'slug',
        'intro',
        'body',
        'cta_label',
        'cta_url',
        'seo_title',
        'seo_description',
        'card_1_title',
        'card_1_text',
        'card_2_title',
        'card_2_text',
        'card_3_title',
        'card_3_text'
      ];

      suffixes.forEach(function (suffix) {
        var node = getInput(slot, suffix);

        if (node) {
          node.addEventListener('input', updateAll);
          node.addEventListener('change', updateAll);
        }
      });
    });

    updateAll();
  }

  restoreAccordionState();
  setupNavCounters();
  setupSectionBadges();
  setupFieldGroups();
  setupCollapsibleFieldGroups();
  setupFieldStates();
  setupEmptyCounters();
  setupCustomPageSlugValidation();
  setupCustomPageCtaPresets();
  setupCustomPageSeoPreview();
  setupCustomPageCardPreview();
  setupCustomPageReadinessPreview();
  initMediaFields();
  updateFilterButtons();
  applyCurrentFilters();
  input.addEventListener('input', applySearch);
  input.addEventListener('keydown', function (event) {
    if (event.key === 'Enter') {
      event.preventDefault();
    }

    if (event.key === 'Escape') {
      input.value = '';
      clearSearch();
    }
  });

  if (clearButton) {
    clearButton.addEventListener('click', function () {
      clearSearch();
      input.focus();
    });
  }

  filterButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      setContentFilter(button.getAttribute('data-dv-content-filter'));
    });
  });

  if (emptyJumpButton) {
    emptyJumpButton.addEventListener('click', focusFirstEmptyField);
  }

  if (expandButton) {
    expandButton.addEventListener('click', function () {
      setAccordionOpen(true);
    });
  }

  if (collapseButton) {
    collapseButton.addEventListener('click', function () {
      setAccordionOpen(false);
    });
  }

  sections.concat(subsections).forEach(function (node) {
    if (typeof node.open === 'undefined') {
      return;
    }

    node.addEventListener('toggle', persistAccordionState);
  });
});
