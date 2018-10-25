getApp();

var t = require("../../../utils/storage_change.js"), a = require("../../../img-loader/img-loader.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_index/math_index"
        };
    },
    data: {
        isloading: 0,
        page_if: !0,
        lastTapDiffTime: 0,
        formulaID: -1,
        result: [],
        url_data: [],
        formula_Contend: [ {
            title: "几何"
        }, {
            title: "代数"
        }, {
            title: "三角学"
        }, {
            title: "方程"
        }, {
            title: "解析几何"
        }, {
            title: "导数"
        }, {
            title: "积分"
        }, {
            title: "矩阵"
        }, {
            title: "概率和统计学"
        } ],
        imgList: {
            "几何": [ "http://img.mp.itc.cn/upload/20161212/510cd7de9aa9490095dacefabcab182b_th.jpg", "http://img.mp.itc.cn/upload/20161212/c02cad25d2684c37a10794e44cd984c9_th.jpg", "http://img.mp.itc.cn/upload/20161212/ca810b09df32467183f43b9b67aa12f1_th.jpg", "http://img.mp.itc.cn/upload/20161212/abedbaf62cd34d568450eb685548b3e6_th.jpg", "http://img.mp.itc.cn/upload/20161212/6e6867dd242b49c7bada17e526ad97ba_th.jpg", "http://img.mp.itc.cn/upload/20161212/356b7bc1315346a1ac8203503a10c49c_th.jpg", "http://img.mp.itc.cn/upload/20161212/72b0f214dc7e4409b3a5ff037f0cc521_th.jpg", "http://img.mp.itc.cn/upload/20161212/d18a2d7ab6664fbb935fbe727f8aec66_th.jpg", "http://img.mp.itc.cn/upload/20161212/84f272629e9a4b378bf483d77fee011b_th.jpg", "http://img.mp.itc.cn/upload/20161212/40a1e43e9b9f41088eab272c54f1f269_th.jpg", "http://img.mp.itc.cn/upload/20161212/8bec6bf7fa5348c9a7d73b4c6c92a942_th.jpg", "http://img.mp.itc.cn/upload/20161212/d0eba5f70c3543ba94e780e5c4563069_th.jpg", "http://img.mp.itc.cn/upload/20161212/e5b493798d484db6a75764c500ed192b_th.jpg", "http://img.mp.itc.cn/upload/20161212/a76b2573bfbf4b1dbbc0c085d7e39d98_th.jpg", "http://img.mp.itc.cn/upload/20161212/97a568b35baa4d90842e039e88138229_th.jpg", "http://img.mp.itc.cn/upload/20161212/a4caaa6129a24268ad325c4b23078c70_th.jpg", "http://img.mp.itc.cn/upload/20161212/92dad8ab1fd3449fb8c3e177dcf3f788_th.jpg", "http://img.mp.itc.cn/upload/20161212/68b8bc6cc38c4b92bab3a71707471c8e_th.jpg", "http://img.mp.itc.cn/upload/20161212/c53deac32aaf4f99b15cf2feb9cfd0f6_th.jpg", "http://img.mp.itc.cn/upload/20161212/d50a4c629c164595a5678d1cc086c0cd_th.jpg", "http://img.mp.itc.cn/upload/20161212/ac368a4ea1b94e9883f06651d9fac1ce_th.jpg", "http://img.mp.itc.cn/upload/20161212/cac032503c054ec59b84d2bd7cf76f79_th.jpg", "http://img.mp.itc.cn/upload/20161212/de8e8cf4a3df4a01b440d596e9a8cabb_th.jpg", "http://img.mp.itc.cn/upload/20161212/47ccfc180e2e4479afcc7a1786778fc8_th.jpg", "http://img.mp.itc.cn/upload/20161212/e2689722a7a3445991b7c602410e5425_th.jpg", "http://img.mp.itc.cn/upload/20161212/87a4a1d131d149ab95cf1f293a4a6a7f_th.jpg", "http://img.mp.itc.cn/upload/20161212/9555823e7b0c4b9bbc8d1feb0f6c0d83_th.jpg", "http://img.mp.itc.cn/upload/20161212/0ef6780d6031409b9f2287bd00c74d57_th.jpg", "http://img.mp.itc.cn/upload/20161212/f0d7c43994c644fd89b4f772760fa0bc_th.jpg", "http://img.mp.itc.cn/upload/20161212/f6edbc44022f42e3b936155fb9187a09_th.jpg", "http://img.mp.itc.cn/upload/20161212/e497bb3ce3d94a5f815e62a5e9013abb_th.jpg", "http://img.mp.itc.cn/upload/20161212/fedf8f8e80f74f6da9083f9b3f50c803_th.jpg", "http://img.mp.itc.cn/upload/20161212/bbe2eb1253fe4a498c56f8a7d36f721b_th.jpg" ],
            "代数": [ "http://files.eduuu.com/img/2017/09/05/165232_59ae65d0d0076.jpg", "http://files.eduuu.com/img/2017/09/05/165233_59ae65d104ba1.jpg" ],
            "三角学": [ "http://file.xdf.cn/uploads/170926/182_170926101646h9PypgSY8DZHeufB.jpg", "http://file.xdf.cn/uploads/170926/182_1709261050529SPSDkbPhKOaHEvS.jpg" ],
            "方程": [ "/images/gongshi/fangcheng/1.jpg", "/images/gongshi/fangcheng/2.jpg", "/images/gongshi/fangcheng/3.jpg", "/images/gongshi/fangcheng/4.jpg" ],
            "解析几何": [ "/images/gongshi/jiexijihe/1.jpg", "/images/gongshi/jiexijihe/2.jpg", "/images/gongshi/jiexijihe/3.jpg", "/images/gongshi/jiexijihe/4.jpg", "/images/gongshi/jiexijihe/5.jpg", "/images/gongshi/jiexijihe/6.jpg", "/images/gongshi/jiexijihe/7.jpg", "/images/gongshi/jiexijihe/8.jpg", "/images/gongshi/jiexijihe/11.jpg", "/images/gongshi/jiexijihe/10.jpg", "/images/gongshi/jiexijihe/12.jpg", "/images/gongshi/jiexijihe/12.jpg", "/images/gongshi/jiexijihe/13.jpg", "/images/gongshi/jiexijihe/14.jpg", "/images/gongshi/jiexijihe/15.jpg", "/images/gongshi/jiexijihe/16.jpg" ]
        }
    },
    my_longtap: function(a) {
        if (this.data.result[a.currentTarget.dataset.index].colected) wx.showToast({
            title: "已收藏",
            icon: "success",
            duration: 1e3
        }); else {
            var e = this;
            wx.showModal({
                title: "提示",
                content: "收藏该公式吗？",
                success: function(i) {
                    if (i.confirm) {
                        wx.showToast({
                            title: "加载中",
                            icon: "loading",
                            duration: 1e4
                        });
                        var s = "https" + a.currentTarget.id.slice(4, a.currentTarget.id.length);
                        wx.downloadFile({
                            url: s,
                            success: function(i) {
                                wx.saveFile({
                                    tempFilePath: i.tempFilePath,
                                    success: function(i) {
                                        var s = {};
                                        s.name = a.currentTarget.id, s.savedFilePath = i.savedFilePath;
                                        var g = [];
                                        wx.getStorage({
                                            key: "colected_data",
                                            success: function(a) {
                                                (g = a.data).push(s), wx.setStorage({
                                                    key: "colected_data",
                                                    data: g,
                                                    success: function(a) {
                                                        wx.getStorage({
                                                            key: "colected_data",
                                                            success: function(a) {
                                                                getApp().globalData.user_storage_data = a.data, e.setData({
                                                                    result: t.storage_deal(e.data.result)
                                                                });
                                                                for (var i = e.data.result.slice(0, e.data.result.length), s = e.data.imgList.slice(0, e.data.imgList.length), g = 0; g < s.length; g++) s[g].colected = i[g].colected;
                                                                e.setData({
                                                                    imgList: s
                                                                }), wx.hideToast();
                                                            },
                                                            fail: function(t) {},
                                                            complete: function(t) {}
                                                        });
                                                    },
                                                    fail: function(t) {},
                                                    complete: function(t) {}
                                                });
                                            }
                                        });
                                    },
                                    fail: function(t) {},
                                    complete: function(t) {}
                                });
                            },
                            fail: function(t) {
                                console.log(t), wx.showToast({
                                    title: "网络或其他原因无法下载",
                                    icon: "success",
                                    duration: 2e3
                                });
                            },
                            complete: function(t) {}
                        });
                    }
                }
            });
        }
    },
    mytap: function(t) {
        var a = t.timeStamp, e = this.data.lastTapDiffTime;
        e > 0 && a - e < 300 && wx.previewImage({
            current: t.currentTarget.id,
            urls: this.data.url_data,
            success: function(t) {},
            fail: function() {},
            complete: function() {}
        }), this.setData({
            lastTapDiffTime: a
        });
    },
    onLoad: function(t) {
        this.imgLoader = new a(this, this.imageOnLoad.bind(this));
        this.setData({
            formulaID: t.id,
            isloading: 1
        }), console.log(t.id);
    },
    LoadPage: function(a, e) {
        a.setData({
            result: t.storage_deal(e.results),
            page_if: e.error
        });
        for (var i = 0; i < e.results.length; i++) a.data.url_data.push(e.results[i].image_url);
        a.TempData.TempResults = e.results.length < a.TempData.pageSize ? e.results : e.results.slice(0, a.TempData.pageSize), 
        a.imgLoader.load(a.TempData.TempResults[0].image_url);
    },
    TempData: {
        Results_count: 0,
        pageNum: 1,
        pageSize: 6,
        CanonPullUp: !1
    },
    onReachBottom: function() {
        this.TempData.CanonPullUp && (wx.showNavigationBarLoading(), this.setData({
            isloading: 1
        }), this.TempData.CanonPullUp = !1, this.TempData.pageNum * this.TempData.pageSize < this.data.result.length ? (this.TempData.pageNum++, 
        this.TempData.TempResults = this.data.result.length < this.data.result.pageSize ? this.data.result : this.data.result.slice(0, this.TempData.pageSize * this.TempData.pageNum), 
        this.imgLoader.load(this.TempData.TempResults[(this.TempData.pageNum - 1) * this.TempData.pageSize].image_url)) : (wx.hideNavigationBarLoading(), 
        this.setData({
            isloading: 0
        })));
    },
    onPullDownRefresh: function() {
        wx.showNavigationBarLoading(), this.setData({
            isloading: 1
        }), this.TempData.CanonPullUp = !1;
        this.data.imgList = [], this.TempData.Results_count = 0, this.imgLoader.load(this.data.result[0].image_url, this.imageOnLoadAll.bind(this));
    },
    imageOnLoadAll: function(t, a) {
        console.log("图片加载完成", t, a), this.setData({
            imgList: this.getImgListData(this.data.result.slice(this.TempData.Results_count, this.TempData.Results_count + 1))
        }), ++this.TempData.Results_count < this.data.result.length ? this.imgLoader.load(this.data.result[this.TempData.Results_count].image_url, this.imageOnLoadAll.bind(this)) : (this.TempData.Results_count = 0, 
        wx.hideNavigationBarLoading(), wx.stopPullDownRefresh(), this.setData({
            isloading: 0
        }));
    },
    imageOnLoad: function(t, a) {
        var e = (this.TempData.pageNum - 1) * this.TempData.pageSize;
        console.log("图片加载完成", t, a), this.setData({
            imgList: this.getImgListData(this.TempData.TempResults.slice(e + this.TempData.Results_count, e + this.TempData.Results_count + 1))
        }), ++this.TempData.Results_count < this.TempData.pageSize && this.TempData.TempResults.length > e + this.TempData.Results_count ? this.imgLoader.load(this.TempData.TempResults[e + this.TempData.Results_count].image_url) : (this.TempData.Results_count = 0, 
        this.TempData.CanonPullUp = !0, wx.hideNavigationBarLoading(), this.setData({
            isloading: 0
        }));
    },
    getImgListData: function(t) {
        return void 0 != this.data.imgList ? (this.setData({
            CurrentPercent: Math.floor((this.data.imgList.length + 1) / this.data.result.length * 100)
        }), console.log(this.data.CurrentPercent), this.data.imgList.concat(t.map(function(t) {
            return {
                _id: t._id,
                colected: t.colected,
                url: t.image_url,
                loaded: !0,
                titleName: parseInt(t.image_url.slice(t.image_url.lastIndexOf("_") + 1, t.image_url.indexOf(".png"))) + 1
            };
        }))) : (this.setData({
            CurrentPercent: Math.floor(1 / this.data.result.length)
        }), t.map(function(t) {
            return {
                _id: t._id,
                colected: t.colected,
                url: t.image_url,
                loaded: !0,
                titleName: parseInt(t.image_url.slice(t.image_url.lastIndexOf("_") + 1, t.image_url.indexOf(".png"))) + 1
            };
        }));
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});