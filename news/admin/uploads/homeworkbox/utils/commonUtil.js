function t(t) {
    return (t = t.toString())[1] ? t : "0" + t;
}

module.exports = {
    formatTime: function(e) {
        var n = e.getFullYear(), o = e.getMonth() + 1, u = e.getDate(), r = e.getHours(), i = e.getMinutes(), c = e.getSeconds();
        return [ n, o, u ].map(t).join("/") + " " + [ r, i, c ].map(t).join(":");
    },
    reqPOST: function(t, e, n) {
        wx.request({
            url: "https://www.yuruisoft.com" + t,
            data: e,
            method: "POST",
            header: {
                "content-type": "application/json",
                yuruisoft: "www.yuruisoft.com"
            },
            success: function(t) {
                return "function" == typeof n && n(t.data);
            },
            fail: function() {
                return "function" == typeof n && n(!1);
            }
        });
    }
};