// pages/collect/collect.js
import { Base } from '../../utils/Base.js';
import { Config } from '../../utils/Config.js';
var baseModel = new Base();
var appid = Config.appid;
Page({

  /**
   * 页面的初始数据
   */
  data: {
      appid:appid
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
    this._collection();
    this.getShareCover();
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function (e) {
    var id = this.data.art_id;
    var img = e.target.dataset.img;
    var title = e.target.dataset.title;
    var url = Config.baseURI + this.data.shareUrl;
    return {
      title: title,
      path: 'pages/display/display?id=' + id,
      imageUrl: url,
      success: function (res) {
        wx.showToast({
          title: '感谢您的分享',
          icon: 'success',
          duration: 1200
        });
      }
    }
  },
  _collection:function(){
    var collection = wx.getStorageSync('collection');
    if(collection){
      this.setData({
        has: true
      });
      var arr = collection.split('__');
      var data = [];
      for(var i=0;i<arr.length;i++){
        data.push(JSON.parse(arr[i]));
      }
      this.setData({
        collect: data
      });
    }else{
      this.setData({
        has: false,
        collect:[]
      });
    }
  },
  delCollect:function(e){
      var id = e.currentTarget.id;
      var collection = wx.getStorageSync('collection');
      var arr = collection.split('__');
      for (var i = 0; i < arr.length; i++) {
        var temp = JSON.parse(arr[i]);
        if (temp.id == id){
            arr.splice(i, 1);
            break;
        }
      }
    if (arr){
      var json = arr.join('__');
      wx.setStorageSync('collection', json);
    }else{
      wx.removeStorageSync('collection');
    }
    this._collection();
  },
  jump:function(e){
    var id = e.currentTarget.id;
    var url = '../display/display?id=' + id;
    wx.navigateTo({
      url: url,
    });
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
  }
})