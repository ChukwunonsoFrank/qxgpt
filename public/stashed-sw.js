const CACHE_NAME = "yfxai-pwa-v1";
const urlsToCache = [
    "/",
    "/offline", // Add this!
    "/manifest.json",
    "/favicon.ico",
];

// Install the service worker and cache important assets
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log("Caching files...");
            // Add files one by one to see which one fails
            return Promise.all(
                urlsToCache.map((url) => {
                    return cache.add(url).catch((err) => {
                        console.error("Failed to cache:", url, err);
                    });
                }),
            );
        }),
    );
    self.skipWaiting(); // Activate immediately
});

// Activate event - cleanup old caches
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) =>
                Promise.all(
                    cacheNames
                        .filter((name) => name !== CACHE_NAME)
                        .map((name) => caches.delete(name)),
                ),
            ),
    );
    event.waitUntil(self.clients.claim()); // Fixed: wrap in waitUntil
});

// Fetch event - Network first, fall back to cache
self.addEventListener("fetch", (event) => {
    // Skip caching for non-GET requests
    if (event.request.method !== "GET") {
        return;
    }

    // Skip caching for API calls and Livewire requests
    if (
        event.request.url.includes("/livewire/") ||
        event.request.url.includes("/api/")
    ) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Don't cache if not a valid response
                if (
                    !response ||
                    response.status !== 200 ||
                    response.type === "error"
                ) {
                    return response;
                }

                // Clone the response
                const responseToCache = response.clone();

                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseToCache);
                });

                return response;
            })
            .catch(() => {
                // Return cached version if available
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Return offline page for navigation requests
                    if (event.request.mode === "navigate") {
                        return caches.match("/offline");
                    }

                    // For other requests, return a basic response
                    return new Response("Offline", {
                        status: 503,
                        statusText: "Service Unavailable",
                    });
                });
            }),
    );
});
