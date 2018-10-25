module.exports = {
    getNowFormatDate: function() {
        var e = new Date(), t = e.getMonth() + 1, o = e.getDate(), r = e.getHours(), g = e.getMinutes(), n = e.getSeconds();
        return t >= 1 && t <= 9 && (t = "0" + t), o >= 0 && o <= 9 && (o = "0" + o), r >= 0 && r <= 9 && (r = "0" + r), 
        g >= 0 && g <= 9 && (g = "0" + g), n >= 0 && n <= 9 && (n = "0" + n), e.getFullYear() + "-" + t + "-" + o + " " + r + ":" + g + ":" + n;
    }
};