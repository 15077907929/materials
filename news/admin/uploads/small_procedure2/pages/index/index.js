// pages/index/index.js
import { Base } from '../../utils/Base.js';
import { Config } from '../../utils/Config.js';
var baseModel = new Base();
var appid = Config.appid;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    page:1,//文章开始状态为1
    count:6,//文章的个数
    appid:appid,//应用ID
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadingAd();
    this._loadingIndex();
    this.getShareCover();
	this.jump_app();
  },
  
  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
    this.fresh();
    wx.stopPullDownRefresh();
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    this._loadingIndex();
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function (e) {
    return {
      title: '恋爱情侣',
      path: 'pages/index/index',
      imageUrl: Config.baseURI + this.data.shareUrl,
      success: function (res) {
        wx.showToast({
          title: '感谢您的分享',
          icon: 'success',
          duration: 1200
        });
      }
    }
  },

  fresh:function(){
    var that = this;
    baseModel.request({
      url: '/api/getRandom',
      type: 'POST',
      data: {
        appid: this.data.appid,
        count: this.data.count,
      },
      sCallback: function (res) {
        if (that.data.ad.length != 0){
          var adIndex = (that.data.page - 2) % that.data.ad.length;
          var currentAd = that.data.ad[adIndex];
          that.setData({
            loadtitle: res.data
          });
          that.data.loadtitle.push({
            art_id: currentAd.id,
            art_tit: currentAd.title,
            art_cate: '1',
            art_img: currentAd.image,
            jump_appid: currentAd.jump_appid,
            jump_extend: currentAd.jump_extend,
            jump_path: currentAd.jump_path
          });
        }else{
          that.setData({
            loadtitle: res.data
          });
        }
      }
    }, true);
  },
  //加载广告
  _loadingAd:function(){
    //加载广告
    var that = this;
    baseModel.request({
      url: '/api/getAllAd',
      type: 'POST',
      data: {
        appid: this.data.appid,
      },
      sCallback: function (res) {
        that.setData({
          banner:res.data['banner'],
          ad:res.data['content']
        });
      }
    }, true);
  },
  //首页标题加载
  _loadingIndex:function(){
    var that = this;
    baseModel.request({
      url: '/api/getArticleTitle',
      type: 'POST',
      data: {
        appid: this.data.appid,
        count: this.data.count,
        page: this.data.page
      },
      sCallback: function (res) {
        var ad = that.data.ad;
        if (!that.data.loadtitle){
          that.setData({
            loadtitle: res.data,
            page: ++that.data.page
          });
        }else{
          that.setData({
            loadtitle: that.data.loadtitle.concat(res.data),
            page: ++that.data.page
          });
        }
        //加载广告
        if(that.data.ad){
          if (that.data.ad.length != 0){
              var adIndex = (that.data.page - 2) % that.data.ad.length;
              var currentAd = ad[adIndex];
              that.data.loadtitle.push({
                art_id: currentAd.id,
                art_tit: currentAd.title,
                art_cate: '1',
                art_img: currentAd.image,
                jump_appid: currentAd.jump_appid,
                jump_extend: currentAd.jump_extend,
                jump_path: currentAd.jump_path
              });
          }
        }

      }
    }, true);
  },
  bannerJump:function(e){
    var url = e.detail.target.dataset.url;
    var jump = e.detail.target.dataset.jump;
    if(jump == 'true'){
      wx.navigateTo({
        url: url,
      });
    }
  },
  getShareCover: function () {
    var that = this;
    baseModel.request({
      url: '/api/shareCover',
      type: 'POST',
      data: {
        appid: that.data.appid,
      },
      sCallback: function (res) {
        if (res.status == 1) {
          that.setData({
            shareUrl: res.url
          });
        }
      }
    }, true);
  },
  jump_app: function () {
    var that = this;
    wx.request({
      url: 'https://news.hmset.com/box/get_jump_app',
      header: {
        "content-type": "application/x-www-form-urlencoded"
      },
      method: "POST",
      data: {
        appid: 'wx7d85f4d298cc18dc'
      },
      success: function (res) {
        console.log(res.data.res.jump_app_id);
        if (res.data.status == 1) {
          console.log(res.data.res.jump_app_id);
          that.setData({
            appId: res.data.res.jump_app_id, // 要跳转的小程序的appid
            path: 'pages/index/index', // 跳转的目标页面
            is_jump: res.data.res.is_jump
          });
        }
      }
    })
  }
})