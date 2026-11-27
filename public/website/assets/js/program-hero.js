/**
 * LAZ Graha Dhuafa Indonesia — Reusable Program Hero Controller (v1.1)
 * - Sudut perspektif 3D natural (menghadap serong ke arah teks di kiri)
 * - 3D Logo Tilt + Specular Shine mengikuti kursor (khusus non-sentuh)
 * - Parallax halus foto latar (mouse + scroll) pada 60fps via requestAnimationFrame
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

    function splitTitleIntoChars(titleEl) {
        if (!titleEl || titleEl.dataset.phSplit === '1') {
            return titleEl ? titleEl.querySelectorAll('.program-hero__char') : [];
        }

        var rawText = (titleEl.textContent || '').trim();
        titleEl.dataset.phSplit = '1';
        if (!rawText) return [];

        titleEl.setAttribute('aria-label', rawText);
        titleEl.textContent = '';

        var words = rawText.split(/\s+/);
        var chars = [];

        words.forEach(function (word, wIdx) {
            var wordSpan = document.createElement('span');
            wordSpan.className = 'program-hero__word';
            wordSpan.setAttribute('aria-hidden', 'true');

            Array.from(word).forEach(function (ch) {
                var charSpan = document.createElement('span');
                charSpan.className = 'program-hero__char';
                charSpan.textContent = ch;
                wordSpan.appendChild(charSpan);
                chars.push(charSpan);
            });

            titleEl.appendChild(wordSpan);

            if (wIdx < words.length - 1) {
                titleEl.appendChild(document.createTextNode(' '));
            }
        });

        return chars;
    }

    function runEntranceAnimation(heroEl, isReducedMotion) {
        if (isReducedMotion || typeof window.gsap === 'undefined') {
            return;
        }

        var gsap = window.gsap;
        var titleEl = heroEl.querySelector('[data-ph-title]');
        var lineEl = heroEl.querySelector('[data-ph-line]');
        var subtitleEl = heroEl.querySelector('[data-ph-subtitle]');
        var descEl = heroEl.querySelector('[data-ph-desc]');
        var visualEl = heroEl.querySelector('[data-ph-visual]');
        var scrollEl = heroEl.querySelector('[data-ph-scroll]');

        var chars = splitTitleIntoChars(titleEl);
        var tl = gsap.timeline({
            defaults: { ease: 'power3.out' }
        });

        if (visualEl) {
            gsap.set(visualEl, { opacity: 0, scale: 0.86, x: 24 });
            tl.to(visualEl, {
                opacity: 1,
                scale: 1,
                x: 0,
                duration: 1.0,
                ease: 'back.out(1.22)',
                clearProps: 'transform'
            }, 0.06);
        }

        if (chars.length > 0) {
            gsap.set(chars, { opacity: 0, y: 26 });
            tl.to(chars, {
                opacity: 1,
                y: 0,
                duration: 0.58,
                stagger: 0.028,
                clearProps: 'transform'
            }, 0.05);
        } else if (titleEl) {
            gsap.set(titleEl, { opacity: 0, x: -24 });
            tl.to(titleEl, { opacity: 1, x: 0, duration: 0.65, clearProps: 'transform' }, 0.05);
        }

        if (lineEl) {
            gsap.set(lineEl, { opacity: 0, scaleX: 0 });
            tl.to(lineEl, {
                opacity: 1,
                scaleX: 1,
                duration: 0.6,
                ease: 'power3.inOut'
            }, '-=0.32');
        }

        if (subtitleEl) {
            gsap.set(subtitleEl, { opacity: 0, x: -16, y: 8 });
            tl.to(subtitleEl, {
                opacity: 1,
                x: 0,
                y: 0,
                duration: 0.55,
                clearProps: 'transform'
            }, '-=0.42');
        }

        if (descEl) {
            gsap.set(descEl, { opacity: 0, y: 18 });
            tl.to(descEl, {
                opacity: 1,
                y: 0,
                duration: 0.62,
                clearProps: 'transform'
            }, '-=0.30');
        }

        if (scrollEl) {
            gsap.set(scrollEl, { opacity: 0, y: 12 });
            tl.to(scrollEl, {
                opacity: 0.78,
                y: 0,
                duration: 0.5
            }, '-=0.25');
        }
    }

    function getBasePose() {
        var isDesktop = (window.innerWidth || document.documentElement.clientWidth) >= 992;
        if (isDesktop) {
            return { rotX: 9, rotY: -20, rotZ: -1.5, shineX: -44, shineY: -48, shineOpacity: 0.34 };
        }
        return { rotX: 8, rotY: -12, rotZ: -1, shineX: -28, shineY: -32, shineOpacity: 0.28 };
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

        if (isReducedMotion) {
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
            scrollYOffset: 0,

            targetRotX: basePose.rotX,
            targetRotY: basePose.rotY,
            targetRotZ: basePose.rotZ,
            currRotX: basePose.rotX,
            currRotY: basePose.rotY,
            currRotZ: basePose.rotZ,

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
            state.targetRotZ = basePose.rotZ;
            scheduleTick();
        }, { passive: true });

        function scheduleTick() {
            if (state.rafId === null && state.isVisible) {
                state.rafId = window.requestAnimationFrame(tick);
            }
        }

        function tick() {
            state.rafId = null;

            var ease = 0.09;
            var keepRunning = false;

            if (bgParallaxEl) {
                var desiredBgY = state.targetBgY + state.scrollYOffset;
                state.currBgX += (state.targetBgX - state.currBgX) * ease;
                state.currBgY += (desiredBgY - state.currBgY) * ease;

                bgParallaxEl.style.transform =
                    'translate3d(' + state.currBgX.toFixed(2) + 'px, ' + state.currBgY.toFixed(2) + 'px, 0)';

                if (
                    Math.abs(state.targetBgX - state.currBgX) > 0.08 ||
                    Math.abs(desiredBgY - state.currBgY) > 0.08
                ) {
                    keepRunning = true;
                }
            }

            if (canUseMouse && tiltEl) {
                state.currRotX += (state.targetRotX - state.currRotX) * 0.10;
                state.currRotY += (state.targetRotY - state.currRotY) * 0.10;
                state.currRotZ += (state.targetRotZ - state.currRotZ) * 0.10;

                tiltEl.style.transform =
                    'rotateX(' + state.currRotX.toFixed(2) + 'deg) ' +
                    'rotateY(' + state.currRotY.toFixed(2) + 'deg) ' +
                    'rotateZ(' + state.currRotZ.toFixed(2) + 'deg)';

                if (
                    Math.abs(state.targetRotX - state.currRotX) > 0.04 ||
                    Math.abs(state.targetRotY - state.currRotY) > 0.04
                ) {
                    keepRunning = true;
                }

                if (shineEl) {
                    state.currShineX += (state.targetShineX - state.currShineX) * 0.13;
                    state.currShineY += (state.targetShineY - state.currShineY) * 0.13;
                    state.currShineOpacity += (state.targetShineOpacity - state.currShineOpacity) * 0.12;

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

        function updateScrollParallax() {
            var rect = heroEl.getBoundingClientRect();
            var vh = window.innerHeight || document.documentElement.clientHeight;
            if (rect.bottom < 0 || rect.top > vh) {
                return;
            }
            var progress = -rect.top / Math.max(rect.height, 1);
            var clamped = Math.max(-0.25, Math.min(1.15, progress));
            state.scrollYOffset = clamped * 34;
            scheduleTick();
        }

        window.addEventListener('scroll', updateScrollParallax, { passive: true });
        updateScrollParallax();

        if ('IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    state.isVisible = entry.isIntersecting;
                    if (state.isVisible) {
                        updateScrollParallax();
                    }
                });
            }, { threshold: 0 });
            io.observe(heroEl);
        }

        if (!canUseMouse) {
            return;
        }

        var TILT_SWING_X = 14;
        var TILT_SWING_Y = 18;
        var MAX_BG_SHIFT = 14;

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

                var radius = Math.max(logoRect.width * 1.25, 280);
                var dx = (e.clientX - logoCenterX) / radius;
                var dy = (e.clientY - logoCenterY) / radius;

                var clampedX = Math.max(-1, Math.min(1, dx));
                var clampedY = Math.max(-1, Math.min(1, dy));

                // Berayun mulus di sekitar sudut perspektif 3D dasar (tetap berdimensi)
                state.targetRotY = (basePose.rotY * 0.55) + (clampedX * TILT_SWING_Y);
                state.targetRotX = (basePose.rotX * 0.55) - (clampedY * TILT_SWING_X);
                state.targetRotZ = basePose.rotZ + (clampedX * 1.6);

                state.targetShineX = clampedX * (logoRect.width * 0.36);
                state.targetShineY = clampedY * (logoRect.height * 0.36);
                state.targetShineOpacity = 0.86;
            }

            scheduleTick();
        }, { passive: true });

        heroEl.addEventListener('mouseleave', function () {
            state.targetBgX = 0;
            state.targetBgY = 0;
            state.targetRotX = basePose.rotX;
            state.targetRotY = basePose.rotY;
            state.targetRotZ = basePose.rotZ;
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
