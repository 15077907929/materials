Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/yuanzhuti/yuanzhuti"
        };
    },
    data: {
        _r_value: null,
        _h_value: null,
        error: !1,
        result_1: "",
        result_2: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_3dtuxingjisuanqi_yuanzhuti.png"
    },
    _r_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _r_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _r_value: a.detail.value
        });
    },
    _h_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _h_value: a.detail.value,
            result_1: "",
            result_2: "",
            error: !1
        }) : this.setData({
            _h_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._r_value && "" != this.data._r_value && null != this.data._h_value && "" != this.data._h_value) {
            var a = Math.PI * Math.pow(Number(this.data._r_value), 2) * Number(this.data._h_value), t = 2 * Math.PI * Number(this.data._r_value) * Number(this.data._h_value);
            this.setData({
                result_1: a,
                result_2: t,
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