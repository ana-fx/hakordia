/**
 * Toast Notification dengan Tailwind CSS
 * 
 * Usage:
 * showToast('Pesan berhasil!', 'success');
 * showToast('Terjadi kesalahan!', 'error');
 * showToast('Peringatan!', 'warning');
 * showToast('Informasi', 'info');
 */

// Ensure toast container exists
function ensureToastContainer() {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none';
        document.body.appendChild(container);
    }
    return container;
}

function showToast(message, type = 'success') {
    const container = ensureToastContainer();

    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'pointer-events-auto flex items-center gap-3 min-w-[280px] max-w-md rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-2xl transform transition-all duration-300 ease-out translate-x-full opacity-0';
    
    // Set background color based on type
    const colorMap = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'warning': 'bg-amber-500',
        'info': 'bg-blue-500',
        'primary': 'bg-primary'
    };
    toast.classList.add(colorMap[type] || colorMap.primary);

    // Create icon based on type
    const iconMap = {
        'success': '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        'error': '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>',
        'warning': '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        'info': '<svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
    };

    // Create close button
    const closeBtn = document.createElement('button');
    closeBtn.className = 'ml-auto flex-shrink-0 rounded-full p-1 text-white/80 hover:bg-white/20 transition';
    closeBtn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
    closeBtn.onclick = () => removeToast(toast);
    closeBtn.setAttribute('aria-label', 'Close notification');

    // Build toast content
    toast.innerHTML = `
        ${iconMap[type] || iconMap.info}
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

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { showToast, removeToast };
}

