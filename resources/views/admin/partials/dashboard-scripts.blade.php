<script>
    const statusOrder = ['pending', 'waiting', 'paid', 'verified', 'expired'];
    const statusClassMap = @json(App\Support\StatusStyle::badgeClassMap());
    const baseBadgeClasses = 'badge rounded-pill d-inline-flex align-items-center fw-semibold text-uppercase px-3 py-2 cursor-pointer gap-1';

    function cycleStatus(id) {
        const badge = document.getElementById('badge-status-' + id);
        let current = badge.dataset.status;
        let idx = statusOrder.indexOf(current);
        let nextIdx = (idx + 1) % statusOrder.length;
        let nextStatus = statusOrder[nextIdx];

        fetch(`/admin/checkouts/${id}/update-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ status: nextStatus })
        })
        .then(res => {
            if (!res.ok) throw new Error('Status gagal diperbarui');
            return res.json();
        })
        .then(() => {
            updateBadgeStatus(id, nextStatus);
            updateWidgetTotals();
            showToast('Status berhasil diperbarui!', 'success');
        })
        .catch(() => {
            showToast('Gagal memperbarui status!', 'error');
        });
    }

    function updateWidgetTotals() {
        fetch('/admin/totals', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            // Update Total Peserta
            const totalParticipantsEl = document.querySelector('[data-widget="total_participants"]');
            if (totalParticipantsEl) {
                totalParticipantsEl.textContent = data.total_participants;
            }

            // Update Total Pendapatan
            const totalIncomeEl = document.querySelector('[data-widget="total_income"]');
            if (totalIncomeEl) {
                totalIncomeEl.textContent = new Intl.NumberFormat('id-ID').format(data.total_income);
            }

            // Update Status Paid
            const paidEl = document.querySelector('[data-widget="paid"]');
            if (paidEl) {
                paidEl.textContent = data.paid;
            }

            // Update Status Expired
            const expiredEl = document.querySelector('[data-widget="expired"]');
            if (expiredEl) {
                expiredEl.textContent = data.expired;
            }

            // Update Status Pending
            const pendingEl = document.querySelector('[data-widget="pending"]');
            if (pendingEl) {
                pendingEl.textContent = data.pending;
            }

            // Update Status Waiting
            const waitingEl = document.querySelector('[data-widget="waiting"]');
            if (waitingEl) {
                waitingEl.textContent = data.waiting;
            }
        })
        .catch(err => {
            console.error('Gagal update widget totals:', err);
        });
    }

    function applyBadgeClasses(badge, status) {
        badge.className = baseBadgeClasses;
        const classes = statusClassMap[status] ?? statusClassMap['default'];
        badge.classList.add(...classes);
    }

    function updateBadgeStatus(id, status) {
        const badge = document.getElementById('badge-status-' + id);
        badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        badge.dataset.status = status;
        applyBadgeClasses(badge, status);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-status-badge]').forEach((badge) => {
            applyBadgeClasses(badge, badge.dataset.status);
        });
    });

    function showImageModal(url) {
        document.getElementById('modalImage').src = url;
        document.getElementById('downloadButton').href = url;
        const modal = document.getElementById('imageModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        // Create toast element
        const toast = document.createElement('div');
        toast.className = 'pointer-events-auto flex items-center gap-3 min-w-[280px] max-w-md rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-2xl transform transition-all duration-300 ease-out translate-x-full opacity-0';
        
        // Set background color based on type
        if (type === 'success') {
            toast.classList.add('bg-green-500');
        } else if (type === 'error') {
            toast.classList.add('bg-red-500');
        } else if (type === 'warning') {
            toast.classList.add('bg-amber-500');
        } else if (type === 'info') {
            toast.classList.add('bg-blue-500');
        } else {
            toast.classList.add('bg-primary');
        }

        // Create icon based on type
        let iconSvg = '';
        if (type === 'success') {
            iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        } else if (type === 'error') {
            iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
        } else if (type === 'warning') {
            iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>';
        } else {
            iconSvg = '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
        }

        // Create close button
        const closeBtn = document.createElement('button');
        closeBtn.className = 'ml-auto flex-shrink-0 rounded-full p-1 text-white/80 hover:bg-white/20 transition';
        closeBtn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
        closeBtn.onclick = () => removeToast(toast);

        // Build toast content
        toast.innerHTML = `
            ${iconSvg}
            <span class="flex-1">${message}</span>
        `;
        toast.appendChild(closeBtn);

        // Add to container
        container.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        });

        // Auto remove after 4 seconds
        const timeout = setTimeout(() => {
            removeToast(toast);
        }, 4000);

        // Store timeout ID for cleanup
        toast.dataset.timeout = timeout;
    }

    function removeToast(toast) {
        if (!toast) return;

        // Clear timeout if exists
        if (toast.dataset.timeout) {
            clearTimeout(toast.dataset.timeout);
        }

        // Animate out
        toast.classList.add('translate-x-full', 'opacity-0');
        toast.classList.remove('translate-x-0', 'opacity-100');

        // Remove from DOM after animation
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    function toggleAdvancedSearch() {
        const advancedSearch = document.getElementById('advancedSearch');
        advancedSearch.classList.toggle('hidden');
    }
</script>

