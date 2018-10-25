var t = require("../../utils/config.js");

Page({
    data: {
        adId: t.adId,
        tips: "输入需要翻译的内容(自动检测语言)",
        query: "",
        tranalready: !1,
        tranresult: "",
        index: "0",
        array: [ "中文", "英语", "粤语", "文言文", "日语", "韩语", "法语", "西班牙语", "泰语", "阿拉伯语", "俄语", "葡萄牙语", "德语", "意大利语", "希腊语", "荷兰语", "波兰语", "保加利亚语", "爱沙尼亚语", "丹麦语", "芬兰语", "捷克语", "罗马尼亚语", "斯洛文尼亚语", "瑞典语", "匈牙利语", "繁体中文", "越南语" ],
        arrayen: [ "zh", "en", "yue", "wyw", "jp", "kor", "fra", "spa", "th", "ara", "ru", "pt", "de", "it", "el", "nl", "pl", "bul", "est", "dan", "fin", "cs", "rom", "slo", "swe", "hu", "cht", "vie" ],
        selected: "未选择"
    },
    onLoad: function(t) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getcontent: function(t) {
        this.setData({
            query: t.detail.value
        });
    },
    bindPickerChange: function(t) {
        this.data.array[t.detail.value];
        this.setData({
            index: t.detail.value
        });
    },
    translate: function() {
        var t = this, r = "2015063000000001", a = new Date().getTime(), e = this.data.query;
        if ("" == e) return wx.showModal({
            content: "请输入需要翻译的内容，谢谢",
            mask: !0,
            duration: 1e3,
            showCancel: !1
        }), !1;
        var o = this.data.index, i = this.data.arrayen[o], u = n(r + e + a + "12345678");
        wx.request({
            url: "https://fanyi-api.baidu.com/api/trans/vip/translate",
            data: {
                q: e,
                appid: r,
                salt: a,
                from: "auto",
                to: i,
                sign: u
            },
            success: function(n) {
                t.setData({
                    tranalready: !0,
                    tranresult: n.data.trans_result[0].dst
                });
            }
        });
    }
});

var n = function(t) {
    function n(t, n) {
        return t << n | t >>> 32 - n;
    }
    function r(t, n) {
        var r, a, e, o, i;
        return e = 2147483648 & t, o = 2147483648 & n, r = 1073741824 & t, a = 1073741824 & n, 
        i = (1073741823 & t) + (1073741823 & n), r & a ? 2147483648 ^ i ^ e ^ o : r | a ? 1073741824 & i ? 3221225472 ^ i ^ e ^ o : 1073741824 ^ i ^ e ^ o : i ^ e ^ o;
    }
    function a(t, n, r) {
        return t & n | ~t & r;
    }
    function e(t, n, r) {
        return t & r | n & ~r;
    }
    function o(t, n, r) {
        return t ^ n ^ r;
    }
    function i(t, n, r) {
        return n ^ (t | ~r);
    }
    function u(t, e, o, i, u, s, f) {
        return t = r(t, r(r(a(e, o, i), u), f)), r(n(t, s), e);
    }
    function s(t, a, o, i, u, s, f) {
        return t = r(t, r(r(e(a, o, i), u), f)), r(n(t, s), a);
    }
    function f(t, a, e, i, u, s, f) {
        return t = r(t, r(r(o(a, e, i), u), f)), r(n(t, s), a);
    }
    function c(t, a, e, o, u, s, f) {
        return t = r(t, r(r(i(a, e, o), u), f)), r(n(t, s), a);
    }
    function d(t) {
        var n, r = "", a = "";
        for (n = 0; n <= 3; n++) r += (a = "0" + (t >>> 8 * n & 255).toString(16)).substr(a.length - 2, 2);
        return r;
    }
    var l, h, g, C, v, y, p, m, w, S = Array();
    for (S = function(t) {
        for (var n, r = t.length, a = r + 8, e = 16 * ((a - a % 64) / 64 + 1), o = Array(e - 1), i = 0, u = 0; u < r; ) i = u % 4 * 8, 
        o[n = (u - u % 4) / 4] = o[n] | t.charCodeAt(u) << i, u++;
        return n = (u - u % 4) / 4, i = u % 4 * 8, o[n] = o[n] | 128 << i, o[e - 2] = r << 3, 
        o[e - 1] = r >>> 29, o;
    }(t = function(t) {
        t = t.replace(/\r\n/g, "\n");
        for (var n = "", r = 0; r < t.length; r++) {
            var a = t.charCodeAt(r);
            a < 128 ? n += String.fromCharCode(a) : a > 127 && a < 2048 ? (n += String.fromCharCode(a >> 6 | 192), 
            n += String.fromCharCode(63 & a | 128)) : (n += String.fromCharCode(a >> 12 | 224), 
            n += String.fromCharCode(a >> 6 & 63 | 128), n += String.fromCharCode(63 & a | 128));
        }
        return n;
    }(t)), y = 1732584193, p = 4023233417, m = 2562383102, w = 271733878, l = 0; l < S.length; l += 16) h = y, 
    g = p, C = m, v = w, p = c(p = c(p = c(p = c(p = f(p = f(p = f(p = f(p = s(p = s(p = s(p = s(p = u(p = u(p = u(p = u(p, m = u(m, w = u(w, y = u(y, p, m, w, S[l + 0], 7, 3614090360), p, m, S[l + 1], 12, 3905402710), y, p, S[l + 2], 17, 606105819), w, y, S[l + 3], 22, 3250441966), m = u(m, w = u(w, y = u(y, p, m, w, S[l + 4], 7, 4118548399), p, m, S[l + 5], 12, 1200080426), y, p, S[l + 6], 17, 2821735955), w, y, S[l + 7], 22, 4249261313), m = u(m, w = u(w, y = u(y, p, m, w, S[l + 8], 7, 1770035416), p, m, S[l + 9], 12, 2336552879), y, p, S[l + 10], 17, 4294925233), w, y, S[l + 11], 22, 2304563134), m = u(m, w = u(w, y = u(y, p, m, w, S[l + 12], 7, 1804603682), p, m, S[l + 13], 12, 4254626195), y, p, S[l + 14], 17, 2792965006), w, y, S[l + 15], 22, 1236535329), m = s(m, w = s(w, y = s(y, p, m, w, S[l + 1], 5, 4129170786), p, m, S[l + 6], 9, 3225465664), y, p, S[l + 11], 14, 643717713), w, y, S[l + 0], 20, 3921069994), m = s(m, w = s(w, y = s(y, p, m, w, S[l + 5], 5, 3593408605), p, m, S[l + 10], 9, 38016083), y, p, S[l + 15], 14, 3634488961), w, y, S[l + 4], 20, 3889429448), m = s(m, w = s(w, y = s(y, p, m, w, S[l + 9], 5, 568446438), p, m, S[l + 14], 9, 3275163606), y, p, S[l + 3], 14, 4107603335), w, y, S[l + 8], 20, 1163531501), m = s(m, w = s(w, y = s(y, p, m, w, S[l + 13], 5, 2850285829), p, m, S[l + 2], 9, 4243563512), y, p, S[l + 7], 14, 1735328473), w, y, S[l + 12], 20, 2368359562), m = f(m, w = f(w, y = f(y, p, m, w, S[l + 5], 4, 4294588738), p, m, S[l + 8], 11, 2272392833), y, p, S[l + 11], 16, 1839030562), w, y, S[l + 14], 23, 4259657740), m = f(m, w = f(w, y = f(y, p, m, w, S[l + 1], 4, 2763975236), p, m, S[l + 4], 11, 1272893353), y, p, S[l + 7], 16, 4139469664), w, y, S[l + 10], 23, 3200236656), m = f(m, w = f(w, y = f(y, p, m, w, S[l + 13], 4, 681279174), p, m, S[l + 0], 11, 3936430074), y, p, S[l + 3], 16, 3572445317), w, y, S[l + 6], 23, 76029189), m = f(m, w = f(w, y = f(y, p, m, w, S[l + 9], 4, 3654602809), p, m, S[l + 12], 11, 3873151461), y, p, S[l + 15], 16, 530742520), w, y, S[l + 2], 23, 3299628645), m = c(m, w = c(w, y = c(y, p, m, w, S[l + 0], 6, 4096336452), p, m, S[l + 7], 10, 1126891415), y, p, S[l + 14], 15, 2878612391), w, y, S[l + 5], 21, 4237533241), m = c(m, w = c(w, y = c(y, p, m, w, S[l + 12], 6, 1700485571), p, m, S[l + 3], 10, 2399980690), y, p, S[l + 10], 15, 4293915773), w, y, S[l + 1], 21, 2240044497), m = c(m, w = c(w, y = c(y, p, m, w, S[l + 8], 6, 1873313359), p, m, S[l + 15], 10, 4264355552), y, p, S[l + 6], 15, 2734768916), w, y, S[l + 13], 21, 1309151649), m = c(m, w = c(w, y = c(y, p, m, w, S[l + 4], 6, 4149444226), p, m, S[l + 11], 10, 3174756917), y, p, S[l + 2], 15, 718787259), w, y, S[l + 9], 21, 3951481745), 
    y = r(y, h), p = r(p, g), m = r(m, C), w = r(w, v);
    return (d(y) + d(p) + d(m) + d(w)).toLowerCase();
};