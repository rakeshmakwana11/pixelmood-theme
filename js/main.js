/**
 * PixelMood — main.js
 * Handles: Copy prompt, mobile nav, category filters active state
 */
(function () {
  'use strict';

  /* ============================================================
     COPY PROMPT
     ============================================================ */
  function showToast(msg) {
    var toast = document.getElementById('pm-copy-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'pm-copy-toast';
      document.body.appendChild(toast);
    }
    toast.textContent = msg || '\u2713 Prompt copied!';
    toast.classList.add('is-visible');
    clearTimeout(toast._t);
    toast._t = setTimeout(function () {
      toast.classList.remove('is-visible');
    }, 2400);
  }

  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.pm-copy-btn');
    if (!btn) return;
    e.preventDefault();
    e.stopPropagation();

    var text = btn.getAttribute('data-content') || '';
    if (!text) {
      /* Fallback: grab from .pm-prompt-content-box on single pages */
      var box = document.querySelector('.pm-prompt-content-box p');
      if (box) text = box.innerText || box.textContent;
    }

    if (!text) return;

    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text).then(function () {
        showToast('\u2713 Prompt copied!');
        btn.textContent = '\u2713 Copied!';
        setTimeout(function () { btn.innerHTML = '&#x2398; Copy'; }, 2000);
      }).catch(function () {
        fallbackCopy(text, btn);
      });
    } else {
      fallbackCopy(text, btn);
    }
  });

  function fallbackCopy(text, btn) {
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;top:-9999px;left:-9999px;opacity:0';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
      document.execCommand('copy');
      showToast('\u2713 Prompt copied!');
      if (btn) {
        btn.textContent = '\u2713 Copied!';
        setTimeout(function () { btn.innerHTML = '&#x2398; Copy'; }, 2000);
      }
    } catch (err) {
      showToast('\u2717 Copy failed. Please copy manually.');
    }
    document.body.removeChild(ta);
  }

  /* ============================================================
     MOBILE NAVIGATION TOGGLE
     ============================================================ */
  var toggle = document.querySelector('.pm-nav-toggle');
  var mobileNav = document.querySelector('.pm-mobile-nav');

  if (toggle && mobileNav) {
    toggle.addEventListener('click', function () {
      var isOpen = mobileNav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    /* Close on outside click */
    document.addEventListener('click', function (e) {
      if (!toggle.contains(e.target) && !mobileNav.contains(e.target)) {
        mobileNav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ============================================================
     CATEGORY FILTER ACTIVE STATE
     ============================================================ */
  var filterLinks = document.querySelectorAll('.pm-cat-filters a');
  var currentUrl = window.location.href;

  filterLinks.forEach(function (link) {
    if (link.href === currentUrl || currentUrl.indexOf(link.href) === 0) {
      link.classList.add('is-active');
    }
  });

  /* Mark "All" active on archive root */
  if (filterLinks.length) {
    var allLink = filterLinks[0];
    var isRoot = /\/prompts\/?$/.test(window.location.pathname) && !window.location.search;
    if (isRoot) allLink.classList.add('is-active');
  }

  /* ============================================================
     SMOOTH CARD HOVER (accessibility: reduce-motion safe)
     ============================================================ */
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    /* Cards already use CSS transition — nothing extra needed */
  }

})();
