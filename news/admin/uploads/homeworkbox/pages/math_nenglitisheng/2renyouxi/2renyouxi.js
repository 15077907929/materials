var _ = require("../../../utils/2renyouxi.js");

Page({
    data: {
        web_request: !1,
        question_data_player_1: null,
        question_data_player_2: null,
        player_1_score: 0,
        player_2_score: 0,
        countof_player_1: "0/10",
        countof_player_2: "0/10",
        error_show_player_1: 0,
        error_show_player_2: 0,
        time_ctrl_player_1: 0,
        time_ctrl_player_2: 0,
        is_first_player_1: !0,
        is_first_player_2: !0,
        Timeouter: 0,
        panel_Data: {
            view_isshow: !1,
            player_1_score: "",
            player_2_score: ""
        },
        one_player_judge: !0,
        NLTS_XXSJ_id: ""
    },
    do_again: function() {
        var t = {};
        t.view_isshow = !1, this.setData({
            panel_Data: t,
            player_1_score: 0,
            player_2_score: 0,
            error_show_player_1: 0,
            error_show_player_2: 0,
            countof_player_1: "0/10",
            countof_player_2: "0/10"
        }), _.initialize(this, this.data.NLTS_XXSJ_id);
    },
    player_1_right_click: function() {
        this.data.is_first_player_1 || (_.clear_time_out(1), this.setData({
            time_ctrl_player_1: 0
        })), 1 == this.data.is_first_player_1 && this.setData({
            is_first_player_1: !1
        }), _.time_ctrl(this, "time_ctrl_player_1"), _.proc(this, !0, "player_1_score", "countof_player_1", "question_data_player_1", this.data.NLTS_XXSJ_id, "error_show_player_1");
    },
    player_1_wrong_click: function() {
        this.data.is_first_player_1 || (_.clear_time_out(1), this.setData({
            time_ctrl_player_1: 0
        })), 1 == this.data.is_first_player_1 && this.setData({
            is_first_player_1: !1
        }), _.time_ctrl(this, "time_ctrl_player_1"), _.proc(this, !1, "player_1_score", "countof_player_1", "question_data_player_1", this.data.NLTS_XXSJ_id, "error_show_player_1");
    },
    player_2_right_click: function() {
        this.data.is_first_player_2 || (_.clear_time_out(2), this.setData({
            time_ctrl_player_2: 0
        })), 1 == this.data.is_first_player_2 && this.setData({
            is_first_player_2: !1
        }), _.time_ctrl(this, "time_ctrl_player_2"), _.proc(this, !0, "player_2_score", "countof_player_2", "question_data_player_2", this.data.NLTS_XXSJ_id, "error_show_player_2");
    },
    player_2_wrong_click: function() {
        this.data.is_first_player_2 || (_.clear_time_out(2), this.setData({
            time_ctrl_player_2: 0
        })), 1 == this.data.is_first_player_2 && this.setData({
            is_first_player_2: !1
        }), _.time_ctrl(this, "time_ctrl_player_2"), _.proc(this, !1, "player_2_score", "countof_player_2", "question_data_player_2", this.data.NLTS_XXSJ_id, "error_show_player_2");
    },
    onLoad: function(t) {
        1 == t.NLTS_id ? this.setData({
            one_player_judge: !0
        }) : 2 == t.NLTS_id ? this.setData({
            one_player_judge: !0,
            web_request: !0
        }) : 3 == t.NLTS_id && this.setData({
            one_player_judge: !1
        }), 1 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul5"
        }) : 2 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul11"
        }) : 3 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul12"
        }) : 4 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul25"
        }) : 5 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul50"
        }) : 6 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_two_decade"
        }) : 7 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_two_decade_10"
        }) : 8 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_two_decade_10_10"
        }) : 9 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_less_100"
        }) : 10 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_more_100"
        }) : 11 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_FOIL"
        }) : 12 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_1"
        }) : 13 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_2"
        }) : 14 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_3"
        }) : 15 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_4"
        }) : 16 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_5"
        }) : 17 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_6"
        }) : 18 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_7"
        }) : 19 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_8"
        }) : 20 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_unit_9"
        }) : 21 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_square_1"
        }) : 22 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_square_4"
        }) : 23 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_square_5"
        }) : 24 == t.NLTS_XXSJ_id ? this.setData({
            NLTS_XXSJ_id: "YGWS_mul_square_9"
        }) : 25 == t.NLTS_XXSJ_id && this.setData({
            NLTS_XXSJ_id: "YGWS_mul_double_digit"
        }), _.initialize(this, this.data.NLTS_XXSJ_id);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {}
});