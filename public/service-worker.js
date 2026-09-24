const CACHE_NAME = 'mgs-static-v3';

self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => {
                return Promise.all(
                    keys
                        .filter((key) => key !== CACHE_NAME)
                        .map((key) => caches.delete(key))
                );
            })
            .then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Hanya GET
    if (request.method !== 'GET') {
        return;
    }

    // Jangan intercept halaman Laravel
    if (request.mode === 'navigate') {
        return;
    }

    const url = new URL(request.url);

    // Hanya resource dari origin sendiri
    if (url.origin !== self.location.origin) {
        return;
    }

    // Hanya static assets
    const cacheableDestinations = [
        'script',
        'style',
        'image',
        'font'
    ];

    if (!cacheableDestinations.includes(request.destination)) {
        return;
    }

    event.respondWith(
        fetch(request)
            .then((response) => {
                if (!response.ok) {
                    return response;
                }

                // Clone SEBELUM response digunakan untuk cache.
                const responseForCache = response.clone();

                event.waitUntil(
                    caches.open(CACHE_NAME)
                        .then((cache) => {
                            return cache.put(request, responseForCache);
                        })
                        .catch((error) => {
                            console.warn(
                                '[PWA] Failed to cache resource:',
                                error
                            );
                        })
                );

                return response;
            })
            .catch(() => {
                return caches.match(request);
            })
    );
});