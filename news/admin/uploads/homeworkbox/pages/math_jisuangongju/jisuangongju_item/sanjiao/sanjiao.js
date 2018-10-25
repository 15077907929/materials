var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/sanjiao/sanjiao"
        };
    },
    data: {
        _h_value: null,
        _b_value: null,
        bian_a_value: null,
        bian_b_value: null,
        bian_c_value: null,
        error: !1,
        result: "",
        images_url: getApp().data.servsers + "/images/jisuangongju/2dtuxingjisuanqi/jisuangongju_2dtuxingjisuanqi_sanjiao.png"
    },
    _h_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _h_value: a.detail.value,
            bian_a_value: null,
            bian_b_value: null,
            bian_c_value: null,
            result: "",
            error: !1
        }) : this.setData({
            _h_value: a.detail.value
        });
    },
    _b_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            _b_value: a.detail.value,
            bian_a_value: null,
            bian_b_value: null,
            bian_c_value: null,
            result: "",
            error: !1
        }) : this.setData({
            _b_value: a.detail.value
        });
    },
    bian_a_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            bian_a_value: a.detail.value,
            _h_value: null,
            _b_value: null,
            result: "",
            error: !1
        }) : this.setData({
            bian_a_value: a.detail.value
        });
    },
    bian_b_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            bian_b_value: a.detail.value,
            _h_value: null,
            _b_value: null,
            result: "",
            error: !1
        }) : this.setData({
            bian_b_value: a.detail.value
        });
    },
    bian_c_value: function(a) {
        null != a.detail.value && "" != a.detail.value ? this.setData({
            bian_c_value: a.detail.value,
            _h_value: null,
            _b_value: null,
            result: "",
            error: !1
        }) : this.setData({
            bian_c_value: a.detail.value
        });
    },
    click_jisuan: function() {
        if (null != this.data._h_value && "" != this.data._h_value && null != this.data._b_value && "" != this.data._b_value) {
            i = a.div(a.mul(Number(this.data._h_value), Number(this.data._b_value)), 2);
            this.setData({
                result: i,
                error: !1
            });
        } else if (null != this.data.bian_a_value && "" != this.data.bian_a_value && null != this.data.bian_b_value && "" != this.data.bian_b_value && null != this.data.bian_c_value && "" != this.data.bian_c_value) {
            var l = Number(this.data.bian_a_value), e = Number(this.data.bian_b_value), u = Number(this.data.bian_c_value), t = .5 * (l + e + u), i = Math.sqrt(t * (t - l) * (t - e) * (t - u));
            console.log("_result" + Math.sqrt(t * (t - l) * (t - e) * (t - u))), isNaN(i) ? this.setData({
                error: !0,
                result: "无效值"
            }) : this.setData({
                result: i
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