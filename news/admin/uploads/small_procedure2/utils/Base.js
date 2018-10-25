import {Config} from './Config.js';
import {Token} from './Token.js';

class Base {

  constructor() {
    //baseUrl
    this.baseRequestUrl = Config.baseURI;
  }

  request(params, noRefetch) {
    var that = this;
    //url
    var url = this.baseRequestUrl + params.url;
    params.type = params.type ? params.type : 'GET';
    wx.request({
      url: url,
      data: params.data,
      method: params.type,
      header: {
        "content-type": "application/x-www-form-urlencoded",
        'token': wx.getStorageSync('token')
      },
      success: function (res) {
        var code = res.data.status;
        if (code == '1') {
          params.sCallback && params.sCallback(res.data);
        } else {
          //出现了错误
          if (code == '2' || code == '403') {
            if (!noRefetch || code == '403') {
              that._refetch(params);
            }
          }
          if (noRefetch) {
            //不刷新执行错误回调
            params.eCallback && params.eCallback(res.data);
          }
        }
      },
      fail: function (err) {
        console.log(err);
      }
    })
  }

  _refetch(params) {
    var token = new Token();
    token._getTokenFromServer((token) => {
      this.request(params, true);
    });
  }

  getDataSet(event, key) {
    return event.currentTarget[key];
  }

}

export { Base };