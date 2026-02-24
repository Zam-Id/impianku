const CACHE_NAME = "impianku-v1";
const assetsToCache = [
    "/manifest.json",
    "/logo.png",
    // Tambahkan asset statis lainnya di sini jika perlu
];

// Install Service Worker
self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(assetsToCache);
        }),
    );
});

// Aktivasi dan hapus cache lama
self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys
                    .filter((key) => key !== CACHE_NAME)
                    .map((key) => caches.delete(key)),
            );
        }),
    );
});

// Strategi Fetch yang aman untuk Redirect
self.addEventListener("fetch", (event) => {
    // Jika ini adalah permintaan navigasi (pindah halaman/redirect)
    if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request).catch(() => {
                // Jika offline, tampilkan halaman utama dari cache
                return caches.match("/");
            }),
        );
        return;
    }

    // Untuk file lainnya (gambar, css, js)
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        }),
    );
});
