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
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = `fixed bottom-6 right-6 z-50 min-w-[220px] max-w-xs rounded-full px-4 py-3 text-sm font-semibold text-white shadow-xl ${type === 'success' ? 'bg-primary' : 'bg-red-500'}`;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2500);
    }

    function toggleAdvancedSearch() {
        const advancedSearch = document.getElementById('advancedSearch');
        advancedSearch.classList.toggle('hidden');
    }
</script>

