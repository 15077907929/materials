Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/qiu/qiu"
        };
    },
    data: {
        _r_value: null,
        error: !1,
        result_1: "",
        result_2: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jsuangongju_3dtuxingjisuanqi_qiu.png"
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
    click_jisuan: function() {
        if (null != this.data._r_value && "" != this.data._r_value) {
            var a = 4 * Math.PI * Math.pow(Number(this.data._r_value), 3) / 3, t = 4 * Math.PI * Math.pow(Number(this.data._r_value), 2);
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