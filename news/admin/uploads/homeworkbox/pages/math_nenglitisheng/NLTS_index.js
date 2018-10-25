var i = require("../../utils/config.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_nenglitisheng/NLTS_index"
        };
    },
    data: {
        adId: i.adId,
        life: [ {
            title: "网络对战",
            des: "胜局积1分，负局扣1分，管理界面可查询总分",
            img: "/images/NLTS_2.png",
            back_ground_color: "rgba(143,202,255,0.5)"
        }, {
            title: "2人游戏",
            des: "邀请朋友，面对面的较量吧！",
            img: "/images/NLTS_3.png",
            back_ground_color: "rgba(162,140,255,0.5)"
        } ]
    },
    my_touchtap: function(i) {
        "学习与实践" == i.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_nenglitisheng/xuexiyushiji/xuexiyushiji?id=1"
        }) : "网络对战" == i.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_nenglitisheng/xuexiyushiji/xuexiyushiji?id=2"
        }) : "2人游戏" == i.currentTarget.id && wx.navigateTo({
            url: "/pages/math_nenglitisheng/xuexiyushiji/xuexiyushiji?id=3",
            success: function(i) {},
            fail: function() {},
            complete: function() {}
        });
    },
    onLoad: function(i) {
        this.setData({
            user_info_local: getApp().globalData.user_info,
            isShowHap: getApp().globalData.isShowHap
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    preview: function(i) {
        var e = [];
        e.push(i.target.dataset.url), wx.previewImage({
            urls: e
        });
    }
});