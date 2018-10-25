var t = require("../store/store");

Page({
    data: {
        pageDatas: [],
        pageShows: [],
        pageHidden: [],
        pageChick: [],
        pageHint: "",
        inputIndex: [],
        rightTimes: 0,
        Checkpoint: 0
    },
    onLoad: function(t) {
        this.stepIndex(this.data.Checkpoint);
    },
    stepIndex: function(a) {
        var i = [], e = "", s = [];
        t.steps[a].forEach(function(a, s) {
            i.push(t.idoims[a]), e += t.idoims[a].idiom;
        }), (s = e.split("")).sort(function() {
            return .5 - Math.random();
        });
        for (var n = [], h = [], o = 0; o < s.length; o++) n.push(!1), h.push(!1);
        this.setData({
            pageDatas: i,
            pageShows: s,
            pageChick: n,
            pageHidden: h
        }), this.setData({
            pageHint: "【提示】：" + this.data.pageDatas[0].explain
        });
    },
    onInputClick: function(a) {
        var i = this, e = a.target.dataset.index, s = this.data.pageChick, n = this.data.pageHidden, h = this.data.inputIndex, o = this.data.rightTimes;
        if (s[e] = !this.data.pageChick[e], s[e] ? h.push(e) : h.pop(e), 4 == h.length) {
            var p = "", d = this;
            this.data.inputIndex.forEach(function(t, a) {
                p += d.data.pageShows[t];
            }), p == d.data.pageDatas[o].idiom ? (h.forEach(function(t, a) {
                n[t] = !0;
            }), o++) : h.forEach(function(t, a) {
                s[t] = !1;
            }), h = [];
        }
        if (this.setData({
            pageChick: s,
            pageHidden: n,
            inputIndex: h,
            rightTimes: o
        }), o < this.data.pageDatas.length) this.setData({
            pageHint: "【提示】：" + this.data.pageDatas[o].explain
        }); else {
            var r = this.data.Checkpoint + 1, g = "第" + (parseInt(r) + 1) + "关";
            this.setData({
                Checkpoint: r,
                rightTimes: 0,
                inputIndex: [],
                pageHint: ""
            }), this.data.Checkpoint == t.steps.length ? wx.showToast({
                title: "恭喜您！通关啦",
                image: "../../../asstes/zan.png",
                duration: 2e3,
                success: function() {
                    setTimeout(function() {
                        wx.redirectTo({
                            url: "../index/index"
                        });
                    }, 2e3);
                }
            }) : wx.showModal({
                content: "进入下一关",
                duration: 3e3,
                success: function(t) {
                    t.confirm ? (i.stepIndex(i.data.Checkpoint), wx.setNavigationBarTitle({
                        title: g
                    })) : t.cancel && wx.redirectTo({
                        url: "../index/index"
                    });
                }
            });
        }
    },
    orderReset: function() {
        var t = [];
        this.data.rightTimes >= 0 && (this.data.pageHidden.forEach(function(a, i) {
            a = !1, t.push(a);
        }), this.setData({
            pageHidden: t,
            pageChick: t,
            rightTimes: 0,
            pageHint: "【提示】：" + this.data.pageDatas[0].explain
        }));
        var a = this.data.pageShows.sort(function() {
            return .5 - Math.random();
        });
        this.setData({
            pageShows: a
        });
    },
    prompt: function() {
        wx.showToast({
            title: this.data.pageDatas[this.data.rightTimes].idiom,
            image: "../../../asstes/prompt.png",
            duration: 1500
        });
    }
});