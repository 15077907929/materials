Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/zhengduobianxin/zhengduobianxin"
        };
    },
    data: {
        _N_value: null,
        _a_value: null,
        bian_N_value: null,
        _r_value: null,
        error: !1,
        result: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_2dtuxingjisuanqi_zhengduobianxing.png"
    },
    _N_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _N_value: a.detail.value,
            bian_N_value: null,
            _r_value: null,
            result: "",
            error: !1
        }) : this.setData({
            _r_value: a.detail.value
        });
    },
    _a_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _a_value: a.detail.value,
            bian_N_value: null,
            _r_value: null,
            result: "",
            error: !1
        }) : this.setData({
            _a_value: a.detail.value
        });
    },
    bian_N_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            bian_N_value: a.detail.value,
            _N_value: null,
            _a_value: null,
            result: "",
            error: !1
        }) : this.setData({
            ban_r_value: a.detail.value
        });
    },
    _r_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _r_value: a.detail.value,
            _N_value: null,
            _a_value: null,
            result: "",
            error: !1
        }) : this.setData({
            _d_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._N_value && "" != this.data._N_value && null != this.data._a_value && "" != this.data._a_value) {
            var a = Math.PI / Number(this.data._N_value), e = Math.pow(Number(this.data._a_value), 2) * Number(this.data._N_value) / (4 * Math.tan(a));
            this.setData({
                result: e,
                error: !1
            });
        } else if (null != this.data.bian_N_value && "" != this.data.bian_N_value && null != this.data._r_value && "" != this.data._r_value) {
            var l = 2 * Math.PI / Number(this.data.bian_N_value), e = Math.pow(Number(this.data._r_value), 2) * Number(this.data.bian_N_value) * Math.sin(l) / 2;
            this.setData({
                result: e,
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