var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/changdu/changdu"
        };
    },
    data: {
        changdu_data: [ {
            titel: "米(m)",
            input_data: null
        }, {
            titel: "千米(km)",
            input_data: null
        }, {
            titel: "厘米(cm)",
            input_data: null
        }, {
            titel: "毫米(mm)",
            input_data: null
        }, {
            titel: "微米(μm)",
            input_data: null
        }, {
            titel: "纳米(nm)",
            input_data: null
        }, {
            titel: "寸(in)",
            input_data: null
        }, {
            titel: "英尺(ft)",
            input_data: null
        }, {
            titel: "码(yd)",
            input_data: null
        }, {
            titel: "英里(mi)",
            input_data: null
        }, {
            titel: "海里(NM)",
            input_data: null
        }, {
            titel: "光年",
            input_data: null
        }, {
            titel: "埃(Å)",
            input_data: null
        } ]
    },
    user_input0: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = t.detail.value, 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, .001), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 100), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1e3), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1e6), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1e9), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 39.3701), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 3.28084), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 1.09361), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 621371e-9), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 539957e-9), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-16), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1e10)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input1: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 1e3), 
        this.data.changdu_data[1].input_data = t.detail.value, this.data.changdu_data[2].input_data = a.mul(t.detail.value, 1e5), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1e6), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1e9), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1e12), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 39370.1), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 3280.84), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 1093.61), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, .621371), this.data.changdu_data[10].input_data = a.mul(t.detail.value, .539957), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-13), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1e13)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input2: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .01), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1e-5), this.data.changdu_data[2].input_data = t.detail.value, 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 10), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1e4), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1e7), this.data.changdu_data[6].input_data = a.mul(t.detail.value, .393701), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, .0328084), this.data.changdu_data[8].input_data = a.mul(t.detail.value, .0109361), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 621371e-11), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 539957e-11), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-18), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1e8)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input3: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .001), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1e-6), this.data.changdu_data[2].input_data = a.mul(t.detail.value, .1), 
        this.data.changdu_data[3].input_data = t.detail.value, this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1e3), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1e6), this.data.changdu_data[6].input_data = a.mul(t.detail.value, .0393701), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, .00328084), this.data.changdu_data[8].input_data = a.mul(t.detail.value, .00109361), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 6.21371e-7), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 5.39957e-7), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-19), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1e7)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input4: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .001), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1e-6), this.data.changdu_data[2].input_data = a.mul(t.detail.value, .1), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1e3), this.data.changdu_data[4].input_data = t.detail.value, 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1e6), this.data.changdu_data[6].input_data = a.mul(t.detail.value, .0393701), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, .00328084), this.data.changdu_data[8].input_data = a.mul(t.detail.value, .00109361), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 6.21371e-7), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 5.39957e-7), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-19), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1e7)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input5: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 1e-9), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1e-12), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 1e-7), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1e-6), this.data.changdu_data[4].input_data = a.mul(t.detail.value, .001), 
        this.data.changdu_data[5].input_data = t.detail.value, this.data.changdu_data[6].input_data = a.mul(t.detail.value, 3.93701e-8), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 3.28084e-9), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 1.09361e-9), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 6.21371e-13), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 5.39957e-13), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-25), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 10)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input6: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .0254), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 254e-7), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 2.54), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 25.4), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 25400), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 254e5), this.data.changdu_data[6].input_data = t.detail.value, 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, .0833333), this.data.changdu_data[8].input_data = a.mul(t.detail.value, .0277778), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 157828e-10), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 137149e-10), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 2.68478e-18), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 254e6)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input7: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .3048), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 3048e-7), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 30.48), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 304.8), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 304800), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 3048e5), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 12), 
        this.data.changdu_data[7].input_data = t.detail.value, this.data.changdu_data[8].input_data = a.mul(t.detail.value, .333333), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 189394e-9), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 164579e-9), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 3.22174e-17), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 3048e6)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input8: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, .9144), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 9144e-7), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 91.44), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 914.4), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 914400), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 9144e5), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 36), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 3), this.data.changdu_data[8].input_data = t.detail.value, 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 568182e-9), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 493737e-9), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 9.66522e-17), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 9144e6)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input9: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 1609.34), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1.60934), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 160934), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1609344), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 160934400), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 160934e7), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 63360), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 5280), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 1760), 
        this.data.changdu_data[9].input_data = t.detail.value, this.data.changdu_data[10].input_data = a.mul(t.detail.value, .868976), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.70108e-13), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 160934e8)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input10: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 1852), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1.852), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 185200), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1852e3), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1852e6), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 1852e9), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 72913.4), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 6076.12), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 2025.37), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 1.15078), this.data.changdu_data[10].input_data = t.detail.value, 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.95757e-13), this.data.changdu_data[12].input_data = a.mul(t.detail.value, 1852e10)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input11: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 946073e10), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 946073e7), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 946073e12), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 946073e13), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 9.46073e21), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, 9.46073e24), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 37247e13), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 310391e11), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 103464e11), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 587863e7), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 510839e7), 
        this.data.changdu_data[11].input_data = t.detail.value, this.data.changdu_data[12].input_data = a.mul(t.detail.value, 9.46073e25)), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    user_input12: function(t) {
        "" == t.detail.value ? a.set_null(this) : (this.data.changdu_data[0].input_data = a.mul(t.detail.value, 1e-10), 
        this.data.changdu_data[1].input_data = a.mul(t.detail.value, 1e-13), this.data.changdu_data[2].input_data = a.mul(t.detail.value, 1e-8), 
        this.data.changdu_data[3].input_data = a.mul(t.detail.value, 1e-7), this.data.changdu_data[4].input_data = a.mul(t.detail.value, 1e-4), 
        this.data.changdu_data[5].input_data = a.mul(t.detail.value, .1), this.data.changdu_data[6].input_data = a.mul(t.detail.value, 3.93701e-9), 
        this.data.changdu_data[7].input_data = a.mul(t.detail.value, 3.28084e-10), this.data.changdu_data[8].input_data = a.mul(t.detail.value, 1.09361e-10), 
        this.data.changdu_data[9].input_data = a.mul(t.detail.value, 6.21371e-14), this.data.changdu_data[10].input_data = a.mul(t.detail.value, 5.39957e-14), 
        this.data.changdu_data[11].input_data = a.mul(t.detail.value, 1.057e-26), this.data.changdu_data[12].input_data = t.detail.value), 
        this.setData({
            changdu_data: this.data.changdu_data
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});