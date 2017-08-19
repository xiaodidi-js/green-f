<template>
	<div class="wrapper" style="padding:0px;">
		<!-- 导航栏 -->
		<router-view></router-view>
        <!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
		<!-- loading加载框 -->
		<loading :show="loadingShow" :text="loadingMessage"></loading>
	</div>
</template>
<script>

import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'

export default{
	data() {
		return {
			data:{

			},
		}
	},
    components: {
        Toast,
        Loading,
    },
	route: {
		
	},
	ready() {
		//	创建数据库
        var myDB = {
            name: 'myDataBase',
            version: 3,
            db: null
        };

        var strData = [{
            id:1001,
            name:"Byron",
            age:24
        },{
            id:1002,
            name:"Frank",
            age:30
        },{
            id:1003,
            name:"Aaron",
            age:26
        }];

        const customerData = [
            { ssn: "444-44-4444", name: "Bill", age: 35, email: "bill@company.com" },
            { ssn: "555-55-5555", name: "Donna", age: 32, email: "donna@home.org" }
        ];

		//	打开数据库
        function openDB(name, version) {
            var version = version || 1;
            var request = window.indexedDB.open(name, version);
			request.onsuccess = function(e) {
            	myDB.db = e.target.result;
			};

            request.onerror = function(e) {
                console.log('open Error' + e);
            };

            // 该事件仅在较新的浏览器中被实现
			request.onupgradeneeded = function(e) {
                var db = e.target.result;
                //	创建一个对象存储空间来持有有关我们客户的信息。
				var objectStore = db.createObjectStore('message', {keyPath: 'ssn'});
                //	创建一个索引来通过 name 搜索客户。
                //	可能会有重复的，因此我们不能使用 unique 索引。
                objectStore.createIndex("name", "name", { unique: false });
                //	创建一个索引来通过 email 搜索客户。
                //	我们希望确保不会有两个客户使用相同的 email 地址，因此我们使用一个 unique 索引。
                objectStore.createIndex("email", "email", { unique: true });
                // 在新创建的对象存储空间中保存值
                for (var i in customerData) {
                    objectStore.add(customerData[i]);
                }
                //	向数据库中增加数据
				var transaction = db.transaction(['message'], "readwrite");
			};
		}
//		openDB(myDB.name, myDB.version);
	},
    methods: {

	},
	events: {

	},
    watch: {

    }
}

</script>

<style type="text/css">

	#app{
		position: relative;
	}

	.wrapper {
		width:100%;
		height:auto;
	}
	.container{
		width:100%;
		height:3.6rem;
		overflow:hidden;
	}

	.box{
		white-space:nowrap;
		font-size:0;
		height:3.6rem;
		padding:0rem;
		width:100%;
		float:left;
	}

	.box-item:last-child{
		border:none;
	}

	.box-item{
		display:inline-block;
		font-size:1.4rem;
		vertical-align:middle;
		text-align:center;
		line-height:2rem;
		margin-top:0.8rem;
		margin-bottom:0.6rem;
		padding:0rem 1.5rem;
		border-right:#EFEFEF solid 1px;
		width:auto;
		position:relative;
	}

	.box-item .line{
		width:100%;
		max-width:100%;
		height:0.2rem;
		position:absolute;
		bottom:-0.8rem;
		left:0rem;
		background-color:#fff;
	}

	.box-item.active{
		color:#f9ad0c;
	}

	.box-item.active .line{
		background-color:#f9ad0c;
	}

	.box-item .tag{
		font-size:0.8rem;
		line-height:1.2rem;
		letter-spacing:.1rem;
		color:#ff7486;
		position:absolute;
		top:-0.8rem;
		right:0.35rem;
		padding:0;
		margin:0;
	}

	.dots-my>a>.vux-icon-dot{
		background:#fff !important;
	}
	.dots-my>a>.vux-icon-dot.active{
		background:#333 !important;
	}

	.weui_toast_text .weui_toast_content {
		font-size:14px;
	}

</style>