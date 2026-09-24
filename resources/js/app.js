import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


/*
|--------------------------------------------------------------------------
| PWA Service Worker
|--------------------------------------------------------------------------
*/

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {

        navigator.serviceWorker.register(
            window.pwaServiceWorkerUrl || '/service-worker.js'
        )
        .then((registration) => {

            console.log(
                '[PWA] Service Worker registered:',
                registration.scope
            );

        })
        .catch((error) => {

            console.error(
                '[PWA] Service Worker registration failed:',
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

window.pwaInstallAvailable = false;


/*
|--------------------------------------------------------------------------
| Check API
|--------------------------------------------------------------------------
*/

if ('onbeforeinstallprompt' in window) {

    console.log(
        '[PWA] beforeinstallprompt API tersedia.'
    );

} else {

    console.warn(
        '[PWA] beforeinstallprompt API TIDAK tersedia.'
    );

}


/*
|--------------------------------------------------------------------------
| Before Install Prompt
|--------------------------------------------------------------------------
*/

window.addEventListener('beforeinstallprompt', (event) => {

    console.log(
        '[PWA] 🔥 beforeinstallprompt diterima.',
        event
    );

    event.preventDefault();

    deferredPrompt = event;

    window.pwaInstallAvailable = true;

    window.dispatchEvent(
        new CustomEvent('pwa-install-available')
    );

});


/*
|--------------------------------------------------------------------------
| Install PWA
|--------------------------------------------------------------------------
*/

window.installPwa = async () => {

    console.log(
        '[PWA] installPwa() dipanggil.'
    );

    if (!deferredPrompt) {

        console.warn(
            '[PWA] ⚠️ deferredPrompt belum tersedia.'
        );

        return;

    }

    deferredPrompt.prompt();

    const { outcome } =
        await deferredPrompt.userChoice;

    console.log(
        '[PWA] Install outcome:',
        outcome
    );

    deferredPrompt = null;

    window.pwaInstallAvailable = false;

    window.dispatchEvent(
        new CustomEvent('pwa-install-finished')
    );

};


/*
|--------------------------------------------------------------------------
| App Installed
|--------------------------------------------------------------------------
*/

window.addEventListener('appinstalled', () => {

    console.log(
        '[PWA] ✅ App berhasil di-install.'
    );

    deferredPrompt = null;

    window.pwaInstallAvailable = false;

    window.dispatchEvent(
        new CustomEvent('pwa-installed')
    );

});