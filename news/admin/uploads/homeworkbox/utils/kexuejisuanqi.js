function e(e) {
    var a = "+-*/()×÷^%#Mod#sin#cos#ln#tan#Int#dms#log#fact#reciproc#cuberoot#powten#sqrt#sqr#cube#asin#acos#atan#powe#sinh#cosh#tanh#asinh#acosh#atanh#frac#@#";
    if (!(a.indexOf(e) > -1 && s(e) && 0 == t(e, a))) return a.indexOf(e) > -1;
}

function t(e, a) {
    return -1 != a.indexOf(e) ? "#" == a[a.indexOf(e) - 1] && "#" == a[a.indexOf(e) + e.length] ? 1 + t(e, a.substring(a.indexOf(e) + e.length)) : 0 + t(e, a.substring(a.indexOf(e) + e.length)) : 0;
}

function a(e) {
    for (var a = /^[0-9]+$/, h = 0, o = e.length; h < o; h++) if (s(e[h]) && t(e[h], "#sin#cos#ln#tan#Int#dms#log#fact#reciproc#cuberoot#powten#sqrt#sqr#cube#asin#acos#atan#powe#sinh#cosh#tanh#asinh#acosh#atanh#frac#@#") && 0 != h && a.test(e[h - 1])) return;
    return !0;
}

function h(t) {
    var h = t.match(/([0-9.]+e\+[0-9]+)|([0-9.]+e\-[0-9]+)|([0-9.]+e[0-9]+)/g);
    null != h && (t = t.replace(/([0-9.]+e\+[0-9]+)|([0-9.]+e\-[0-9]+)|([0-9.]+e[0-9]+)/g, "@"));
    var o = [], n = [], r = [], l = !1;
    t.replace(/\s/g, "");
    for (var i = 0, u = t.length; i < u; i++) e(t[i]) || e(t[i - 1]) || 0 == i || s(t[i]) || s(t[i - 1]) ? s(t[i - 1]) && 0 != i && s(t[i]) ? o[o.length - 1] = o[o.length - 1] + t[i] + "" : o.push(t[i]) : o[o.length - 1] = o[o.length - 1] + t[i] + "";
    if (-1 == "+*/)×÷^%".indexOf(o[0]) && ("(" != o[0] || -1 == "+*/)×÷^%".indexOf(o[1]))) {
        "-" == o[0] && (l = !0);
        for (var f = 0, c = o.length; f < c; f++) if (!e(o[f]) && isNaN(o[f])) return;
        if (a(o)) {
            if (l && !isNaN(o[1]) && (o.shift(), o[0] = -o[0]), null != h && h.length > 0) for (var M = 0, v = 0; M < o.length; M++) "@" == o[M] && (o[M] = o[M].replace(/[@]/, h[v]), 
            v++);
            for (;o.length > 0; ) {
                var d = o.shift();
                if (e(d)) if ("(" == d) n.push(d); else if (")" == d) for (var g = n.pop(); "(" != g && n.length > 0; ) r.push(g), 
                g = n.pop(); else {
                    for (;p(d, n[n.length - 1]) && n.length > 0; ) r.push(n.pop());
                    n.push(d);
                } else r.push(Number(d));
            }
            if (n.length > 0) for (;n.length > 0; ) r.push(n.pop());
            for (;r.length > 0; ) for (;r.length > 0; ) "(" == r[0] ? r.shift() : n.push(r.shift());
            return n;
        }
    }
}

function s(e) {
    var t = /^[A-Za-z]+$/;
    if ("string" == typeof e) {
        for (var a = 0, h = e.length; a < h; a++) if (!t.test(e[a])) return;
        return !0;
    }
    return t.test(e);
}

function o(e) {
    return "-" == e || "+" == e ? 1 : "*" == e || "/" == e || "×" == e || "÷" == e || "^" == e || "Mod" == e || "%" == e ? 2 : "sin" == e || "cos" == e || "ln" == e || "tan" == e || "Int" == e || "dms" == e || "log" == e || "fact" == e || "reciproc" == e || "cuberoot" == e || "powten" == e || "sqrt" == e || "sqr" == e || "cube" == e || "asin" == e || "acos" == e || "atan" == e || "powe" == e || "sinh" == e || "cosh" == e || "tanh" == e || "asinh" == e || "acosh" == e || "atanh" == e || "frac" == e ? 4 : 0;
}

function p(e, t) {
    return o(e) <= o(t);
}

function n(t, a) {
    for (var h = [], s = 0, o = t.length; s < o; s++) if (e(t[s])) if ("powe" == t[s]) {
        var p = h.pop(), n = Math.pow(Math.E, p);
        h.push(n);
    } else if ("sin" == t[s]) {
        p = h.pop();
        0 == a ? ((l = p / 180) == Math.floor(l) && (p = 0), p = r.div(r.mul(p, Math.PI), 180)) : 2 == a && ((l = p / 200) == Math.floor(l) && (p = 0), 
        p = r.div(r.mul(p, Math.PI), 200));
        n = Math.sin(p);
        h.push(n);
    } else if ("sinh" == t[s]) {
        var p = h.pop(), n = r.mul(r.sub(Math.pow(Math.E, p), Math.pow(Math.E, r.mul(-1, p))), .5);
        h.push(n);
    } else if ("cosh" == t[s]) {
        var p = h.pop(), n = r.mul(r.add(Math.pow(Math.E, p), Math.pow(Math.E, r.mul(-1, p))), .5);
        h.push(n);
    } else if ("tanh" == t[s]) {
        var p = h.pop(), n = r.div(r.sub(Math.pow(Math.E, p), Math.pow(Math.E, r.mul(-1, p))), r.add(Math.pow(Math.E, p), Math.pow(Math.E, r.mul(-1, p))));
        h.push(n);
    } else if ("asinh" == t[s]) {
        var p = h.pop(), n = Math.log(r.add(p, Math.sqrt(r.add(Math.pow(p, 2), 1))));
        h.push(n);
    } else if ("acosh" == t[s]) {
        var p = h.pop(), n = Math.log(r.add(p, Math.sqrt(r.sub(Math.pow(p, 2), 1))));
        h.push(n);
    } else if ("atanh" == t[s]) {
        var p = h.pop(), n = r.mul(Math.log(r.div(r.add(1, p), r.sub(1, p))), .5);
        h.push(n);
    } else if ("asin" == t[s]) {
        p = h.pop();
        0 == a ? p = r.div(r.mul(p, Math.PI), 180) : 2 == a && (p = r.div(r.mul(p, Math.PI), 200));
        n = Math.asin(p);
        h.push(n);
    } else if ("acos" == t[s]) {
        p = h.pop();
        0 == a ? p = r.div(r.mul(p, Math.PI), 180) : 2 == a && (p = r.div(r.mul(p, Math.PI), 200));
        n = Math.acos(p);
        h.push(n);
    } else if ("atan" == t[s]) {
        p = h.pop();
        0 == a ? p = r.div(r.mul(p, Math.PI), 180) : 2 == a && (p = r.div(r.mul(p, Math.PI), 200));
        n = Math.atan(p);
        h.push(n);
    } else if ("cos" == t[s]) {
        p = h.pop();
        if (0 == a) if ((l = p / 90) % 2 == 1 && l == Math.floor(l)) i = 0; else p = r.div(r.mul(p, Math.PI), 180); else if (2 == a) if ((l = p / 100) % 2 == 1 && l == Math.floor(l)) i = 0; else p = r.div(r.mul(p, Math.PI), 200);
        if (0 == i) n = 0; else n = Math.cos(p);
        h.push(n);
    } else if ("tan" == t[s]) {
        p = h.pop();
        if (0 == a) (l = p / 180) == Math.floor(l) && (p = 0), p = r.div(r.mul(p, Math.PI), 180); else if (2 == a) {
            var l = p / 200;
            l == Math.floor(l) && (p = 0), p = r.div(r.mul(p, Math.PI), 200);
        }
        n = Math.tan(p);
        h.push(n);
    } else if ("ln" == t[s]) {
        var p = h.pop(), n = Math.log(p);
        h.push(n);
    } else if ("Int" == t[s]) {
        var p = h.pop(), n = Math.floor(p);
        h.push(n);
    } else if ("frac" == t[s]) {
        var p = h.pop(), n = r.sub(p, Math.floor(p));
        h.push(n);
    } else if ("dms" == t[s]) {
        var p = h.pop(), n = r.math_dms(p);
        h.push(n);
    } else if ("log" == t[s]) {
        var p = h.pop(), n = r.div(Math.log(p), Math.LN10);
        h.push(n);
    } else if ("fact" == t[s]) {
        var p = h.pop(), n = r.fact(p);
        h.push(n);
    } else if ("reciproc" == t[s]) {
        var p = h.pop(), n = r.reciproc(p);
        h.push(n);
    } else if ("cuberoot" == t[s]) {
        var p = h.pop(), n = r.cuberoot(p);
        h.push(n);
    } else if ("powten" == t[s]) {
        var p = h.pop(), n = Math.pow(10, p);
        h.push(n);
    } else if ("sqrt" == t[s]) {
        var p = h.pop(), n = Math.sqrt(p);
        h.push(n);
    } else if ("sqr" == t[s]) {
        var p = h.pop(), n = Math.pow(p, 2);
        h.push(n);
    } else if ("cube" == t[s]) {
        var p = h.pop(), n = Math.pow(p, 3);
        h.push(n);
    } else {
        if (h.length < 2) return;
        var p = h.pop(), i = h.pop();
        if ("-" == t[s]) n = r.sub(i, p); else if ("+" == t[s]) n = r.add(i, p); else if ("*" == t[s] || "×" == t[s]) n = r.mul(i, p); else if ("/" == t[s] || "÷" == t[s]) n = r.div(i, p); else if ("Mod" == t[s]) n = i % p; else if ("%" == t[s]) n = i % p; else if ("^" == t[s]) n = Math.pow(i, p);
        h.push(n);
    } else h.push(t[s]);
    return h[0];
}

var r = require("fudianshu_bug.js");

module.exports = {
    calCommonExp: function(e, t) {
        var a = h(e);
        if (null != a) return n(a, t);
    },
    getLastNumberStr_fixed: function(t) {
        var a = [];
        t.replace(/\s/g, "");
        for (var h = 0, o = t.length; h < o; h++) e(t[h]) || e(t[h - 1]) || 0 == h || s(t[h]) || s(t[h - 1]) ? s(t[h - 1]) && 0 != h && s(t[h]) ? a[a.length - 1] = a[a.length - 1] + t[h] + "" : a.push(t[h]) : a[a.length - 1] = a[a.length - 1] + t[h] + "";
        for (var p = [], n = null, h = 0, r = a.length; h < r; h++) if (")" == a[h]) {
            for (p.push(a[h]); "(" != p[p.length - 1]; ) n = null == n ? p.pop() : p.pop() + n;
            n = "(" + n, p[p.length - 1] = n, n = null;
        } else p.push(a[h]);
        return p[p.length - 1];
    }
};