const CACHE_NAME = 'prmi-ambon-cache-v1';
const urlsToCache = [
  '/',
  '/offline.html',
  '/assets/img/icon-192x192.png',
  '/assets/img/icon-512x512.png',
  'asstes/css/custom.css', // ganti sesuai asset kamu
  'asstes/js/custom.js'    // ganti sesuai asset kamu
];

// Install & cache file
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

// Aktifkan Service Worker & hapus cache lama
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      )
    )
  );
});

// Fetch file: online dulu, kalau gagal ambil dari cache
self.addEventListener('fetch', event => {
  event.respondWith(
    fetch(event.request).catch(() => {
      return caches.match(event.request).then(response => {
        return response || caches.match('/offline.html');
      });
    })
  );
});
