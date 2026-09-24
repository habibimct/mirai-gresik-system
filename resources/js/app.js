import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register(
            window.pwaServiceWorkerUrl || '/service-worker.js'
        ).catch((error) => {
            console.warn(
                'PWA service worker could not be registered.',
                error
            );
        });
    });
}

/*
|--------------------------------------------------------------------------
| PWA Install
|--------------------------------------------------------------------------
*/

let deferredPrompt = null;

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();

    deferredPrompt = event;

    window.dispatchEvent(new CustomEvent('pwa-install-available'));
});

window.addEventListener('appinstalled', () => {
    deferredPrompt = null;

    window.dispatchEvent(new CustomEvent('pwa-installed'));
});

window.installPwa = async () => {
    if (!deferredPrompt) {
        return;
    }

    deferredPrompt.prompt();

    await deferredPrompt.userChoice;

    deferredPrompt = null;

    window.dispatchEvent(new CustomEvent('pwa-install-finished'));
};