function r(r, n, t) {
    return n in r ? Object.defineProperty(r, n, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : r[n] = t, r;
}

function n(t, e) {
    var u = t.data[e];
    u >= 100 ? "time_ctrl_player_1" == e ? t.setData({
        Timeouter: 1
    }) : t.setData({
        Timeouter: 2
    }) : "time_ctrl_player_1" == e ? w = setTimeout(function() {
        u++, t.setData(r({}, e, u)), n(t, e);
    }, 100) : q = setTimeout(function() {
        u++, t.setData(r({}, e, u)), n(t, e);
    }, 100);
}

function t() {
    for (var r = 0; r < .1; ) r = Math.random();
    var n = Math.floor(1e3 * r) - 10 * Math.floor(100 * r), t = Math.floor(1e4 * r) - 10 * Math.floor(1e3 * r), e = Math.floor(1e5 * r) - 10 * Math.floor(1e4 * r), u = Math.floor(1e6 * r) - 10 * Math.floor(1e5 * r);
    r = n % 3 == 0 ? Math.floor(100 * (r + 1)) : n % 3 == 1 ? Math.floor(100 * (r + 2)) : Math.floor(100 * r);
    var i = 0, o = null;
    if (t % 2 == 0) {
        var m = null, a = null;
        m = u % 2 == 0 ? String(Math.floor(r / 2) + e % 3 + 1) : String(Math.floor(r / 2) - e % 3 - 1), 
        a = r % 2 == 1 ? String(5) : String(0), i = Number(m + a), o = !1;
    } else i = 5 * r, o = !0;
    return {
        Question: String(r) + "×5=" + String(i),
        judge_result: o
    };
}

function e() {
    var r = j(), n = 0, t = null;
    if (r.judge_num % 2 == 0) {
        var e = String(Math.floor(r.Random / 4));
        if (r.Random % 4 == 0) u = "00"; else if (r.Random % 4 == 1) u = "25"; else if (r.Random % 4 == 2) u = "50"; else if (r.Random % 4 == 3) var u = "75";
        e = "8" == e || "9" == e ? String(Number(e) - r.error_num % 2 + 1) : "0" == e || "1" == e ? String(Number(e) + r.error_num % 2 + 1) : r.operation_num % 2 == 0 ? String(Number(e) + r.error_num % 2 + 1) : String(Number(e) - r.error_num % 2 - 1), 
        n = Number(e + u), t = !1;
    } else n = 25 * r.Random, t = !0;
    return {
        Question: String(r.Random) + "×25=" + String(n),
        judge_result: t
    };
}

function u() {
    var r = t();
    return r.Question = r.Question.substring(-1, r.Question.indexOf("×")) + "×50" + r.Question.substring(r.Question.indexOf("=")) + "0", 
    r;
}

function i() {
    var r = j(), n = 0, t = null;
    3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1));
    var e = r.Random.toString().charAt(0) + r.multi_num.toString();
    if (r.judge_num % 2 == 0) {
        var u = String(r.Random * Number(e)), i = u.substring(-1, u.length - 2), o = u.charAt(u.length - 2), m = u.charAt(u.length - 1);
        o = "8" == o || "9" == o ? String(Number(o) - r.error_num % 2 + 1) : "0" == o || "1" == o ? String(Number(o) + r.error_num % 2 + 1) : r.operation_num % 2 == 0 ? String(Number(o) + r.error_num % 2 + 1) : String(Number(o) - r.error_num % 2 - 1), 
        n = Number(i + o + m), t = !1;
    } else n = r.Random * Number(e), t = !0;
    return {
        Question: String(r.Random) + "×" + e + "=" + String(n),
        judge_result: t
    };
}

function o() {
    var r = j(), n = 0, t = null;
    3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1));
    var e = r.Random.toString().charAt(0) + String(Number(10 - r.Random.toString().charAt(1)));
    if (r.judge_num % 2 == 0) {
        var u = String(r.Random * Number(e)), i = u.substring(-1, u.length - 2), o = u.substring(u.length - 2);
        i = r.operation_num % 2 == 0 ? String(Number(i) + r.error_num % 2 + 1) : String(Number(i) - r.error_num % 2 - 1), 
        n = Number(i + o), t = !1;
    } else n = r.Random * Number(e), t = !0;
    return {
        Question: String(r.Random) + "×" + e + "=" + String(n),
        judge_result: t
    };
}

function m() {
    var r = j(), n = 0, t = null;
    3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1));
    var e = String(Number(10 - r.Random.toString().charAt(0))) + r.Random.toString().charAt(1);
    if (r.judge_num % 2 == 0) {
        var u = String(r.Random * Number(e)), i = u.substring(-1, u.length - 2), o = u.substring(u.length - 2);
        i = r.operation_num % 2 == 0 ? String(Number(i) + r.error_num % 2 + 1) : String(Number(i) - r.error_num % 2 - 1), 
        n = Number(i + o), t = !1;
    } else n = r.Random * Number(e), t = !0;
    return {
        Question: String(r.Random) + "×" + e + "=" + String(n),
        judge_result: t
    };
}

function a() {
    var r = j(), n = 0, t = null;
    3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1));
    var e = String(100 - Number(r.Random.toString().charAt(0))), u = String(100 - Number(r.Random.toString().charAt(1)));
    if (r.judge_num % 2 == 0) {
        var i = String(Number(e) * Number(u)), o = i.substring(-1, i.length - 2), m = i.substring(i.length - 2);
        o = r.operation_num % 2 == 0 ? String(Number(o) + r.error_num % 2 + 1) : String(Number(o) - r.error_num % 2 - 1), 
        n = Number(o + m), t = !1;
    } else n = Number(e) * Number(u), t = !0;
    return {
        Question: e + "×" + u + "=" + String(n),
        judge_result: t
    };
}

function _() {
    var r = j(), n = 0, t = null;
    3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1));
    var e = String(100 + Number(r.Random.toString().charAt(0))), u = String(100 + Number(r.Random.toString().charAt(1)));
    if (r.judge_num % 2 == 0) {
        var i = String(Number(e) * Number(u)), o = i.substring(-1, i.length - 2), m = i.substring(i.length - 2);
        o = r.operation_num % 2 == 0 ? String(Number(o) + r.error_num % 2 + 1) : String(Number(o) - r.error_num % 2 - 1), 
        n = Number(o + m), t = !1;
    } else n = Number(e) * Number(u), t = !0;
    return {
        Question: e + "×" + u + "=" + String(n),
        judge_result: t
    };
}

function l() {
    var r = j(), n = j(), t = 0, e = null;
    if (3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1)), 
    3 == n.Random.toString().length && (n.Random = n.Random.toString().substring(1)), 
    r.judge_num % 2 == 0) {
        var u = String(r.Random * n.Random), i = u.substring(-1, u.length - 2), o = u.charAt(u.length - 2), m = u.charAt(u.length - 1);
        o = "8" == o || "9" == o ? String(Number(o) - r.error_num % 2 + 1) : "0" == o || "1" == o ? String(Number(o) + r.error_num % 2 + 1) : r.operation_num % 2 == 0 ? String(Number(o) + r.error_num % 2 + 1) : String(Number(o) - r.error_num % 2 - 1), 
        t = Number(i + o + m), e = !1;
    } else t = r.Random * n.Random, e = !0;
    return {
        Question: String(r.Random) + "×" + String(n.Random) + "=" + String(t),
        judge_result: e
    };
}

function g(r) {
    var n = j(), t = 0, e = null;
    3 == n.Random.toString().length && (n.Random = n.Random.toString().substring(1));
    var u = Number(n.Random.toString().charAt(0) + r);
    if (n.judge_num % 2 == 0) {
        var i = String(Math.pow(u, 2)), o = i.substring(-1, i.length - 2), m = i.charAt(i.length - 2), a = i.charAt(i.length - 1);
        m = "8" == m || "9" == m ? String(Number(m) - n.error_num % 2 + 1) : "0" == m || "1" == m ? String(Number(m) + n.error_num % 2 + 1) : n.operation_num % 2 == 0 ? String(Number(m) + n.error_num % 2 + 1) : String(Number(m) - n.error_num % 2 - 1), 
        t = Number(o + m + a), e = !1;
    } else t = Math.pow(u, 2), e = !0;
    return {
        Question: String(u) + "^2=" + String(t),
        judge_result: e
    };
}

function S(r) {
    var n = j(), t = 0, e = null;
    3 == n.Random.toString().length && (n.Random = n.Random.toString().substring(1));
    var u = Number(r + n.Random.toString().charAt(0));
    if (n.judge_num % 2 == 0) {
        var i = String(Math.pow(u, 2)), o = i.substring(-1, i.length - 2), m = i.charAt(i.length - 2), a = i.charAt(i.length - 1);
        m = "8" == m || "9" == m ? String(Number(m) - n.error_num % 2 + 1) : "0" == m || "1" == m ? String(Number(m) + n.error_num % 2 + 1) : n.operation_num % 2 == 0 ? String(Number(m) + n.error_num % 2 + 1) : String(Number(m) - n.error_num % 2 - 1), 
        t = Number(o + m + a), e = !1;
    } else t = Math.pow(u, 2), e = !0;
    return {
        Question: String(u) + "^2=" + String(t),
        judge_result: e
    };
}

function s() {
    return S("1");
}

function d() {
    return S("4");
}

function f() {
    return S("5");
}

function b() {
    return S("9");
}

function h() {
    return g("1");
}

function R() {
    return g("2");
}

function c() {
    return g("3");
}

function N() {
    return g("4");
}

function v() {
    return g("5");
}

function G() {
    return g("6");
}

function W() {
    return g("7");
}

function Y() {
    return g("8");
}

function M() {
    return g("9");
}

function A() {
    var r = j(), n = 0, t = null;
    if (3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1)), 
    r.judge_num % 2 == 0) {
        var e = String(Math.pow(r.Random, 2)), u = e.substring(-1, e.length - 2), i = e.charAt(e.length - 2), o = e.charAt(e.length - 1);
        i = "8" == i || "9" == i ? String(Number(i) - r.error_num % 2 + 1) : "0" == i || "1" == i ? String(Number(i) + r.error_num % 2 + 1) : r.operation_num % 2 == 0 ? String(Number(i) + r.error_num % 2 + 1) : String(Number(i) - r.error_num % 2 - 1), 
        n = Number(u + i + o), t = !1;
    } else n = Math.pow(r.Random, 2), t = !0;
    return {
        Question: String(r.Random) + "^2=" + String(n),
        judge_result: t
    };
}

function j() {
    for (var r = 0; r < .1; ) r = Math.random();
    var n = Math.floor(1e3 * r) - 10 * Math.floor(100 * r), t = Math.floor(1e4 * r) - 10 * Math.floor(1e3 * r), e = Math.floor(1e5 * r) - 10 * Math.floor(1e4 * r), u = Math.floor(1e6 * r) - 10 * Math.floor(1e5 * r), i = Math.floor(1e7 * r) - 10 * Math.floor(1e6 * r);
    return r = n % 3 == 0 ? Math.floor(100 * (r + 1)) : n % 3 == 1 ? Math.floor(100 * (r + 2)) : Math.floor(100 * r), 
    {
        Random: r,
        judge_num: t,
        error_num: e,
        operation_num: u,
        multi_num: i
    };
}

function p() {
    var r = j(), n = 0, t = null;
    if (r.judge_num % 2 == 0) {
        var e = null;
        if (r.multi_num % 8 == 0) {
            e = (o = (12 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×12=";
        } else if (r.multi_num % 8 == 1) {
            e = (o = (13 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×13=";
        } else if (r.multi_num % 8 == 2) {
            e = (o = (14 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×14=";
        } else if (r.multi_num % 8 == 3) {
            e = (o = (15 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×15=";
        } else if (r.multi_num % 8 == 4) {
            e = (o = (16 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×16=";
        } else if (r.multi_num % 8 == 5) {
            e = (o = (17 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×17=";
        } else if (r.multi_num % 8 == 6) {
            e = (o = (18 * r.Random).toString()).substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×18=";
        } else if (r.multi_num % 8 == 7) {
            var o = (19 * r.Random).toString();
            e = o.substring(-1, o.length - 1);
            var u = o.charAt(o.length - 1), i = String(r.Random) + "×19=";
        }
        e = r.operation_num % 2 == 0 ? String(Number(e) + r.error_num % 3 + 1) : String(Number(e) - r.error_num % 3 - 1), 
        n = Number(e + u), i += String(n), t = !1;
    } else if (t = !0, r.multi_num % 8 == 0) {
        n = 12 * r.Random;
        i = String(r.Random) + "×12=" + String(n);
    } else if (r.multi_num % 8 == 1) {
        n = 13 * r.Random;
        i = String(r.Random) + "×13=" + String(n);
    } else if (r.multi_num % 8 == 2) {
        n = 14 * r.Random;
        i = String(r.Random) + "×14=" + String(n);
    } else if (r.multi_num % 8 == 3) {
        n = 15 * r.Random;
        i = String(r.Random) + "×15=" + String(n);
    } else if (r.multi_num % 8 == 4) {
        n = 16 * r.Random;
        i = String(r.Random) + "×16=" + String(n);
    } else if (r.multi_num % 8 == 5) {
        n = 17 * r.Random;
        i = String(r.Random) + "×17=" + String(n);
    } else if (r.multi_num % 8 == 6) {
        n = 18 * r.Random;
        i = String(r.Random) + "×18=" + String(n);
    } else if (r.multi_num % 8 == 7) {
        n = 19 * r.Random;
        i = String(r.Random) + "×19=" + String(n);
    }
    return {
        Question: i,
        judge_result: t
    };
}

function Q() {
    var r = j(), n = 0, t = null;
    if (3 == r.Random.toString().length && (r.Random = r.Random.toString().substring(1)), 
    r.judge_num % 2 == 0) {
        var e = r.Random.toString().charAt(0), u = null, i = r.Random.toString().charAt(r.Random.toString().length - 1), o = Number(e) + Number(i);
        2 == o.toString().length ? (e = (Number(o.toString().charAt(0)) + Number(e)).toString(), 
        u = "8" == (u = o.toString().charAt(1)) || "9" == u ? (Number(u) - (r.error_num % 2 + 1)).toString() : "0" == u || "1" == u ? (Number(u) + (r.error_num % 2 + 1)).toString() : r.operation_num % 2 == 0 ? String(Number(u) + r.error_num % 2 + 1) : String(Number(u) - r.error_num % 2 - 1)) : u = "8" == (u = o.toString().charAt(0)) || "9" == u ? (Number(u) - (r.error_num % 2 + 1)).toString() : "0" == u || "1" == u ? (Number(u) + (r.error_num % 2 + 1)).toString() : r.operation_num % 2 == 0 ? String(Number(u) + r.error_num % 2 + 1) : String(Number(u) - r.error_num % 2 - 1), 
        n = Number(e + u + i), t = !1;
    } else n = 11 * r.Random, t = !0;
    return {
        Question: String(r.Random) + "×11=" + String(n),
        judge_result: t
    };
}

var w, q;

require("commonUtil.js");

module.exports = {
    YGWS_mul5: t,
    YGWS_mul11: Q,
    YGWS_mul12: p,
    YGWS_mul25: e,
    YGWS_mul50: u,
    YGWS_mul_two_decade: i,
    YGWS_mul_two_decade_10: o,
    YGWS_mul_two_decade_10_10: m,
    YGWS_mul_less_100: a,
    YGWS_mul_more_100: _,
    YGWS_mul_FOIL: l,
    YGWS_mul_unit_1: h,
    YGWS_mul_square_1: s,
    YGWS_mul_square_4: d,
    YGWS_mul_square_5: f,
    YGWS_mul_square_9: b,
    YGWS_mul_double_digit: A,
    proc: function(n, g, S, j, w, q, D) {
        if (n.data[w].judge_result == g) {
            var T, O = n.data[S];
            if (O++, x = String(O) + "/10", n.setData((T = {}, r(T, S, O), r(T, j, x), T)), 
            O > 10) return;
        } else {
            var y, O = n.data[S];
            O--;
            var x = String(O) + "/10", F = t();
            if (n.setData((y = {}, r(y, S, O), r(y, j, x), r(y, D, 1), y)), O < 0) return;
            setTimeout(function() {
                n.setData(r({}, D, 0));
            }, 500);
        }
        "YGWS_mul5" == q ? F = t() : "YGWS_mul11" == q ? F = Q() : "YGWS_mul12" == q ? F = p() : "YGWS_mul25" == q ? F = e() : "YGWS_mul50" == q ? F = u() : "YGWS_mul_two_decade" == q ? F = i() : "YGWS_mul_two_decade_10" == q ? F = o() : "YGWS_mul_two_decade_10_10" == q ? F = m() : "YGWS_mul_less_100" == q ? F = a() : "YGWS_mul_more_100" == q ? F = _() : "YGWS_mul_FOIL" == q ? F = l() : "YGWS_mul_unit_1" == q ? F = h() : "YGWS_mul_unit_2" == q ? F = R() : "YGWS_mul_unit_3" == q ? F = c() : "YGWS_mul_unit_4" == q ? F = N() : "YGWS_mul_unit_5" == q ? F = v() : "YGWS_mul_unit_6" == q ? F = G() : "YGWS_mul_unit_7" == q ? F = W() : "YGWS_mul_unit_8" == q ? F = Y() : "YGWS_mul_unit_9" == q ? F = M() : "YGWS_mul_square_1" == q ? F = s() : "YGWS_mul_square_4" == q ? F = d() : "YGWS_mul_square_5" == q ? F = f() : "YGWS_mul_square_9" == q ? F = b() : "YGWS_mul_double_digit" == q && (F = A());
        n.setData(r({}, w, F));
    },
    time_ctrl: n,
    clear_time_out: function(r) {
        1 == r ? clearTimeout(w) : clearTimeout(q);
    },
    initialize: function(r, n) {
        if ("YGWS_mul5" == n) var g = t(), S = t(); else if ("YGWS_mul11" == n) var g = Q(), S = Q(); else if ("YGWS_mul12" == n) var g = p(), S = p(); else if ("YGWS_mul25" == n) var g = e(), S = e(); else if ("YGWS_mul50" == n) var g = u(), S = u(); else if ("YGWS_mul_two_decade" == n) var g = i(), S = i(); else if ("YGWS_mul_two_decade_10" == n) var g = o(), S = o(); else if ("YGWS_mul_two_decade_10_10" == n) var g = m(), S = m(); else if ("YGWS_mul_less_100" == n) var g = a(), S = a(); else if ("YGWS_mul_more_100" == n) var g = _(), S = _(); else if ("YGWS_mul_FOIL" == n) var g = l(), S = l(); else if ("YGWS_mul_unit_1" == n) var g = h(), S = h(); else if ("YGWS_mul_unit_2" == n) var g = R(), S = R(); else if ("YGWS_mul_unit_3" == n) var g = c(), S = c(); else if ("YGWS_mul_unit_4" == n) var g = N(), S = N(); else if ("YGWS_mul_unit_5" == n) var g = v(), S = v(); else if ("YGWS_mul_unit_6" == n) var g = G(), S = G(); else if ("YGWS_mul_unit_7" == n) var g = W(), S = W(); else if ("YGWS_mul_unit_8" == n) var g = Y(), S = Y(); else if ("YGWS_mul_unit_9" == n) var g = M(), S = M(); else if ("YGWS_mul_square_1" == n) var g = s(), S = s(); else if ("YGWS_mul_square_4" == n) var g = d(), S = d(); else if ("YGWS_mul_square_5" == n) var g = f(), S = f(); else if ("YGWS_mul_square_9" == n) var g = b(), S = b(); else if ("YGWS_mul_double_digit" == n) var g = A(), S = A();
        r.setData({
            question_data_player_1: g,
            question_data_player_2: S
        });
    }
};