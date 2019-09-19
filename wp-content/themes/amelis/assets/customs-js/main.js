!function(e, n) {
    "object" == typeof exports && "undefined" != typeof module ? n() : "function" == typeof define && define.amd ? define(n) : n();
}(0, function() {
    "use strict";
    function e(e) {
        function n() {
            var d = Date.now() - l;
            d < i && d >= 0 ? r = setTimeout(n, i - d) : (r = null, t || (f = e.apply(u, o), 
            u = null, o = null));
        }
        var i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : 100, t = arguments[2], r = void 0, o = void 0, u = void 0, l = void 0, f = void 0, d = function() {
            u = this;
            for (var d = arguments.length, a = Array(d), s = 0; s < d; s++) a[s] = arguments[s];
            o = a, l = Date.now();
            var c = t && !r;
            return r || (r = setTimeout(n, i)), c && (f = e.apply(u, o), u = null, o = null), 
            f;
        };
        return d.clear = function() {
            r && (clearTimeout(r), r = null);
        }, d.flush = function() {
            r && (f = e.apply(u, o), u = null, o = null, clearTimeout(r), r = null);
        }, d;
    }
    var n = window.jQuery;
    if (!n) throw new Error("resizeend require jQuery");
    n.event.special.resizeend = {
        setup: function() {
            var i = n(this);
            i.on("resize.resizeend", e.call(null, function(e) {
                e.type = "resizeend", i.trigger("resizeend", e);
            }, 250));
        },
        teardown: function() {
            n(this).off("resize.resizeend");
        }
    };
});

/*!
 * verge 1.10.2+201705300050
 * http://npm.im/verge
 * MIT Ryan Van Etten
 */
!function(a, b, c) {
    "undefined" != typeof module && module.exports ? module.exports = c() : a[b] = c();
}(this, "verge", function() {
    function a() {
        return {
            width: k(),
            height: l()
        };
    }
    function b(a, b) {
        var c = {};
        return b = +b || 0, c.width = (c.right = a.right + b) - (c.left = a.left - b), c.height = (c.bottom = a.bottom + b) - (c.top = a.top - b), 
        c;
    }
    function c(a, c) {
        return !(!(a = a && !a.nodeType ? a[0] : a) || 1 !== a.nodeType) && b(a.getBoundingClientRect(), c);
    }
    function d(b) {
        b = null == b ? a() : 1 === b.nodeType ? c(b) : b;
        var d = b.height, e = b.width;
        return d = "function" == typeof d ? d.call(b) : d, (e = "function" == typeof e ? e.call(b) : e) / d;
    }
    var e = {}, f = "undefined" != typeof window && window, g = "undefined" != typeof document && document, h = g && g.documentElement, i = f.matchMedia || f.msMatchMedia, j = i ? function(a) {
        return !!i.call(f, a).matches;
    } : function() {
        return !1;
    }, k = e.viewportW = function() {
        var a = h.clientWidth, b = f.innerWidth;
        return a < b ? b : a;
    }, l = e.viewportH = function() {
        var a = h.clientHeight, b = f.innerHeight;
        return a < b ? b : a;
    };
    return e.mq = j, e.matchMedia = i ? function() {
        return i.apply(f, arguments);
    } : function() {
        return {};
    }, e.viewport = a, e.scrollX = function() {
        return f.pageXOffset || h.scrollLeft;
    }, e.scrollY = function() {
        return f.pageYOffset || h.scrollTop;
    }, e.rectangle = c, e.aspect = d, e.inX = function(a, b) {
        var d = c(a, b);
        return !!d && d.right >= 0 && d.left <= k();
    }, e.inY = function(a, b) {
        var d = c(a, b);
        return !!d && d.bottom >= 0 && d.top <= l();
    }, e.inViewport = function(a, b) {
        var d = c(a, b);
        return !!d && d.bottom >= 0 && d.right >= 0 && d.top <= l() && d.left <= k();
    }, e;
});

/*
 * @file
 *
 * Available variables
 * - boilerplate_display
 *
 */
var boilerplate_display = {};

(function($) {
    'use strict';
    boilerplate_display.getHeight = function() {
        return verge.viewportH();
    };
    boilerplate_display.getWidth = function() {
        return verge.viewportW();
    };
    boilerplate_display.getScrollY = function() {
        return verge.scrollY();
    };
    boilerplate_display.getScrollX = function() {
        return verge.scrollX();
    };
    boilerplate_display.getOrientation = function() {
        return getOrientation(boilerplate_display.getWidth(), boilerplate_display.getHeight());
    };
    boilerplate_display.height = verge.viewportH();
    boilerplate_display.width = verge.viewportW();
    boilerplate_display.scrollY = verge.scrollY();
    boilerplate_display.scrollX = verge.scrollX();
    boilerplate_display.orientation = getOrientation(boilerplate_display.width, boilerplate_display.height);
    $(window).on('resizeend', function() {
        boilerplate_display.scrollYOrigin = boilerplate_display.scrollY;
        boilerplate_display.scrollXOrigin = boilerplate_display.scrollX;
        boilerplate_display.scrollY = verge.scrollY();
        boilerplate_display.scrollX = verge.scrollX();
        boilerplate_display.orientationOrigin = boilerplate_display.orientation;
        boilerplate_display.heightOrigin = boilerplate_display.height;
        boilerplate_display.widthOrigin = boilerplate_display.width;
        boilerplate_display.height = verge.viewportH();
        boilerplate_display.width = verge.viewportW();
        boilerplate_display.orientation = getOrientation(boilerplate_display.width, boilerplate_display.height);
    });
    $(window).on('scroll', function() {
        boilerplate_display.scrollYOrigin = boilerplate_display.scrollY;
        boilerplate_display.scrollXOrigin = boilerplate_display.scrollX;
        boilerplate_display.scrollY = verge.scrollY();
        boilerplate_display.scrollX = verge.scrollX();
    });
    function getOrientation(width, height) {
        if (height > width) {
            return 'portrait';
        } else if (height < width) {
            return 'landscape';
        } else {
            return 'square';
        }
    }
})(jQuery);

(function($) {
    "use strict";
    $(document).ready(function() {
        // sticky menu
        var c;
        var currentScrollTop = 0;
        var header = $('#mainHeader');
        var offset_header = $('#mainHeader').offset().top;
        if (offset_header > 0) {
            $('#mainHeader').addClass('pin-top');
        }
        $(window).scroll(function() {
            var a = $(window).scrollTop();
            var b = header.height();
            currentScrollTop = a;
            if (a > 0) {
                header.addClass("pin-top");
            } else {
                header.removeClass("pin-top");
                header.removeClass("pin");
            }
            if (c < currentScrollTop && a > 0) {
                header.addClass("pin");
            } else if (c > currentScrollTop && a > 0) {
                header.removeClass("pin");
            }
            c = currentScrollTop;
        });
    });
})(jQuery);

/*
 * @file
 *
 * Available variables
 * - boilerplate_display
 *
*/
(function($) {
    'use strict';
    $(document).ready(function() {
        console.log('DOM is ready! JS\'s running 🚀 Load time : ' + (parseInt(Date.now()) - parseInt(boilerplate_timer)) + 'ms.');
    });
    $(window).on({
        load: function() {
            console.log('The document has finished loading! Total load time : ' + (parseInt(Date.now()) - parseInt(boilerplate_timer)) + 'ms.');
        },
        resizeend: function() {
            console.log('Window has been resized!');
        }
    });
    $(window).on('load resizeend', function() {
        if (boilerplate_display) {
            console.log('boilerplate_display');
        }
    });
})(jQuery);

(function($) {
    'use strict';
    $(window).on('load', function() {
        if (typeof boilerplate_print_css_url !== 'undefined' && boilerplate_print_css_url !== null) {
            $('head').append('<link rel="stylesheet" href="' + boilerplate_print_css_url + '" type="text/css" media="print"/>');
        }
    });
})(jQuery);
//# sourceMappingURL=main.js.map