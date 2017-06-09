<style scoped>

</style>

<template>
	<!-- 限时抢购 -->
	<tap-card></tap-card>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
    import TapCard from 'components/tap-card'
    import Toast from 'vux/src/components/toast'

    export default{
        data() {
            return {
                toastMessage:'',
                toastShow:false,
                data:[]
            }
        },
        components: {
            TapCard,
            Toast
        },
        route: {
            data(transition) {
                this.$http.get('src/data/index.json').then((response)=>{
                    transition.next({
                        data: response.data
                    })
                },(response)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                })
            }
        },
        ready() {

        }
    }

</script>