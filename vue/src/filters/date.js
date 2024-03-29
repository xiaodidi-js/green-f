/**
 * Created by SamHong on 2017/5/4.
 */
export const normalTime = (time) => {
    if (time) {
        var oDate = new Date();

        oDate.setTime(time);

        var y = oDate.getFullYear();
        var m = oDate.getMonth() + 1;
        var d = oDate.getDate();

        var h = oDate.getHours();
        var mm = oDate.getMinutes();
        var s = oDate.getSeconds();

        return y + '-' + m + '-' + d + ' ' + h + ':' + mm + ':' + s;
    }
}