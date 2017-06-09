//获取购物车数量
export const cartNums = state => {
	return state.cart.length;
}

//获取购物车
export const cartInfo = state => {
	return state.cart;
}

//获取购物车ids
export const cartIds = state => {
	let ids = [];
	if(state.cart.length<=0){
		return ids;
	}
	for(let plist=0;plist<state.cart.length;plist++){
		ids.push({id:state.cart[plist].id,format:state.cart[plist].format});
	}
	return ids;
}

//获取购物车
export const cartSum = state => {
	let sum = 0;
	if(state.cart.length<=0) {
		return sum.toFixed(2);
	}
	for(let plist=0;plist<state.cart.length;plist++){
		sum += state.cart[plist].price*state.cart[plist].nums;
	}
	return sum.toFixed(2);
}

//获取选择的购物车
export const selCartInfo = state => {
	return state.selCart;
}

//获取选择购物车
export const selCartSum = state => {
	let sum = 0;
	if(state.selCart.length <= 0) {
		return sum.toFixed(2);
	}
	for(let slist = 0;slist < state.selCart.length;slist++) {
		sum += state.selCart[slist].price * state.selCart[slist].nums;
	}
	return sum.toFixed(2);
}

//获取选择购物车ids
export const selCartIds = state => {
	let ids = [];
	if(state.selCart.length <= 0) {
		return ids;
	}
	for(let slist = 0;slist < state.selCart.length; slist++) {
		ids.push({id:state.selCart[slist].id,format:state.selCart[slist].format});
	}
	return ids;
}

//获取选择购物车ids,不包含规格
export const selCartIdsNoFormat = state => {
	let ids = [];
	if(state.selCart.length<=0){
		return ids;
	}
	for(let slist = 0;slist < state.selCart.length; slist++) {
		if(ids.indexOf(state.selCart[slist].id) < 0) {
			ids.push(state.selCart[slist].id);
		}
	}
	return ids;
}