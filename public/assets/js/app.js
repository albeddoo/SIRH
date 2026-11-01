/* SIRH — JS vanilla : ajout automatique du jeton CSRF aux requêtes fetch POST. */
(function () {
    'use strict';
    function csrfMeta() {
        var el = document.querySelector('meta[name="csrf-token"]');
        return el ? el.getAttribute('content') : null;
    }
    var _fetch = window.fetch;
    window.fetch = function (input, init) {
        init = init || {};
        var method = (init.method || 'GET').toUpperCase();
        if (method === 'POST' || method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
            var t = csrfMeta();
            if (t) {
                init.headers = new Headers(init.headers || {});
                if (!init.headers.has('X-CSRF-Token')) init.headers.set('X-CSRF-Token', t);
            }
        }
        return _fetch.call(this, input, init);
    };
})();
