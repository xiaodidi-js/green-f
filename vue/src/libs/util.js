/**
 * Created by aresn on 16/7/18.
 */

export const fetchGet = (target, data) => {
    if (data) {
        var params = [];
        for (var i in data) {
            params.push(i);
            params.push(data[i])
        }
        target = target + '/' + params.join('/')
    }
    return new Promise((resolve, reject) => {
        axios({
            url: localStorage.apiDomain + target,
            method: 'get',
            withCredentials: false
        }).then(function (response) {
            resolve(response.data)
        }).catch(function (error) {
            reject(error)
        })
    })
};

export const fetchPost = (target, data) => {
    return new Promise((resolve, reject) => {
        var postData = Qs.stringify(data);
        axios({
            url: localStorage.apiDomain + target,
            method: 'post',
            data: postData,
            withCredentials: false
        }).then(function (response) {
            resolve(response.data)
        }).catch(function (error) {
            reject(error)
        })
    })
};

// 监听页面滚动条的状态（是否滚动）
// window.addEventListener("scroll",function () {
//     //  滚动时获取页面滚动条的位置
//     var sTop = document.documentElement.scrollTop || document.body.scrollTop;
//     //  滚动条的位置保存到本地存储里面
//     ls.setItem("sTop",sTop);
// },false);
//
// //存储滚动条到本地
// var ls = window.localStorage;
// // 页面每次加载的时候获取本地存储里面的值
// if(ls.getItem("sTop")) {
//     var oldStop = ls.getItem('sTop');
//     console.log(oldStop);
//     // 获取到的值来设置页面滚动条的位置
//     if(document.documentElement.scrollTop) {
//         document.documentElement.scrollTop = oldStop;
//     } else {
//         document.body.scrollTop = oldStop;
//     }
//     console.log(ls.getItem("sTop"));
// }