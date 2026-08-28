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

document.addEventListener('DOMContentLoaded', () => {
    const transactions = document.querySelector('[data-transactions]');
    if (!transactions) return;

    let activePanel = 'requests';
    const search = transactions.querySelector('[data-transaction-search]');
    const status = transactions.querySelector('[data-transaction-status]');
    const type = transactions.querySelector('[data-transaction-type]');
    const date = transactions.querySelector('[data-transaction-date]');
    const empty = transactions.querySelector('[data-transactions-empty]');
    const visibleLabel = transactions.querySelector('[data-transaction-visible]');
    const totalLabel = transactions.querySelector('[data-transaction-total]');

    const activeBody = () => transactions.querySelector(`[data-transaction-panel="${activePanel}"]`);
    const applyTransactionFilters = () => {
        const rows = [...(activeBody()?.querySelectorAll('[data-transaction-row]') || [])];
        const query = (search?.value || '').trim().toLocaleLowerCase('es');
        let visible = 0;

        rows.forEach((row) => {
            const matches = (!query || row.textContent.toLocaleLowerCase('es').includes(query))
                && (!status?.value || row.dataset.status === status.value)
                && (!type?.value || row.dataset.type === type.value)
                && (!date?.value || row.dataset.date.includes(date.value));
            row.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });

        empty?.classList.toggle('hidden', visible !== 0);
        if (visibleLabel) visibleLabel.textContent = visible;
        if (totalLabel) totalLabel.textContent = rows.length;
    };

    transactions.querySelectorAll('[data-transaction-tab]').forEach((tab) => tab.addEventListener('click', () => {
        activePanel = tab.dataset.transactionTab;
        transactions.querySelectorAll('[data-transaction-tab]').forEach((item) => {
            const selected = item === tab;
            item.classList.toggle('is-active', selected);
            item.setAttribute('aria-selected', String(selected));
        });
        transactions.querySelectorAll('[data-transaction-panel]').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.transactionPanel !== activePanel));
        applyTransactionFilters();
    }));

    [search, status, type, date].forEach((control) => {
        control?.addEventListener(control === search ? 'input' : 'change', applyTransactionFilters);
    });

    transactions.querySelector('[data-transaction-clear]')?.addEventListener('click', () => {
        if (search) search.value = '';
        if (status) status.value = '';
        if (type) type.value = '';
        if (date) date.value = '';
        applyTransactionFilters();
    });

    document.querySelectorAll('[data-transaction-detail]').forEach((button) => button.addEventListener('click', () => {
        const title = document.querySelector('[data-transaction-detail-title]');
        if (title) title.textContent = button.dataset.transactionDetail;
    }));

    applyTransactionFilters();
});

document.addEventListener('DOMContentLoaded', () => {
    const scheduleTabs = document.querySelectorAll('[data-schedule-view]');
    if (!scheduleTabs.length) return;

    const schedulePanel = document.querySelector('[data-schedule-root]');
    const spacesView = document.querySelector('[data-spaces-view]');
    const exportView = document.querySelector('[data-export-view]');
    const spaceSearch = document.querySelector('[data-space-search]');
    const spaceFilter = document.querySelector('[data-space-filter]');
    const mapElement = document.querySelector('[data-leaflet-map]');
    const campusCenter = [-1.65605, -78.67795];
    let campusMap = null;
    let activeMapLayer = null;
    let mapLayers = {};
    const spaceMarkers = [];

    const initCampusMap = () => {
        if (campusMap || !mapElement || !window.L) return;

        campusMap = window.L.map(mapElement, {zoomControl: false}).setView(campusCenter, 17);
        mapLayers = {
            street: window.L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: '&copy; OpenStreetMap',
            }),
            satellite: window.L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 20,
                attribution: 'Tiles &copy; Esri',
            }),
        };
        mapLayers.hybrid = window.L.layerGroup([
            window.L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {maxZoom: 20, attribution: 'Tiles &copy; Esri'}),
            window.L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {maxZoom: 20}),
        ]);
        activeMapLayer = mapLayers.street.addTo(campusMap);

        document.querySelectorAll('[data-space-card]').forEach((card) => {
            const index = card.dataset.spaceIndex;
            const latLng = [Number(card.dataset.spaceLat), Number(card.dataset.spaceLng)];
            const marker = window.L.circleMarker(latLng, {
                radius: 12,
                color: '#ffffff',
                weight: 3,
                fillColor: index === '0' ? '#2563eb' : '#00a875',
                fillOpacity: 1,
            }).addTo(campusMap);
            const title = card.querySelector('.space-result-copy b')?.textContent || '';
            const detail = card.querySelector('.space-result-copy small')?.textContent || '';
            marker.bindPopup(`<b>${title}</b>${detail}`);
            marker.bindTooltip(title, {direction: 'top', className: 'leaflet-space-tooltip', offset: [0, -9]});
            marker.on('click', () => selectSpace(index, false));
            spaceMarkers[index] = marker;
        });
    };

    scheduleTabs.forEach((tab) => tab.addEventListener('click', () => {
        const showSpaces = tab.dataset.scheduleView === 'spaces';
        scheduleTabs.forEach((item) => {
            const selected = item === tab;
            item.classList.toggle('is-active', selected);
            item.setAttribute('aria-selected', String(selected));
        });
        if (schedulePanel) {
            schedulePanel.hidden = false;
            schedulePanel.classList.toggle('hidden', showSpaces);
        }
        spacesView?.classList.toggle('hidden', !showSpaces);
        if (exportView) exportView.hidden = true;
        const workspace = document.querySelector('.workspace');
        if (workspace) workspace.scrollTop = 0;
        if (showSpaces) {
            initCampusMap();
            window.setTimeout(() => campusMap?.invalidateSize(), 50);
        }
    }));

    const filterSpaces = () => {
        const query = (spaceSearch?.value || '').trim().toLocaleLowerCase('es');
        const wantedType = spaceFilter?.value || '';
        document.querySelectorAll('[data-space-card]').forEach((card) => {
            const matches = (!query || card.dataset.spaceName.includes(query))
                && (!wantedType || card.dataset.spaceType === wantedType);
            card.classList.toggle('hidden', !matches);
        });
    };
    spaceSearch?.addEventListener('input', filterSpaces);
    spaceFilter?.addEventListener('change', filterSpaces);

    const selectSpace = (index, moveMap = true) => {
        const selectedCard = document.querySelector(`[data-space-card][data-space-index="${index}"]`);
        document.querySelectorAll('[data-space-card]').forEach((card) => card.classList.toggle('is-active', card === selectedCard));
        const title = document.querySelector('[data-space-detail-title]');
        const copy = document.querySelector('[data-space-detail-copy]');
        if (title) title.textContent = selectedCard?.querySelector('.space-result-copy b')?.textContent || '';
        if (copy) copy.textContent = selectedCard?.querySelector('.space-result-copy small')?.textContent || '';
        spaceMarkers.forEach((marker, markerIndex) => marker?.setStyle({fillColor: String(markerIndex) === String(index) ? '#2563eb' : '#00a875'}));
        const selectedMarker = spaceMarkers[index];
        if (moveMap && selectedMarker && campusMap) campusMap.panTo(selectedMarker.getLatLng(), {animate: true});
        selectedMarker?.openPopup();
    };
    document.querySelectorAll('[data-space-card]').forEach((card) => card.addEventListener('click', () => selectSpace(card.dataset.spaceIndex)));
    document.querySelectorAll('.map-style-switch button').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('.map-style-switch button').forEach((item) => item.classList.toggle('is-active', item === button));
        if (!campusMap) return;
        if (activeMapLayer) campusMap.removeLayer(activeMapLayer);
        activeMapLayer = mapLayers[button.dataset.mapStyle] || mapLayers.street;
        activeMapLayer.addTo(campusMap);
    }));
    document.querySelector('[data-map-zoom-in]')?.addEventListener('click', () => campusMap?.zoomIn());
    document.querySelector('[data-map-zoom-out]')?.addEventListener('click', () => campusMap?.zoomOut());
    document.querySelector('[data-map-center]')?.addEventListener('click', () => campusMap?.setView(campusCenter, 17));
});

document.addEventListener('DOMContentLoaded', () => {
    const assets = document.querySelector('[data-assets]');
    if (!assets) return;

    let activeAssetsPanel = 'inventory';
    const search = assets.querySelector('[data-assets-search]');
    const category = assets.querySelector('[data-assets-category]');
    const status = assets.querySelector('[data-assets-status]');
    const building = assets.querySelector('[data-assets-building]');
    const empty = assets.querySelector('[data-assets-empty]');
    const visibleLabel = assets.querySelector('[data-assets-visible]');
    const totalLabel = assets.querySelector('[data-assets-total]');
    const activeBody = () => assets.querySelector(`[data-assets-panel="${activeAssetsPanel}"]`);

    const filterAssets = () => {
        const rows = [...(activeBody()?.querySelectorAll('[data-asset-row]') || [])];
        const query = (search?.value || '').trim().toLocaleLowerCase('es');
        let visible = 0;
        rows.forEach((row) => {
            const matches = (!query || row.textContent.toLocaleLowerCase('es').includes(query))
                && (!category?.value || row.dataset.category === category.value)
                && (!status?.value || row.dataset.status === status.value)
                && (!building?.value || row.dataset.building.includes(building.value));
            row.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });
        empty?.classList.toggle('hidden', visible !== 0);
        if (visibleLabel) visibleLabel.textContent = visible;
        if (totalLabel) totalLabel.textContent = rows.length;
    };

    assets.querySelectorAll('[data-assets-tab]').forEach((tab) => tab.addEventListener('click', () => {
        activeAssetsPanel = tab.dataset.assetsTab;
        assets.querySelectorAll('[data-assets-tab]').forEach((item) => {
            const selected = item === tab;
            item.classList.toggle('is-active', selected);
            item.setAttribute('aria-selected', String(selected));
        });
        assets.querySelectorAll('[data-assets-panel]').forEach((panel) => panel.classList.toggle('hidden', panel.dataset.assetsPanel !== activeAssetsPanel));
        assets.querySelectorAll('[data-assets-heading]').forEach((heading) => heading.classList.toggle('hidden', heading.dataset.assetsHeading !== activeAssetsPanel));
        if (category) category.value = '';
        if (status) status.value = '';
        if (building) building.value = '';
        filterAssets();
    }));

    [search, category, status, building].forEach((control) => control?.addEventListener(control === search ? 'input' : 'change', filterAssets));
    assets.querySelector('[data-assets-clear]')?.addEventListener('click', () => {
        if (search) search.value = '';
        if (category) category.value = '';
        if (status) status.value = '';
        if (building) building.value = '';
        filterAssets();
    });
    filterAssets();
});

document.addEventListener('DOMContentLoaded', () => {
    const managementPanel = document.querySelector('[data-infra-panel="management"]');
    const mapPanel = document.querySelector('[data-infra-panel="map"]');
    if (!managementPanel || !mapPanel) return;

    const campusCenter = [-1.65605, -78.67795];
    const buildTileLayers = () => ({
        street: window.L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 20, attribution: '&copy; OpenStreetMap'}),
        satellite: window.L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {maxZoom: 20, attribution: 'Tiles &copy; Esri'}),
        hybrid: window.L.layerGroup([
            window.L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {maxZoom: 20, attribution: 'Tiles &copy; Esri'}),
            window.L.tileLayer('https://services.arcgisonline.com/ArcGIS/rest/services/Reference/World_Boundaries_and_Places/MapServer/tile/{z}/{y}/{x}', {maxZoom: 20}),
        ]),
    });

    // --- Vista: Gestión / Mapa campus ---
    let campusMap = null;
    let campusLayers = {};
    let activeCampusLayer = null;

    const initCampusMap = () => {
        const element = document.querySelector('[data-infra-map]');
        if (campusMap || !element || !window.L) return;

        campusMap = window.L.map(element, {zoomControl: false}).setView(campusCenter, 17);
        campusLayers = buildTileLayers();
        activeCampusLayer = campusLayers.street.addTo(campusMap);

        document.querySelectorAll('[data-infra-marker]').forEach((marker) => {
            const point = window.L.circleMarker([Number(marker.dataset.markerLat), Number(marker.dataset.markerLng)], {
                radius: 12,
                color: '#ffffff',
                weight: 3,
                fillColor: marker.dataset.markerIndex === '0' ? '#2563eb' : '#00a875',
                fillOpacity: 1,
            }).addTo(campusMap);
            point.bindPopup('<b>' + marker.dataset.markerTitle + '</b><br>' + marker.dataset.markerDetail);
            point.bindTooltip(marker.dataset.markerTitle, {direction: 'top', offset: [0, -9]});
        });
    };

    document.querySelectorAll('[data-infra-view]').forEach((tab) => tab.addEventListener('click', () => {
        const showMap = tab.dataset.infraView === 'map';
        document.querySelectorAll('[data-infra-view]').forEach((item) => {
            const selected = item === tab;
            item.classList.toggle('is-active', selected);
            item.setAttribute('aria-selected', String(selected));
        });
        managementPanel.classList.toggle('hidden', showMap);
        mapPanel.classList.toggle('hidden', !showMap);
        if (!showMap) return;
        initCampusMap();
        window.setTimeout(() => campusMap?.invalidateSize(), 60);
    }));

    document.querySelectorAll('[data-infra-map-style]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-infra-map-style]').forEach((item) => item.classList.toggle('is-active', item === button));
        if (!campusMap) return;
        if (activeCampusLayer) campusMap.removeLayer(activeCampusLayer);
        activeCampusLayer = campusLayers[button.dataset.infraMapStyle] || campusLayers.street;
        activeCampusLayer.addTo(campusMap);
    }));

    document.querySelector('[data-infra-map-zoom-in]')?.addEventListener('click', () => campusMap?.zoomIn());
    document.querySelector('[data-infra-map-zoom-out]')?.addEventListener('click', () => campusMap?.zoomOut());
    document.querySelector('[data-infra-map-center]')?.addEventListener('click', () => campusMap?.setView(campusCenter, 17));

    // --- Árbol de edificios ---
    document.querySelectorAll('[data-tree-toggle]').forEach((head) => head.addEventListener('click', (event) => {
        if (event.target.closest('[data-modal-open]')) return;
        const building = head.closest('[data-tree-building]');
        building?.classList.toggle('is-open');
        document.querySelectorAll('[data-tree-toggle]').forEach((item) => item.classList.toggle('is-active', item === head));
    }));

    const treeSearch = document.querySelector('[data-tree-search]');
    treeSearch?.addEventListener('input', () => {
        const query = treeSearch.value.trim().toLocaleLowerCase('es');
        document.querySelectorAll('[data-tree-building]').forEach((building) => {
            const spaces = [...building.querySelectorAll('[data-tree-space]')];
            let visibleSpaces = 0;
            spaces.forEach((space) => {
                const matches = !query || space.dataset.spaceName.includes(query);
                space.classList.toggle('hidden', !matches);
                if (matches) visibleSpaces += 1;
            });
            const matchesBuilding = !query || building.dataset.buildingName.includes(query);
            building.classList.toggle('hidden', !matchesBuilding && visibleSpaces === 0);
            if (query && visibleSpaces > 0) building.classList.add('is-open');
        });
    });

    // --- Filtros de espacios ---
    const spaceSearch = document.querySelector('[data-space-filter-search]');
    const statusSelect = document.querySelector('[data-space-status]');
    const emptyMessage = document.querySelector('[data-spaces-empty]');
    let activeKind = '';

    const filterSpaces = () => {
        const query = (spaceSearch?.value || '').trim().toLocaleLowerCase('es');
        const wantedStatus = statusSelect?.value || '';
        let visible = 0;

        document.querySelectorAll('[data-space-item]').forEach((card) => {
            const matches = (!query || card.dataset.spaceName.includes(query))
                && (!activeKind || card.dataset.spaceKind === activeKind)
                && (!wantedStatus || card.dataset.spaceStatus === wantedStatus);
            card.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });

        emptyMessage?.classList.toggle('hidden', visible > 0);
    };

    spaceSearch?.addEventListener('input', filterSpaces);
    statusSelect?.addEventListener('change', filterSpaces);
    document.querySelectorAll('[data-space-kind]').forEach((chip) => chip.addEventListener('click', () => {
        document.querySelectorAll('[data-space-kind]').forEach((item) => item.classList.toggle('is-active', item === chip));
        activeKind = chip.dataset.spaceKind;
        filterSpaces();
    }));

    document.querySelectorAll('[data-space-layout]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-space-layout]').forEach((item) => item.classList.toggle('is-active', item === button));
        document.querySelector('[data-space-cards]')?.classList.toggle('is-list', button.dataset.spaceLayout === 'list');
    }));

    // --- Mini mapas de los modales: se crean al abrirlos porque Leaflet necesita el alto real ---
    const modalMaps = new WeakMap();
    document.querySelectorAll('[data-modal-open]').forEach((trigger) => trigger.addEventListener('click', () => {
        const modal = document.getElementById(trigger.dataset.modalOpen);
        const element = modal?.querySelector('[data-modal-map]');
        if (!element || !window.L) return;

        window.setTimeout(() => {
            let map = modalMaps.get(element);
            if (!map) {
                map = window.L.map(element, {zoomControl: false, attributionControl: false}).setView(campusCenter, 17);
                buildTileLayers().street.addTo(map);
                let pin = null;
                map.on('click', (event) => {
                    if (pin) map.removeLayer(pin);
                    pin = window.L.marker(event.latlng).addTo(map);
                });
                modalMaps.set(element, map);
            }
            map.invalidateSize();
        }, 80);
    }));

    document.querySelectorAll('[data-icon-picker] button').forEach((button) => button.addEventListener('click', () => {
        button.closest('[data-icon-picker]').querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === button));
    }));
});

document.addEventListener('DOMContentLoaded', () => {
    // --- Selectores de color de los modales de facultad y carrera ---
    document.querySelectorAll('[data-color-swatches]').forEach((group) => {
        const section = group.closest('.identity-section');
        const colorInput = section?.querySelector('[data-color-input]');
        const colorText = section?.querySelector('[data-color-text]');

        group.querySelectorAll('button').forEach((swatch) => swatch.addEventListener('click', () => {
            group.querySelectorAll('button').forEach((item) => item.classList.toggle('is-active', item === swatch));
            const color = swatch.dataset.color;
            if (colorInput) colorInput.value = color;
            if (colorText) colorText.value = color;
        }));

        colorInput?.addEventListener('input', () => {
            if (colorText) colorText.value = colorInput.value;
            group.querySelectorAll('button').forEach((item) => item.classList.remove('is-active'));
        });
    });

    const careersPanel = document.querySelector('[data-careers-panel]');
    const curriculumPanel = document.querySelector('[data-curriculum-panel]');
    if (!careersPanel || !curriculumPanel) return;

    // --- Buscador y disposición de las tarjetas de carrera ---
    const careerSearch = document.querySelector('[data-career-search]');
    const careersEmpty = document.querySelector('[data-careers-empty]');

    careerSearch?.addEventListener('input', () => {
        const query = careerSearch.value.trim().toLocaleLowerCase('es');
        let visible = 0;
        document.querySelectorAll('[data-career-item]').forEach((card) => {
            const matches = !query || card.dataset.careerName.includes(query);
            card.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });
        careersEmpty?.classList.toggle('hidden', visible > 0);
    });

    document.querySelectorAll('[data-career-layout]').forEach((button) => button.addEventListener('click', () => {
        document.querySelectorAll('[data-career-layout]').forEach((item) => item.classList.toggle('is-active', item === button));
        document.querySelector('[data-career-cards]')?.classList.toggle('is-list', button.dataset.careerLayout === 'list');
    }));

    // --- Malla curricular de la carrera abierta ---
    const curriculumTitle = curriculumPanel.querySelector('[data-curriculum-title]');
    const curriculumSummary = curriculumPanel.querySelector('[data-curriculum-summary]');
    const curriculumEmpty = curriculumPanel.querySelector('[data-curriculum-empty]');
    const curriculumEmptyText = curriculumPanel.querySelector('[data-curriculum-empty-text]');
    const curriculumToolbar = curriculumPanel.querySelector('.curriculum-toolbar');
    const paoTabs = [...curriculumPanel.querySelectorAll('[data-pao-tabs] button')];
    const subjectSearch = curriculumPanel.querySelector('[data-subject-search]');
    let activeGrid = null;

    const activePao = () => paoTabs.find((tab) => tab.classList.contains('is-active'))?.dataset.pao || '1';

    const renderSubjects = () => {
        if (!activeGrid) return;

        const pao = activePao();
        const query = (subjectSearch?.value || '').trim().toLocaleLowerCase('es');
        let visible = 0;

        activeGrid.querySelectorAll('[data-subject]').forEach((subject) => {
            const matches = subject.dataset.pao === pao && (!query || subject.dataset.subjectName.includes(query));
            subject.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });

        const totalSubjects = activeGrid.querySelectorAll('[data-subject]').length;
        const credits = [...activeGrid.querySelectorAll('[data-subject]')]
            .filter((subject) => subject.dataset.pao === pao)
            .reduce((sum, subject) => sum + Number(subject.querySelector('p').textContent.split(' ')[0]), 0);

        curriculumEmpty?.classList.toggle('hidden', visible > 0);
        if (curriculumEmptyText && visible === 0) {
            curriculumEmptyText.textContent = totalSubjects === 0
                ? 'Esta carrera todavía no tiene materias registradas en su malla.'
                : 'No hay materias en el ' + pao + '.º PAO con ese criterio.';
        }
        if (curriculumSummary) {
            curriculumSummary.textContent = visible > 0
                ? visible + ' materias en el ' + pao + '.º PAO · ' + credits + ' créditos.'
                : 'Sin materias que mostrar.';
        }
    };

    const openCareer = (trigger) => {
        const slug = trigger.dataset.careerLink;
        activeGrid = curriculumPanel.querySelector('[data-curriculum-for="' + slug + '"]');

        curriculumPanel.querySelectorAll('[data-curriculum-for]').forEach((grid) => grid.classList.toggle('hidden', grid !== activeGrid));
        if (curriculumTitle) curriculumTitle.textContent = 'Malla curricular · ' + trigger.dataset.careerTitle;
        if (subjectSearch) subjectSearch.value = '';

        // Abre el primer PAO que tenga materias para no aterrizar en una pestaña vacía.
        const firstPao = activeGrid?.querySelector('[data-subject]')?.dataset.pao || '1';
        paoTabs.forEach((tab) => tab.classList.toggle('is-active', tab.dataset.pao === firstPao));
        curriculumToolbar?.classList.toggle('hidden', !activeGrid?.querySelector('[data-subject]'));

        renderSubjects();
        careersPanel.classList.add('hidden');
        curriculumPanel.classList.remove('hidden');
        document.querySelector('.workspace')?.scrollTo({top: 0, behavior: 'smooth'});
    };

    document.querySelectorAll('[data-career-link]').forEach((trigger) => trigger.addEventListener('click', () => openCareer(trigger)));

    paoTabs.forEach((tab) => tab.addEventListener('click', () => {
        paoTabs.forEach((item) => item.classList.toggle('is-active', item === tab));
        renderSubjects();
    }));

    subjectSearch?.addEventListener('input', renderSubjects);

    document.querySelector('[data-curriculum-back]')?.addEventListener('click', () => {
        curriculumPanel.classList.add('hidden');
        careersPanel.classList.remove('hidden');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const panel = document.querySelector('[data-users-panel]');
    if (!panel) return;

    const body = panel.querySelector('[data-users-body]');
    const search = panel.querySelector('[data-users-search]');
    const statusSelect = panel.querySelector('[data-users-status]');
    const emptyMessage = panel.querySelector('[data-users-empty]');
    const rangeLabel = panel.querySelector('[data-users-range]');
    const selectAll = panel.querySelector('[data-users-select-all]');
    const roleChips = [...panel.querySelectorAll('[data-user-role]')];
    const rows = [...panel.querySelectorAll('[data-user-row]')];
    let activeRole = '';

    const applyFilters = () => {
        const query = (search?.value || '').trim().toLocaleLowerCase('es');
        const wantedStatus = statusSelect?.value || '';
        let visible = 0;

        rows.forEach((row) => {
            const matches = (!query || row.dataset.userSearch.includes(query))
                && (!activeRole || row.dataset.userRole === activeRole)
                && (!wantedStatus || row.dataset.userStatus === wantedStatus);
            row.classList.toggle('hidden', !matches);
            if (matches) visible += 1;
        });

        emptyMessage?.classList.toggle('hidden', visible > 0);
        if (rangeLabel) {
            rangeLabel.textContent = visible > 0 ? '1-' + visible + ' de ' + rows.length : '0 de ' + rows.length;
        }
    };

    search?.addEventListener('input', applyFilters);
    statusSelect?.addEventListener('change', applyFilters);

    roleChips.forEach((chip) => chip.addEventListener('click', () => {
        // El mismo chip vuelve a mostrar todos los roles.
        activeRole = activeRole === chip.dataset.userRole ? '' : chip.dataset.userRole;
        roleChips.forEach((item) => item.classList.toggle('is-active', item.dataset.userRole === activeRole));
        applyFilters();
    }));

    panel.querySelector('[data-users-clear]')?.addEventListener('click', () => {
        activeRole = '';
        roleChips.forEach((chip) => chip.classList.remove('is-active'));
        if (search) search.value = '';
        if (statusSelect) statusSelect.value = '';
        applyFilters();
    });

    selectAll?.addEventListener('change', () => {
        rows.filter((row) => !row.classList.contains('hidden'))
            .forEach((row) => {
                const checkbox = row.querySelector('input[type="checkbox"]');
                if (checkbox) checkbox.checked = selectAll.checked;
            });
    });

    // Orden por columna: alterna ascendente y descendente sobre las filas ya renderizadas.
    let sortColumn = '';
    let sortAscending = true;

    panel.querySelectorAll('[data-sort-users]').forEach((header) => header.addEventListener('click', () => {
        const column = header.dataset.sortUsers;
        sortAscending = column === sortColumn ? !sortAscending : true;
        sortColumn = column;

        // Solo se reordenan las filas de la tabla: las tarjetas viven fuera del tbody.
        const sortableRows = body ? [...body.querySelectorAll('[data-user-row]')] : [];
        const ordered = sortableRows.sort((first, second) => {
            const left = first.dataset['sort' + column.charAt(0).toUpperCase() + column.slice(1)] || '';
            const right = second.dataset['sort' + column.charAt(0).toUpperCase() + column.slice(1)] || '';
            return sortAscending ? left.localeCompare(right, 'es') : right.localeCompare(left, 'es');
        });

        ordered.forEach((row) => body?.appendChild(row));
    }));

    applyFilters();
});
