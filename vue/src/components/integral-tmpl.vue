<template>
    <div class="body-list">
        <template v-for="item in list">
            <ul>
                <li v-if="item.type == 'orders'">
                    <div class="all-date">
                        <p v-if="item.type == 'orders'">消费积分</p>
                        <p v-else>签到积分</p>
                        <p>{{ item.createtime | time }}</p>
                    </div>
                    <div class="add-number">{{ item.amount }}</div>
                </li>
            </ul>
        </template>
    </div>
</template>

<script>
	export default{
		props: {
            list: {
                type: Array,
                default: [],
            },
        },
	    data() {
			return {
				
			}
		},
        methods: {

        },
        ready() {

        },
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var years = d.getFullYear();
                var moneths = d.getMonth();
                var dates = d.getDate();
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return (years) + '-' + (moneths + 1 > 9 ? moneths + 1 : '0' + (moneths + 1)) + '-' + (dates > 9 ? dates : '0' + dates) + ' ' + hours + ':' + minutes + ':' + seconds;
            }
        },
	}
</script>

<style scoped>

</style>