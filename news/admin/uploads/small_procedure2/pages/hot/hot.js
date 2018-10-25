// pages/hot/hot.js
import { Base } from '../../utils/Base.js';
import { Config } from '../../utils/Config.js';
var baseModel = new Base();
var appid = Config.appid;
Page({

  /**
   * 页面的初始数据
   */
  data: {
    page: 1,//文章开始状态为1
    count: 6,//文章的个数
    appid: appid,//应用ID
    front: ['third','second','first']
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      this._loadingIndex();
    this.getShareCover();
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
  _loadingIndex: function () {
    var that = this;
    baseModel.request({
      url: '/api/getHotArticle',
      type: 'POST',
      data: {
        appid: this.data.appid,
        count: this.data.count,
        page: this.data.page
      },
      sCallback: function (res) {
        if (!that.data.loadtitle) {
          that.setData({
            loadtitle: res.data,
            page: ++that.data.page
          });
        } else {
          that.setData({
            loadtitle: that.data.loadtitle.concat(res.data),
            page: ++that.data.page
          });
        }
      }
    }, true);
  },
  jumpFn :function(e){
    var id = baseModel.getDataSet(e,'id');
    var url = '../display/display?id='+id;
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