<template>
    <div>
        <img src="./logo-proposals/logo.png" alt="">
        <ul>
            <li v-for="(item, index) in list" :key="index">
                {{item}}
                {{index}}
                <form action="">
                
                    <input type="text" placeholder="Seriesname" v-model="item.seriesname" name="serie">
                    <input type="url" placeholder="URL" v-model="item.url" name="url">
                    <input type="text" placeholder="season" v-model="item.season" name="season">
                    <input type="text" placeholder="episode" v-model="item.episode" name="episode">
                    <input type="color" v-model="item.status" name="status">

                </form>
            </li>
        </ul>
        <button @click="list.push( {
                        'seriesname':'asdfölkj',
                        'url': 'https://youtube.com',
                        'season':1,
                        'episode':5,
                        'status':'#ffffff'
                    })">+</button>
    {{list}}
    

    </div>
</template>

<script>
export default {
    components: {
        //comp,
    },
    data: function() {
        return {
            example: 'seriesname',
            list: 
                [
                    {
                        "seriesname":"The Walking Dead",
                        "url": "https://youtube.com",
                        "season":1,
                        "episode":5,
                        "status":"#ff0000"
                    },
                    {
                        "seriesname":"walking dead 2",
                        "url": "https://youtube.com",
                        "season":4,
                        "episode":3,
                        "status":"#ff0000"
                    }
                ]
        }
    },
    computed: {
    },
    mounted () {
        console.log('app.vue mounted.');
    },
    methods: {
        
    },
}
</script>

<style>

</style>