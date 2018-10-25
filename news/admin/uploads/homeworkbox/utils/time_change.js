module.exports = {
    time_change: function(t) {
        var e, a, o, f, i = [];
        for (i[0] = 31, i[1] = 28, i[2] = 31, i[3] = 30, i[4] = 31, i[5] = 30, i[6] = 31, 
        i[7] = 31, i[8] = 30, i[9] = 31, i[10] = 31, i[11] = 31, e = t + 28800, o = 1970, 
        f = 0; ;) {
            if (a = e, (e -= o % 4 == 0 && o % 100 != 0 || o % 400 == 0 ? 31622400 : 31536e3) < 0) {
                e = a;
                break;
            }
            o++;
        }
        for (i[1] = o % 4 == 0 && o % 100 != 0 || o % 400 == 0 ? 29 : 28; ;) {
            if (a = e, (e -= 86400 * i[f]) < 0) {
                e = a;
                break;
            }
            f++;
        }
        return {
            year: o,
            month: f + 1,
            day: Math.floor(e / 86400 + 1),
            hour: Math.floor(e % 86400 / 3600),
            minute: Math.floor(e % 3600 / 60),
            second: Math.floor(e % 60)
        };
    },
    delete_data: function(t, e) {
        for (var a = t.data.delete_list, o = t.data.fileList_Data, f = [], i = (o.length, 
        0); i < a.length; i++) {
            for (;0 != o.length; ) a[i] == o[0].filePath ? o.shift() : f.push(o.shift());
            o = f, f = [];
        }
        t.setData({
            fileList_Data: o,
            checked_set: !1
        });
        for (var l = [], n = 0; n < a.length; n++) {
            for (wx.removeSavedFile({
                filePath: a[n],
                success: function(t) {},
                fail: function(t) {},
                complete: function(t) {}
            }); 0 != e.length; ) {
                var r = e.shift();
                r.savedFilePath != a[n] && l.push(r);
            }
            e = l, l = [];
        }
        wx.setStorage({
            key: "colected_data",
            data: e,
            success: function(t) {
                getApp().globalData.user_storage_data = e;
            },
            fail: function(t) {},
            complete: function(t) {}
        });
    },
    clear_all_data: function(t) {
        var e = t.data.fileList_Data;
        t.setData({
            fileList_Data: []
        });
        for (var a = 0; a < e.length; a++) wx.removeSavedFile({
            filePath: e[a].filePath,
            success: function(t) {},
            fail: function(t) {},
            complete: function(t) {}
        });
    }
};