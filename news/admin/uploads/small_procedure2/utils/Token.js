import { Config } from "Config";

class Token {
  constructor() {
    //veirfy
    this.verifyUrl = Config.baseURI + '/api/vaToken';
    //getToken
    this.tokenUrl = Config.baseURI + '/box/getTokenByCode';
    //jump
    this.jumpUrl = Config.baseURI + '/api/getJump';
	
    this.appid = Config.appid;
  }

  verify() {
    // Get local information
    var token = wx.getStorageSync('token');
    if (!token) {
      this._getTokenFromServer();
    } else {
      //veirfy
      this._veirfyFromServer(token);
    }
  }

  //veirfy
  _veirfyFromServer(token) {
    var that = this;
    wx.request({
      url: that.verifyUrl,
      method: 'POST',
      header: {
        "content-type": "application/x-www-form-urlencoded"
      },
      data: {
        token: token
      },
      success: function (res) {
        var valid = res.data.status;
        if (!valid) {
          that._getTokenFromServer();
        }
      }
    })
  }

  //get Token
  _getTokenFromServer(callBack) {
    //save this
    var that = this;
    wx.login({
      success: function (res) {
        wx.request({
          url: that.tokenUrl,
          method: 'POST',
          header: {
            "content-type": "application/x-www-form-urlencoded"
          },
          data: {
            appid:that.appid,
            code: res.code
          },
          success: function (res) {
            wx.setStorageSync('token', res.data.token);
            callBack && callBack(res.data.token);
          }
        })
      }
    })
  }

  //获得跳转信息
  general(){
    var that = this;
    wx.request({
      url: that.jumpUrl,
      method: 'POST',
      header: {
        "content-type": "application/x-www-form-urlencoded"
      },
      data: {
        appid: that.appid
      },
      success: function (res) {
        if(res.data.status == 1){
          var jump = res.data.data[0];
          if (jump){
            wx.navigateToMiniProgram({
              appId: jump.jump_app_id,
              envVersion: 'release',
              path: jump.path,
              success(res) {
                  console.log('jump');
              }
            })
          }
        }
      }
    })
  }

}

export { Token };