self.addEventListener('fetch', function(event) {
    if (event.request.method !== 'GET') {
        return;
    }
    event.respondWith(
        caches.open('application').then(function(cache) {
            return fetch(event.request).then(function(response) {
                cache.put(event.request, response.clone());
                return response;
            });
        })
    );
});