requirejs(["jquery","ScrollMagic","swiper","animation.gsap","TweenMax","debug.addIndicators","enquire","jquery-ias.min","spinner","trigger","noneleft"],function(e,n,r){"use strict";!function(){e(".price-block__tariff-cell"),e(".price-block-wrapper"),enquire.register("screen and (max-width : 640px)",{match:function(){e(".language-banner").height(e(window).height())},unmatch:function(){e(".language-banner").height(e(window).height())}});var n=navigator.userAgent.indexOf("Chrome")>-1,r=(navigator.userAgent.indexOf("MSIE"),navigator.userAgent.indexOf("Firefox"),navigator.userAgent.indexOf("Safari")>-1);navigator.userAgent.indexOf("Presto");n&&r&&(r=!1)}();var t=new n.Controller;new n.Scene({offset:10,duration:1e3}).setTween(".full",2,{css:{width:"100vw"},ease:Power2.easeOut}).addTo(t),new n.Scene({offset:250,reverse:!0}).setClassToggle(".full","js-del-shadow").addTo(t),new n.Scene({offset:10,reverse:!0}).setClassToggle(".price-block","js-del-status").addTo(t),function(e){enquire.register("screen and (max-width : 1024px)",{match:function(e){new r(".swiper-container",{slidesPerView:"auto",centeredSlides:!1,grabCursor:!0})},unmatch:function(){e.destroy()}})}(),function(){var n=e(".price-block__tariff-cell"),r=e(".price-block-wrapper");enquire.register("screen and (max-width : 768px)",{match:function(){n.length>2&&r.addClass("js-restructuring-cells")},unmatch:function(){n.length>2&&r.removeClass("js-restructuring-cells")}})}()});