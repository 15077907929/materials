Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/sangedingdiandesanjiaoqu/sangedingdiandesanjiaoqu"
        };
    },
    data: {
        _x1_value: null,
        _y1_value: null,
        _x2_value: null,
        _y2_value: null,
        _x3_value: null,
        _y3_value: null,
        error: !1,
        result: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_jiexijihe_sangedingdiandesanjiaoqu.png"
    },
    _x1_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _x1_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _x1_value: a.detail.value
        });
    },
    _y1_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _y1_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _y1_value: a.detail.value
        });
    },
    _x2_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _x2_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _x2_value: a.detail.value
        });
    },
    _y2_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _y2_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _y2_value: a.detail.value
        });
    },
    _x3_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _x3_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _x3_value: a.detail.value
        });
    },
    _y3_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _y3_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _y3_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._x1_value && "" != this.data._x1_value && null != this.data._y1_value && "" != this.data._y1_value && null != this.data._x2_value && "" != this.data._x2_value && null != this.data._y2_value && "" != this.data._y2_value && null != this.data._x3_value && "" != this.data._x3_value && null != this.data._y3_value && "" != this.data._y3_value) {
            var a = Number(this.data._x1_value), e = Number(this.data._y1_value), l = Number(this.data._x2_value), t = Number(this.data._y2_value), u = Number(this.data._x3_value), i = Number(this.data._y3_value), _ = Math.abs(.5 * (a * (t - i) + l * (i - e) + u * (e - t)));
            this.setData({
                result: _,
                error: !1
            });
        } else this.setData({
            error: !0
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});