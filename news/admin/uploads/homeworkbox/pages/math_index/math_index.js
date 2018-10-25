var a = require(getApp().data.require_message_data), e = require("../../utils/config.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_index/math_index"
        };
    },
    data: {
        adId: e.adId,
        search_key: [],
        messages: [ {
            title: "几何",
            url: "/images/Index_png_Path/jihe.png",
            rightImage: "/images/tip.png"
        }, {
            title: "三角学",
            url: "/images/Index_png_Path/sanjiaoxue.png",
            rightImage: "/images/tip.png"
        }, {
            title: "方程",
            url: "/images/Index_png_Path/fangcheng.png",
            rightImage: "/images/tip.png"
        } ]
    },
    wxSearchFn: function(e) {
        var t = this;
        a.wxSearchAddHisKey(t);
    },
    wxSearchInput: function(e) {
        var t = this;
        a.wxSearchInput(e, t);
    },
    wxSerchFocus: function(e) {
        var t = this;
        a.wxSearchFocus(e, t);
    },
    wxSearchBlur: function(e) {
        var t = this;
        a.wxSearchBlur(e, t);
    },
    wxSearchKeyTap: function(e) {
        var t = this;
        a.wxSearchKeyTap(e, t);
    },
    wxSearchDeleteKey: function(e) {
        var t = this;
        a.wxSearchDeleteKey(e, t);
    },
    wxSearchDeleteAll: function(e) {
        var t = this;
        a.wxSearchDeleteAll(t);
    },
    wxSearchTap: function(e) {
        var t = this;
        a.wxSearchHiddenPancel(t);
    },
    bindtap0: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=几何"
        });
    },
    bindtap1: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=代数"
        });
    },
    bindtap2: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=三角学"
        });
    },
    bindtap3: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=方程"
        });
    },
    bindtap4: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=解析几何"
        });
    },
    bindtap5: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=导数"
        });
    },
    bindtap6: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=积分"
        });
    },
    bindtap7: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=矩阵"
        });
    },
    bindtap8: function() {
        wx.navigateTo({
            url: "/pages/math_index/formula/formula?id=概率和统计学"
        });
    },
    onLoad: function(e) {
        var t = this;
        this.setData({
            isShowHap: getApp().globalData.isShowHap
        }), a.init(t, 63, getApp().globalData.changyong_Search_key, getApp().globalData.isShowKey, getApp().globalData.isShowHis);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    preview: function(a) {
        var e = [];
        e.push(a.target.dataset.url), wx.previewImage({
            urls: e
        });
    }
});