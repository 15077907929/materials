function a(a) {
    var e = a.data.wxSearchData;
    e.view.isShow = !1, a.setData({
        wxSearchData: e
    });
}

function e(a) {
    var e = [];
    try {
        if (e = wx.getStorageSync("wxSearchHisKeys")) {
            var t = a.data.wxSearchData;
            t.his = e, a.setData({
                wxSearchData: t
            });
        }
    } catch (a) {}
}

var t, r = [], i = [];

module.exports = {
    init: function(a, t, r, i, c, n) {
        var o = {}, s = {
            barHeight: t,
            isShow: !1
        };
        s.isShowSearchKey = void 0 === i || i, s.isShowSearchHistory = void 0 === c || c, 
        o.keys = r, wx.getSystemInfo({
            success: function(e) {
                var r = e.windowHeight;
                s.seachHeight = r - t + 200, o.view = s, a.setData({
                    wxSearchData: o
                });
            }
        }), "function" == typeof n && n(), e(a);
    },
    initColor: function(a) {
        r = a;
    },
    initMindKeys: function(a) {
        i = a;
    },
    wxSearchInput: function(a, e, r) {
        var i = e.data.wxSearchData, c = a.detail.value, n = [];
        if (i.value = c, i.mindKeys = n, 0 != a.detail.cursor) var o = a.detail.value;
        void 0 != t && clearTimeout(t), t = setTimeout(function() {
            getApp().ajax.reqPOST("/Mathtool/SearchKeydeal", {
                Searchkey: o
            }, function(a) {
                if (a && (void 0 == a.error || "NOTFOUND" != a.error)) {
                    var t = null;
                    t = a.Search_data.length <= getApp().globalData.amount_remind_key ? a.Search_data.length : getApp().globalData.amount_remind_key;
                    for (var r = 0; r < t; r++) i.mindKeys.push(a.Search_data[r].key);
                    e.setData({
                        wxSearchData: i
                    });
                }
            });
        }, 500);
    },
    wxSearchFocus: function(a, e, t) {
        var r = e.data.wxSearchData;
        r.view.isShow = !0, r.keys = getApp().globalData.changyong_Search_key, r.view.isShowSearchKey = getApp().globalData.isShowKey, 
        r.view.isShowSearchHistory = getApp().globalData.isShowHis, e.setData({
            wxSearchData: r
        }), "function" == typeof t && t();
    },
    wxSearchBlur: function(a, e, t) {
        var r = e.data.wxSearchData;
        r.value = a.detail.value, e.setData({
            wxSearchData: r
        }), "function" == typeof t && t();
    },
    wxSearchKeyTap: function(a, e, t) {
        var r = e.data.wxSearchData;
        r.value = a.target.dataset.key, e.setData({
            wxSearchData: r
        }), "function" == typeof t && t();
    },
    wxSearchAddHisKey: function(t) {
        a(t);
        var r = t.data.wxSearchData.value;
        if (void 0 !== r && 0 != r.length) {
            var i = wx.getStorageSync("wxSearchHisKeys");
            i ? (i.indexOf(r) < 0 && i.unshift(r), wx.setStorage({
                key: "wxSearchHisKeys",
                data: i,
                success: function() {
                    e(t);
                }
            })) : ((i = []).push(r), wx.setStorage({
                key: "wxSearchHisKeys",
                data: i,
                success: function() {
                    e(t);
                }
            })), wx.navigateTo({
                url: "/pages/math_index/formula/formula?name=Search_index&id=" + t.data.wxSearchData.value
            });
        }
    },
    wxSearchDeleteKey: function(a, t) {
        var r = a.target.dataset.key, i = wx.getStorageSync("wxSearchHisKeys");
        i.splice(i.indexOf(r), 1), wx.setStorage({
            key: "wxSearchHisKeys",
            data: i,
            success: function() {
                e(t);
            }
        });
    },
    wxSearchDeleteAll: function(a) {
        wx.removeStorage({
            key: "wxSearchHisKeys",
            success: function(e) {
                var t = [], r = a.data.wxSearchData;
                r.his = t, a.setData({
                    wxSearchData: r
                });
            }
        });
    },
    wxSearchHiddenPancel: a
};