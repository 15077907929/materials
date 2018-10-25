Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/jinzita/jinzita"
        };
    },
    data: {
        _D_value: null,
        _h_value: null,
        error: !1,
        result: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_3dtuxingjisuanqi_jinzita.png"
    },
    _D_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _D_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _r_value: a.detail.value
        });
    },
    _h_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _h_value: a.detail.value,
            result: "",
            error: !1
        }) : this.setData({
            _h_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._D_value && "" != this.data._D_value && null != this.data._h_value && "" != this.data._h_value) {
            var a = Number(this.data._D_value) * Number(this.data._h_value) / 3;
            this.setData({
                result: a,
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