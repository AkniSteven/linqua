requirejs(["jquery"],function(o){"use strict";({init:function(){this.burgerPopupOpen()},burgerPopupOpen:function(){o(".burger-menu").on("click",function(){o(this).parents("body").toggleClass("burger-popup--open")}),o(".burger-popup__close-popup").on("click",function(){o(this).parents("body").removeClass("burger-popup--open"),console.log("sdvdfsvdfbv")})}}).init()});