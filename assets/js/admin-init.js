(function () {
  'use strict';

  var root = document.documentElement;
  root.classList.add('dv-admin-initializing');

  function reveal() {
    root.classList.remove('dv-admin-initializing');
    window.clearTimeout(fallback);
  }

  // Footer scripts initialize panels in DOMContentLoaded handlers before paint.
  var fallback = window.setTimeout(reveal, 4000);
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      window.requestAnimationFrame(reveal);
    }, { once: true });
  } else {
    window.requestAnimationFrame(reveal);
  }
  window.addEventListener('pageshow', reveal);
}());
