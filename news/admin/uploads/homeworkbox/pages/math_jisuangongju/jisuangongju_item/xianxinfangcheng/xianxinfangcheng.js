Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/xianxinfangcheng/xianxinfangcheng"
        };
    },
    data: {
        _a1_value: null,
        _b1_value: null,
        _c1_value: null,
        _a2_value: null,
        _b2_value: null,
        _c2_value: null,
        error: !1,
        result_1: "",
        result_2: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_fangchengqiujie_xianxinfangchengzhu.png"
    },
    _a1_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _a1_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _a1_value: a.detail.value
        });
    },
    _b1_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _b1_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _b1_value: a.detail.value
        });
    },
    _c1_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _c1_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _c1_value: a.detail.value
        });
    },
    _a2_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _a2_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _a2_value: a.detail.value
        });
    },
    _b2_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _b2_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _b2_value: a.detail.value
        });
    },
    _c2_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _c2_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _c2_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._a1_value && "" != this.data._a1_value && null != this.data._b1_value && "" != this.data._b1_value && null != this.data._c1_value && "" != this.data._c1_value && null != this.data._a2_value && "" != this.data._a2_value && null != this.data._b2_value && "" != this.data._b2_value && null != this.data._c2_value && "" != this.data._c2_value) {
            var a = Number(this.data._a1_value), e = Number(this.data._a2_value), l = Number(this.data._b1_value), t = Number(this.data._b2_value), u = Number(this.data._c1_value), _ = Number(this.data._c2_value), i = (a * _ - e * u) / (a * t - e * l), s = (l * _ - t * u) / (l * e - t * a);
            this.setData({
                result_1: s,
                result_2: i,
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