/**
 * LAZ Graha Dhuafa Indonesia — Reusable Program Hero Controller (v1.2)
 * - Teks masuk bergantian (fade + slide up) saat halaman dimuat
 * - 3D Logo Tilt + Specular Shine halus mengikuti mouse (khusus non-sentuh)
 * - Parallax halus foto latar mengikuti mouse (60fps via requestAnimationFrame)
 * - Menghormati prefers-reduced-motion & perangkat sentuh
 */
(function () {
    'use strict';

    var reducedMotionQuery = window.matchMedia
        ? window.matchMedia('(prefers-reduced-motion: reduce)')
        : { matches: false };

    var finePointerQuery = window.matchMedia
        ? window.matchMedia('(hover: hover) and (pointer: fine)')
        : { matches: false };

    /**
     * Teks masuk bergantian (fade + slide up) + logo masuk halus saat halaman dimuat
     */
    function runEntranceAnimation(heroEl, isReducedMotion) {
        if (isReducedMotion || typeof window.gsap === 'undefined') {
            return;
        }

        var gsap = window.gsap;
        var titleEl = heroEl.querySelector('[data-ph-title]');
        var subtitleEl = heroEl.querySelector('[data-ph-subtitle]');
        var descEl = heroEl.querySelector('[data-ph-desc]');
        var visualEl = heroEl.querySelector('[data-ph-visual]');
        var scrollEl = heroEl.querySelector('[data-ph-scroll]');

        var tl = gsap.timeline({
            defaults: { ease: 'power3.out' }
        });

        var textItems = [titleEl, subtitleEl, descEl].filter(Boolean);
        if (textItems.length > 0) {
            gsap.set(textItems, { opacity: 0, y: 22 });
            tl.to(textItems, {
                opacity: 1,
                y: 0,
                duration: 0.72,
                stagger: 0.14,
                clearProps: 'transform'
            }, 0.06);
        }

        if (visualEl) {
            gsap.set(visualEl, { opacity: 0, scale: 0.92, y: 16 });
            tl.to(visualEl, {
                opacity: 1,
                scale: 1,
                y: 0,
                duration: 0.85,
                clearProps: 'transform'
            }, 0.12);
        }

        if (scrollEl) {
            gsap.set(scrollEl, { opacity: 0 });
            tl.to(scrollEl, {
                opacity: 0.78,
                duration: 0.5
            }, '-=0.25');
        }
    }

    function getBasePose() {
        var isDesktop = (window.innerWidth || document.documentElement.clientWidth) >= 992;
        if (isDesktop) {
            return { rotX: 5, rotY: -10, shineX: -36, shineY: -40, shineOpacity: 0.22 };
        }
        return { rotX: 4, rotY: -6, shineX: -24, shineY: -28, shineOpacity: 0.18 };
    }

    function initHeroInstance(heroEl) {
        var isReducedMotion = !!reducedMotionQuery.matches;
        var canUseMouse = !!finePointerQuery.matches && !isReducedMotion;

        runEntranceAnimation(heroEl, isReducedMotion);

        var scrollLink = heroEl.querySelector('[data-ph-scroll]');
        if (scrollLink) {
            scrollLink.addEventListener('click', function (e) {
                var href = scrollLink.getAttribute('href');
                if (href && href.charAt(0) === '#' && href.length > 1) {
                    var target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: isReducedMotion ? 'auto' : 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        }

        if (isReducedMotion || !canUseMouse) {
            return;
        }

        var bgParallaxEl = heroEl.querySelector('[data-ph-bg-parallax]');
        var tiltEl = heroEl.querySelector('[data-ph-tilt]');
        var shineEl = heroEl.querySelector('[data-ph-shine]');

        var basePose = getBasePose();

        var state = {
            targetBgX: 0,
            targetBgY: 0,
            currBgX: 0,
            currBgY: 0,

            targetRotX: basePose.rotX,
            targetRotY: basePose.rotY,
            currRotX: basePose.rotX,
            currRotY: basePose.rotY,

            targetShineX: basePose.shineX,
            targetShineY: basePose.shineY,
            currShineX: basePose.shineX,
            currShineY: basePose.shineY,
            targetShineOpacity: basePose.shineOpacity,
            currShineOpacity: basePose.shineOpacity,

            rafId: null,
            isVisible: true
        };

        window.addEventListener('resize', function () {
            basePose = getBasePose();
            state.targetRotX = basePose.rotX;
            state.targetRotY = basePose.rotY;
            scheduleTick();
        }, { passive: true });

        function scheduleTick() {
            if (state.rafId === null && state.isVisible) {
                state.rafId = window.requestAnimationFrame(tick);
            }
        }

        function tick() {
            state.rafId = null;

            var keepRunning = false;

            if (bgParallaxEl) {
                state.currBgX += (state.targetBgX - state.currBgX) * 0.08;
                state.currBgY += (state.targetBgY - state.currBgY) * 0.08;

                bgParallaxEl.style.transform =
                    'translate3d(' + state.currBgX.toFixed(2) + 'px, ' + state.currBgY.toFixed(2) + 'px, 0)';

                if (
                    Math.abs(state.targetBgX - state.currBgX) > 0.06 ||
                    Math.abs(state.targetBgY - state.currBgY) > 0.06
                ) {
                    keepRunning = true;
                }
            }

            if (tiltEl) {
                state.currRotX += (state.targetRotX - state.currRotX) * 0.10;
                state.currRotY += (state.targetRotY - state.currRotY) * 0.10;

                tiltEl.style.transform =
                    'rotateX(' + state.currRotX.toFixed(2) + 'deg) ' +
                    'rotateY(' + state.currRotY.toFixed(2) + 'deg)';

                if (
                    Math.abs(state.targetRotX - state.currRotX) > 0.04 ||
                    Math.abs(state.targetRotY - state.currRotY) > 0.04
                ) {
                    keepRunning = true;
                }

                if (shineEl) {
                    state.currShineX += (state.targetShineX - state.currShineX) * 0.12;
                    state.currShineY += (state.targetShineY - state.currShineY) * 0.12;
                    state.currShineOpacity += (state.targetShineOpacity - state.currShineOpacity) * 0.10;

                    shineEl.style.transform =
                        'translate3d(' + state.currShineX.toFixed(1) + 'px, ' + state.currShineY.toFixed(1) + 'px, 0)';
                    shineEl.style.opacity = state.currShineOpacity.toFixed(3);

                    if (Math.abs(state.targetShineOpacity - state.currShineOpacity) > 0.01) {
                        keepRunning = true;
                    }
                }
            }

            if (keepRunning) {
                scheduleTick();
            }
        }

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    state.isVisible = entry.isIntersecting;
                });
            }, { threshold: 0 });
            io.observe(heroEl);
        }

        var TILT_SWING_X = 12;
        var TILT_SWING_Y = 15;
        var MAX_BG_SHIFT = 12;

        heroEl.addEventListener('mousemove', function (e) {
            var heroRect = heroEl.getBoundingClientRect();
            var normHeroX = ((e.clientX - heroRect.left) / Math.max(heroRect.width, 1)) - 0.5;
            var normHeroY = ((e.clientY - heroRect.top) / Math.max(heroRect.height, 1)) - 0.5;

            state.targetBgX = -normHeroX * MAX_BG_SHIFT * 2;
            state.targetBgY = -normHeroY * MAX_BG_SHIFT * 1.4;

            if (tiltEl) {
                var logoRect = tiltEl.getBoundingClientRect();
                var logoCenterX = logoRect.left + logoRect.width / 2;
                var logoCenterY = logoRect.top + logoRect.height / 2;

                var radius = Math.max(logoRect.width * 1.35, 280);
                var dx = (e.clientX - logoCenterX) / radius;
                var dy = (e.clientY - logoCenterY) / radius;

                var clampedX = Math.max(-1, Math.min(1, dx));
                var clampedY = Math.max(-1, Math.min(1, dy));

                state.targetRotY = (basePose.rotY * 0.5) + (clampedX * TILT_SWING_Y);
                state.targetRotX = (basePose.rotX * 0.5) - (clampedY * TILT_SWING_X);

                state.targetShineX = clampedX * (logoRect.width * 0.34);
                state.targetShineY = clampedY * (logoRect.height * 0.34);
                state.targetShineOpacity = 0.62;
            }

            scheduleTick();
        }, { passive: true });

        heroEl.addEventListener('mouseleave', function () {
            state.targetBgX = 0;
            state.targetBgY = 0;
            state.targetRotX = basePose.rotX;
            state.targetRotY = basePose.rotY;
            state.targetShineX = basePose.shineX;
            state.targetShineY = basePose.shineY;
            state.targetShineOpacity = basePose.shineOpacity;
            scheduleTick();
        }, { passive: true });
    }

    function bootAllProgramHeroes() {
        var heroes = document.querySelectorAll('[data-program-hero]');
        heroes.forEach(function (heroEl) {
            if (heroEl.dataset.phReady === '1') return;
            heroEl.dataset.phReady = '1';
            initHeroInstance(heroEl);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootAllProgramHeroes);
    } else {
        bootAllProgramHeroes();
    }
})();
