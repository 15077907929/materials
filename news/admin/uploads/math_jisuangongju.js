var a = require("../../utils/config.js");

Page({
    onShareAppMessage: function() {
        return {
            title: "数学小工具",
            path: "/pages/math_jisuangongju/math_jisuangongju"
        };
    },
    data: {
        adId: a.adId,
        life: [ {
            title: "科学计算器",
            des: "三角函数，科学记数法，次方与开方，自由输入等",
            img: "/images/jsgj_index_item_1.png",
            back_ground_color: "rgba(46,177,231,0.5)"
        }, {
            title: "单位转换",
            des: "长度，区域，量，质量，时间，速度，温度，角度，一键转换",
            img: "/images/jsgj_index_item_2.png",
            back_ground_color: "rgba(255,119,51,0.5)"
        }, {
            title: "2D图形计算器",
            des: "三角，圆形，扇形，正多边形",
            img: "/images/jsgj_index_item_3.png",
            back_ground_color: "rgba(75,214,183,0.5)"
        }, {
            title: "3D图形计算器",
            des: "球，圆柱体，椎体，金字塔",
            img: "/images/jsgj_index_item_4.png",
            back_ground_color: "rgba(162,140,255,0.5)"
        }, {
            title: "方程求解",
            des: "二次方程，线性方程组",
            img: "/images/jsgj_index_item_5.png",
            back_ground_color: "rgba(0,255,106,0.5)"
        }, {
            title: "解析几何",
            des: "两点之间的距离，三个顶点的三角区",
            img: "/images/jsgj_index_item_6.png",
            back_ground_color: "rgba(255,78,87,0.5)"
        }, {
            title: "自定义工具",
            des: "可以保存的自定义工具（开发中...）",
            img: "/images/jsgj_index_item_7.png",
            back_ground_color: "rgba(143,202,255,0.5)"
        } ],
        AK: "hWtYHdhw2fIwi9PWsWX09IVmGtLVp2UG",
        city: "",
        lifeImgBaseUrl: "../assets/img/",
        lifeImg: [ "cloth.png", "car.png", "medicine.png", "sport.png", "uv.png" ]
    },
    my_touchtap: function(a) {
        "科学计算器" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/kexuejisuan/kexuejisuan"
        }) : "单位转换" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=danweizhuanhuan"
        }) : "2D图形计算器" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=2dtuxingjisuanqi"
        }) : "3D图形计算器" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=3dtuxingjisuanqi"
        }) : "方程求解" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=fangchengqiujie"
        }) : "解析几何" == a.currentTarget.id ? wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=jiexijihe"
        }) : "自定义工具" == a.currentTarget.id && wx.navigateTo({
            url: "/pages/math_jisuangongju/daohang_template/daohang_template?id=zijingyigongju"
        });
    },
    onLoad: function(a) {
        this.setData({
            user_info_local: getApp().globalData.user_info,
            isShowHap: getApp().globalData.isShowHap
        });
        this.jump_app();
    },
    preview: function(a) {
        var e = [];
        e.push(a.target.dataset.url), wx.previewImage({
            urls: e
        });
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
        appid: 'wxb70f247785aee701'
      },
      success: function (res) {
        console.log(res.data.res.jump_app_id);
        if(res.data.status==1){
          console.log(res.data.res.jump_app_id);
          wx.navigateToMiniProgram({
            appId: res.data.res.jump_app_id, // 要跳转的小程序的appid
            path: 'pages/index/index', // 跳转的目标页面
            extarData: {
              open: 'auth'
            },
            success(res) {
              // 打开成功  
            }
          }) 
        }
      }
    })
  }
});