// pages/display/display.js
import { Base } from '../../utils/Base.js';
import { Config } from '../../utils/Config.js';
var WxParse = require('../../wxParse/wxParse.js');
var baseModel = new Base();
var appid = Config.appid;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    count: 6,//文章的个数
    appid: appid,//应用ID
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    if(options){
      var id = options.id;
      this._loadContent(id);
    }
  },
  onShow: function () {
    this.getShareCover();
  },
  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
    this._loadRecommended(this);
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function (e) {
      var id = this.data.art_id;
      if(id){
         return {
           title: this.data.title,
           path:'pages/display/display?id='+id,
           imageUrl: Config.baseURI + this.data.shareUrl,
           success: function(res){
              wx.showToast({
                title: '感谢您的分享',
                icon: 'success',
                duration: 1200
              });
           }
         }
      }
  },
  //加载内容
  _loadContent: function (id){
    var that = this;
    baseModel.request({
      url: '/api/getArticle',
      type: 'POST',
      data: {
        appid: this.data.appid,
        article: id
      },
      sCallback: function (res) {
        that.setData({
          title: res.data[0].art_tit,
          art_addtime: res.data[0].art_addtime,
          art_cate: res.data[0].art_cate,
          art_id: res.data[0].art_id,
          art_img: res.data[0].art_img
        })
        that._loadRecommended(that);
        //输出到插件的模板中
        var temp = WxParse.wxParse('content', 'html', res.data[0].art_content, that, 5);
      }
    }, true);
  },
  //加载推荐文章
  _loadRecommended: function (that){
    var art_cate = that.data.art_cate;
    baseModel.request({
      url: '/api/getRandomRecommended',
      type: 'POST',
      data: {
        appid: that.data.appid,
        count: that.data.count,
        cate: art_cate
      },
      sCallback: function (res) {
        if (!that.data.loadtitle) {
          that.setData({
            loadtitle: res.data,
          });
        } else {
          that.setData({
            loadtitle: that.data.loadtitle.concat(res.data),
          });
        }
      }
    }, true);
  },
  recommend:function(e){
    var id = baseModel.getDataSet(e, 'id');
    var url = '../display/display?id=' + id;
    wx.navigateTo({
      url: url,
    });
  },
  
  goHome: function () {
    wx.switchTab({
      url: '../hot/hot',
    });
  },

  collection:function(){
      var data = {};
      data.id = this.data.art_id;
      data.title = this.data.title;
      data.img = this.data.art_img;
      var json = JSON.stringify(data);
      var collection = wx.getStorageSync('collection');
      if(collection){
        var arr = collection.split('__');
      }
      if(arr){
        var bool = true;
        for(var i=0;i<arr.length;i++){
            var temp = JSON.parse(arr[i]);
            if (temp.id == data.id){
              bool = false;
              break;
            }
        }
        if(!bool){
          wx.showToast({
            title: '您已经收藏了',
            icon: 'success',
            duration: 1200
          });
        }else{
          wx.setStorageSync('collection', collection + '__' + json);
          wx.showToast({
            title: '收藏成功',
            icon: 'success',
            duration: 1200
          });
        }
      }else{
        wx.setStorageSync('collection',json);
        wx.showToast({
          title: '收藏成功',
          icon: 'success',
          duration: 1200
        });
      }
  },
  getShareCover:function(){
    var that = this;
    baseModel.request({
      url: '/api/shareCover',
      type: 'POST',
      data: {
        appid: that.data.appid,
      },
      sCallback: function (res) {
        if(res.status == 1){
          that.setData({
            shareUrl: res.url
          });
        }
      }
    }, true);
  }
})