<style>
    .join-us-box {
        position: relative;
        z-index: 2;
        overflow: hidden;
        border-radius: 10px;
        transition: transform .65s cubic-bezier(.05,.2,.1,1),box-shadow .65s cubic-bezier(.05,.2,.1,1);
    }
    .join-us-box .thumbnail a {
        display: block;
    }
    .join-us-box .thumbnail a img {
        box-shadow: 0 25px 65px rgb(0 0 0 / 10%);
        transition: transform 1s ease,opacity .5s ease .25s;
        border-radius: 10px;
        height: 480px;
        object-fit: cover;
    }
    .join-us-box:after {
        background: linear-gradient(180deg,transparent,#fd4766);
        background: linear-gradient(180deg,transparent, var(--color-primary));
        opacity: 0;
    }
    .join-us-box:before {
        background: linear-gradient(180deg,rgba(15,15,15,0),rgba(15,15,15,.75));
    }
    .join-us-box:after, .join-us-box:before {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 85%;
        display: block;
        z-index: 1;
        content: "";
        transition: opacity .65s cubic-bezier(.05,.2,.1,1);
        cursor: pointer;
    }
    .join-us-box .content .inner {
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 30px;
        z-index: 2;
        width: 100%;
        z-index: 3;
    }
    .transparent_link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2;
    }
    .join-us-box .content .inner .heading {
        transition: opacity .65s cubic-bezier(.05,.2,.1,1),transform .65s cubic-bezier(.05,.2,.1,1);
    }
    .join-us-box .content .category {
        margin: -5px -5px 5px;
    }
    .join-us-box .content .category a {
        color: #fff;
        opacity: 0.9;
        display: inline-block;
        margin: 5px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .5px;
    }
    .join-us-box .content .title {
        margin-bottom: 0;
    }
    .join-us-box .content .title a {
        color: #f8f8f8;
        font-size: 16px;
        line-height: 24px;
    }
    .join-us-box .content .inner .footer {
        opacity: 0;
        position: absolute;
        bottom: 35px;
        margin-top: 10px;
        transform: translateY(20px);
        line-height: 1.5em;
        max-width: 80%;
        transition: opacity .18s cubic-bezier(.05,.2,.1,1),transform .18s cubic-bezier(.05,.2,.1,1);
        background: transparent;
    }
    /* .new-nv-btn {
        border: 2px solid hsla(0,0%,100%,.2);
        color: #fff;
    } */
    .new-nv-btn {
        /* padding: 0 23px;
        height: 40px;
        display: inline-block;
        line-height: 34px;
        border: 2px solid #fff;
        border-radius: 4px;
        font-size: 14px; */
        position: relative;
        z-index: 2;
        /* color: #fff;
        letter-spacing: .2px;
        text-transform: uppercase; */
    }
    .join-us-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 55px rgb(253 71 102 / 22%);
    }
    .join-us-box:hover:before {
        opacity: 0;
    }
    .join-us-box:hover .thumbnail a img {
        transform: scale(1.1);
        transition: all 9s cubic-bezier(.1,.2,7,1);
    }
    .join-us-box:hover .content .inner .heading {
        transform: translateY(-62px);
        transition: opacity .65s cubic-bezier(.05,.2,.1,1),transform .65s cubic-bezier(.05,.2,.1,1);
    }
    .join-us-box:hover .content .inner .footer {
        transform: translateY(0);
        opacity: 1;
        transition: opacity .65s cubic-bezier(.05,.2,.1,1) .15s,transform .65s cubic-bezier(.05,.2,.1,1) .15s;
    }
    .join-us-box:after {
        background: linear-gradient(180deg,transparent,#191919);
        opacity: 0;
    }
    .join-us-box:hover:after {
        opacity: 1;
    }
</style>