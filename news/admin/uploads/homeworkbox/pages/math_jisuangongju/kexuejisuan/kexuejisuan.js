function t(t, a, i) {
    return a in t ? Object.defineProperty(t, a, {
        value: i,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = i, t;
}

var a = require(getApp().data.require_kexuejisuanqi_data), i = require(getApp().data.require_fudianshu_bug);

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/kexuejisuan/kexuejisuan"
        };
    },
    data: {
        input_BKC: "black",
        is_show_: 0,
        is_show_Inv: 0,
        is_show_F_E: 0,
        font_size: "180%",
        font_size_value: "180%",
        radioItems: [ {
            name: "度",
            value: "du"
        }, {
            name: "弧度",
            value: "hudu",
            checked: "true"
        }, {
            name: "梯度",
            value: "tidu"
        } ],
        id1: "MC",
        id2: "MR",
        id3: "MS",
        id4: "M+",
        id5: "M-",
        id6: "←",
        id7: "CE",
        id8: "C",
        id9: "±",
        id10: "sqrt",
        id11: "7",
        id12: "8",
        id13: "9",
        id14: "/",
        id15: "%",
        id16: "4",
        id17: "5",
        id18: "6",
        id19: "*",
        id20: "reciproc",
        id21: "1",
        id22: "2",
        id23: "3",
        id24: "-",
        id25: "=",
        id26: "0",
        id27: ".",
        id28: "+",
        id30: "ln",
        id31: "(",
        id32: ")",
        id33: "Int",
        id34: "sinh",
        id35: "sin",
        id36: "sqr",
        id37: "fact",
        id38: "dms",
        id39: "cosh",
        id40: "cos",
        id41: "^",
        id42: "y/xy",
        id43: "π",
        id44: "tanh",
        id45: "tan",
        id46: "cube",
        id47: "cuberoot",
        id49: "Exp",
        id50: "Mod",
        id51: "log",
        id52: "powten",
        id53: "asin",
        id54: "acos",
        id55: "atan",
        id56: "powe",
        id57: "asinh",
        id58: "acosh",
        id59: "atanh",
        id60: "frac",
        id61: "2*π",
        ms_data: 0,
        screenData: "0",
        screenData_value: "0",
        memery_show: 0,
        lastIsOperator: !1
    },
    hidden: function(t) {
        "gray" == this.data.input_BKC && this.setData({
            input_BKC: "black",
            is_show_: 0
        });
    },
    input_Data: function(t) {
        this.setData({
            screenData: t.detail.value
        });
    },
    input_focus: function(t) {
        "black" == this.data.input_BKC && this.setData({
            input_BKC: "gray",
            is_show_: 1
        });
    },
    my_data: {
        Temp_size: null,
        Temp_size_01: null,
        Temp_num: null
    },
    change_size: function(a, i) {
        0 <= a.length && a.length <= 15 && this.setData(t({}, i, "180%")), 15 < a.length && a.length < 21 && this.setData(t({}, i, "150%")), 
        21 <= a.length && a.length < 27 && this.setData(t({}, i, "120%")), 27 <= a.length && a.length <= 31 && this.setData(t({}, i, "100%")), 
        27 <= a.length && a.length <= 31 && this.setData(t({}, i, "90%")), 31 <= a.length && a.length <= 37 && this.setData(t({}, i, "80%"));
    },
    clickButton: function(t) {
        var e = /[^\)0-9]/g, s = /[^.0-9]/g, d = /[^.\)0-9]/g, h = this.data.screenData.toString();
        this.change_size(h, "font_size");
        var n = this.data.screenData_value.toString(), r = t.target.id;
        if (r == this.data.id6) {
            if (0 == h) return;
            h = h.substring(0, h.length - 1);
        } else if (r == this.data.id8) h = 0; else if ("id_input" == r) "black" == this.data.input_BKC ? this.setData({
            input_BKC: "gray",
            is_show_: 1
        }) : this.setData({
            input_BKC: "black",
            is_show_: 0
        }); else if ("id_Inv" == r) 0 == this.data.is_show_Inv ? this.setData({
            is_show_Inv: 1
        }) : this.setData({
            is_show_Inv: 0
        }); else if ("id_F_E" == r) if (0 == this.data.is_show_F_E) {
            if (this.setData({
                is_show_F_E: 1
            }), null == this.deal_kxjs(h)) return;
            h = this.deal_kxjs(h);
        } else {
            this.setData({
                is_show_F_E: 0
            });
            var l = h.match(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e[0-9]+\))/g);
            if (null != l) {
                h = h.replace(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e[0-9]+\))/g, "#");
                for (var u = 0; u < l.length; u++) l[u] = l[u].substring(1, l[u].length - 1);
                for (var o = 0; o < l.length; o++) if (-1 != l[o].indexOf("e+")) {
                    var _ = l[o].substring(-1, l[o].indexOf("e+")), g = l[o].substring(l[o].indexOf("e+") + 2);
                    l[o] = String(i.mul(Number(_), Math.pow(10, Number(g))));
                } else {
                    var f = l[o].substring(-1, l[o].indexOf("e")), c = l[o].substring(l[o].indexOf("e") + 1);
                    l[o] = String(i.mul(Number(f), Math.pow(10, Number(c))));
                }
                for (var m = 0; m < l.length; m++) h = h.replace(/[#]/, l[m]);
            }
            var v = h.match(/(\([0-9.]+e\-[0-9]+\))/g);
            if (null != v) {
                h = h.replace(/(\([0-9.]+e\-[0-9]+\))/g, "#");
                for (var p = 0; p < v.length; p++) v[p] = v[p].substring(1, v[p].length - 1);
                for (var b = 0; b < v.length; b++) if (-1 != v[b].indexOf("e-")) {
                    var D = v[b].substring(-1, v[b].indexOf("e-")), x = v[b].substring(v[b].indexOf("e-") + 2);
                    v[b] = String(i.div(Number(D), Math.pow(10, Number(x))));
                }
                for (var w = 0; w < v.length; w++) h = h.replace(/[#]/, v[w]);
            }
        } else if (r == this.data.id7) n = 0; else if (r == this.data.id3) 0 != n && this.setData({
            ms_data: n,
            memery_show: 1
        }); else if (r == this.data.id2) 0 == h ? h = this.data.ms_data : 0 == this.data.ms_data ? h = 0 : h += this.data.ms_data; else if (r == this.data.id1) 1 == this.data.memery_show && this.setData({
            ms_data: 0,
            memery_show: 0
        }); else if (r == this.data.id4) {
            if (0 == this.data.memery_show) return;
            I = i.add(this.data.ms_data, n);
            this.setData({
                ms_data: I
            });
        } else if (r == this.data.id5) {
            if (0 == this.data.memery_show) return;
            var I = i.sub(this.data.ms_data, n);
            this.setData({
                ms_data: I
            });
        } else if (r == this.data.id43) 0 == h ? h = Math.PI : h += Math.PI, this.setData({
            lastIsOperator: !1
        }); else if (r == this.data.id61) 0 == h ? h = i.mul(Math.PI, 2) : h += i.mul(Math.PI, 2), 
        this.setData({
            lastIsOperator: !1
        }); else if (r == this.data.id9) {
            if (0 == h) return;
            h = "-" != h.substring(0, 1) ? "-" + h : h.substring(1);
        } else if (r == this.data.id32) {
            var k = h.match(/[\(]/g);
            if (!((k ? k.length : 0) > ((k = h.match(/[\)]/g)) ? k.length : 0)) || e.test(h[h.length - 1])) return;
            h += r;
        } else if (r == this.data.id31) if (0 == h) h = r; else {
            if (!s.test(h[h.length - 1])) return;
            h += r;
        } else if (r == this.data.id10 || r == this.data.id20 || r == this.data.id30 || r == this.data.id34 || r == this.data.id35 || r == this.data.id36 || r == this.data.id37 || r == this.data.id38 || r == this.data.id39 || r == this.data.id40 || r == this.data.id44 || r == this.data.id45 || r == this.data.id46 || r == this.data.id47 || r == this.data.id51 || r == this.data.id52 || r == this.data.id53 || r == this.data.id54 || r == this.data.id55 || r == this.data.id56 || r == this.data.id33 || r == this.data.id57 || r == this.data.id58 || r == this.data.id59 || r == this.data.id60) {
            O = h.substring(h.length - 1, h.length);
            d.test(O) ? (h += r, this.setData({
                lastIsOperator: !0
            })) : 0 == h ? (h = r, this.setData({
                lastIsOperator: !0
            })) : h = h.substring(-1, h.lastIndexOf(a.getLastNumberStr_fixed(h))) + r + a.getLastNumberStr_fixed(h);
        } else if (r == this.data.id25) {
            if (1 == this.data.is_show_F_E) {
                if (null == this.deal_kxjs(h)) return;
                h = this.deal_kxjs(h);
            }
            0 == h && (n = h);
            var O = h.substring(h.length - 1, h.length);
            if (e.test(O)) return;
            if (parseFloat(h) == h && (n = h), 1 == this.data.radioItems[0].checked) j = 0; else if (1 == this.data.radioItems[1].checked) j = 1; else if (1 == this.data.radioItems[2].checked) var j = 2;
            var M = h;
            if (1 == this.data.is_show_F_E) {
                var y = M.match(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e\-[0-9]+\))|(\([0-9.]+e[0-9]+\))/g);
                if (null != y) {
                    M = M.replace(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e\-[0-9]+\))|(\([0-9.]+e[0-9]+\))/g, "#");
                    for (var C = 0; C < y.length; C++) y[C] = y[C].substring(1, y[C].length - 1);
                    for (var E = 0; E < y.length; E++) M = M.replace(/[#]/, y[E]);
                }
            }
            n = a.calCommonExp(M, j), 1 == this.data.is_show_F_E && (n = this.deal_number_kxjs(String(n))), 
            void 0 === n && (n = "error");
        } else {
            if ((r == this.data.id28 || r == this.data.id24 || r == this.data.id19 || r == this.data.id14 || r == this.data.id15 || r == this.data.id41 || r == this.data.id42 || r == this.data.id15) && (this.data.lastIsOperator || 0 == h)) return;
            "0" == h && r != this.data.id27 ? h = r : h += r, r == this.data.id28 || r == this.data.id24 || r == this.data.id19 || r == this.data.id14 || r == this.data.id15 || r == this.data.id41 || r == this.data.id42 || r == this.data.id15 ? this.setData({
                lastIsOperator: !0
            }) : this.setData({
                lastIsOperator: !1
            });
        }
        this.change_size(n, "font_size_value"), this.setData({
            screenData: h,
            screenData_value: n
        });
    },
    deal_kxjs: function(t) {
        var a = null, i = t.match(/e{1}/g), e = t.match(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e\-[0-9]+\))|(\([0-9.]+e[0-9]+\))/g);
        if (null != e) {
            if (i.length != e.length) return a = "error input", void this.setData({
                screenData_value: a
            });
            if (e.length > 0) {
                t = t.replace(/(\([0-9.]+e\+[0-9]+\))|(\([0-9.]+e\-[0-9]+\))|(\([0-9.]+e[0-9]+\))/g, "#"), 
                t = this.deal_number_kxjs(t);
                for (var s = 0; s < e.length; s++) t = t.replace(/[#]/, e[s]);
            }
        } else {
            if (null != i) return a = "error input", void this.setData({
                screenData_value: a
            });
            t = this.deal_number_kxjs(t);
        }
        return t;
    },
    deal_number_kxjs: function(t) {
        var a = t.match(/[0-9.]+/g);
        if (t = t.replace(/[0-9.]+/g, "@"), null != a) {
            for (var i = 0; i < a.length; i++) if (-1 != a[i].indexOf(".")) if (Number(a[i]) > 1) {
                var e = a[i].indexOf(".") - 1;
                a[i] = a[i].replace(".", "");
                var s = a[i][0], d = a[i].substring(1);
                a[i] = "(" + s + "." + d + "e+" + e + ")";
            } else {
                var h = a[i].search(/[^0.]/) - 1;
                if (a[i] = a[i].substring(h + 1), 1 == a[i].length) a[i] = "(" + a[i] + "e-" + h + ")"; else {
                    var n = a[i][0], r = a[i].substring(1);
                    a[i] = "(" + n + "." + r + "e-" + h + ")";
                }
            } else if (1 == a[i].replace(/[0]/g, "").length) {
                var l = a[i].length - 1, u = a[i].replace(/[0]/g, "");
                a[i] = "(" + u + "e+" + l + ")";
            } else {
                var o = a[i].length - 1, _ = a[i][0], g = a[i].substring(1);
                a[i] = "(" + _ + "." + g + "e+" + o + ")";
            }
            for (var f = 0; f < a.length; f++) t = t.replace(/[@]/, a[f]);
        }
        return t;
    },
    radioChange: function(t) {
        for (var a = t.detail.value, i = {}, e = 0; e < this.data.radioItems.length; e++) a == this.data.radioItems[e].name ? i["radioItems[" + e + "].checked"] = !0 : i["radioItems[" + e + "].checked"] = !1;
        this.setData(i);
    },
    shuru: function(t) {
        this.setData({
            jisuan_data: t.detail.value
        });
    },
    querenjisuan: function() {
        this.setData({
            text_data: a.calCommonExp(this.data.jisuan_data)
        });
    },
    onLoad: function(t) {
        this.setData({
            text_data_math: Math.asin(.2)
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});