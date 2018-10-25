Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/ercifangcheng/ercifangcheng"
        };
    },
    data: {
        _a_value: null,
        _b_value: null,
        _c_value: null,
        error: !1,
        result_1: "",
        result_2: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_fangchengqiujie_ericifangcheng.png"
    },
    _a_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _a_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _a_value: a.detail.value
        });
    },
    _b_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _b_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _b_value: a.detail.value
        });
    },
    _c_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _c_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _c_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._a_value && "" != this.data._a_value && null != this.data._b_value && "" != this.data._b_value && null != this.data._c_value && "" != this.data._c_value) {
            var a = Number(this.data._a_value), e = Number(this.data._b_value), t = Number(this.data._c_value), u = (-e + Math.sqrt(Math.pow(e, 2) - 4 * a * t)) / 2 * a, l = (-e - Math.sqrt(Math.pow(e, 2) - 4 * a * t)) / 2 * a;
            this.setData({
                result_1: u,
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