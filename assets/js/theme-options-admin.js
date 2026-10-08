(function () {
    'use strict';

    const STORAGE_KEY = 'dvThemeOptionsActivePanel';
    const VIEW_MODE_STORAGE_KEY = 'dvThemeOptionsViewMode';

    function updateSaveVisibility(page) {
        const cluster = page.querySelector('.dv-admin-save-cluster');
        const panel = page.querySelector('.dv-admin-card.is-active');
        if (cluster) {
            cluster.hidden = !page.classList.contains('has-unsaved-changes')
                && !page.classList.contains('is-searching-options')
                && !(panel && panel.querySelector('[name^="dv_theme_options["]'));
        }
    }

    function refreshGroupToggle(panel) {
        if (!panel) return;
        const button = panel.querySelector('[data-dv-groups-toggle]');
        if (!button) return;
        const groups = Array.from(panel.querySelectorAll('.dv-admin-field-group')).filter(group => !group.hidden);
        button.hidden = groups.length < 2;
        button.textContent = groups.some(group => group.classList.contains('is-collapsed')) ? 'Раскрыть группы' : 'Свернуть группы';
    }

    function readOptionViewMode() {
        try {
            return window.localStorage.getItem(VIEW_MODE_STORAGE_KEY) === 'all' ? 'all' : 'basic';
        } catch (error) {
            return 'basic';
        }
    }

    function writeOptionViewMode(mode) {
        try {
            window.localStorage.setItem(VIEW_MODE_STORAGE_KEY, mode === 'all' ? 'all' : 'basic');
        } catch (error) {}
    }

    function applyOptionViewMode(page, mode) {
        const nextMode = mode === 'all' ? 'all' : 'basic';
        const isSearching = page.classList.contains('is-searching-options');

        page.dataset.dvOptionsViewMode = nextMode;

        page.querySelectorAll('.dv-admin-field-group[data-dv-advanced="1"]').forEach((group) => {
            group.hidden = !isSearching && nextMode === 'basic';
        });

        page.querySelectorAll('[data-dv-options-view-mode]').forEach((button) => {
            const isActive = button.dataset.dvOptionsViewMode === nextMode;
            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
        page.querySelectorAll('.dv-admin-card').forEach(refreshGroupToggle);
    }

    function setActiveGroup(page, groupId) {
        const groupButtons = Array.from(page.querySelectorAll('.dv-admin-mode-nav [data-dv-options-group]'));
        const links = Array.from(page.querySelectorAll('.dv-admin-nav a[data-dv-options-group]'));
        const nextGroup = groupId || (links[0] ? links[0].dataset.dvOptionsGroup : '');

        if (!nextGroup || page.classList.contains('is-searching-options')) {
            return;
        }

        groupButtons.forEach((button) => {
            const isActive = button.dataset.dvOptionsGroup === nextGroup;
            button.classList.toggle('is-active', isActive);
            button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            button.tabIndex = isActive ? 0 : -1;
        });

        links.forEach((link) => {
            link.hidden = link.dataset.dvOptionsGroup !== nextGroup;
        });

        page.dataset.dvActiveOptionsGroup = nextGroup;
    }

    function setupGroupNavigation(page, activateTarget) {
        const groupButtons = Array.from(page.querySelectorAll('.dv-admin-mode-nav [data-dv-options-group]'));
        const links = Array.from(page.querySelectorAll('.dv-admin-nav a[data-dv-options-group]'));

        groupButtons.forEach((button, buttonIndex) => {
            button.addEventListener('click', () => {
                const groupId = button.dataset.dvOptionsGroup || '';
                const firstLink = links.find((link) => link.dataset.dvOptionsGroup === groupId);

                if (firstLink) {
                    activateTarget(firstLink.getAttribute('href'));
                }
            });

            button.addEventListener('keydown', (event) => {
                if (!['ArrowLeft', 'ArrowRight', 'Home', 'End'].includes(event.key)) {
                    return;
                }

                event.preventDefault();

                let nextIndex = buttonIndex;
                if (event.key === 'Home') {
                    nextIndex = 0;
                } else if (event.key === 'End') {
                    nextIndex = groupButtons.length - 1;
                } else {
                    const direction = event.key === 'ArrowRight' ? 1 : -1;
                    nextIndex = (buttonIndex + direction + groupButtons.length) % groupButtons.length;
                }

                groupButtons[nextIndex].focus();
                groupButtons[nextIndex].click();
            });
        });
    }

    function readActiveTarget() {
        try {
            return window.localStorage.getItem(STORAGE_KEY) || '';
        } catch (error) {
            return '';
        }
    }

    function writeActiveTarget(targetId) {
        try {
            window.localStorage.setItem(STORAGE_KEY, targetId || '');
        } catch (error) {}
    }

    function setFieldGroupExpanded(group, isExpanded) {
        const body = group.querySelector('.dv-admin-field-group-body');
        const toggle = group.querySelector('.dv-admin-field-group-toggle');
        const toggleText = group.querySelector('.dv-admin-field-group-toggle-text');

        group.classList.toggle('is-collapsed', !isExpanded);

        if (body) {
            body.hidden = !isExpanded;
        }

        if (toggle) {
            toggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
        }

        if (toggleText) {
            toggleText.textContent = isExpanded ? 'Свернуть' : 'Раскрыть';
        }
        refreshGroupToggle(group.closest('.dv-admin-card'));
    }

    function formatOptionCount(count) {
        if (count === 1) {
            return '1 настройка';
        }

        if (count > 1 && count < 5) {
            return `${count} настройки`;
        }

        return `${count} настроек`;
    }

    function getFormSignature(form) {
        const entries = Array.from(new FormData(form).entries())
            .map(([key, value]) => [key, String(value)])
            .sort(([keyA, valueA], [keyB, valueB]) => {
                if (keyA === keyB) {
                    return valueA.localeCompare(valueB);
                }

                return keyA.localeCompare(keyB);
            });

        return JSON.stringify(entries);
    }

    function setupUnsavedState(page) {
        const form = page.querySelector('form[data-dv-unsaved-form]');
        const indicator = page.querySelector('.dv-admin-unsaved-indicator');
        const submitButton = form ? form.querySelector('.dv-admin-toolbar .button-primary') : null;

        if (!form || !indicator || !submitButton) {
            return;
        }

        let initialSignature = getFormSignature(form);
        let isSubmitting = false;

        function updateState() {
            const hasChanges = getFormSignature(form) !== initialSignature;

            page.classList.toggle('has-unsaved-changes', hasChanges);
            indicator.hidden = !hasChanges;
            submitButton.classList.toggle('is-attention-needed', hasChanges);
            updateSaveVisibility(page);
        }

        form.addEventListener('input', updateState);
        form.addEventListener('change', updateState);
        form.addEventListener('submit', () => {
            isSubmitting = true;
            initialSignature = getFormSignature(form);
            page.classList.remove('has-unsaved-changes');
            indicator.hidden = true;
            submitButton.classList.remove('is-attention-needed');
        });

        window.addEventListener('beforeunload', (event) => {
            if (isSubmitting || getFormSignature(form) === initialSignature) {
                return;
            }

            event.preventDefault();
            event.returnValue = '';
        });
    }

    function activateTab(page, targetId, shouldPushState) {
        if (page.classList.contains('is-searching-options')) {
            return;
        }

        const links = page.querySelectorAll('.dv-admin-nav a[href^="#dv-options-"]');
        const panels = page.querySelectorAll('.dv-admin-card[id^="dv-options-"]');
        const nextPanel = document.getElementById((targetId || '').replace(/^#/, ''));

        if (!nextPanel || !page.contains(nextPanel) || !nextPanel.matches('.dv-admin-card[id^="dv-options-"]')) {
            return;
        }

        const activeLink = Array.from(links).find((link) => link.getAttribute('href') === targetId);
        setActiveGroup(page, activeLink ? activeLink.dataset.dvOptionsGroup : '');

        links.forEach((link) => {
            const isActive = link.getAttribute('href') === targetId;
            link.classList.toggle('is-active', isActive);
            link.setAttribute('aria-current', isActive ? 'page' : 'false');
        });

        panels.forEach((panel) => {
            const isActive = `#${panel.id}` === targetId;
            panel.classList.toggle('is-active', isActive);
            panel.hidden = !isActive;
        });

        if (shouldPushState && window.history && window.history.replaceState) {
            window.history.replaceState(null, '', targetId);
        }

        writeActiveTarget(targetId);
        updateSaveVisibility(page);
    }

    function setupSettingsSearch(page, getActiveTarget, setActiveTarget) {
        const search = page.querySelector('#dv-theme-options-search');
        const clearButton = page.querySelector('#dv-theme-options-search-clear');
        const counter = page.querySelector('#dv-theme-options-search-count');
        const fields = Array.from(page.querySelectorAll('.dv-admin-field, .dv-admin-check, .dv-admin-order-item'));
        const orderDetails = Array.from(page.querySelectorAll('details.dv-admin-order-grid'));
        const groups = Array.from(page.querySelectorAll('.dv-admin-field-group'));
        const panels = Array.from(page.querySelectorAll('.dv-admin-card[id^="dv-options-"]'));
        const links = Array.from(page.querySelectorAll('.dv-admin-nav a[href^="#dv-options-"]'));

        if (!search || !fields.length) {
            return;
        }

        const countLabel = search.dataset.countLabel || 'Found';
        const emptyText = search.dataset.emptyText || 'Nothing found';

        function getPanelLink(panel) {
            return links.find((link) => link.getAttribute('href') === `#${panel.id}`);
        }

        function clearSearchState(targetId) {
            orderDetails.forEach((details) => {
                details.hidden = false;
                if (details.dataset.dvSearchOpened === '1') {
                    details.open = false;
                    delete details.dataset.dvSearchOpened;
                }
            });
            fields.forEach((field) => {
                field.hidden = false;
                field.classList.remove('is-options-search-match');
            });

            groups.forEach((group) => {
                group.hidden = false;
                setFieldGroupExpanded(group, group.dataset.dvDefaultExpanded !== '0');
            });

            panels.forEach((panel) => {
                panel.classList.remove('is-options-search-result');
                panel.hidden = true;
            });

            links.forEach((link) => {
                link.hidden = false;
            });

            page.classList.remove('is-searching-options');
            applyOptionViewMode(page, readOptionViewMode());
            if (counter) {
                counter.textContent = '';
            }

            activateTab(page, targetId || getActiveTarget(), false);
        }

        function applySearch() {
            const query = search.value.trim().toLowerCase();

            if (!query) {
                clearSearchState();
                return;
            }

            let matchedCount = 0;

            page.classList.add('is-searching-options');

            fields.forEach((field) => {
                const haystack = field.textContent.trim().toLowerCase();
                const isMatch = haystack.indexOf(query) !== -1;

                field.hidden = !isMatch;
                field.classList.toggle('is-options-search-match', isMatch);

                if (isMatch) {
                    matchedCount += 1;
                }
            });

            orderDetails.forEach((details) => {
                const hasMatches = Boolean(details.querySelector('.is-options-search-match'));
                details.hidden = !hasMatches;
                if (hasMatches && !details.open) {
                    details.dataset.dvSearchOpened = '1';
                    details.open = true;
                }
            });

            groups.forEach((group) => {
                const hasGroupMatch = Boolean(group.querySelector('.is-options-search-match'));

                group.hidden = !hasGroupMatch;

                if (hasGroupMatch) {
                    setFieldGroupExpanded(group, true);
                }
            });

            panels.forEach((panel) => {
                const hasMatches = Boolean(panel.querySelector('.is-options-search-match'));
                const link = getPanelLink(panel);

                panel.hidden = !hasMatches;
                panel.classList.toggle('is-options-search-result', hasMatches);

                if (link) {
                    link.hidden = !hasMatches;
                    link.classList.toggle('is-active', false);
                    link.setAttribute('aria-current', 'false');
                }
            });

            if (counter) {
                counter.textContent = matchedCount ? `${countLabel}: ${matchedCount}` : emptyText;
            }
            updateSaveVisibility(page);
        }

        search.addEventListener('input', applySearch);
        search.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
            }

            if (event.key === 'Escape') {
                search.value = '';
                clearSearchState();
            }
        });

        if (clearButton) {
            clearButton.addEventListener('click', () => {
                search.value = '';
                clearSearchState();
                search.focus();
            });
        }

        links.forEach((link) => {
            link.addEventListener('click', () => {
                const targetId = link.getAttribute('href');

                if (search.value) {
                    search.value = '';
                    setActiveTarget(targetId);
                    clearSearchState(targetId);
                    return;
                }

                setActiveTarget(targetId);
            });
        });

        const requestedSearch = new URLSearchParams(window.location.search).get('dv-settings-search');

        if (requestedSearch) {
            search.value = requestedSearch;
            applySearch();
            search.focus({ preventScroll: true });
            search.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function setupNavCounters(page) {
        const links = Array.from(page.querySelectorAll('.dv-admin-nav a[href^="#dv-options-"]'));

        links.forEach((link) => {
            const targetId = link.getAttribute('href') || '';
            const panel = targetId ? page.querySelector(targetId) : null;

            if (!panel || link.querySelector('.dv-admin-nav-count')) {
                return;
            }

            const count = panel.querySelectorAll('.dv-admin-field, .dv-admin-check, .dv-admin-order-item').length;

            if (!count) {
                return;
            }

            const badge = document.createElement('span');
            badge.className = 'dv-admin-nav-count';
            badge.textContent = String(count);
            link.appendChild(badge);
        });
    }

    function setupQuickWorkflows(page, activateTarget) {
        const search = page.querySelector('#dv-theme-options-search');
        const workflows = Array.from(page.querySelectorAll('[data-dv-options-target]'));

        workflows.forEach((workflow) => {
            workflow.addEventListener('click', (event) => {
                const targetId = workflow.dataset.dvOptionsTarget || '';
                const searchQuery = workflow.dataset.dvOptionsSearch || '';

                if (!targetId || !page.querySelector(targetId)) {
                    return;
                }

                event.preventDefault();

                const drawer = workflow.closest('.dv-admin-workflow-drawer');
                if (drawer) {
                    drawer.open = false;
                }

                if (search) {
                    search.value = '';
                    search.dispatchEvent(new Event('input', { bubbles: true }));
                }

                activateTarget(targetId);

                if (search && searchQuery) {
                    search.value = searchQuery;
                    search.dispatchEvent(new Event('input', { bubbles: true }));
                    search.focus();
                }

                const toolbar = page.querySelector('.dv-admin-toolbar');
                if (toolbar && !searchQuery) {
                    toolbar.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    }

    function setupOptionGroups(page) {
        const headerPanel = page.querySelector('#dv-options-header');
        const catalogPanel = page.querySelector('#dv-options-catalog');
        const footerPanel = page.querySelector('#dv-options-footer');

        if (headerPanel && catalogPanel) {
            catalogPanel.querySelectorAll('[data-dv-option-key]').forEach((field) => {
                const key = field.dataset.dvOptionKey || '';
                if (key.startsWith('header_') || key.startsWith('topbar_')) {
                    headerPanel.appendChild(field);
                } else if (key === 'footer_categories_limit' && footerPanel) {
                    footerPanel.appendChild(field);
                }
            });
        }
        const definitions = {
            'dv-options-visual': [
                {
                    title: 'Пресеты и палитра',
                    description: 'Общий вид и цветовая схема.',
                    keys: [
                        'theme_visual_preset',
                        'theme_color_scheme',
                    ],
                },
                {
                    title: 'Габариты интерфейса',
                    description: 'Ширина, скругления, отступы и тени.',
                    keys: [
                        'theme_radius_style',
                        'theme_layout_width',
                        'theme_density_style',
                        'theme_shadow_style',
                    ],
                },
                {
                    title: 'Шапка, футер и карточки',
                    description: 'Основные блоки, фото и карточки товаров.',
                    keys: [
                        'theme_header_style',
                        'theme_footer_style',
                        'theme_card_style',
                        'theme_card_image_ratio',
                        'theme_card_image_padding',
                        'theme_card_hover_style',
                        'theme_card_title_lines',
                    ],
                },
            ],
            'dv-options-header': [
                {
                    title: 'Контакты и кнопки',
                    description: 'Город, телефон, поиск и быстрые действия.',
                    keys: [
                        'header_topbar_enabled',
                        'topbar_city_enabled',
                        'topbar_phone_enabled',
                        'topbar_shop_enabled',
                        'topbar_delivery_enabled',
                        'topbar_about_enabled',
                        'topbar_contacts_enabled',
                        'header_search_enabled',
                        'header_actions_enabled',
                        'header_compare_enabled',
                        'header_wishlist_enabled',
                        'header_cart_enabled',
                        'header_ozon_enabled',
                        'header_account_enabled',
                    ],
                },
                {
                    title: 'Меню категорий',
                    description: 'Категории и ссылки верхнего меню.',
                    advanced: false,
                    keys: [
                        'header_catalog_dropdown_enabled',
                        'header_nav_links_enabled',
                        'header_categories_limit',
                    ],
                },
            ],
            'dv-options-catalog': [
                {
                    title: 'Сетка товаров',
                    description: 'Количество товаров и колонок.',
                    keys: ['catalog_per_page', 'catalog_columns'],
                },
                {
                    title: 'Фильтры каталога',
                    advanced: false,
                    description: 'Подбор, цена, наличие и рекомендации.',
                    keys: [
                        'catalog_marka_limit',
                        'catalog_category_limit',
                        'catalog_path_enabled',
                        'catalog_marka_enabled',
                        'catalog_categories_enabled',
                        'catalog_price_enabled',
                        'catalog_stock_enabled',
                        'catalog_recs_enabled',
                        'catalog_recs_limit',
                    ],
                },
            ],
            'dv-options-catalog-card': [
                {
                    title: 'Состав карточки',
                    description: 'Элементы карточки в списке товаров.',
                    keys: [
                        'catalog_card_badges_enabled',
                        'catalog_card_actions_enabled',
                        'catalog_card_compat_enabled',
                        'catalog_card_rating_enabled',
                        'catalog_card_sku_enabled',
                        'catalog_card_stock_qty_enabled',
                    ],
                },
            ],
            'dv-options-home': [
                {
                    title: 'Товарные блоки',
                    description: 'Количество колонок в подборках на главной странице.',
                    keys: [
                        'home_product_columns',
                    ],
                },
            ],
            'dv-options-search': [
                {
                    title: 'Поиск',
                    description: 'Лимиты live-search и полной страницы результатов.',
                    keys: [
                        'search_live_limit',
                        'search_page_per_page',
                    ],
                },
                {
                    title: 'Страница 404',
                    description: 'Поиск, быстрые действия и популярные разделы на странице ошибки.',
                    keys: [
                        'not_found_categories_limit',
                        'not_found_search_enabled',
                        'not_found_actions_enabled',
                        'not_found_categories_enabled',
                    ],
                },
            ],
            'dv-options-footer': [
                {
                    title: 'Основные колонки',
                    description: 'Бренд, контакты и ссылки.',
                    keys: [
                        'footer_brand_enabled',
                        'footer_description_enabled',
                        'footer_contacts_enabled',
                        'footer_catalog_enabled',
                        'footer_categories_limit',
                        'footer_customers_enabled',
                        'footer_company_enabled',
                    ],
                },
                {
                    title: 'Нижняя строка',
                    description: 'Копирайт, способы оплаты и документы.',
                    keys: [
                        'footer_bottom_enabled',
                        'footer_payment_icons_enabled',
                        'footer_legal_links_enabled',
                        'footer_privacy_enabled',
                        'footer_offer_enabled',
                    ],
                },
                {
                    title: 'Отдельные ссылки',
                    description: 'Точные переключатели ссылок в колонках покупателей и компании.',
                    keys: [
                        'footer_customers_1_enabled',
                        'footer_customers_2_enabled',
                        'footer_customers_3_enabled',
                        'footer_customers_4_enabled',
                        'footer_customers_5_enabled',
                        'footer_company_1_enabled',
                        'footer_company_2_enabled',
                        'footer_company_3_enabled',
                        'footer_company_4_enabled',
                    ],
                },
            ],
            'dv-options-cart': [
                {
                    title: 'Таблица корзины',
                    description: 'Фото, цена и сумма в строках корзины.',
                    keys: [
                        'cart_product_image_enabled',
                        'cart_price_enabled',
                        'cart_subtotal_enabled',
                    ],
                },
                {
                    title: 'Промо и рекомендации',
                    description: 'Промокод и cross-sells под корзиной.',
                    keys: [
                        'cart_coupon_enabled',
                        'cart_cross_sells_enabled',
                    ],
                },
            ],
            'dv-options-checkout': [
                {
                    title: 'Оформление заказа',
                    description: 'Видимость штатных блоков WooCommerce на checkout.',
                    keys: [
                        'checkout_coupon_enabled',
                        'checkout_login_enabled',
                        'checkout_order_notes_enabled',
                    ],
                },
            ],
            'dv-options-product': [
                {
                    title: 'Верх карточки',
                    description: 'Галерея, артикул и короткое описание рядом с покупкой.',
                    keys: [
                        'product_gallery_hint_enabled',
                        'product_meta_sku_enabled',
                        'product_part_number_enabled',
                        'product_summary_description_enabled',
                    ],
                },
                {
                    title: 'Покупка и действия',
                    description: 'Избранное, сравнение и ссылка на маркетплейс в товаре.',
                    advanced: false,
                    keys: [
                        'product_actions_enabled',
                        'product_wishlist_enabled',
                        'product_compare_enabled',
                        'product_ozon_enabled',
                    ],
                },
                {
                    title: 'Нижние вкладки',
                    description: 'Описание, характеристики и отзывы под первым экраном товара.',
                    keys: [
                        'product_tab_description_enabled',
                        'product_tab_specs_enabled',
                        'product_tab_reviews_enabled',
                    ],
                },
                {
                    title: 'Рекомендации и сравнение',
                    description: 'Related, похожие товары, недавно просмотренные и лимит сравнения.',
                    keys: [
                        'product_related_enabled',
                        'product_related_limit',
                        'product_similar_enabled',
                        'product_similar_limit',
                        'product_recent_enabled',
                        'product_recent_limit',
                        'compare_limit',
                    ],
                },
            ],
            'dv-options-service': [
                {
                    title: 'Виртуальные страницы',
                    description: 'Включение служебных страниц, которые тема отдает без Elementor и отдельных файлов.',
                    keys: [
                        'service_about_enabled',
                        'service_delivery_enabled',
                        'service_contacts_enabled',
                        'service_return_enabled',
                        'service_privacy_enabled',
                        'service_agreement_enabled',
                    ],
                },
            ],
        };

        Object.entries(definitions).forEach(([panelId, groups]) => {
            const panel = page.querySelector(`#${panelId}`);

            if (!panel || panel.dataset.dvOptionGroupsReady === '1') {
                return;
            }

            const heading = panel.querySelector('h2');
            const visibleGroups = groups.filter((group) => {
                return group.keys.some((key) => panel.querySelector(`[data-dv-option-key="${key}"]`));
            });
            let insertAfter = panel.querySelector('.dv-settings-related-links') || heading;

            if (heading && visibleGroups.length > 1) {
                const panelTools = document.createElement('div');
                panelTools.className = 'dv-admin-panel-tools';

                const viewMode = document.createElement('div');
                viewMode.className = 'dv-admin-view-mode';
                viewMode.setAttribute('role', 'group');
                viewMode.setAttribute('aria-label', 'Объём настроек');

                [
                    ['basic', 'Основные'],
                    ['all', 'Все настройки'],
                ].forEach(([mode, label]) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.dataset.dvOptionsViewMode = mode;
                    button.setAttribute('aria-pressed', 'false');
                    button.textContent = label;
                    button.addEventListener('click', () => {
                        writeOptionViewMode(mode);
                        applyOptionViewMode(page, mode);
                    });
                    viewMode.appendChild(button);
                });

                const expandAll = document.createElement('button');
                expandAll.type = 'button';
                expandAll.className = 'dv-admin-panel-tool';
                expandAll.dataset.dvGroupsToggle = '1';
                expandAll.textContent = 'Раскрыть группы';

                expandAll.addEventListener('click', () => {
                    const visible = Array.from(panel.querySelectorAll('.dv-admin-field-group')).filter(group => !group.hidden);
                    const open = visible.some(group => group.classList.contains('is-collapsed'));
                    visible.forEach(group => setFieldGroupExpanded(group, open));
                    refreshGroupToggle(panel);
                });

                panelTools.append(viewMode, expandAll);
                insertAfter.insertAdjacentElement('afterend', panelTools);
                insertAfter = panelTools;
            }

            groups.forEach((group, groupIndex) => {
                const fields = group.keys
                    .map((key) => panel.querySelector(`[data-dv-option-key="${key}"]`))
                    .filter(Boolean);

                if (!fields.length) {
                    return;
                }

                const wrapper = document.createElement('section');
                wrapper.className = 'dv-admin-field-group';
                const isAdvanced = typeof group.advanced === 'boolean'
                    ? group.advanced
                    : groups.length > 1 && groupIndex > 0;

                wrapper.dataset.dvAdvanced = isAdvanced ? '1' : '0';

                const head = document.createElement('div');
                head.className = 'dv-admin-field-group-head';

                const copy = document.createElement('div');
                copy.className = 'dv-admin-field-group-copy';

                const title = document.createElement('h3');
                title.textContent = group.title;

                const description = document.createElement('p');
                description.textContent = group.description;

                const toggle = document.createElement('button');
                toggle.type = 'button';
                toggle.className = 'dv-admin-field-group-toggle';

                const count = document.createElement('span');
                count.className = 'dv-admin-field-group-count';
                count.textContent = formatOptionCount(fields.length);

                const toggleText = document.createElement('span');
                toggleText.className = 'dv-admin-field-group-toggle-text';

                const body = document.createElement('div');
                body.className = 'dv-admin-field-group-body';
                body.id = `${panelId}-group-${groupIndex + 1}`;

                const isCollapsed = groups.length > 1 && groupIndex > 0;

                wrapper.dataset.dvDefaultExpanded = isCollapsed ? '0' : '1';
                toggle.setAttribute('aria-controls', body.id);

                toggle.append(count, toggleText);
                toggle.addEventListener('click', () => {
                    const nextExpanded = wrapper.classList.contains('is-collapsed');
                    setFieldGroupExpanded(wrapper, nextExpanded);
                });

                copy.append(title, description);
                head.append(copy, toggle);
                wrapper.append(head, body);
                fields.forEach((field) => body.appendChild(field));
                setFieldGroupExpanded(wrapper, !isCollapsed);

                if (insertAfter && insertAfter.parentNode === panel) {
                    insertAfter.insertAdjacentElement('afterend', wrapper);
                } else {
                    panel.appendChild(wrapper);
                }

                insertAfter = wrapper;
            });

            panel.dataset.dvOptionGroupsReady = '1';
        });

        applyOptionViewMode(page, readOptionViewMode());
    }

    function setupVisualPreview(page) {
        const preview = page.querySelector('.dv-visual-preview');
        const state = preview ? preview.querySelector('.dv-visual-preview-state') : null;
        const deviceButtons = preview ? Array.from(preview.querySelectorAll('[data-dv-preview-device]')) : [];

        if (!preview) {
            return;
        }

        const bindings = [
            {
                key: 'theme_visual_preset',
                prefix: 'dv-preview-preset-',
                allowed: ['default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries'],
                fallback: 'default',
            },
            {
                key: 'theme_color_scheme',
                prefix: 'dv-preview-color-',
                allowed: ['preset', 'default', 'contrast', 'soft', 'graphite', 'ozon', 'market', 'wildberries'],
                fallback: 'preset',
            },
            {
                key: 'theme_layout_width',
                prefix: 'dv-preview-width-',
                allowed: ['contained', 'wide', 'fluid'],
                fallback: 'wide',
            },
            {
                key: 'theme_radius_style',
                prefix: 'dv-preview-radius-',
                allowed: ['sharp', 'soft', 'round'],
                fallback: 'soft',
            },
            {
                key: 'theme_density_style',
                prefix: 'dv-preview-density-',
                allowed: ['compact', 'balanced', 'air'],
                fallback: 'balanced',
            },
            {
                key: 'theme_shadow_style',
                prefix: 'dv-preview-shadow-',
                allowed: ['none', 'soft', 'deep'],
                fallback: 'soft',
            },
            {
                key: 'theme_header_style',
                prefix: 'dv-preview-header-',
                allowed: ['compact', 'balanced', 'wide-search'],
                fallback: 'balanced',
            },
            {
                key: 'theme_footer_style',
                prefix: 'dv-preview-footer-',
                allowed: ['compact', 'standard', 'spacious'],
                fallback: 'standard',
            },
            {
                key: 'theme_card_style',
                prefix: 'dv-preview-card-',
                allowed: ['standard', 'compact', 'showcase'],
                fallback: 'standard',
            },
            {
                key: 'theme_card_image_ratio',
                prefix: 'dv-preview-image-',
                allowed: ['square', 'portrait', 'wide'],
                fallback: 'square',
            },
            {
                key: 'theme_card_image_padding',
                prefix: 'dv-preview-padding-',
                allowed: ['tight', 'balanced', 'safe'],
                fallback: 'balanced',
            },
            {
                key: 'theme_card_hover_style',
                prefix: 'dv-preview-hover-',
                allowed: ['none', 'soft', 'lift'],
                fallback: 'soft',
            },
            {
                key: 'theme_card_title_lines',
                prefix: 'dv-preview-title-',
                allowed: ['two', 'three', 'four'],
                fallback: 'three',
            },
        ];

        const controls = bindings
            .map((binding) => {
                const selector = `[name="dv_theme_options[${binding.key}]"]`;
                const field = page.querySelector(selector);

                return field ? { ...binding, field, initialValue: field.value } : null;
            })
            .filter(Boolean);
        const controlsByKey = new Map(controls.map((binding) => [binding.key, binding]));
        const recipeSelect = preview.querySelector('#dv-visual-recipe-select');
        const recipeApply = preview.querySelector('[data-dv-apply-recipe]');
        const recipeOptions = Array.from(preview.querySelectorAll('option[data-dv-visual-recipe]'))
            .map((option) => {
                try {
                    const recipe = JSON.parse(option.dataset.dvVisualRecipe || '{}');

                    return recipe && typeof recipe === 'object'
                        ? { option, recipe }
                        : null;
                } catch (error) {
                    return null;
                }
            })
            .filter(Boolean);

        if (!controls.length) {
            return;
        }

        function normalizeValue(binding) {
            return binding.allowed.includes(binding.field.value) ? binding.field.value : binding.fallback;
        }

        function recipeMatches(recipe) {
            return Object.entries(recipe).every(([key, value]) => {
                const binding = controlsByKey.get(key);

                return binding ? normalizeValue(binding) === value : true;
            });
        }

        function syncPreview() {
            let hasDraft = false;

            controls.forEach((binding) => {
                const value = normalizeValue(binding);

                binding.allowed.forEach((choice) => {
                    preview.classList.remove(`${binding.prefix}${choice}`);
                });

                preview.classList.add(`${binding.prefix}${value}`);

                if (value !== binding.initialValue) {
                    hasDraft = true;
                }
            });

            preview.classList.toggle('is-live-preview', hasDraft);

            if (state) {
                state.textContent = hasDraft
                    ? state.dataset.liveLabel || state.textContent
                    : state.dataset.savedLabel || state.textContent;
            }

            if (recipeSelect) {
                const matching = recipeOptions.find(({ recipe }) => recipeMatches(recipe));
                recipeSelect.value = matching ? matching.option.value : '';
                if (recipeApply) recipeApply.disabled = !recipeSelect.value;
            }
        }

        function setPreviewDevice(device) {
            const nextDevice = device === 'mobile' ? 'mobile' : 'desktop';

            preview.classList.toggle('is-preview-mobile', nextDevice === 'mobile');

            deviceButtons.forEach((button) => {
                const isActive = button.dataset.dvPreviewDevice === nextDevice;

                button.classList.toggle('is-active', isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
        }

        controls.forEach((binding) => {
            binding.field.addEventListener('change', syncPreview);
            binding.field.addEventListener('input', syncPreview);
        });

        deviceButtons.forEach((button) => {
            button.addEventListener('click', () => {
                setPreviewDevice(button.dataset.dvPreviewDevice || 'desktop');
            });
        });

        if (recipeApply && recipeSelect) {
            recipeSelect.addEventListener('change', () => { recipeApply.disabled = !recipeSelect.value; });
            recipeApply.addEventListener('click', () => {
                const chosen = recipeOptions.find(({ option }) => option.value === recipeSelect.value);
                if (!chosen) return;
                const recipe = chosen.recipe;
                Object.entries(recipe).forEach(([key, value]) => {
                    const binding = controlsByKey.get(key);

                    if (!binding || !binding.allowed.includes(value)) {
                        return;
                    }

                    binding.field.value = value;
                    binding.field.dispatchEvent(new Event('change', { bubbles: true }));
                });

                syncPreview();
            });
        }

        syncPreview();
        setPreviewDevice('desktop');
    }

    function setupConfirmActions(page) {
        const buttons = page.querySelectorAll('[data-dv-confirm]');

        buttons.forEach((button) => {
            button.addEventListener('click', (event) => {
                const message = button.dataset.dvConfirm || '';

                if (message && !window.confirm(message)) {
                    event.preventDefault();
                }
            });
        });
    }

    function setupCopyActions(page) {
        const buttons = page.querySelectorAll('[data-dv-copy-target]');

        function copyViaFallback(text) {
            const textarea = document.createElement('textarea');

            textarea.value = text;
            textarea.setAttribute('readonly', 'readonly');
            textarea.style.position = 'fixed';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        function markCopied(button) {
            const label = button.dataset.dvCopyLabel || button.textContent;
            const copiedLabel = button.dataset.dvCopiedLabel || 'Copied';

            button.textContent = copiedLabel;
            button.classList.add('is-copied');

            window.setTimeout(() => {
                button.textContent = label;
                button.classList.remove('is-copied');
            }, 1800);
        }

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.dataset.dvCopyTarget || '';
                const safeTargetId = window.CSS && window.CSS.escape ? window.CSS.escape(targetId) : targetId;
                const target = targetId ? page.querySelector(`#${safeTargetId}`) : null;
                const text = target ? target.value || target.textContent || '' : '';

                if (!text) {
                    return;
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(() => markCopied(button)).catch(() => {
                        copyViaFallback(text);
                        markCopied(button);
                    });
                    return;
                }

                copyViaFallback(text);
                markCopied(button);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const page = document.querySelector('.dv-theme-options-page');

        if (!page) {
            return;
        }

        const links = page.querySelectorAll('.dv-admin-nav a[href^="#dv-options-"]');
        const firstLink = links[0];
        const hashId = window.location.hash ? window.location.hash.slice(1) : '';
        const hashPanel = hashId ? document.getElementById(hashId) : null;
        const storedTarget = readActiveTarget();
        const storedPanel = storedTarget ? document.getElementById(storedTarget.replace(/^#/, '')) : null;
        const isOptionsPanel = (panel) => panel && page.contains(panel) && panel.matches('.dv-admin-card[id^="dv-options-"]');
        const initialHash = isOptionsPanel(hashPanel)
            ? window.location.hash
            : isOptionsPanel(storedPanel)
                ? storedTarget
            : firstLink ? firstLink.getAttribute('href') : '';
        let activeTarget = initialHash;

        if (!initialHash) {
            return;
        }

        page.classList.add('dv-admin-tabs-ready');
        activateTab(page, initialHash, false);
        setupGroupNavigation(page, (targetId) => {
            activeTarget = targetId || activeTarget;
            activateTab(page, activeTarget, true);
        });
        setupOptionGroups(page);
        setupNavCounters(page);

        links.forEach((link) => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                activeTarget = link.getAttribute('href');
                activateTab(page, activeTarget, true);
            });
        });

        setupSettingsSearch(
            page,
            () => activeTarget,
            (nextTarget) => {
                activeTarget = nextTarget || activeTarget;
            }
        );
        window.addEventListener('hashchange', () => {
            const targetId = window.location.hash;
            const panel = document.getElementById(targetId.slice(1));

            if (!isOptionsPanel(panel)) {
                return;
            }

            const search = page.querySelector('#dv-theme-options-search');
            if (search && search.value) {
                search.value = '';
                search.dispatchEvent(new Event('input', { bubbles: true }));
            }

            activeTarget = targetId;
            activateTab(page, activeTarget, false);
        });
        setupQuickWorkflows(page, (targetId) => {
            activeTarget = targetId || activeTarget;
            activateTab(page, activeTarget, true);
        });

        setupUnsavedState(page);
        setupVisualPreview(page);
        setupConfirmActions(page);
        setupCopyActions(page);
    });
}());
