var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/jiaodu/jiaodu"
        };
    },
    data: {
        _data: [ {
            titel: "度(°)",
            input_data: null
        }, {
            titel: "弧度(rad)",
            input_data: null
        }, {
            titel: "π弧度(πrad)",
            input_data: null
        }, {
            titel: "秒",
            input_data: null
        }, {
            titel: "分(′)",
            input_data: null
        } ]
    },
    user_input0: function(t) {
        "" == t.detail.value ? a.set_null_(this, 5) : (this.data._data[0].input_data = t.detail.value, 
        this.data._data[1].input_data = a.mul(t.detail.value, .0174533), this.data._data[2].input_data = a.mul(t.detail.value, .00555556), 
        this.data._data[3].input_data = a.mul(t.detail.value, 3600), this.data._data[4].input_data = a.mul(t.detail.value, 60)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input1: function(t) {
        "" == t.detail.value ? a.set_null_(this, 5) : (this.data._data[0].input_data = a.mul(t.detail.value, 57.2958), 
        this.data._data[1].input_data = t.detail.value, this.data._data[2].input_data = a.mul(t.detail.value, .31831), 
        this.data._data[3].input_data = a.mul(t.detail.value, 206265), this.data._data[4].input_data = a.mul(t.detail.value, 3437.75)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input2: function(t) {
        "" == t.detail.value ? a.set_null_(this, 5) : (this.data._data[0].input_data = a.mul(t.detail.value, 180), 
        this.data._data[1].input_data = a.mul(t.detail.value, 3.14159), this.data._data[2].input_data = t.detail.value, 
        this.data._data[3].input_data = a.mul(t.detail.value, 648e3), this.data._data[4].input_data = a.mul(t.detail.value, 10800)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input3: function(t) {
        "" == t.detail.value ? a.set_null_(this, 5) : (this.data._data[0].input_data = a.mul(t.detail.value, 278e-6), 
        this.data._data[1].input_data = a.mul(t.detail.value, 485202e-11), this.data._data[2].input_data = a.mul(t.detail.value, 154444e-11), 
        this.data._data[3].input_data = t.detail.value, this.data._data[4].input_data = a.mul(t.detail.value, .01668)), 
        this.setData({
            _data: this.data._data
        });
    },
    user_input4: function(t) {
        "" == t.detail.value ? a.set_null_(this, 5) : (this.data._data[0].input_data = a.mul(t.detail.value, .016667), 
        this.data._data[1].input_data = a.mul(t.detail.value, 290894e-9), this.data._data[2].input_data = a.mul(t.detail.value, 925944e-10), 
        this.data._data[3].input_data = a.mul(t.detail.value, 60), this.data._data[4].input_data = t.detail.value), 
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