module.exports = {
    storage_deal: function(e) {
        for (var t = e, a = getApp().globalData.user_storage_data, r = 0; r < t.length; r++) for (var o = 0; o < a.length; o++) {
            if (t[r].image_url == a[o].name) {
                t[r].colected = !0;
                break;
            }
            t[r].colected = !1;
        }
        return t;
    }
};