function a(a, t) {
    var d, u, l;
    try {
        d = a.toString().split(".")[1].length;
    } catch (a) {
        d = 0;
    }
    try {
        u = t.toString().split(".")[1].length;
    } catch (a) {
        u = 0;
    }
    return l = Math.pow(10, Math.max(d, u)), (n(a, l) + n(t, l)) / l;
}

function t(a, t) {
    var d, u, l;
    try {
        d = a.toString().split(".")[1].length;
    } catch (a) {
        d = 0;
    }
    try {
        u = t.toString().split(".")[1].length;
    } catch (a) {
        u = 0;
    }
    return l = Math.pow(10, Math.max(d, u)), (n(a, l) - n(t, l)) / l;
}

function n(a, t) {
    var n = 0, d = a.toString(), u = t.toString(), l = 0, e = 0;
    if (-1 != d.indexOf("e")) try {
        -1 != d.indexOf(".") ? n += d.split("e")[0].split(".")[1].length : n += 0, l = Number(d.split("e")[1]), 
        d = d.split("e")[0];
    } catch (l) {} else try {
        n += d.split(".")[1].length;
    } catch (l) {}
    if (-1 != u.indexOf("e")) try {
        -1 != u.indexOf(".") ? n += u.split("e")[0].split(".")[1].length : n += 0, e = Number(u.split("e")[1]), 
        u = u.split("e")[0];
    } catch (l) {} else try {
        n += u.split(".")[1].length;
    } catch (l) {}
    var i = Math.pow(10, n - l - e);
    if (-1 == i.toString().indexOf("e")) return Number(d.replace(".", "")) * Number(u.replace(".", "")) / Math.pow(10, n - l - e);
    var _ = Number(d.replace(".", "")) * Number(u.replace(".", "")), r = _.toString().length, p = Number(i.toString().split("e")[1]);
    if (p > 0) {
        if (p >= r) {
            for (var c = "0.", h = 0; h < p - r; h++) c += "0";
            return Number(c + _.toString());
        }
        for (var g = _.toString(), o = null, s = 0; s < p; s++) null != o ? (o = g.substring(g.length - 1) + o, 
        g = g.substring(-1, g.length - 1)) : (o = g.substring(g.length - 1), g = g.substring(-1, g.length - 1));
        return Number(g + "." + o);
    }
    if (p < 0) {
        for (var f = _.toString(), v = 0; v < Math.abs(p); v++) f += "0";
        return Number(f);
    }
}

function d(a, t) {
    var d, u, l = 0, e = 0;
    try {
        l = a.toString().split(".")[1].length;
    } catch (a) {}
    try {
        e = t.toString().split(".")[1].length;
    } catch (a) {}
    return d = Number(a.toString().replace(".", "")), u = Number(t.toString().replace(".", "")), 
    n(d / u, Math.pow(10, e - l));
}

function u(a) {
    return 0 == a ? 1 : a * u(a - 1);
}

function l(a) {
    a.data.changdu_data[0].input_data = null, a.data.changdu_data[1].input_data = null, 
    a.data.changdu_data[2].input_data = null, a.data.changdu_data[3].input_data = null, 
    a.data.changdu_data[4].input_data = null, a.data.changdu_data[5].input_data = null, 
    a.data.changdu_data[6].input_data = null, a.data.changdu_data[7].input_data = null, 
    a.data.changdu_data[8].input_data = null, a.data.changdu_data[9].input_data = null, 
    a.data.changdu_data[10].input_data = null, a.data.changdu_data[11].input_data = null, 
    a.data.changdu_data[12].input_data = null;
}

module.exports = {
    add: a,
    sub: t,
    mul: n,
    div: d,
    math_dms: function(d) {
        var u = Math.floor(d), l = Math.floor(60 * (d - u)), e = n(t(n(t(d, u), 60), l), 60);
        return a(a(u, n(l, .01)), n(e, 1e-4));
    },
    math_F_E: function(a) {
        var t = Math.floor(Math.log(a) / Math.LN10), d = n(a, Math.pow(10, -t));
        return t >= 0 ? d + "e+" + t : d + "e" + t;
    },
    convertNUM: function(a) {
        if (-1 != a.indexOf("e")) return n(Number(a.substring(0, a.indexOf("e"))), Math.pow(10, Number(a.substring(a.indexOf("e") + 1, a.length))));
    },
    math_convert_du: function(a) {
        return 2 * a * Math.PI / 360;
    },
    fact: u,
    reciproc: function(a) {
        return d(1, a);
    },
    cuberoot: function(a) {
        var n, d;
        for (d = 2 * (n = a) / 3 + a / (3 * n * n); Math.abs(t(d, n)) > 1e-6; ) d = 2 * (n = d) / 3 + a / (3 * n * n);
        return d;
    },
    set_null: l,
    set_value: function(a, t, d) {
        if ("" == t.detail.value) l(a); else {
            if ("." == t.detail.value.toString()[t.detail.value.toString().length - 1]) return;
            if (1 == d) u = 1e6; else if (2 == d) u = 1e9; else if (3 == d) u = 1e4; else if (4 == d) u = 1e3; else if (5 == d) u = 1; else if (6 == d) u = .001; else if (13 == d) var u = 1e-4;
            a.data.changdu_data[0].input_data = n(t.detail.value, n(1e-6, u)), a.data.changdu_data[1].input_data = n(t.detail.value, n(1e-9, u)), 
            a.data.changdu_data[2].input_data = n(t.detail.value, n(1e-4, u)), a.data.changdu_data[3].input_data = n(t.detail.value, n(.001, u)), 
            a.data.changdu_data[4].input_data = n(t.detail.value, u), a.data.changdu_data[5].input_data = n(t.detail.value, n(1e3, u)), 
            a.data.changdu_data[6].input_data = n(t.detail.value, n(393701e-10, u)), a.data.changdu_data[7].input_data = n(t.detail.value, n(328084e-11, u)), 
            a.data.changdu_data[8].input_data = n(t.detail.value, n(109361e-11, u)), a.data.changdu_data[9].input_data = n(t.detail.value, n(6.21371e-10, u)), 
            a.data.changdu_data[10].input_data = n(t.detail.value, n(5.39957e-10, u)), a.data.changdu_data[11].input_data = n(t.detail.value, n(1.057e-22, u)), 
            a.data.changdu_data[12].input_data = n(t.detail.value, n(1e4, u));
        }
        a.setData({
            changdu_data: a.data.changdu_data
        });
    },
    set_null_quyu: function(a) {
        a.data._data[0].input_data = null, a.data._data[1].input_data = null, a.data._data[2].input_data = null, 
        a.data._data[3].input_data = null, a.data._data[4].input_data = null, a.data._data[5].input_data = null, 
        a.data._data[6].input_data = null, a.data._data[7].input_data = null, a.data._data[8].input_data = null, 
        a.data._data[9].input_data = null;
    },
    set_null_liang: function(a) {
        a.data._data[0].input_data = null, a.data._data[1].input_data = null, a.data._data[2].input_data = null, 
        a.data._data[3].input_data = null, a.data._data[4].input_data = null, a.data._data[5].input_data = null, 
        a.data._data[6].input_data = null;
    },
    set_null_zhongliang: function(a) {
        a.data._data[0].input_data = null, a.data._data[1].input_data = null, a.data._data[2].input_data = null, 
        a.data._data[3].input_data = null, a.data._data[4].input_data = null, a.data._data[5].input_data = null, 
        a.data._data[6].input_data = null, a.data._data[7].input_data = null, a.data._data[8].input_data = null, 
        a.data._data[9].input_data = null;
    },
    set_null_: function(a, t) {
        for (var n = 0; n < t; n++) a.data._data[n].input_data = null;
    }
};