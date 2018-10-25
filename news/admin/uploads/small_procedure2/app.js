//app.js
import { Token } from './utils/Token.js';
App({
  onLaunch: function () {
    var tokenModel = new Token();
    tokenModel.verify();
    tokenModel.general();
  },
  // onShow: function (options) {
  //   var str =options.scene;
  //   if(str != 1038){
  //     var tokenModel = new Token();
  //     tokenModel.general();
  //   }
  // },
})