<style>
    :root {
        --bs-gray-100: #fefefe;
        --bs-gray-200: #f6f7f9;
        --bs-gray-300: #cacaca;
        --bs-gray-400: #aab0bc;
        --bs-gray-500: #959ca9;
        --bs-gray-600: #60697b;
        --bs-gray-700: #2f353a;
        --bs-gray-800: #21262c;
        --bs-gray-900: #1e2228;
        --bs-blue: #3f78e0;
        --bs-sky: #5eb9f0;
        --bs-purple: #747ed1;
        --bs-grape: #605dba;
        --bs-violet: #a07cc5;
        --bs-pink: #d16b86;
        --bs-fuchsia: #e668b3;
        --bs-red: #e2626b;
        --bs-orange: #f78b77;
        --bs-yellow: #fab758;
        --bs-green: #45c4a0;
        --bs-leaf: #7cb798;
        --bs-aqua: #54a8c7;
        --bs-navy: #343f52;
        --bs-ash: #9499a3;
        --bs-white: #fff;
        --bs-light: #fefefe;
        --bs-gray: #f6f7f9;
        --bs-dark: #262b32;
        --bs-primary: #894F9E;
        --bs-secondary: #aab0bc;
        --bs-success: #45c4a0;
        --bs-info: #54a8c7;
        --bs-warning: #fab758;
        --bs-danger: #e2626b;
        --bs-blue-rgb: 63, 120, 224;
        --bs-sky-rgb: 94, 185, 240;
        --bs-purple-rgb: 116, 126, 209;
        --bs-grape-rgb: 96, 93, 186;
        --bs-violet-rgb: 160, 124, 197;
        --bs-pink-rgb: 209, 107, 134;
        --bs-fuchsia-rgb: 230, 104, 179;
        --bs-red-rgb: 226, 98, 107;
        --bs-orange-rgb: 247, 139, 119;
        --bs-yellow-rgb: 250, 183, 88;
        --bs-green-rgb: 69, 196, 160;
        --bs-leaf-rgb: 124, 183, 152;
        --bs-aqua-rgb: 84, 168, 199;
        --bs-navy-rgb: 52, 63, 82;
        --bs-ash-rgb: 148, 153, 163;
        --bs-white-rgb: 255, 255, 255;
        --bs-light-rgb: 254, 254, 254;
        --bs-gray-rgb: 246, 247, 249;
        --bs-dark-rgb: 38, 43, 50;
        --bs-primary-rgb: 63, 120, 224;
        --bs-secondary-rgb: 170, 176, 188;
        --bs-success-rgb: 69, 196, 160;
        --bs-info-rgb: 84, 168, 199;
        --bs-warning-rgb: 250, 183, 88;
        --bs-danger-rgb: 226, 98, 107;
        --bs-white-rgb: 255, 255, 255;
        --bs-black-rgb: 0, 0, 0;
        --bs-body-color-rgb: 96, 105, 123;
        --bs-body-bg-rgb: 254, 254, 254;
        --bs-font-sans-serif: "F37Zagma-Regular", sans-serif;
        --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        --bs-gradient: linear-gradient(180deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
        --bs-root-font-size: 20px;
        --bs-body-font-family: var(--bs-font-sans-serif);
        --bs-body-font-size: 0.8rem;
        --bs-body-font-weight: normal
        --bs-body-line-height: 1.7;
        --bs-body-color: #60697b;
        --bs-body-bg: #fefefe;
    }
    .post-header .post-meta {
    font-size: .8rem;
}
.post-meta {
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: .7rem;
    color: #aab0bc;
}
.post-meta li {
    display: inline-block;
    font-size: 16px;
    margin-right: 15px;
}
.post-meta li i {
    padding-right: 0.2rem;
    vertical-align: -0.05rem;
    font-size: 16px;
}
.card {
    box-shadow: 0 0 0 0.05rem rgba(8,60,130,.06), 0 0 1.25rem rgba(30,34,40,.04);
    border: 0;
}
.card {
    --bs-card-spacer-y: 2rem;
    --bs-card-spacer-x: 2rem;
    --bs-card-title-spacer-y: 0.5rem;
    --bs-card-border-width: 1px;
    --bs-card-border-color: rgba(164, 174, 198, 0.2);
    --bs-card-border-radius: 0.4rem;
    --bs-card-inner-border-radius: 0.4rem;
    --bs-card-cap-padding-y: 0.9rem;
    --bs-card-cap-padding-x: 2rem;
    --bs-card-cap-bg: transparent;
    --bs-card-bg: #fff;
    --bs-card-img-overlay-padding: 1rem;
    --bs-card-group-margin: 0.75rem;
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    height: var(--bs-card-height);
    word-wrap: break-word;
    background-color: var(--bs-card-bg);
    background-clip: border-box;
    border: var(--bs-card-border-width) solid var(--bs-card-border-color);
    border-radius: var(--bs-card-border-radius);
    box-shadow: var(--bs-card-box-shadow);
}
.card-img, .card-img-top {
    border-top-left-radius: var(--bs-card-inner-border-radius);
    border-top-right-radius: var(--bs-card-inner-border-radius);
}
.card-img, .card-img-bottom, .card-img-top {
    width: 100%;
}
figure {
    margin: 0;
    padding: 0;
}
.card-img-top img {
    border-top-left-radius: 0.4rem;
    border-top-right-radius: 0.4rem;
}
figure img {
    width: 100%;
    max-width: 100%;
    height: auto!important;
}
.blog.single .card-body {
    padding: 2.8rem 3rem 2.8rem;
}
.blog.single .post {
    margin-bottom: 0;
}
.post-content {
    position: relative;
}
.mt-8 {
    margin-top: 2rem!important;
}
.blog.single .post .tag-list li, .widget .tag-list li {
    margin-top: 0;
    margin-bottom: 0.45rem;
}
.tag-list li {
    display: inline-block;
    margin-right: 0.2rem;
    margin-bottom: 0.1rem;
}

.btn-soft-ash {
    --bs-btn-active-shadow: 0rem 0.25rem 0.75rem rgba(30, 34, 40, 0.05)!important;
    --bs-btn-color: #9499a3;
    --bs-btn-bg: #eeeff0;
    --bs-btn-border-color: #eeeff0;
    --bs-btn-hover-color: #9499a3;
    --bs-btn-hover-bg: #eeeff0;
    --bs-btn-hover-border-color: #eeeff0;
    --bs-btn-focus-shadow-rgb: 225,226,228;
    --bs-btn-active-color: #9499a3;
    --bs-btn-active-bg: #eeeff0;
    --bs-btn-active-border-color: #eeeff0;
    --bs-btn-active-shadow: 0rem 0.25rem 0.75rem rgba(30, 34, 40, 0.15);
    --bs-btn-disabled-color: #9499a3;
    --bs-btn-disabled-bg: #eeeff0;
    --bs-btn-disabled-border-color: #eeeff0;
}
.btn-soft-ash {
    --bs-btn-color: #343f52;
    --bs-btn-bg: rgba(164, 174, 198, 0.2);
    --bs-btn-border-color: transparent;
    --bs-btn-hover-color: #343f52;
    --bs-btn-hover-bg: rgba(164, 174, 198, 0.2);
    --bs-btn-hover-border-color: rgba(0, 0, 0, 0);
    --bs-btn-focus-shadow-rgb: 52,63,82;
    --bs-btn-active-color: #343f52;
    --bs-btn-active-bg: rgba(164, 174, 198, 0.2);
    --bs-btn-active-border-color: rgba(0, 0, 0, 0);
    --bs-btn-active-shadow: 0rem 0.25rem 0.75rem rgba(30, 34, 40, 0.15);
    --bs-btn-disabled-color: #343f52;
    --bs-btn-disabled-bg: rgba(164, 174, 198, 0.2);
    --bs-btn-disabled-border-color: transparent;
}
.btn-group-sm>.btn, .btn-sm {
    --bs-btn-padding-y: 0.4rem;
    --bs-btn-padding-x: 1rem;
    --bs-btn-font-size: 0.7rem;
    --bs-btn-border-radius: 0.4rem;
}
.btn:hover {
    color: var(--bs-btn-hover-color);
    background-color: var(--bs-btn-hover-bg);
    border-color: var(--bs-btn-hover-border-color);
}
.btn:not(.btn-link):hover {
    transform: translateY(-0.15rem);
    box-shadow: 0 0.25rem 0.75rem rgba(30,34,40,.15);
}
.btn.btn-white:hover, .btn[class*=btn-soft-]:hover {
    box-shadow: 0 0.25rem 0.75rem rgba(30,34,40,.05);
}
.btn-group {
    border-radius: 0.4rem;
}
.btn-group, .btn-group-vertical {
    position: relative;
    display: inline-flex;
    vertical-align: middle;
}
.dropdown-toggle {
    white-space: nowrap;
}
.btn-red {
    --bs-btn-active-bg: $value;
    --bs-btn-active-border-color: $value;
    --bs-btn-active-shadow: var(--bs-btn-box-shadow);
    --bs-btn-color: #fff;
    --bs-btn-bg: #e2626b;
    --bs-btn-border-color: #e2626b;
    --bs-btn-hover-color: #fff;
    --bs-btn-hover-bg: #e2626b;
    --bs-btn-hover-border-color: #e2626b;
    --bs-btn-focus-shadow-rgb: 230,122,129;
    --bs-btn-active-color: #fff;
    --bs-btn-active-bg: #e2626b;
    --bs-btn-active-border-color: #e2626b;
    --bs-btn-active-shadow: 0rem 0.25rem 0.75rem rgba(30, 34, 40, 0.15);
    --bs-btn-disabled-color: #fff;
    --bs-btn-disabled-bg: #e2626b;
    --bs-btn-disabled-border-color: #e2626b;
}
[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
    cursor: pointer;
}
.btn-group-vertical>.btn, .btn-group>.btn {
    position: relative;
    flex: 1 1 auto;
}
.btn-group-sm>.btn-icon.btn, .btn-icon.btn-sm {
    padding-top: 0.3rem;
    padding-bottom: 0.3rem;
}
.btn-icon.btn-icon-start i {
    margin-right: 0.3rem;
}
.btn-group-sm>.btn-icon.btn i, .btn-icon.btn-sm i {
    font-size: .8rem;
}
.share-dropdown .dropdown-menu {
    min-width: 6.25rem;
    margin-top: 1rem!important;
    padding-top: 0.65rem!important;
    padding-bottom: 0.65rem!important;
}
.dropdown-menu {
    border: 0;
}
.user-avatar {
    margin-right: 1rem;
    width: 3rem;
    height: 3rem;
    position: relative;
    border-radius: 100%;
}
.author-info .h6, .author-info h6 {
    margin-bottom: 0.2rem;
}
.link-dark {
    color: #343f52;
    font-weight: 500;
}
.fs-15 {
    font-size: .75rem!important;
}
.btn-group-sm>.btn-icon.btn, .btn-icon.btn-sm {
    padding-top: 0.3rem;
    padding-bottom: 0.3rem;
}
.h4, h4 {
    font-size: .95rem;
}
.unordered-list {
    padding-left: 0;
    list-style: none;
}
.unordered-list li {
    position: relative;
    padding-left: 1rem;
}
.text-reset a {
    color: inherit!important;
}
a {
    transition: all .2s ease-in-out;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-weight: 700;
    color: #343f52;
    word-spacing: 0.1rem;
    letter-spacing: -.01rem;
}
.h1, h1 {
    font-size: calc(1.27rem + .24vw);
}
@media (min-width: 1200px)
{
    .h1, h1 {
        font-size: 1.45rem;
    }
}
p {
    font-size: 17px;
}
.g-6, .gx-6 {
    --bs-gutter-y: 1.5rem;
}
.carousel, .carousel-cell-image {
    border-radius: 0.375rem !important;
}
ul.list-unstyled li a {
    font-weight: 500 !important;
}
.bx {
    font-size: 1rem;
}
.dropdown-item {
    display: block;
    width: 100%;
    padding: var(--bs-dropdown-item-padding-y) var(--bs-dropdown-item-padding-x);
    clear: both;
    font-weight: 500;
    color: #343f52;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}
.share-dropdown .dropdown-menu .dropdown-item {
    padding: 0.25rem 1.15rem;
    font-size: .7rem;
}
.dropdown-item {
    font-weight: 700;
    letter-spacing: -.01rem;
}
.share-dropdown .dropdown-menu .dropdown-item i {
    padding-right: 0.4rem;
    vertical-align: -0.1rem;
    width: 1rem;
    font-size: .8rem;
}
aside:not(.doc-sidebar) .widget+.widget {
    margin-top: 2rem;
}
.widget-title {
    font-size: 21px;
    font-weight: 500;
}
.widget .unordered-list {
    list-style: disc;
    margin-left: 25px;
}
.widget .unordered-list li {
    padding-left: 0rem;
    margin-bottom: 4px;
}
.user-avatar .org-logo {
    width: 48px !important;
    height: 48px !important;
    object-fit: cover;
}
</style>