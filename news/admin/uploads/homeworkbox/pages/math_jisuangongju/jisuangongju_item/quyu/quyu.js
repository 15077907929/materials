var a = require("../../../../utils/fudianshu_bug.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/jisuangongju_item/quyu/quyu"
        };
    },
    data: {
        _data: [ {
            titel: "平方千米(km²)",
            input_data: null
        }, {
            titel: "公顷(ha)",
            input_data: null
        }, {
            titel: "英亩",
            input_data: null
        }, {
            titel: "平方米(m²)",
            input_data: null
        }, {
            titel: "平方厘米(cm²)",
            input_data: null
        }, {
            titel: "平方毫米(mm²)",
            input_data: null
        }, {
            titel: "平方英里(mi²)",
            input_data: null
        }, {
            titel: "平方码(yd²)",
            input_data: null
        }, {
            titel: "平方尺(ft²)",
            input_data: null
        }, {
            titel: "平方英寸(in²)",
            input_data: null
        } ]
    },
    user_input0: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = t.detail.value, 
        this.data._data[1].input_data = a.mul(t.detail.value, 100), this.data._data[2].input_data = a.mul(t.detail.value, 247.105), 
        this.data._data[3].input_data = a.mul(t.detail.value, 1e6), this.data._data[4].input_data = a.mul(t.detail.value, 1e10), 
        this.data._data[5].input_data = a.mul(t.detail.value, 1e12), this.data._data[6].input_data = a.mul(t.detail.value, .386102), 
        this.data._data[7].input_data = a.mul(t.detail.value, 1195990), this.data._data[8].input_data = a.mul(t.detail.value, 10763900), 
        this.data._data[9].input_data = a.mul(t.detail.value, 155e7)), this.setData({
            _data: this.data._data
        });
    },
    user_input1: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, .01), 
        this.data._data[1].input_data = t.detail.value, this.data._data[2].input_data = a.mul(t.detail.value, 2.47105), 
        this.data._data[3].input_data = a.mul(t.detail.value, 1e4), this.data._data[4].input_data = a.mul(t.detail.value, 1e8), 
        this.data._data[5].input_data = a.mul(t.detail.value, 1e10), this.data._data[6].input_data = a.mul(t.detail.value, .00386102), 
        this.data._data[7].input_data = a.mul(t.detail.value, 11959.9), this.data._data[8].input_data = a.mul(t.detail.value, 107639), 
        this.data._data[9].input_data = a.mul(t.detail.value, 155e5)), this.setData({
            _data: this.data._data
        });
    },
    user_input2: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, .00404686), 
        this.data._data[1].input_data = a.mul(t.detail.value, .404686), this.data._data[2].input_data = t.detail.value, 
        this.data._data[3].input_data = a.mul(t.detail.value, 4046.86), this.data._data[4].input_data = a.mul(t.detail.value, 40468600), 
        this.data._data[5].input_data = a.mul(t.detail.value, 404686e4), this.data._data[6].input_data = a.mul(t.detail.value, .0015625), 
        this.data._data[7].input_data = a.mul(t.detail.value, 4840), this.data._data[8].input_data = a.mul(t.detail.value, 43560), 
        this.data._data[9].input_data = a.mul(t.detail.value, 6272640)), this.setData({
            _data: this.data._data
        });
    },
    user_input3: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 1e-6), 
        this.data._data[1].input_data = a.mul(t.detail.value, 1e-4), this.data._data[2].input_data = a.mul(t.detail.value, 247105e-9), 
        this.data._data[3].input_data = t.detail.value, this.data._data[4].input_data = a.mul(t.detail.value, 1e4), 
        this.data._data[5].input_data = a.mul(t.detail.value, 1e6), this.data._data[6].input_data = a.mul(t.detail.value, 3.86102e-7), 
        this.data._data[7].input_data = a.mul(t.detail.value, 1.19599), this.data._data[8].input_data = a.mul(t.detail.value, 10.7639), 
        this.data._data[9].input_data = a.mul(t.detail.value, 1550)), this.setData({
            _data: this.data._data
        });
    },
    user_input4: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 1e-10), 
        this.data._data[1].input_data = a.mul(t.detail.value, 1e-8), this.data._data[2].input_data = a.mul(t.detail.value, 2.47105e-8), 
        this.data._data[3].input_data = a.mul(t.detail.value, 1e-4), this.data._data[4].input_data = t.detail.value, 
        this.data._data[5].input_data = a.mul(t.detail.value, 100), this.data._data[6].input_data = a.mul(t.detail.value, 3.86102e-11), 
        this.data._data[7].input_data = a.mul(t.detail.value, 119599e-9), this.data._data[8].input_data = a.mul(t.detail.value, .00107639), 
        this.data._data[9].input_data = a.mul(t.detail.value, .155)), this.setData({
            _data: this.data._data
        });
    },
    user_input5: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 1e-12), 
        this.data._data[1].input_data = a.mul(t.detail.value, 1e-10), this.data._data[2].input_data = a.mul(t.detail.value, 2.47105e-10), 
        this.data._data[3].input_data = a.mul(t.detail.value, 1e-6), this.data._data[4].input_data = a.mul(t.detail.value, .01), 
        this.data._data[5].input_data = t.detail.value, this.data._data[6].input_data = a.mul(t.detail.value, 3.86102e-13), 
        this.data._data[7].input_data = a.mul(t.detail.value, 119599e-11), this.data._data[8].input_data = a.mul(t.detail.value, 107639e-10), 
        this.data._data[9].input_data = a.mul(t.detail.value, .00155)), this.setData({
            _data: this.data._data
        });
    },
    user_input6: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 2.58999), 
        this.data._data[1].input_data = a.mul(t.detail.value, 258.999), this.data._data[2].input_data = a.mul(t.detail.value, 640), 
        this.data._data[3].input_data = a.mul(t.detail.value, 2589990), this.data._data[4].input_data = a.mul(t.detail.value, 258999e5), 
        this.data._data[5].input_data = a.mul(t.detail.value, 258999e7), this.data._data[6].input_data = t.detail.value, 
        this.data._data[7].input_data = a.mul(t.detail.value, 3097600), this.data._data[8].input_data = a.mul(t.detail.value, 27878400), 
        this.data._data[9].input_data = a.mul(t.detail.value, 401449e4)), this.setData({
            _data: this.data._data
        });
    },
    user_input7: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 8.36127e-7), 
        this.data._data[1].input_data = a.mul(t.detail.value, 836127e-10), this.data._data[2].input_data = a.mul(t.detail.value, 206611e-9), 
        this.data._data[3].input_data = a.mul(t.detail.value, .836127), this.data._data[4].input_data = a.mul(t.detail.value, 8361.27), 
        this.data._data[5].input_data = a.mul(t.detail.value, 836127), this.data._data[6].input_data = a.mul(t.detail.value, 3.2283e-7), 
        this.data._data[7].input_data = t.detail.value, this.data._data[8].input_data = a.mul(t.detail.value, 9), 
        this.data._data[9].input_data = a.mul(t.detail.value, 1296)), this.setData({
            _data: this.data._data
        });
    },
    user_input8: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 9.2903e-8), 
        this.data._data[1].input_data = a.mul(t.detail.value, 92903e-10), this.data._data[2].input_data = a.mul(t.detail.value, 229568e-10), 
        this.data._data[3].input_data = a.mul(t.detail.value, .092903), this.data._data[4].input_data = a.mul(t.detail.value, 929.03), 
        this.data._data[5].input_data = a.mul(t.detail.value, 92903), this.data._data[6].input_data = a.mul(t.detail.value, 3.587e-8), 
        this.data._data[7].input_data = a.mul(t.detail.value, .111111), this.data._data[8].input_data = t.detail.value, 
        this.data._data[9].input_data = a.mul(t.detail.value, 144)), this.setData({
            _data: this.data._data
        });
    },
    user_input9: function(t) {
        "" == t.detail.value ? a.set_null_quyu(this) : (this.data._data[0].input_data = a.mul(t.detail.value, 6.45e-10), 
        this.data._data[1].input_data = a.mul(t.detail.value, 6.45e-8), this.data._data[2].input_data = a.mul(t.detail.value, 1.59383e-7), 
        this.data._data[3].input_data = a.mul(t.detail.value, 645e-6), this.data._data[4].input_data = a.mul(t.detail.value, 6.45), 
        this.data._data[5].input_data = a.mul(t.detail.value, 645), this.data._data[6].input_data = a.mul(t.detail.value, 2.49036e-10), 
        this.data._data[7].input_data = a.mul(t.detail.value, 771414e-9), this.data._data[8].input_data = a.mul(t.detail.value, .00694272), 
        this.data._data[9].input_data = t.detail.value), this.setData({
            _data: this.data._data
        });
    },
    onLoad: function(a) {},
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});