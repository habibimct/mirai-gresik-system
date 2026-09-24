import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


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