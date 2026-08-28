document.addEventListener('DOMContentLoaded', () => {
    if (window.lucide) window.lucide.createIcons();

    const root = document.documentElement;
    const toast = document.querySelector('.toast');
    let toastTimer;
    const showToast = (message) => {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toast.classList.remove('is-visible'), 2600);
    };

    document.querySelectorAll('[data-toast]').forEach((element) => {
        element.addEventListener('click', () => showToast(element.dataset.toast));
    });

    const updateClock = () => {
        const now = new Date();
        const days = ['DOMINGO', 'LUNES', 'MARTES', 'MIÉRCOLES', 'JUEVES', 'VIERNES', 'SÁBADO'];
        const clock = document.querySelector('[data-clock]');
        const day = document.querySelector('[data-day]');
        const date = document.querySelector('[data-date]');
        if (clock) clock.textContent = now.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit', hour12: false});
        if (day) day.textContent = days[now.getDay()];
        if (date) date.textContent = now.toLocaleDateString('es-EC', {day: '2-digit', month: 'short', year: 'numeric'}).toUpperCase();
    };
    updateClock();
    setInterval(updateClock, 30000);

    const sidebar = document.querySelector('.sidebar');
    const mobileBackdrop = document.querySelector('.mobile-backdrop');
    const setSidebar = (open) => {
        sidebar?.classList.toggle('is-open', open);
        mobileBackdrop?.classList.toggle('is-open', open);
    };
    document.querySelector('[data-toggle-sidebar]')?.addEventListener('click', () => setSidebar(true));
    document.querySelector('[data-close-sidebar]')?.addEventListener('click', () => setSidebar(false));

    if (localStorage.getItem('espoch-theme') === 'dark') root.classList.add('dark');
    document.querySelector('[data-theme-toggle]')?.addEventListener('click', () => {
        root.classList.toggle('dark');
        localStorage.setItem('espoch-theme', root.classList.contains('dark') ? 'dark' : 'light');
        showToast(root.classList.contains('dark') ? 'Modo oscuro activado' : 'Modo claro activado');
    });

    document.querySelectorAll('[data-dropdown-toggle]').forEach((button) => {
        const dropdown = document.getElementById(button.dataset.dropdownToggle);
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            dropdown?.classList.toggle('is-open');
        });
    });
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.role-switcher')) document.querySelectorAll('.dropdown').forEach((menu) => menu.classList.remove('is-open'));
    });

    const openModal = (id) => {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        modal.querySelector('input, select, textarea')?.focus();
    };
    const closeModal = (modal) => {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
    };
    document.querySelectorAll('[data-modal-open]').forEach((button) => button.addEventListener('click', () => openModal(button.dataset.modalOpen)));
    document.querySelectorAll('[data-modal-close]').forEach((button) => button.addEventListener('click', () => closeModal(button.closest('.modal'))));
    document.querySelectorAll('.modal').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(modal); }));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') document.querySelectorAll('.modal.is-open').forEach(closeModal); });
    document.querySelectorAll('[data-demo-form]').forEach((form) => form.addEventListener('submit', (event) => {
        event.preventDefault();
        closeModal(form.closest('.modal'));
        form.reset();
        showToast('Guardado correctamente en la demostración');
    }));

    const applyTableFilters = () => {
        const query = (document.querySelector('[data-table-search]')?.value || '').toLocaleLowerCase('es');
        const filter = document.querySelector('[data-table-filter]')?.value || '';
        document.querySelectorAll('[data-search-row]').forEach((row) => {
            const matchesSearch = row.textContent.toLocaleLowerCase('es').includes(query);
            const matchesFilter = !filter || row.dataset.filterValue === filter || row.textContent.includes(filter);
            row.classList.toggle('hidden', !matchesSearch || !matchesFilter);
        });
    };
    document.querySelector('[data-table-search]')?.addEventListener('input', applyTableFilters);
    document.querySelector('[data-table-filter]')?.addEventListener('change', applyTableFilters);

    document.querySelectorAll('[data-tabs]').forEach((tabs) => {
        tabs.querySelectorAll('[data-tab]').forEach((button) => button.addEventListener('click', () => {
            tabs.querySelectorAll('[data-tab]').forEach((item) => item.classList.toggle('is-active', item === button));
            document.querySelectorAll('[data-tab-panel]').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== button.dataset.tab));
        }));
    });

    document.querySelectorAll('[data-semester]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-semester]').forEach((item) => item.classList.remove('is-active'));
        button.classList.add('is-active');
        showToast(`Malla del ${button.dataset.semester}.º PAO cargada`);
    }));

    const catalogGrid = document.querySelector('[data-catalog-grid]');
    const catalogSearch = document.querySelector('[data-catalog-search]');
    const availableOnly = document.querySelector('[data-only-available]');
    const filterCatalog = () => {
        if (!catalogGrid) return;
        const query = (catalogSearch?.value || '').toLocaleLowerCase('es');
        const category = document.querySelector('input[name="category"]:checked')?.value || 'all';
        let visible = 0;
        catalogGrid.querySelectorAll('[data-product]').forEach((product) => {
            const matches = product.dataset.name.includes(query)
                && (category === 'all' || product.dataset.category === category)
                && (!availableOnly?.checked || product.dataset.available === 'true');
            product.classList.toggle('hidden', !matches);
            if (matches) visible++;
        });
        const count = document.querySelector('[data-result-count]');
        if (count) count.textContent = visible;
    };
    catalogSearch?.addEventListener('input', filterCatalog);
    availableOnly?.addEventListener('change', filterCatalog);
    document.querySelectorAll('input[name="category"]').forEach((radio) => radio.addEventListener('change', filterCatalog));
    document.querySelector('[data-clear-filters]')?.addEventListener('click', () => {
        if (catalogSearch) catalogSearch.value = '';
        const all = document.querySelector('input[name="category"][value="all"]');
        if (all) all.checked = true;
        if (availableOnly) availableOnly.checked = false;
        filterCatalog();
    });
    document.querySelectorAll('[data-catalog-view]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-catalog-view]').forEach((item) => item.classList.toggle('is-active', item === button));
        catalogGrid?.classList.toggle('is-list', button.dataset.catalogView === 'list');
    }));

    const cart = new Map();
    const cartDrawer = document.querySelector('[data-cart-drawer]');
    const drawerBackdrop = document.querySelector('.drawer-backdrop');
    const cartItems = document.querySelector('[data-cart-items]');
    const setCartOpen = (open) => {
        cartDrawer?.classList.toggle('is-open', open);
        drawerBackdrop?.classList.toggle('is-open', open);
        cartDrawer?.setAttribute('aria-hidden', open ? 'false' : 'true');
    };
    const renderCart = () => {
        const total = [...cart.values()].reduce((sum, item) => sum + item.quantity, 0);
        document.querySelectorAll('[data-cart-count]').forEach((count) => count.textContent = total);
        if (!cartItems) return;
        if (!cart.size) {
            cartItems.innerHTML = '<div class="empty-cart"><p>Aún no agregas equipos.</p></div>';
            return;
        }
        cartItems.innerHTML = [...cart.values()].map((item) => `<div class="cart-item"><span><b>${item.name}</b><small>Cantidad: ${item.quantity}</small></span><button type="button" data-remove-cart="${item.id}">×</button></div>`).join('');
        cartItems.querySelectorAll('[data-remove-cart]').forEach((button) => button.addEventListener('click', () => { cart.delete(button.dataset.removeCart); renderCart(); }));
    };
    document.querySelectorAll('[data-add-cart]').forEach((button) => button.addEventListener('click', () => {
        const current = cart.get(button.dataset.id) || {id: button.dataset.id, name: button.dataset.name, quantity: 0};
        current.quantity++;
        cart.set(current.id, current);
        renderCart();
        showToast(`${current.name} agregado`);
    }));
    document.querySelector('[data-open-cart]')?.addEventListener('click', () => setCartOpen(true));
    document.querySelectorAll('[data-close-cart]').forEach((button) => button.addEventListener('click', () => setCartOpen(false)));
    document.querySelector('[data-submit-cart]')?.addEventListener('click', () => {
        if (!cart.size) return showToast('Agrega al menos un equipo');
        cart.clear(); renderCart(); setCartOpen(false); showToast('Solicitud generada correctamente');
    });

    document.querySelectorAll('[data-place]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-place]').forEach((item) => item.classList.toggle('is-active', item === button));
        const title = document.querySelector('[data-place-title]'); const detail = document.querySelector('[data-place-detail]');
        if (title) title.textContent = button.dataset.place; if (detail) detail.textContent = button.dataset.detail;
    }));
    document.querySelector('[data-place-search]')?.addEventListener('input', (event) => {
        const query = event.target.value.toLocaleLowerCase('es');
        document.querySelectorAll('[data-place]').forEach((place) => place.classList.toggle('hidden', !place.textContent.toLocaleLowerCase('es').includes(query)));
    });
    document.querySelectorAll('[data-building]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-building]').forEach((item) => item.classList.toggle('is-active', item === button));
        const target = document.querySelector('[data-building-title]'); if (target) target.textContent = button.dataset.building;
        showToast(`${button.dataset.building} seleccionado`);
    }));
    document.querySelectorAll('[data-message-title]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-message-title]').forEach((item) => item.classList.toggle('is-active', item === button));
        const title = document.querySelector('.message-detail [data-message-title]');
        const text = document.querySelector('.message-detail [data-message-text]');
        const type = document.querySelector('.message-detail [data-message-type]');
        if (title) title.textContent = button.dataset.messageTitle;
        if (text) text.textContent = button.dataset.messageText;
        if (type) type.textContent = button.dataset.messageType.toUpperCase();
    }));

    const activateVirtualTab = (tabName) => {
        document.querySelectorAll('[data-virtual-tab]').forEach((button) => button.classList.toggle('is-active', button.dataset.virtualTab === tabName));
        document.querySelectorAll('[data-virtual-panel]').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.virtualPanel !== tabName));
    };
    document.querySelectorAll('[data-virtual-tab]').forEach((button) => button.addEventListener('click', () => activateVirtualTab(button.dataset.virtualTab)));
    document.querySelectorAll('[data-virtual-tab-target]').forEach((button) => button.addEventListener('click', () => {
        activateVirtualTab(button.dataset.virtualTabTarget);
        document.querySelector('[data-virtual-panel="course"]')?.scrollIntoView({behavior: 'smooth', block: 'start'});
    }));
    document.querySelectorAll('[data-module-toggle]').forEach((button) => button.addEventListener('click', () => {
        button.closest('.module-item')?.classList.toggle('is-open');
    }));

    const calendarTitle = document.querySelector('[data-calendar-title]');
    const calendarMonths = ['Julio 2026', 'Agosto 2026', 'Septiembre 2026'];
    let calendarMonth = 1;
    const setCalendarMonth = (index) => {
        calendarMonth = Math.max(0, Math.min(calendarMonths.length - 1, index));
        if (calendarTitle) calendarTitle.textContent = calendarMonths[calendarMonth];
    };
    document.querySelector('[data-calendar-prev]')?.addEventListener('click', () => setCalendarMonth(calendarMonth - 1));
    document.querySelector('[data-calendar-next]')?.addEventListener('click', () => setCalendarMonth(calendarMonth + 1));
    document.querySelector('[data-calendar-today]')?.addEventListener('click', () => { setCalendarMonth(1); showToast('Mostrando agosto de 2026'); });
    // Filtros por chip: replican los botones de estado/rol de la app original.
    document.querySelectorAll('[data-filter-chips]').forEach((group) => {
        const scope = group.closest('.panel') || document;
        const chips = group.querySelectorAll('[data-filter-chip]');
        chips.forEach((chip) => chip.addEventListener('click', () => {
            chips.forEach((other) => other.classList.toggle('is-active', other === chip));
            const wanted = chip.dataset.filterChip;
            scope.querySelectorAll('[data-search-row]').forEach((row) => {
                row.classList.toggle('hidden', Boolean(wanted) && row.dataset.filterValue !== wanted);
            });
        }));
    });
    // Horarios: buscador de clase/docente sobre la grilla.
    const scheduleSearch = document.querySelector('[data-schedule-search]');
    if (scheduleSearch) {
        scheduleSearch.addEventListener('input', () => {
            const query = scheduleSearch.value.trim().toLocaleLowerCase('es');
            document.querySelectorAll('[data-class-cell]').forEach((cell) => {
                cell.classList.toggle('is-dimmed', Boolean(query) && !cell.dataset.searchText.includes(query));
            });
        });
    }

    // Horarios: panel Ubicaciones (edificio -> piso -> aula) que fija los chips de filtro.
    const locationsPanel = document.querySelector('[data-locations-panel]');
    if (locationsPanel) {
        const backdrop = document.querySelector('.locations-backdrop');
        const toggle = document.querySelector('[data-locations-toggle]');
        const setLocationsPanel = (open) => {
            locationsPanel.classList.toggle('is-open', open);
            locationsPanel.setAttribute('aria-hidden', String(!open));
            backdrop?.classList.toggle('is-visible', open);
            toggle?.classList.toggle('is-open', open);
        };
        toggle?.addEventListener('click', () => setLocationsPanel(!locationsPanel.classList.contains('is-open')));
        document.querySelectorAll('[data-locations-close]').forEach((el) => el.addEventListener('click', () => setLocationsPanel(false)));

        document.querySelectorAll('[data-building-tab]').forEach((tab) => tab.addEventListener('click', () => {
            const index = tab.dataset.buildingTab;
            document.querySelectorAll('[data-building-tab]').forEach((other) => other.classList.toggle('is-active', other === tab));
            document.querySelectorAll('[data-building-panel]').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.buildingPanel !== index));
        }));

        document.querySelectorAll('[data-pick-room]').forEach((chip) => chip.addEventListener('click', () => {
            const room = chip.dataset.pickRoom;
            const setChip = (selector, value) => { const el = document.querySelector(selector); if (el) el.textContent = value; };
            setChip('[data-chip-building]', chip.dataset.pickBuilding);
            setChip('[data-chip-floor]', chip.dataset.pickFloor);
            setChip('[data-chip-room]', room);
            document.querySelectorAll('[data-class-cell]').forEach((cell) => {
                cell.classList.toggle('is-dimmed', cell.dataset.room !== room);
            });
            setLocationsPanel(false);
            showToast('Mostrando el horario de ' + room);
        }));
    }
    // Horarios: alterna entre la grilla y la pantalla "Generar formato".
    const exportView = document.querySelector('[data-export-view]');
    if (exportView) {
        const scheduleRoot = document.querySelector('[data-schedule-root]');
        const setExportView = (open) => {
            exportView.hidden = !open;
            if (scheduleRoot) scheduleRoot.hidden = open;
            document.querySelector('.hero-panel')?.classList.toggle('is-compact', open);
        };
        document.querySelector('[data-export-open]')?.addEventListener('click', () => setExportView(true));
        document.querySelector('[data-export-close]')?.addEventListener('click', () => setExportView(false));

        // La hoja de impresión refleja lo elegido en el panel lateral.
        const syncSheet = () => {
            const building = document.querySelector('[data-export-building]')?.value || '';
            const room = document.querySelector('[data-export-room]')?.value || '';
            const period = document.querySelector('[data-export-period]')?.value || '';
            const setText = (selector, value) => { const el = document.querySelector(selector); if (el) el.textContent = value; };
            setText('[data-sheet-building]', building.toLocaleUpperCase('es'));
            setText('[data-sheet-room]', room.toLocaleUpperCase('es'));
            setText('[data-sheet-period]', period.toLocaleUpperCase('es'));
            setText('[data-summary-building]', building);
            setText('[data-summary-room]', room);
        };
        ['[data-export-building]', '[data-export-room]', '[data-export-period]'].forEach((selector) => {
            document.querySelector(selector)?.addEventListener('change', syncSheet);
            document.querySelector(selector)?.addEventListener('input', syncSheet);
        });
        syncSheet();
    }
});
