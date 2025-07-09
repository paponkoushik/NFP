<link rel="" href="https://fonts.googleapis.com/css?family=Fjalla+One" />
<link rel="" href="https://fonts.googleapis.com/css?family=Noto+Sans" />
<style>
    .flickity-enabled {
        position: relative;
    }
    .flickity-enabled:focus {
        outline: 0;
    }
    .flickity-viewport {
        overflow: hidden;
        position: relative;
        height: 100%;
    }
    .flickity-slider {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    .flickity-enabled.is-draggable {
        -webkit-tap-highlight-color: transparent;
        tap-highlight-color: transparent;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .flickity-enabled.is-draggable .flickity-viewport {
        cursor: move;
        cursor: -webkit-grab;
        cursor: grab;
    }
    .flickity-enabled.is-draggable .flickity-viewport.is-pointer-down {
        cursor: -webkit-grabbing;
        cursor: grabbing;
    }
    .flickity-prev-next-button {
        position: absolute;
        top: 50%;
        width: 44px;
        height: 44px;
        border: none;
        border-radius: 50%;
        background: #fff;
        background: rgba(255, 255, 255, 0.75);
        cursor: pointer;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }
    .flickity-prev-next-button:hover {
        background: #fff;
    }
    .flickity-prev-next-button:focus {
        outline: 0;
        box-shadow: 0 0 0 5px #09f;
    }
    .flickity-prev-next-button:active {
        opacity: 0.6;
    }
    .flickity-prev-next-button.previous {
        left: 10px;
    }
    .flickity-prev-next-button.next {
        right: 10px;
    }
    .flickity-rtl .flickity-prev-next-button.previous {
        left: auto;
        right: 10px;
    }
    .flickity-rtl .flickity-prev-next-button.next {
        right: auto;
        left: 10px;
    }
    .flickity-prev-next-button:disabled {
        opacity: 0.3;
        cursor: auto;
    }
    .flickity-prev-next-button svg {
        position: absolute;
        left: 20%;
        top: 20%;
        width: 60%;
        height: 60%;
    }
    .flickity-prev-next-button .arrow {
        fill: #333;
    }
    .flickity-page-dots {
        position: absolute;
        width: 100%;
        bottom: -25px;
        padding: 0;
        margin: 0;
        list-style: none;
        text-align: center;
        line-height: 1;
    }
    .flickity-rtl .flickity-page-dots {
        direction: rtl;
    }
    .flickity-page-dots .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin: 0 8px;
        background: #333;
        border-radius: 50%;
        opacity: 0.25;
        cursor: pointer;
    }
    .flickity-page-dots .dot.is-selected {
        opacity: 1;
    }

    body {
        background-color: #000;
    }

    .overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to bottom, rgba(14, 29, 51, 0.8), rgba(14, 29, 51, 0.2));
    }

    .hero-slider {
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }
    .hero-slider .carousel-cell {
        width: 100%;
        height: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
    }
    .hero-slider .carousel-cell .slide-content {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
        text-align: center;
    }
    .hero-slider .carousel-cell .slide-content .title {
        position: relative;
        font-family: "Fjalla One", sans-serif;
        font-size: 3.2rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #ffffff;
    }
    .hero-slider .carousel-cell .slide-content .caption {
        font-family: "Noto Sans", sans-serif;
        font-size: 2.2rem;
        color: #ffffff;
        margin-bottom: 30px;
    }
    .hero-slider .carousel-cell .slide-content .btn {
        display: inline-block;
        border: 1px solid #fff;
        padding: 14px 18px;
        text-transform: uppercase;
        font-family: "Noto Sans", sans-serif;
        font-size: 0.9rem;
        letter-spacing: 2px;
        color: #fff;
        text-decoration: none;
    }
    .hero-slider .carousel-cell .slide-content .btn:hover {
        background: #fff;
        color: #000;
        transition: all 0.2s ease;
    }
    .hero-slider .flickity-prev-next-button {
        width: 80px;
        height: 80px;
        background: transparent;
    }
    .hero-slider .flickity-prev-next-button:hover {
        background: transparent;
    }
    .hero-slider .flickity-prev-next-button .arrow {
        fill: white;
    }
    .hero-slider .flickity-page-dots {
        bottom: 30px;
    }
    .hero-slider .flickity-page-dots .dot {
        width: 30px;
        height: 4px;
        opacity: 1;
        background: rgba(255, 255, 255, 0.5);
        border: 0 solid white;
        border-radius: 0;
    }
    .hero-slider .flickity-page-dots .dot.is-selected {
        background: #ff0000;
        border: 0 solid #ff0000;
    }

    /* --------------------------------
    Masking
    -------------------------------- */
    .slide-content .title,
    .slide-content .caption,
    .slide-content .btn {
        position: relative;
        opacity: 0;
        -webkit-animation-fill-mode: forwards;
        animation-fill-mode: forwards;
    }

    .slide-content.mask .mask {
        position: relative;
        overflow: hidden;
    }
    .slide-content.mask .title {
        -webkit-animation-duration: 0.4s;
        animation-duration: 0.4s;
        -webkit-animation-delay: 0.7s;
        animation-delay: 0.7s;
        -webkit-animation-name: slide-up;
        animation-name: slide-up;
        -webkit-animation-fill-mode: backwards;
        animation-fill-mode: backwards;
        opacity: 1;
    }
    .slide-content.mask .divider {
        display: inline-block;
        position: relative;
        margin: 5px auto;
        height: 2px;
        width: 60%;
        background-color: #ffffff;
        -webkit-animation: divider-mask 1s 0.3s both;
        animation: divider-mask 1s 0.3s both;
    }
    .slide-content.mask .caption,
    .slide-content.mask .btn {
        -webkit-animation-duration: 0.4s;
        animation-duration: 0.4s;
        -webkit-animation-delay: 0.7s;
        animation-delay: 0.7s;
        -webkit-animation-name: slide-down;
        animation-name: slide-down;
    }

    @-webkit-keyframes slide-up {
        0% {
            opacity: 0;
            -webkit-transform: translateY(100%);
        }
        100% {
            opacity: 1;
            -webkit-transform: translateY(0);
        }
    }
    @keyframes slide-up {
        0% {
            opacity: 0;
            transform: translateY(100%);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @-webkit-keyframes slide-down {
        0% {
            opacity: 0;
            -webkit-transform: translateY(-100%);
        }
        100% {
            opacity: 1;
            -webkit-transform: translateY(0);
        }
    }
    @keyframes slide-down {
        0% {
            opacity: 0;
            transform: translateY(-100%);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @-webkit-keyframes divider-mask {
        0%,
        100% {
            transform: scaleX(0);
        }
        40%,
        60% {
            -webkit-transform: scaleX(1);
        }
    }
    @keyframes divider-mask {
        0%,
        100% {
            transform: scaleX(0);
        }
        40%,
        60% {
            transform: scaleX(1);
        }
    }
</style>

<div class="hero-slider" data-carousel>
    <div class="carousel-cell" style="background-image: url(https://78media.tumblr.com/469798be38e86cc01ea4ba08563af785/tumblr_p38kazKBIX1snegd3o1_1280.jpg);">
        <div class="overlay"></div>
        <div class="slide-content">
            <div class="mask">
                <h2 class="title">Slide 1</h2>
            </div>
            <div class="divider"></div>
            <div class="mask">
                <p class="caption">NFP platform is fun to use.</p>
                <a href="/" target="_blank" class="btn">Tell me more</a>
            </div>
        </div>
    </div>
    <div class="carousel-cell" style="background-image: url(https://78media.tumblr.com/f3577e640674f66119dad5ce61b4582c/tumblr_ozf8vw9LYN1snegd3o1_1280.jpg);">
        <div class="overlay"></div>
        <div class="slide-content">
            <div class="mask">
                <h2 class="title">Slide 2</h2>
            </div>
            <div class="divider"></div>
            <div class="mask">
                <p class="caption">NFP platform is flexible.</p>
                <a href="/" target="_blank" class="btn">Tell me more</a>
            </div>
        </div>
    </div>
    <div class="carousel-cell" style="background-image: url(https://78media.tumblr.com/895918f98ebb3644e885f663bf63ba61/tumblr_pa4fmzV4kV1snegd3o1_1280.jpg);">
        <div class="overlay"></div>
        <div class="slide-content">
            <div class="mask">
                <h2 class="title">Slide 3</h2>
            </div>
            <div class="divider"></div>
            <div class="mask">
                <p class="caption">NFP platform is awesome.</p>
                <a href="/" target="_blank" class="btn">Tell me more</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.1.0/flickity.pkgd.min.js" defer></script>
<script>
    setTimeout(() => {
        var options = {
            accessibility: true,
            prevNextButtons: true,
            pageDots: true,
            setGallerySize: false,
            arrowShape: {
                x0: 10,
                x1: 60,
                y1: 50,
                x2: 60,
                y2: 45,
                x3: 15,
            },
        };

        var $carousel = $("[data-carousel]").flickity(options);
        var $slideContent = $(".slide-content");
        var flkty = $carousel.data("flickity");
        var selectedSlide = flkty.selectedElement;

        flkty.on("settle", function (index) {
            selectedSlide = flkty.selectedElement;
        });

        flkty.on("change", function (index) {
            $slideContent.eq(index).removeClass("mask");

            setTimeout(function () {
                $slideContent.addClass("mask");
            }, 500);
        });

        flkty.on("dragStart", function (event) {
            var index = 0;
            selectedSlide = flkty.selectedElement;

            if (event.layerX > 0) {
                // direction right
                index = $(selectedSlide).index() + 1;
            } else {
                // direction left
                index = $(selectedSlide).index() - 1;
            }

            $slideContent.eq(index).removeClass("mask");
        });

        setTimeout(function () {
            $slideContent.addClass("mask");
        }, 500);
    }, 1000);
</script>
