var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/liang/liang"
        };
    },
    data: {
        _data: [ {
            titel: "升(l)",
            input_data: null
        }, {
            titel: "立方米(m³)",
            input_data: null
        }, {
            titel: "立方英寸(in³)",
            input_data: null
        }, {
            titel: "立方英尺(ft³)",
            input_data: null
        }, {
            titel: "立方码(yd³)",
            input_data: null
        }, {
            titel: "加仑(美国)(gal)",
            input_data: null
        }, {
            titel: "加仑(英国)(gal)",
            input_data: null
        } ]
    },
    user_input0: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = t.detail.value, 
        this.data._data[1].input_data = a.mul(t.detail.value, .001), this.data._data[2].input_data = a.mul(t.detail.value, 61.0237), 
        this.data._data[3].input_data = a.mul(t.detail.value, .0353147), this.data._data[4].input_data = a.mul(t.detail.value, .00130795), 
        this.data._data[5].input_data = a.mul(t.detail.value, .264172), this.data._data[6].input_data = a.mul(t.detail.value, .219969)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input1: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 1e3), 
        this.data._data[1].input_data = t.detail.value, this.data._data[2].input_data = a.mul(t.detail.value, 61023.7), 
        this.data._data[3].input_data = a.mul(t.detail.value, 35.3147), this.data._data[4].input_data = a.mul(t.detail.value, 1.30795), 
        this.data._data[5].input_data = a.mul(t.detail.value, 264.172), this.data._data[6].input_data = a.mul(t.detail.value, 219.969)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input2: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, .016), 
        this.data._data[1].input_data = a.mul(t.detail.value, 16e-6), this.data._data[2].input_data = t.detail.value, 
        this.data._data[3].input_data = a.mul(t.detail.value, 565035e-9), this.data._data[4].input_data = a.mul(t.detail.value, 209272e-10), 
        this.data._data[5].input_data = a.mul(t.detail.value, .00422675), this.data._data[6].input_data = a.mul(t.detail.value, .00351951)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input3: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 28.317), 
        this.data._data[1].input_data = a.mul(t.detail.value, .028317), this.data._data[2].input_data = a.mul(t.detail.value, 1728.01), 
        this.data._data[3].input_data = t.detail.value, this.data._data[4].input_data = a.mul(t.detail.value, .0370372), 
        this.data._data[5].input_data = a.mul(t.detail.value, 7.48056), this.data._data[6].input_data = a.mul(t.detail.value, 6.22887)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input4: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 764.555), 
        this.data._data[1].input_data = a.mul(t.detail.value, .764555), this.data._data[2].input_data = a.mul(t.detail.value, 46656), 
        this.data._data[3].input_data = a.mul(t.detail.value, 27), this.data._data[4].input_data = t.detail.value, 
        this.data._data[5].input_data = a.mul(t.detail.value, 201.974), this.data._data[6].input_data = a.mul(t.detail.value, 168.179)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input5: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 3.785), 
        this.data._data[1].input_data = a.mul(t.detail.value, .003785), this.data._data[2].input_data = a.mul(t.detail.value, 230.975), 
        this.data._data[3].input_data = a.mul(t.detail.value, .133666), this.data._data[4].input_data = a.mul(t.detail.value, .00495059), 
        this.data._data[5].input_data = t.detail.value, this.data._data[6].input_data = a.mul(t.detail.value, .832584)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input6: function(t) {
        "" == t.detail.value ? a.set_null_liang(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 4.546), 
        this.data._data[1].input_data = a.mul(t.detail.value, .004546), this.data._data[2].input_data = a.mul(t.detail.value, 277.414), 
        this.data._data[3].input_data = a.mul(t.detail.value, .16054), this.data._data[4].input_data = a.mul(t.detail.value, .00594594), 
        this.data._data[5].input_data = a.mul(t.detail.value, 1.20093), this.data._data[6].input_data = t.detail.value), 
        this.setData({
            _data: this.data._data
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});