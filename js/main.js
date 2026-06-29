/**
 * PixelMood - main.js
 * Handles: Copy prompt, mobile nav, header scroll, card click, category filters
 */
(function () {
  'use strict';

  /* ============================================================
     COPY PROMPT BUTTON
  ============================================================ */
  function initCopyButtons() {
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.pm-copy-btn');
      if (!btn) return;

      var promptText = btn.getAttribute('data-prompt');
      if (!promptText) return;

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(promptText).then(function () {
          showCopyFeedback(btn);
        }).catch(function () {
          fallbackCopy(promptText, btn);
        });
      } else {
        fallbackCopy(promptText, btn);
      }
    });
  }

  function fallbackCopy(text, btn) {
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;opacity:0;top:0;left:0';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
      document.execCommand('copy');
      showCopyFeedback(btn);
    } catch (err) {
      console.warn('PixelMood: Copy failed', err);
    }
    document.body.removeChild(ta);
  }

  function showCopyFeedback(btn) {
    var original = btn.innerHTML;
    btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Copied!';
    btn.classList.add('pm-copy-btn--success');
    setTimeout(function () {
      btn.innerHTML = original;
      btn.classList.remove('pm-copy-btn--success');
    }, 2000);
  }

  /* ============================================================
     MOBILE NAVIGATION
  ============================================================ */
  function initMobileNav() {
    var toggle  = document.getElementById('pm-nav-toggle');
    var mobileNav = document.getElementById('pm-mobile-nav');
    var overlay = document.getElementById('pm-mobile-overlay');
    var body    = document.body;

    if (!toggle || !mobileNav) return;

    function openNav() {
      mobileNav.classList.add('pm-mobile-nav--open');
      mobileNav.setAttribute('aria-hidden', 'false');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.classList.add('pm-nav-toggle--active');
      body.classList.add('pm-nav-open');
      if (overlay) overlay.classList.add('pm-mobile-overlay--visible');
    }

    function closeNav() {
      mobileNav.classList.remove('pm-mobile-nav--open');
      mobileNav.setAttribute('aria-hidden', 'true');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.classList.remove('pm-nav-toggle--active');
      body.classList.remove('pm-nav-open');
      if (overlay) overlay.classList.remove('pm-mobile-overlay--visible');
    }

    toggle.addEventListener('click', function () {
      if (mobileNav.classList.contains('pm-mobile-nav--open')) {
        closeNav();
      } else {
        openNav();
      }
    });

    if (overlay) {
      overlay.addEventListener('click', closeNav);
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeNav();
    });
  }

  /* ============================================================
     STICKY HEADER SCROLL EFFECT
  ============================================================ */
  function initStickyHeader() {
    var header = document.getElementById('masthead');
    if (!header) return;

    var scrolled = false;
    window.addEventListener('scroll', function () {
      if (window.scrollY > 50) {
        if (!scrolled) {
          header.classList.add('pm-site-header--scrolled');
          scrolled = true;
        }
      } else {
        if (scrolled) {
          header.classList.remove('pm-site-header--scrolled');
          scrolled = false;
        }
      }
    }, { passive: true });
  }

  /* ============================================================
     CLICKABLE PROMPT CARDS
  ============================================================ */
  function initCardClick() {
    document.addEventListener('click', function (e) {
      var card = e.target.closest('.pm-card');
      if (!card) return;

      // Don't intercept clicks on buttons or links inside the card
      if (e.target.closest('a, button, .pm-copy-btn')) return;

      var link = card.querySelector('.pm-card-title a');
      if (link && link.href) {
        window.location.href = link.href;
      }
    });

    // Add pointer cursor to cards
    document.querySelectorAll('.pm-card').forEach(function (card) {
      card.style.cursor = 'pointer';
    });
  }

  /* ============================================================
     SCROLL REVEAL ANIMATION
  ============================================================ */
  function initScrollReveal() {
    if (!('IntersectionObserver' in window)) return;

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('pm-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.pm-card').forEach(function (el) {
      observer.observe(el);
    });
  }

  /* ============================================================
     SEARCH INPUT CLEAR BUTTON
  ============================================================ */
  function initSearchClear() {
    document.querySelectorAll('.pm-search-input').forEach(function (input) {
      input.addEventListener('input', function () {
        var wrap = input.closest('.pm-search-wrap');
        if (!wrap) return;
        var clearBtn = wrap.querySelector('.pm-search-clear');
        if (input.value.length > 0) {
          if (!clearBtn) {
            clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'pm-search-clear';
            clearBtn.setAttribute('aria-label', 'Clear search');
            clearBtn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
            clearBtn.addEventListener('click', function () {
              input.value = '';
              input.focus();
              clearBtn.remove();
            });
            wrap.appendChild(clearBtn);
          }
        } else if (clearBtn) {
          clearBtn.remove();
        }
      });
    });
  }

  /* ============================================================
     INIT ALL
  ============================================================ */
  document.addEventListener('DOMContentLoaded', function () {
    initCopyButtons();
    initMobileNav();
    initStickyHeader();
    initCardClick();
    initScrollReveal();
    initSearchClear();
  });

})();
