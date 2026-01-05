export default function initDisplay() {
    toggleFullScreen();
    toggleAutoRefresh();
}

function toggleFullScreen() {
    const toggle = document.querySelector('[data-toggle="fullScreen"]');
    if (!toggle) {
        return;
    }

    const displayWrappers = document.querySelectorAll('[data-display-wrapper]');
    const savedState = localStorage.getItem('fullScreen');
    if (savedState !== null) {
        toggle.checked = savedState === '1';
        displayWrappers.forEach((wrapper) => {
            wrapper.classList.remove('max-w-5xl', !toggle.checked);
        });
    }

    toggle.addEventListener('change', (event) => {
        const isEnabled = event.target.checked;
        localStorage.setItem('fullScreen', isEnabled ? '1' : '0');
        displayWrappers.forEach((wrapper) => {
            wrapper.classList.toggle('max-w-5xl', !isEnabled);
        });
    });
}

function toggleAutoRefresh() {
    const toggle = document.querySelector('[data-toggle="refresh"]');
    if (!toggle) {
        return;
    }

    const refreshMetaName = 'auto-refresh';
    const applyRefreshMeta = (isEnabled) => {
        const existingMeta = document.querySelector(`meta[name="${refreshMetaName}"]`);
        if (isEnabled) {
            if (existingMeta) {
                return;
            }
            const meta = document.createElement('meta');
            meta.setAttribute('name', refreshMetaName);
            meta.setAttribute('http-equiv', 'refresh');
            meta.setAttribute('content', '60');
            document.head.appendChild(meta);
        } else if (existingMeta) {
            existingMeta.remove();
        }
    };

    const savedState = localStorage.getItem('refresh');
    if (savedState !== null) {
        toggle.checked = savedState === '1';
        applyRefreshMeta(toggle.checked);
    }

    toggle.addEventListener('change', (event) => {
        const isEnabled = event.target.checked;
        localStorage.setItem('refresh', isEnabled ? '1' : '0');
        applyRefreshMeta(isEnabled);
    });
}
