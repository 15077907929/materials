require("/utils/login.js");

var a = require("utils/commonUtil.js");

require("/utils/IndexSearchInput/wxSearch.js");

App({
    data: {
        servsers: "https://www.yuruisoft.com/MathTool",
        require_message_data: "../../utils/IndexSearchInput/wxSearch.js",
        require_kexuejisuanqi_data: "../../../utils/kexuejisuanqi.js",
        require_fudianshu_bug: "../../../utils/fudianshu_bug.js"
    },
    ajax: {
        req: a.req,
        reqPOST: a.reqPOST
    },
    com: {},
    globalData: {
        user_storage_data: [],
        user_info: {}
    },
    onLaunch: function() {
        var a = this;
        wx.getStorage({
            key: "amount_remind_key",
            success: function(e) {
                a.globalData.amount_remind_key = e.data;
            },
            fail: function(e) {
                wx.setStorage({
                    key: "amount_remind_key",
                    data: 5,
                    success: function(e) {
                        a.globalData.amount_remind_key = 5;
                    }
                });
            }
        }), wx.getStorage({
            key: "changyong_Search_key",
            success: function(e) {
                a.globalData.changyong_Search_key = e.data;
            },
            fail: function(e) {
                wx.setStorage({
                    key: "changyong_Search_key",
                    data: [ "几何", "代数", "三角学", "方程", "解析几何" ],
                    success: function(e) {
                        a.globalData.changyong_Search_key = [ "几何", "代数", "三角学", "方程", "解析几何" ];
                    }
                });
            }
        }), wx.getStorage({
            key: "isShowKey",
            success: function(e) {
                a.globalData.isShowKey = e.data;
            },
            fail: function(e) {
                wx.setStorage({
                    key: "isShowKey",
                    data: !0,
                    success: function(e) {
                        a.globalData.isShowKey = !0;
                    }
                });
            }
        }), wx.getStorage({
            key: "isShowHis",
            success: function(e) {
                a.globalData.isShowHis = e.data;
            },
            fail: function(e) {
                wx.setStorage({
                    key: "isShowHis",
                    data: !0,
                    success: function(e) {
                        a.globalData.isShowHis = !0;
                    }
                });
            }
        }), wx.getStorage({
            key: "isShowHap",
            success: function(e) {
                a.globalData.isShowHap = e.data;
            },
            fail: function(e) {
                wx.setStorage({
                    key: "isShowHap",
                    data: !0,
                    success: function(e) {
                        a.globalData.isShowHap = !0;
                    }
                });
            }
        }), wx.getStorage({
            key: "colected_data",
            success: function(e) {
                a.globalData.user_storage_data = e.data;
            },
            fail: function(a) {
                try {
                    wx.setStorageSync("colected_data", []);
                } catch (a) {}
            }
        }), wx.checkSession({
            success: function(e) {
                wx.getStorage({
                    key: "rd_session",
                    success: function(e) {
                        a.ajax.reqPOST("/Mathtool/Verificationdeal", {
                            yuruisoft_session: e.data
                        }, function(e) {
                            e && !e.error && e.exist || a.login(a);
                        });
                    },
                    fail: function(e) {
                        a.login(a);
                    }
                }), wx.getUserInfo({
                    success: function(e) {
                        a.globalData.user_info = e.userInfo;
                    }
                });
            },
            fail: function() {}
        });
    }
});