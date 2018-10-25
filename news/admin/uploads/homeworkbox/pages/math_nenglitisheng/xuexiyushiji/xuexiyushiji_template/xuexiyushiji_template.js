var i = getApp();

Page({
    data: {
        load_data: {
            text_content: "",
            gif_url: ""
        },
        view_txt_show: 1,
        view_daizhi_zuo_show: 0,
        view_daizhi_you_show: 0,
        view_gongshi_show: 0,
        current_id: null,
        daizhi: "A"
    },
    SJ_CZ: function() {
        wx.navigateTo({
            url: "/pages/math_nenglitisheng/2renyouxi/2renyouxi?NLTS_XXSJ_id=" + this.data.current_id + "&NLTS_id=1",
            success: function(i) {},
            fail: function() {},
            complete: function() {}
        });
    },
    daizhi: function() {
        "A" == this.data.daizhi ? this.setData({
            daizhi: "B"
        }) : this.setData({
            daizhi: "A"
        }), 0 == this.data.view_daizhi_zuo_show && 0 == this.data.view_daizhi_you_show ? this.setData({
            view_daizhi_zuo_show: 1,
            view_daizhi_you_show: 0,
            view_txt_show: 0,
            view_gongshi_show: 0
        }) : 1 == this.data.view_daizhi_zuo_show && 0 == this.data.view_daizhi_you_show ? this.setData({
            view_daizhi_zuo_show: 0,
            view_daizhi_you_show: 1,
            view_txt_show: 0,
            view_gongshi_show: 0
        }) : this.setData({
            view_daizhi_zuo_show: 1,
            view_daizhi_you_show: 0,
            view_txt_show: 0,
            view_gongshi_show: 0
        });
    },
    gongshi: function() {
        1 != this.data.view_gongshi_show && this.setData({
            view_daizhi_zuo_show: 0,
            view_daizhi_you_show: 0,
            view_txt_show: 0,
            view_gongshi_show: 1
        });
    },
    wenzi: function() {
        1 != this.data.view_txt_show && this.setData({
            view_daizhi_zuo_show: 0,
            view_daizhi_you_show: 0,
            view_txt_show: 1,
            view_gongshi_show: 0
        });
    },
    onLoad: function(t) {
        _ = this;
        wx.getSystemInfo({
            success: function(i) {
                _.setData({
                    windowHeight: i.windowHeight
                });
            }
        }), this.setData({
            current_id: t.id
        });
        var _ = this;
        wx.showToast({
            title: "下载中",
            icon: "loading",
            duration: 1e4
        }), i.ajax.reqPOST("/Mathtool/Abilitydeal", {
            id: t.id
        }, function(i) {
            i ? (_.setData({
                txt_data: i.txt_data,
                url_gongshi: i.url_gongshi,
                url_daizhi_left: i.url_daizhi_left,
                url_daizhi_right: i.url_daizhi_right
            }), wx.hideToast()) : console.log("失败！");
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});