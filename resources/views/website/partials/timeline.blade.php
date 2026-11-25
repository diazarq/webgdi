<!-- ====== Slider Pilar Program (Scroll-Snap + Tombol) ====== -->
<div class="container program-slider-section">
  <div class="program-slider">
    <div class="program-slider__viewport">
      <div class="program-slider__track">
        <!-- Kartu 1 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://www.dompetdhuafa.org/wp-content/uploads/2024/04/Arwan-Angkat-Derajat-Keluarga_2.jpg" alt="Pendidikan">
          </div>
        </div>
        <!-- Kartu 2 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://www.dompetdhuafa.org/wp-content/uploads/2022/03/Dakwah-dan-Budaya-ilustrasi.jpeg" alt="Dakwah & Budaya">
          </div>
        </div>
        <!-- Kartu 3 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://www.dompetdhuafa.org/wp-content/uploads/2022/11/IMG-20221107-WA0016-01.jpeg" alt="Ekonomi">
          </div>
        </div>
        <!-- Kartu 4 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://donasi.dompetdhuafa.org/wp-content/uploads/2019/08/kesehatan-dhuafa-1.jpg" alt="Kesehatan">
          </div>
        </div>
        <!-- Kartu 5 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://storage.googleapis.com/pyd-upload/website/page/1703914398526_bantuan-lansia-dhuafa.jpg" alt="Sosial & Kemanusiaan">
          </div>
        </div>
        <!-- Kartu 6 -->
        <div class="program-slider__slide">
          <div class="pilar-card">
            <img src="https://storage.googleapis.com/pyd-upload/website/page/1703908868132_hibah.jpg" alt="Wakaf & Hibah">
          </div>
        </div>
      </div>
    </div>

    <!-- Tombol Navigasi (Kiri & Kanan Luar Kartu) -->
    <button type="button" class="program-slider__btn program-slider__btn--prev" aria-label="Previous">
      <span>&lsaquo;</span>
    </button>
    <button type="button" class="program-slider__btn program-slider__btn--next" aria-label="Next">
      <span>&rsaquo;</span>
    </button>
  </div>
</div>
<!-- ====== End Slider ====== -->

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

/* Section wrapper: posisi alami di bawah navbar, beri ruang atas agar
   shadow & border atas kartu tidak terpotong */
.program-slider-section {
    position: relative;
    z-index: 1;
    padding-top: 60px;
    padding-bottom: 60px;
}

/* Wrapper slider khusus: posisi relatif agar tombol mengacu ke area slider, bukan halaman */
.program-slider {
    position: relative;
    z-index: 1;
    font-family: 'Poppins', sans-serif;
}

/* Area geser: scroll native + snap halus.
   overflow-y: hidden DIPERLUKAN untuk scroll horizontal bersih,
   padding atas/bawah yang cukup mencegah shadow kartu terpotong */
.program-slider__viewport {
    overflow-x: auto;
    overflow-y: hidden;
    padding: 20px 0 28px;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    cursor: grab;
}

.program-slider__viewport::-webkit-scrollbar {
    display: none;
}

.program-slider__viewport.is-dragging {
    cursor: grabbing;
    user-select: none;
}

.program-slider__track {
    display: flex;
    gap: 24px;
}

/* 1 kartu per layar (HP) */
.program-slider__slide {
    flex: 0 0 100%;
    scroll-snap-align: start;
}

/* 2 kartu per layar (>= 576px) */
@media (min-width: 576px) {
    .program-slider__slide {
        flex-basis: calc((100% - 24px) / 2);
    }
}

/* 3 kartu per layar (>= 768px) — col-md-4 */
@media (min-width: 768px) {
    .program-slider__slide {
        flex-basis: calc((100% - 48px) / 3);
    }
}

.pilar-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    background: #fff;
    padding: 0;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.pilar-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.22);
}

.pilar-card img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    display: block;
    pointer-events: none;
}

/* Tombol navigasi: lingkaran hijau, di luar kartu, tengah vertikal */
.program-slider__btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 45px;
    height: 45px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 50%;
    background: #00875A;
    color: #fff;
    font-size: 26px;
    line-height: 1;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.18);
    transition: background 0.3s, transform 0.2s;
    padding: 0;
}

.program-slider__btn--prev {
    left: -20px;
}

.program-slider__btn--next {
    right: -20px;
}

.program-slider__btn--prev:hover,
.program-slider__btn--next:hover {
    background: #00a06b;
    transform: translateY(-50%) scale(1.06);
}

.program-slider__btn--prev:active,
.program-slider__btn--next:active {
    transform: translateY(-50%) scale(0.96);
}

/* Responsive */
@media (max-width: 767px) {
    .program-slider__btn {
        width: 40px;
        height: 40px;
        font-size: 22px;
    }

    .program-slider__btn--prev {
        left: -12px;
    }

    .program-slider__btn--next {
        right: -12px;
    }

    .pilar-card img {
        height: 190px;
    }
}
</style>

<script>
(function () {
    var viewport = document.querySelector(".program-slider__viewport");
    var track = document.querySelector(".program-slider__track");
    var slides = Array.prototype.slice.call(document.querySelectorAll(".program-slider__slide"));
    var prevBtn = document.querySelector(".program-slider__btn--prev");
    var nextBtn = document.querySelector(".program-slider__btn--next");

    if (!viewport || !track || !slides.length || !prevBtn || !nextBtn) return;

    function perView() {
        var w = window.innerWidth || document.documentElement.clientWidth;
        return w >= 768 ? 3 : 1;
    }

    function step() {
        var gap = parseFloat(getComputedStyle(track).gap) || 24;
        return slides[0].getBoundingClientRect().width + gap;
    }

    function maxIndex() {
        return Math.max(0, slides.length - perView());
    }

    function currentIndex() {
        return Math.round(viewport.scrollLeft / step());
    }

    // Tombol navigasi (loop halus)
    function goTo(i) {
        var max = maxIndex();
        if (i > max) i = 0;
        else if (i < 0) i = max;
        viewport.scrollTo({ left: i * step(), behavior: "smooth" });
    }

    prevBtn.addEventListener("click", function () { goTo(currentIndex() - 1); });
    nextBtn.addEventListener("click", function () { goTo(currentIndex() + 1); });

    // Drag pakai mouse (layar sentuh/trackpad ditangani scroll native)
    var isDown = false;
    var startX = 0;
    var startScroll = 0;

    viewport.addEventListener("pointerdown", function (e) {
        if (e.pointerType !== "mouse") return;
        isDown = true;
        startX = e.clientX;
        startScroll = viewport.scrollLeft;
        viewport.classList.add("is-dragging");
    });

    viewport.addEventListener("pointermove", function (e) {
        if (!isDown) return;
        viewport.scrollLeft = startScroll - (e.clientX - startX);
    });

    function stopDrag() {
        isDown = false;
        viewport.classList.remove("is-dragging");
    }
    viewport.addEventListener("pointerup", stopDrag);
    viewport.addEventListener("pointercancel", stopDrag);
    viewport.addEventListener("pointerleave", stopDrag);

    // Hindari seret gambar saat drag dimulai dari gambar
    viewport.addEventListener("mousedown", function (e) {
        if (e.button === 0 && e.target.tagName === "IMG") e.preventDefault();
    });
})();
</script>