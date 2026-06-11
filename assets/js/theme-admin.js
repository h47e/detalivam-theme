document.addEventListener('DOMContentLoaded', function () {
  setupSuiteHeader();
  setupBackToTop();
  setupLocalSearchShortcut();
  setupCommandPalette();
  setupConfirmActions();
  setupUnsavedForms();

  function setupSuiteHeader() {
    var header = document.querySelector('.dv-suite-header');

    if (!header) {
      return;
    }

    var ticking = false;
    var compactOffset = 0;

    function measure() {
      var rect = header.getBoundingClientRect();
      compactOffset = window.scrollY + rect.top + 72;
    }

    function update() {
      ticking = false;
      document.body.classList.toggle('dv-suite-header-compact', window.scrollY > compactOffset);
    }

    function requestUpdate() {
      if (ticking) {
        return;
      }

      ticking = true;
      window.requestAnimationFrame(update);
    }

    measure();
    update();

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', function () {
      document.body.classList.remove('dv-suite-header-compact');
      measure();
      requestUpdate();
    });
  }

  function setupBackToTop() {
    var page = document.querySelector('.dv-suite-page');
    var header = document.querySelector('.dv-suite-header');

    if (!page || !header) {
      return;
    }

    var button = document.createElement('button');
    var ticking = false;

    button.type = 'button';
    button.className = 'dv-suite-back-to-top';
    button.textContent = 'Наверх';
    button.setAttribute('aria-label', 'Вернуться к началу раздела ДеталиВам');

    document.body.appendChild(button);

    function update() {
      ticking = false;
      button.classList.toggle('is-visible', window.scrollY > 520);
    }

    function requestUpdate() {
      if (ticking) {
        return;
      }

      ticking = true;
      window.requestAnimationFrame(update);
    }

    button.addEventListener('click', function () {
      page.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
      });
    });

    update();
    window.addEventListener('scroll', requestUpdate, { passive: true });
  }

  function setupLocalSearchShortcut() {
    var selectors = [
      '#dv-theme-options-search',
      '#dv-store-settings-search',
      '#dv-theme-content-search',
      '#dv-uploads-filter',
      '[data-dv-seo-category-search]',
    ];

    function isTypingTarget(target) {
      if (!target) {
        return false;
      }

      if (target.isContentEditable) {
        return true;
      }

      var tagName = (target.tagName || '').toLowerCase();

      return ['input', 'textarea', 'select', 'button'].indexOf(tagName) !== -1;
    }

    function getVisibleSearch() {
      var page = document.querySelector('.dv-suite-page') || document;
      var inputs = [];

      selectors.forEach(function (selector) {
        page.querySelectorAll(selector).forEach(function (input) {
          if (inputs.indexOf(input) === -1) {
            inputs.push(input);
          }
        });
      });

      page.querySelectorAll('input[type="search"]').forEach(function (input) {
        if (input.id !== 'dv-suite-command-search' && inputs.indexOf(input) === -1) {
          inputs.push(input);
        }
      });

      inputs = inputs.filter(function (input) {
        return input && !input.disabled && input.offsetParent !== null;
      });

      return inputs[0] || null;
    }

    document.addEventListener('keydown', function (event) {
      if (event.key !== '/' || event.ctrlKey || event.metaKey || event.altKey) {
        return;
      }

      if (isTypingTarget(event.target) || document.body.classList.contains('dv-suite-command-open')) {
        return;
      }

      var search = getVisibleSearch();

      if (!search) {
        return;
      }

      event.preventDefault();
      search.focus();

      if (typeof search.select === 'function') {
        search.select();
      }
    });
  }

  function setupCommandPalette() {
    var openButton = document.getElementById('dv-suite-command-open');
    var command = document.getElementById('dv-suite-command');

    if (!openButton || !command) {
      return;
    }

    var search = document.getElementById('dv-suite-command-search');
    var items = Array.prototype.slice.call(command.querySelectorAll('.dv-suite-command-item'));
    var empty = command.querySelector('.dv-suite-command-empty');
    var closeButtons = Array.prototype.slice.call(command.querySelectorAll('[data-dv-command-close]'));
    var previousFocus = null;
    var activeIndex = -1;

    function getVisibleItems() {
      return items.filter(function (item) {
        return !item.hidden;
      });
    }

    function setActiveItem(nextIndex) {
      var visibleItems = getVisibleItems();

      items.forEach(function (item) {
        item.classList.remove('is-active');
        item.setAttribute('aria-selected', 'false');
      });

      if (!visibleItems.length) {
        activeIndex = -1;
        if (search) {
          search.removeAttribute('aria-activedescendant');
        }
        return;
      }

      activeIndex = Math.max(0, Math.min(nextIndex, visibleItems.length - 1));
      visibleItems[activeIndex].classList.add('is-active');
      visibleItems[activeIndex].setAttribute('aria-selected', 'true');

      if (search) {
        search.setAttribute('aria-activedescendant', visibleItems[activeIndex].id);
      }

      visibleItems[activeIndex].scrollIntoView({
        block: 'nearest',
      });
    }

    function filterItems() {
      var query = (search && search.value ? search.value : '').trim().toLowerCase();
      var visible = 0;

      items.forEach(function (item) {
        var haystack = item.getAttribute('data-search') || item.textContent || '';
        var isVisible = !query || haystack.toLowerCase().indexOf(query) !== -1;
        item.hidden = !isVisible;

        if (isVisible) {
          visible += 1;
        }
      });

      if (empty) {
        empty.hidden = visible !== 0;
      }

      setActiveItem(0);
    }

    function openCommand() {
      previousFocus = document.activeElement;
      command.hidden = false;
      document.body.classList.add('dv-suite-command-open');
      openButton.setAttribute('aria-expanded', 'true');

      if (search) {
        search.value = '';
        filterItems();
        window.setTimeout(function () {
          search.focus();
        }, 0);
      }
    }

    function closeCommand() {
      command.hidden = true;
      document.body.classList.remove('dv-suite-command-open');
      openButton.setAttribute('aria-expanded', 'false');

      if (previousFocus && typeof previousFocus.focus === 'function') {
        previousFocus.focus();
      }
    }

    openButton.setAttribute('aria-expanded', 'false');
    openButton.setAttribute('aria-controls', 'dv-suite-command');
    openButton.addEventListener('click', openCommand);

    closeButtons.forEach(function (button) {
      button.addEventListener('click', closeCommand);
    });

    if (search) {
      search.addEventListener('input', filterItems);
      search.addEventListener('keydown', function (event) {
        var key = event.key || '';
        var visibleItems = getVisibleItems();

        if (!visibleItems.length) {
          return;
        }

        if (key === 'ArrowDown') {
          event.preventDefault();
          setActiveItem(activeIndex + 1);
        }

        if (key === 'ArrowUp') {
          event.preventDefault();
          setActiveItem(activeIndex - 1);
        }

        if (key === 'Home') {
          event.preventDefault();
          setActiveItem(0);
        }

        if (key === 'End') {
          event.preventDefault();
          setActiveItem(visibleItems.length - 1);
        }

        if (key === 'Enter' && activeIndex >= 0) {
          event.preventDefault();
          visibleItems[activeIndex].click();
        }
      });
    }

    command.addEventListener('click', function (event) {
      if (event.target && event.target.closest && event.target.closest('.dv-suite-command-item')) {
        closeCommand();
      }
    });

    document.addEventListener('keydown', function (event) {
      var key = event.key || '';
      var isCommandShortcut = (event.ctrlKey || event.metaKey) && key.toLowerCase() === 'k';

      if (isCommandShortcut) {
        event.preventDefault();
        if (command.hidden) {
          openCommand();
        } else {
          closeCommand();
        }
        return;
      }

      if (key === 'Escape' && !command.hidden) {
        event.preventDefault();
        closeCommand();
      }
    });
  }

  function setupConfirmActions() {
    var announcer = document.createElement('div');

    announcer.className = 'screen-reader-text';
    announcer.setAttribute('role', 'status');
    announcer.setAttribute('aria-live', 'polite');
    document.body.appendChild(announcer);

    document.addEventListener('click', function (event) {
      var trigger = event.target && event.target.closest
        ? event.target.closest('[data-dv-confirm]')
        : null;

      if (!trigger || trigger.disabled || trigger.getAttribute('aria-disabled') === 'true') {
        return;
      }

      var message = trigger.getAttribute('data-dv-confirm') || '';

      if (!message || window.confirm(message)) {
        return;
      }

      event.preventDefault();
      event.stopPropagation();
      announcer.textContent = 'Действие отменено.';
    }, true);
  }

  function setupUnsavedForms() {
    var forms = Array.prototype.slice.call(document.querySelectorAll('[data-dv-unsaved-form]'));
    var isSubmitting = false;

    if (!forms.length) {
      return;
    }

    var labels = window.dvThemeAdmin || {};
    var bar = document.createElement('div');
    var message = document.createElement('strong');
    var counter = document.createElement('button');
    var saveButton = document.createElement('button');

    bar.className = 'dv-suite-dirty-bar';
    bar.setAttribute('role', 'status');
    bar.setAttribute('aria-live', 'polite');

    message.textContent = labels.unsavedMessage || 'Unsaved changes';
    counter.type = 'button';
    counter.className = 'dv-suite-dirty-count';
    counter.setAttribute('aria-label', 'Перейти к первому изменённому полю');
    saveButton.type = 'button';
    saveButton.className = 'button button-primary';
    saveButton.textContent = labels.saveLabel || 'Save';

    bar.appendChild(message);
    bar.appendChild(counter);
    bar.appendChild(saveButton);
    document.body.appendChild(bar);

    function isTrackableControl(control) {
      var type = (control.getAttribute('type') || '').toLowerCase();
      var excludedTypes = ['button', 'submit', 'reset', 'hidden', 'search'];

      return control.name && excludedTypes.indexOf(type) === -1 && !control.disabled;
    }

    function getControlValue(control) {
      var type = (control.getAttribute('type') || '').toLowerCase();

      if (type === 'checkbox' || type === 'radio') {
        return control.checked ? '1' : '0';
      }

      if (control.tagName === 'SELECT' && control.multiple) {
        return Array.prototype.slice.call(control.options)
          .filter(function (option) {
            return option.selected;
          })
          .map(function (option) {
            return option.value;
          })
          .join('|');
      }

      return control.value;
    }

    function getFieldWrapper(control) {
      return control.closest('.dv-admin-field, .dv-admin-check, tr, label');
    }

    function getDirtyControls() {
      var dirtyControls = [];

      forms.forEach(function (form) {
        var controls = Array.prototype.slice.call(form.querySelectorAll('input, textarea, select'));

        controls.forEach(function (control) {
          if (!isTrackableControl(control)) {
            return;
          }

          if (getControlValue(control) !== (control.dataset.dvInitialValue || '')) {
            dirtyControls.push(control);
          }
        });
      });

      return dirtyControls;
    }

    function updateDirtyState() {
      var dirtyControls = getDirtyControls();
      var dirtyForms = [];
      var dirtyNames = {};

      forms.forEach(function (form) {
        form.querySelectorAll('.is-dv-field-dirty').forEach(function (element) {
          element.classList.remove('is-dv-field-dirty');
        });
        form.dataset.dvDirty = '0';
      });

      dirtyControls.forEach(function (control) {
        var wrapper = getFieldWrapper(control);
        dirtyNames[control.name] = true;

        if (dirtyForms.indexOf(control.form) === -1) {
          dirtyForms.push(control.form);
        }

        if (wrapper) {
          wrapper.classList.add('is-dv-field-dirty');
        }
      });

      dirtyForms.forEach(function (form) {
        if (form) {
          form.dataset.dvDirty = '1';
        }
      });

      var dirtyCount = Object.keys(dirtyNames).length;
      var hasDirtyForm = dirtyCount > 0;

      counter.textContent = hasDirtyForm ? (labels.dirtyCount || 'Changed fields:') + ' ' + dirtyCount : '';
      counter.hidden = !hasDirtyForm;
      document.body.classList.toggle('dv-suite-has-dirty-form', hasDirtyForm);
    }

    function focusFirstDirtyControl() {
      var dirtyControl = getDirtyControls()[0];

      if (!dirtyControl) {
        return;
      }

      var wrapper = getFieldWrapper(dirtyControl) || dirtyControl;

      revealDirtyControl(dirtyControl);

      wrapper.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
      });

      wrapper.classList.add('is-dv-field-focus');

      window.setTimeout(function () {
        if (typeof dirtyControl.focus === 'function') {
          dirtyControl.focus({
            preventScroll: true,
          });
        }
      }, 260);

      window.setTimeout(function () {
        wrapper.classList.remove('is-dv-field-focus');
      }, 1600);
    }

    function submitForm(form) {
      if (!form) {
        return;
      }

      if (typeof form.requestSubmit === 'function') {
        form.requestSubmit();
      } else {
        isSubmitting = true;
        form.submit();
      }
    }

    function getPreferredSaveForm() {
      var activeForm = document.activeElement && document.activeElement.closest
        ? document.activeElement.closest('[data-dv-unsaved-form]')
        : null;

      if (activeForm) {
        return activeForm;
      }

      return forms.find(function (item) {
        return item.dataset.dvDirty === '1';
      }) || null;
    }

    function clearPageSearch(control) {
      var optionsPage = control.closest('.dv-theme-options-page');
      var contentSearch = document.getElementById('dv-theme-content-search');
      var contentClear = document.getElementById('dv-theme-content-search-clear');

      if (optionsPage && optionsPage.classList.contains('is-searching-options')) {
        var optionsSearch = optionsPage.querySelector('#dv-theme-options-search');
        var optionsClear = optionsPage.querySelector('#dv-theme-options-search-clear');

        if (optionsSearch) {
          optionsSearch.value = '';
        }

        if (optionsClear) {
          optionsClear.click();
        }
      }

      if (contentSearch && contentSearch.value) {
        contentSearch.value = '';

        if (contentClear) {
          contentClear.click();
        }
      }
    }

    function revealDirtyControl(control) {
      var optionsPanel = control.closest('.dv-theme-options-page .dv-admin-card[id^="dv-options-"]');
      var storeSection = control.closest('[data-dv-store-section]');
      var detailsNodes = [];
      var node = control.parentElement;

      clearPageSearch(control);

      if (optionsPanel && optionsPanel.hidden) {
        var optionsLink = document.querySelector('.dv-theme-options-page .dv-admin-nav a[href="#' + optionsPanel.id + '"]');

        if (optionsLink) {
          optionsLink.click();
        } else {
          optionsPanel.hidden = false;
        }
      }

      if (storeSection) {
        var storeToggle = storeSection.querySelector('.dv-store-section-toggle');

        storeSection.hidden = false;
        storeSection.classList.remove('is-collapsed');
        storeSection.setAttribute('aria-expanded', 'true');

        if (storeToggle) {
          storeToggle.setAttribute('aria-expanded', 'true');
          storeToggle.textContent = storeToggle.getAttribute('data-open-label') || storeToggle.textContent;
        }
      }

      while (node) {
        if (node.tagName === 'DETAILS') {
          detailsNodes.unshift(node);
        }

        node = node.parentElement;
      }

      detailsNodes.forEach(function (details) {
        details.hidden = false;
        details.open = true;
      });
    }

    forms.forEach(function (form) {
      var controls = Array.prototype.slice.call(form.querySelectorAll('input, textarea, select'));

      controls.forEach(function (control) {
        if (isTrackableControl(control)) {
          control.dataset.dvInitialValue = getControlValue(control);
        }
      });

      form.addEventListener('input', function (event) {
        if (event.target && event.target.closest('.dv-suite-command')) {
          return;
        }

        updateDirtyState();
      });

      form.addEventListener('change', function () {
        updateDirtyState();
      });

      form.addEventListener('submit', function () {
        isSubmitting = true;
        document.body.classList.remove('dv-suite-has-dirty-form');
      });
    });

    saveButton.addEventListener('click', function () {
      submitForm(getPreferredSaveForm());
    });

    counter.addEventListener('click', focusFirstDirtyControl);

    document.addEventListener('keydown', function (event) {
      var key = event.key || '';
      var isSaveShortcut = (event.ctrlKey || event.metaKey) && key.toLowerCase() === 's';

      if (!isSaveShortcut) {
        return;
      }

      event.preventDefault();
      submitForm(getPreferredSaveForm());
    });

    window.addEventListener('beforeunload', function (event) {
      if (isSubmitting || !getDirtyControls().length) {
        return;
      }

      event.preventDefault();
      event.returnValue = '';
    });
  }
});
