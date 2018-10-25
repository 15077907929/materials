var n = getApp();

Page({
    data: {
        userInfo: {},
        hasUserInfo: !1,
        canIUse: wx.canIUse("button.open-type.getUserInfo")
    },
    gamePage: function() {
        wx.navigateTo({
            url: "../main/main"
        });
    },
    historyOption: function() {
        wx.navigateTo({
            url: "../history/history",
            success: function(n) {},
            fail: function(n) {},
            complete: function(n) {}
        });
    },
    onLoad: function() {
        n.globalData.userInfo || this.data.canIUse;
    },
    getUserInfo: function(n) {}
});