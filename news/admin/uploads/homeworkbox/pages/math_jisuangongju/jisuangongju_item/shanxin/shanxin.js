Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/shanxin/shanxin"
        };
    },
    data: {
        _r_value: null,
        _a_value: null,
        ban_r_value: null,
        _b_value: null,
        error: !1,
        result_1: "",
        result_2: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_2dtuxingjisuanqi_sanxing.png"
    },
    _r_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _r_value: a.detail.value,
            ban_r_value: null,
            _b_value: null,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _r_value: a.detail.value
        });
    },
    _a_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _a_value: a.detail.value,
            ban_r_value: null,
            _b_value: null,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _a_value: a.detail.value
        });
    },
    ban_r_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            ban_r_value: a.detail.value,
            _r_value: null,
            _a_value: null,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            ban_r_value: a.detail.value
        });
    },
    _b_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _b_value: a.detail.value,
            _r_value: null,
            _a_value: null,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _d_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._r_value && "" != this.data._r_value && null != this.data._a_value && "" != this.data._a_value) {
            var a = 2 * Math.PI * Number(this.data._r_value) * Number(this.data._a_value) / 360, l = Math.PI * Math.pow(Number(this.data._r_value), 2) * Number(this.data._a_value) / 360;
            this.setData({
                result_1: a,
                result_2: l,
                error: !1
            });
        } else if (null != this.data.ban_r_value && "" != this.data.ban_r_value && null != this.data._b_value && "" != this.data._b_value) {
            var a = Math.PI * this.data._b_value / 2, l = this.data._b_value;
            this.setData({
                result_1: a,
                result_2: l,
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