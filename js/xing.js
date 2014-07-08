(function () {
    function r(a, g, i) {
        a && (document.addEventListener ? a.addEventListener(g, i, !1) : a.attachEvent("on" + g, i))
    }
    function w(a, g, i) {
        for (var j = [], a = document.getElementsByTagName(a), d = 0, l = a.length; d < l; d++) for (var k = a[d], e = g, h = i, f = j, b = k.attributes, c = 0, o = b.length; c < o; c++) {
            var n = b[c],
                p = n.nodeValue;
            n.nodeName === e && p === h && f.push(k)
        }
        return j
    }
    function p() {
        var a, g, i = document.scripts;
        i || (i = document.querySelectorAll("script"));
        for (var j = 0; j < i.length; j++) if (a = i[j].src, -1 !== a.indexOf("share.js") && (g = a.indexOf("/js/external/share.js"), -1 !== g)) return a.substring(0, g)
    }
    function C(a) {
        a || (a = window.event);
        a.cancelBubble = !0;
        a.stopPropagation && a.stopPropagation();
        t && clearTimeout(t)
    }
    function D() {
        t = setTimeout(function () {
            for (var a = 0; a < o.length; a++) {
                var g = o[a];
                g.nextSibling && "xing-statistics-hovercard" == g.nextSibling.className && g.parentNode.removeChild(g.nextSibling)
            }
        }, 250)
    }
    function m() {
        var a = encodeURIComponent(location.href),
            g;
        g = "querySelectorAll" in document ? document.querySelectorAll('script[type="XING/Share"]') : w("script", "type", "XING/Share");
        for (var i = 0, j = g.length; i < j; i++) {
            var d = g[i],
                l = d.getAttribute("data-counter"),
                k = d.getAttribute("data-button-shape") || "rectangle",
                e = d.getAttribute("data-lang"),
                h = d.getAttribute("data-url"),
                f = a;
            h && (f = encodeURIComponent(h));
            f = f.split("%");
            for (h = 0; h < f.length; h++) f[h] = f[h].substring(0, 2).toLowerCase() + f[h].substring(2);
            f = f.join("%");
            if ("no_count" === l) {
                var h = e,
                    b = k;
                if (b) {
                    var c = void 0,
                        k = d.parentNode;
                    document.createElement("img");
                    var e = document.createElement("iframe"),
                        m = c = void 0,
                        n = document.createElement("div"),
                        l = document.createElement("a");
                    e.setAttribute("frameBorder", "0");
                    e.setAttribute("allowtransparency", "true");
                    e.setAttribute("scrolling", "no");
                    e.setAttribute("src", "javascript:'<html></html>'");
                    e.setAttribute("style", "padding:0px !important;border:none !important;margin:0px !important;overflow:hidden !important;background-color:transparent !important;");
                    e.setAttribute("class", "XING");
                    switch (b) {
                        case "small_square":
                            n.setAttribute("id", "share-button-16");
                            e.setAttribute("width", 16);
                            e.setAttribute("height",
                                16);
                            break;
                        case "square":
                            n.setAttribute("id", "share-button-32");
                            e.setAttribute("width", 32);
                            e.setAttribute("height", 32);
                            break;
                        case "rectangle":
                            n.setAttribute("id", "spi-button-20"), e.setAttribute("width", 55), e.setAttribute("height", 20), c = document.createElement("span"), c.innerHTML = "XING", m = document.createElement("div"), n.appendChild(m), n.appendChild(c)
                    }
                    l.setAttribute("href", p() + "/social_plugins/share?url=" + f + "&amp;wtmc=XING;&amp;sc_p=xing-share");
                    l.setAttribute("target", "_blank");
                    l.setAttribute("title",
                        "de" == h ? "Meinen Kontakten auf XING empfehlen" : "Share with my contacts on XING");
                    l.setAttribute("id", "share-link");
                    l.appendChild(n);
                    f = n.getAttribute("id");
                    h = f.split("-")[0];
                    b = f.split("-")[2];
                    c = [];
                    c.push("#" + f + "{-moz-border-radius: 3px; -moz-box-sizing: border-box; -webkit-border-radius: 3px; border: 1px solid #004b58; border-radius: 3px; box-sizing: border-box; font-family: Arial, sans-serif; margin: 0; outline: none; overflow: visible; padding: 0; position: relative;");
                    switch (h) {
                        case "share":
                            c.push("width:" + b + "px; height:" + b + "px;");
                            c.push("#" + f + ":hover {background-position: -" + (b - 2) + "px 0; }");
                            s || window.devicePixelRatio && 1.5 > window.devicePixelRatio || (null, c.push("background-size: " + 2 * (b - 2) + "px " + (b - 2) + "px;}\n}"));
                            break;
                        case "spi":
                            c.push("height:" + b + "px;"), c.push("background-color:  #165b66; background-image: -moz-linear-gradient(top, #326e79, #003848); background-image: -ms-linear-gradient(top, #326e79, #003848); background-image: -o-linear-gradient(top, #326e79, #003848); background-image: -webkit-gradient(linear, left top, left bottom, from(#326e79), to(#003848)); }"),
                                null, c.push("border-radius: 3px 0 0 3px; border: 0; border-right: 1px solid #40717c; content: ' '; left: 0px; position: absolute; top: 0px; height: " + (b - 2) + "px; width: " + (b - 2) + "px; }\n"), c.push("#" + f + " span {position: relative;  top: 2px; font-weight: bold; font-size: 12px; color: white; padding-left:" + (b - -2) + "px;}"), c.push("a {text-decoration: none;}"), c.push("#" + f + ":hover { background-color: #206575; background-image: -moz-linear-gradient(top, #206575, #003848); background-image: -ms-linear-gradient(top, #206575, #003848); background-image: -o-linear-gradient(top, #206575, #003848); background-image: -webkit-gradient(linear, left top, left bottom, from(#206575), to(#003848)); }"),
                                c.push("#" + f + ":hover div:first-child {background-position: -" + (b - 2) + "px 0px; }"), s || window.devicePixelRatio && 1.5 > window.devicePixelRatio || (c.push("background-size: " + 2 * (b - 2) + "px " + (b - 2) + "px; border-right: 1px solid #40717c; }\n}"))
                    }
                    c = c.join("\n");
                    f = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><style>' + c +
                        '</style></head><body style="margin:0;">';
                    h = l;
                    b = void 0;
                    if (!(b = h.outerHTML)) b = document.createElement("div"), b.appendChild(h.cloneNode(!0)), b = b.innerHTML;
                    c = f + b + "</body></html>";
                    k.replaceChild(e, d);
                    u(e, c, "share-link", l);
                    r(e, "load", u.bind(null, e, c, "share-link", l))
                }
            } else h = l, b = e, c = k, k = h + "_" + c, e = document.createElement("iframe"), l = d.parentNode, m = p() + "/app/share?op=get_share_button", y++, f = [m, ";url=", f, ";counter=", h, ";lang=", b, ";type=iframe;hovercard_position=", y, ";shape=", c].join(""), h = {
                right_rectangle: {
                    width: 121,
                    height: 20
                },
                right_square: {
                    width: 86,
                    height: 20
                },
                top_rectangle: {
                    width: 55,
                    height: 62
                }
            }, b = document.createElement("div"), c = ["position:relative;height:", h[k].height, "px;width:", h[k].width, "px;"].join(""), s && (c += "overflow:hidden;"), b.setAttribute("style", c), r(b, "mouseover", C), e.setAttribute("style", "padding:0px !important;border:none !important;margin:0px !important;overflow:hidden !important;background-color:transparent !important;width:" + h[k].width + "px !important;height:" + h[k].height + "px !important;"), e.setAttribute("scrolling",
                "no"), e.setAttribute("height", h[k].height), e.setAttribute("src", f), e.setAttribute("width", h[k].width), e.setAttribute("class", "XING"), e.setAttribute("frameBorder", "0"), e.setAttribute("allowtransparency", "true"), o.push(e), b.appendChild(e), l.replaceChild(b, d)
        }
        r(document, "mouseover", D)
    }
    function z() {
        if (!q) {
            try {
                document.documentElement.doScroll("left")
            } catch (a) {
                setTimeout(z, 1);
                return
            }
            m()
        }
    }
    function A() {
        if (v) {
            var a;
            a = !1 in document ? document.querySelectorAll('iframe[class="XING"]') : w("iframe", "class", "XING");
            for (var g = 0, i = a.length; g < i; g++) a[g].src = a[g].src;
            v = !1
        }
    }
    function u(a, g, i, j) {
        var d = a.document;
        a.contentDocument ? d = a.contentDocument : a.contentWindow && (d = a.contentWindow.document);
        null != d && (d.open(), d.writeln(g), d.close(), null != i && r(d.getElementById(i), "click", function (a) {
            window.open(j.getAttribute("href"), j.getAttribute("title"), "width=600, height=450");
            a.preventDefault ? a.preventDefault() : a.returnValue = false
        }))
    }
    var v = !1,
        q = !1,
        y = 0,
        o = [],
        t, s = -1 !== navigator.userAgent.indexOf("MSIE 7") || -1 !== navigator.userAgent.indexOf("MSIE 6"),
        x = "@media  (min-resolution: 192dpi), (-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 3/2), (min-device-pixel-ratio: 1.5), (min-resolution: 2dppx) {\n";
    "complete" === document.readyState && (q = !0, setTimeout(m, 1));
    if (document.addEventListener) document.addEventListener("DOMContentLoaded", function () {
        q = true;
        m()
    }, !1), window.addEventListener("load", function () {
        q = true;
        m()
    }, !1);
    else if (document.attachEvent) {
        document.attachEvent("onreadystatechange", function () {
            q = true;
            m()
        });
        window.attachEvent("onload", function () {
            q = true;
            m()
        });
        var B = !1;
        try {
            B = null == window.frameElement
        } catch (E) {}
        document.documentElement.doScroll && B && z()
    }
    window.onfocus = function () {
        A()
    };
    r(window, "message", function (a) {
        var g, i;
        if (a.data.indexOf("hovercard") !== -1) {
            if (!(s || typeof a.data !== "string")) {
                i = a.data.split("|");
                a = i[0];
                g = i[1];
                i = i[2];
                var j;
                b: {
                    for (j = 0; j < o.length; j++) if (a === o[j].src) {
                        j = true;
                        break b
                    }
                    j = false
                }
                if (j) {
                    var d, l, k, e;
                    k = 0;
                    for (e = o.length; k < e; k++) {
                        d = o[k];
                        j = d.parentNode;
                        if (d.src === a) {
                            d = document.createElement("iframe");
                            d.setAttribute("class", "xing-statistics-hovercard");
                            d.setAttribute("frameBorder", "none");
                            d.setAttribute("allowtransparency", "true");
                            d.setAttribute("scrolling", "no");
                            switch (g) {
                                case "right":
                                    d.setAttribute("style", "position: absolute; top: 0; z-index:1000000; background-color: transparent; border: none; padding: 0; overflow: hidden; width: 120px; height: 85px;left:63px;");
                                    break;
                                case "right_square":
                                    d.setAttribute("style", "position: absolute; top: 0; z-index:1000000; background-color: transparent; border: none; padding: 0; overflow: hidden; width: 120px; height: 85px;left:24px;");
                                    break;
                                case "top":
                                    d.setAttribute("style", "position: absolute; top: 0; z-index:1000000; background-color: transparent; border: none; padding: 0; overflow: hidden; width: 120px; height: 85px;left:57px;")
                            }
                            d.setAttribute("src", "javascript:'<html></html>'");
                            l = '<!DOCTYPE html><html><head></head><body style="margin:0;">' + i + "</body></html>";
                            if (j && j.childNodes.length === 1) {
                                j.appendChild(d);
                                u(d, l)
                            }
                        }
                    }
                }
            }
        } else {
            v = true;
            A()
        }
    })
})();