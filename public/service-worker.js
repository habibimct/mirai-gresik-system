const CACHE_NAME = 'mgs-static-v1';

self.addEventListener('install', () => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys
                .filter((key) => key !== CACHE_NAME)
                .map((key) => caches.delete(key)))
        ).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;

    if (request.method !== 'GET' || request.mode === 'navigate') {
        return;
    }

    const url = new URL(request.url);
    if (url.origin !== self.location.origin) {
        return;
    }

    event.respondWith(
        caches.match(request).then((cached) => {
            const networkRequest = fetch(request).then((response) => {
                if (response.ok && ['script', 'style', 'image', 'font'].includes(request.destination)) {
                    caches.open(CACHE_NAME).then((cache) => cache.put(request, response.clone()));
                }

                return response;
            });

            return cached || networkRequest;
        })
    );
});
