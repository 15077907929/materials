var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/wendu/wendu"
        };
    },
    data: {
        _data: [ {
            titel: "摄氏度(°C)",
            input_data: null
        }, {
            titel: "华氏温度(°F)",
            input_data: null
        }, {
            titel: "开尔文温度(K)",
            input_data: null
        }, {
            titel: "兰氏温度(°R)",
            input_data: null
        } ]
    },
    user_input0: function(t) {
        "" == t.detail.value ? a.set_null_(this, 4) : (this.data._data[0].input_data = t.detail.value, 
        this.data._data[1].input_data = a.mul(t.detail.value, 33.8), this.data._data[2].input_data = a.mul(t.detail.value, 274.15), 
        this.data._data[3].input_data = a.mul(t.detail.value, 493.47)), this.setData({
            _data: this.data._data
        });
    },
    user_input1: function(t) {
        "" == t.detail.value ? a.set_null_(this, 4) : (this.data._data[0].input_data = a.mul(t.detail.value, -17.2222), 
        this.data._data[1].input_data = t.detail.value, this.data._data[2].input_data = a.mul(t.detail.value, 255.928), 
        this.data._data[3].input_data = a.mul(t.detail.value, 460.67)), this.setData({
            _data: this.data._data
        });
    },
    user_input2: function(t) {
        "" == t.detail.value ? a.set_null_(this, 4) : (this.data._data[0].input_data = a.mul(t.detail.value, -272.15), 
        this.data._data[1].input_data = a.mul(t.detail.value, -457.87), this.data._data[2].input_data = t.detail.value, 
        this.data._data[3].input_data = a.mul(t.detail.value, 1.8)), this.setData({
            _data: this.data._data
        });
    },
    user_input3: function(t) {
        "" == t.detail.value ? a.set_null_(this, 4) : (this.data._data[0].input_data = a.mul(t.detail.value, -272.594), 
        this.data._data[1].input_data = a.mul(t.detail.value, -458.67), this.data._data[2].input_data = a.mul(t.detail.value, .555556), 
        this.data._data[3].input_data = t.detail.value), this.setData({
            _data: this.data._data
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});