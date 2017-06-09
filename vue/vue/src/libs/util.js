/**
 * Created by aresn on 16/7/18.
 */
// let util = {
//
// };
// util.alert = function(content) {
//     window.alert(content);
// };
//
// export default util;

export const fetchGet = (target, data) => {
    if (data) {
        var params = []
        for (var i in data) {
            params.push(i)
            params.push(data[i])
        }
        target = target + '/' + params.join('/')
    }
    return new Promise((resolve, reject) => {
        axios({
            url: target,
            method: 'get',
            withCredentials: false
        }).then(function (response) {
            resolve(response.data)
        }).catch(function (error) {
            reject(error)
        })
    })
}

export const fetchPost = (target, data) => {
    return new Promise((resolve, reject) => {
        var postData = Qs.stringify(data)
        axios({
            url: target,
            method: 'post',
            data: postData,
            withCredentials: false
        }).then(function (response) {
            resolve(response.data)
        }).catch(function (error) {
            reject(error)
        })
    })
}