var o = require("commonUtil.js");

module.exports = {
    Login: function(e, t, n, i, s) {
        wx.showToast({
            title: "正在登录",
            icon: "loading",
            duration: 1e4
        }), o.reqPOST("/Mathtool/Logindeal", {
            code: e,
            encryptedData: t,
            iv: n,
            raw: i,
            signature: s
        }, function(o) {
            o ? (wx.hideToast(), wx.setStorage({
                key: "rd_session",
                data: o.rd_session,
                success: function(o) {},
                fail: function(o) {},
                complete: function(o) {}
            })) : console.log("失败！");
        });
    }
};