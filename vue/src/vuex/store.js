import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

//应用状态
const state = {
	cart: sessionStorage.getItem('myCart') ? JSON.parse(sessionStorage.getItem('myCart')) : [],
	selCart: JSON.parse(sessionStorage.getItem('mySelCart')) || [],
    dtype: 1,
	shopname: {},
    message: {},
	text: ""
}

//应用状态操作
const mutations = {
    myActiveTwo (state,text) {
        state.text = text;
    },
    myVipMessage (state,message) {
        state.message = message;
    },
	mySearch (state,shopName) {
       state.shopname = shopName;
	},
	myActive (state, index) {
       state.dtype = index
    },
	SETCARTOBJ (state,obj) {
		if(state.cart.length > 0) {
			let added = false;
			for(let plist = 0;plist < state.cart.length; plist++) {
				if(typeof state.cart[plist] === 'object' && state.cart[plist].id == obj.id && state.cart[plist].format == obj.format) {
					state.cart[plist].nums += obj.nums;
					added = true;
					break;
				}
			}
			if(!added) {
				state.cart.push(obj);
			}
		}else{
			state.cart.push(obj);
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	SETCARTOBJS (state,objs) {
		state.cart = objs.slice(0);
		for(let plist=0;plist<state.cart.length;plist++){
			state.cart[plist].price = state.cart[plist].price/state.cart[plist].nums;
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	INCRECARTNUMS (state,id,format) {
		for(let plist = 0; plist < state.cart.length; plist++) {
			if(typeof state.cart[plist]==='object'&&state.cart[plist].id==id&&state.cart[plist].format==format){
				state.cart[plist].nums += 1;
				break;
			}
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	REDUCECARTNUMS (state,id,format) {
		for(let plist=0;plist<state.cart.length;plist++){
			if(typeof state.cart[plist]==='object'&&state.cart[plist].id==id&&state.cart[plist].format==format){
				if(state.cart[plist].nums>=1) state.cart[plist].nums -= 1;
				break;
			}
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	DELCARTOBJ (state,id,format) {
		for(let plist=0;plist<state.cart.length;plist++){
			if(typeof state.cart[plist]==='object'&&state.cart[plist].id==id&&state.cart[plist].format==format){
				state.cart.splice(plist,1);
				break;
			}
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	DELCARTOBJS (state,objs) {
		for(let po=0;po<objs.length;po++){
			for(let plist=0;plist<state.cart.length;plist++){
				if(typeof state.cart[plist]==='object'&&state.cart[plist].id==objs[po].id&&state.cart[plist].format==objs[po].format){
					state.cart.splice(plist,1);
					break;
				}
			}
		}
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	},
	CLEARCART (state) {
		state.selCart = [];
		state.cart = [];
		sessionStorage.removeItem('mySelCart');
        sessionStorage.removeItem('myCart');
	},
	SETSELCART (state,sarray) {
		if(typeof sarray==='object'&&sarray.length>0){
			state.selCart = [];
			if(sarray.length===state.cart.length){
				state.selCart = state.cart;
			}else{
				for(let slist=0;slist<sarray.length;slist++){
					for(let plist=0;plist<state.cart.length;plist++){
						if(state.cart[plist].id==sarray[slist].id&&state.cart[plist].format==sarray[slist].format){
							state.selCart.push(state.cart[plist]);
							break;
						}
					}
				}
			}
			sessionStorage.setItem('mySelCart',JSON.stringify(state.selCart));
		}
	},
	CLEARSELCART (state){
		if(state.selCart.length > 0) {
			let delIndex = [];
			for(let slist = 0;slist < state.selCart.length;slist++) {
				for(let plist = 0;plist < state.cart.length;plist++) {
					if(state.cart[plist].id == state.selCart[slist].id && state.cart[plist].format == state.selCart[slist].format) {
						delIndex.push(plist);
						break;
					}
				}
			}
			delIndex.sort(function(a,b){return a-b;});
			delIndex.reverse();
			for(let key=0;key<delIndex.length;key++){
				state.cart.splice(delIndex[key],1);
			}
			state.selCart = [];
		}else{
			state.cart = [];
		}
		sessionStorage.setItem('mySelCart',JSON.stringify(state.selCart));
        sessionStorage.setItem('myCart',JSON.stringify(state.cart));
	}
}

export default new Vuex.Store({
	state,
	mutations
})