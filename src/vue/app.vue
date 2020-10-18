<template>
<div>
    <div class="container">
        <div class="my-4"><img src="/../../logo-proposals/logo.png" alt=""></div>
        <table class="table">
            <draggable tag="tbody" handle=".handle" v-model="list" draggable="tr">
                <template v-for="(item, index) in list">
                    <tr :key="index" :class="{'tr-running':item.status == 'running','tr-hiatus':item.status == 'hiatus','tr-finished':item.status == 'finished', 'd-flex':1}">
                        <td class="d-flex flex-fill">
                            <div class="drag-padding handle"><button><icons type="draggable"></icons></button></div>
                            <div>
                                <div class="dropdown d-flex justify-content-between">
                                    <div v-if="item.open == false">
                                        <a v-if="item.url!=''" :href="item.url">{{item.seriesname}}</a>
                                        <span v-else>{{item.seriesname}}</span>
                                    </div>
                                    <div v-if="item.open == true"><input class="w-100" type="text" :placeholder="item.seriesname" v-model="item.seriesname" name="serie"></div>
                                        <button @click="toggle(index);register_outerclick(['oc-'+index, 'oc-'+index+'-dropdown'], ()=>close(index))" :ref="'oc-'+index"><icons type="pen"></icons></button><!-- @click="(e)=>handleClick(e,index)" toggle(index);  -->
                                        <div :class="{x:true, open:item.open}" :ref="'oc-'+index+'-dropdown'"> 
                                            <input class="w-100" type="url" placeholder="URL" v-model="item.url" name="url">
                                        </div>
                                    </div>
                                </div>
                                    <div>
                                        <div class="d-flex justify-content-start">
                                            Season:
                                            <div @click="item.season--" class="numChange"><icons type="caret_left"></icons></div>
                                            <div class="season">{{item.season}}</div>
                                            <div @click="item.season++" class="numChange"><icons type="caret_right"></icons></div>
                                        </div>
                                    </div>
                                <div>
                                <div class="d-flex justify-content-start">
                                    Episode:
                                    <div @click="item.episode--" class="numChange"><icons type="caret_left"></icons></div>
                                    <div class="episode">{{item.episode}}</div>
                                    <div @click="item.episode++" class="numChange"><icons type="caret_right"></icons></div>
                                </div>
                            </div>
                        </td>
                        <td class="d-flex flex-fill justify-content-end">
                            <div class="position-relative">
                                <button @click="item.opennote=!item.opennote"><icons type="note"></icons></button>
                                <div v-if="item.opennote == true">
                                    <textarea class="w-100 position-absolute" :placeholder="item.note" v-model="item.note" name="serie"></textarea>
                                </div>
                            </div>
                            <div class="radio-padding">
                                <div class="radio-div">
                                    <div class="radio radio-running radio-inline" title="Running">
                                        <input type="radio" :id="'status-'+index+'-running'" v-model="item.status" value="running" :checked="item.status=='running'">
                                        <label :for="'status-'+index+'-running'"></label>
                                    </div>
                                    <div class="radio radio-hiatus radio-inline" title="Hiatus">
                                        <input type="radio" :id="'status-'+index+'-hiatus'" v-model="item.status" value="hiatus" :checked="item.status=='hiatus'">
                                        <label :for="'status-'+index+'-hiatus'"></label>
                                    </div>
                                    <div class="radio radio-finished radio-inline" title="Finished">
                                        <input type="radio" :id="'status-'+index+'-finished'" v-model="item.status" value="finished" :checked="item.status=='finished'">
                                        <label :for="'status-'+index+'-finished'"></label>
                                    </div>                
                                </div>                        
                            </div>
                            <div class="delete-padding"  @click="list.splice(index, 1)"><button><icons type="delete"></icons></button></div>
                        </td>
                    </tr>
                </template>
            </draggable>
        </table>

        <button @click="list.push(defaultSeries())">
            +
        </button>
        <pre>{{list}}</pre>
    </div>
</div>
</template>

<script>
import draggable from 'vuedraggable';
import icons from './icons.vue';
export default {
    components: {
        draggable,
        icons,
    },
    data: function() {
        return {
            example: 'seriesname',
            list: [
                {
                    "seriesname":"The Walking Dead",
                    "url": "https://youtube.com",
                    "season":42,
                    "episode":9337,
                    "status":"running",
                    "open": false,
                    "note":'',
                    "opennote": false
                },
                {
                    "seriesname":"BBBBBBBBBBB",
                    "url": "https://youtube.com",
                    "season":4,
                    "episode":3,
                    "status":"hiatus",
                    "open": false,
                    "note":'',
                    "opennote": false
                },
                {
                    "seriesname":"CCCCCCCCCC",
                    "url": "https://youtube.com",
                    "season":4,
                    "episode":3,
                    "status":"finished",
                    "open": false,
                    "note":'',
                    "opennote": false
                }
            ],
            
            outerclick_refereces: [],
            outerclick_callback: null
        }
    },
    computed: {
    },
    created() {
        document.addEventListener('click', this.check_outerclick);
    },
    beforeDestroy() {
        //window.removeEventListener('click', this.close);
    },
    mounted () {
        console.log('app.vue mounted.');
    },
    methods: {
        onUpdate: function (event) {
            //this.list.splice(event.newIndex, 0, this.list.splice(event.oldIndex, 1)[0])
        },
        defaultSeries: function (){
            return {
                'seriesname': 'Seriesname',
                'url': 'https://youtube.com',
                'season': 1,
                'episode': 1,
                'status': 'running',
                'open': '',
                'note': '',
                'opennote': false
            };
        },
        toggle: function(index){
            this.list.forEach((item,i)=>{
                item.open = (index == i) ? !item.open : false;
            });
        },
        close: function(index) {
            console.log('close', arguments);
            this.list[index].open = false;
            this.list.forEach((item)=>{
                item.open = false;
            });
        },

        register_outerclick: function(references, callback){
            this.outerclick_references = references;
            this.outerclick_callback = callback;
        },
        check_outerclick: function(e) {
            if ( e.target instanceof HTMLElement ) {
                let inside_click = false;
                for (let item of this.outerclick_references) {
                    let ref = this.$refs[item][0];
                    if ( ref.contains(e.target) ) { // => not outside click
                        inside_click = true;
                    }
                }
                if ( !inside_click ) {
                    if ( typeof this.outerclick_callback == 'function' ) this.outerclick_callback(e);
                    this.outerclick_references = [];
                    this.outerclick_callback = null;
                } 
            }
        }
    }
}
</script>

<style lang="scss">
* {outline:none !important;}

table td{ padding: 0.4rem 0 !important;}
table td>div{padding:0 0.2rem;}
table td>div.drag-padding{padding-right:0;}
table td>div.note-padding{padding-right:0.4rem;}
table td>div.radio-padding{padding-right:0;}
table td>div.delete-padding{padding-left:0;}

table .numChange{ padding: 0 5px; }
table .season{
    width: 18px;
    font-weight: bold;
    text-align: right;
}
table .episode{
    width: 35px;
    font-weight: bold;
    text-align: right;
}

button {
    background-color: rgba(255,255,255,0); 
    border:none;
    //padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}
.dropdown {
    position: relative;
    width: 250px;
    
    .x {
        position:absolute;
        z-index: 9999;
        left:0;
        top:100%;
        height:0;
        overflow: hidden;
    }
    .x.open {
        height:auto;
    }
}
td textarea{
    min-width:150px;
    margin-left: -15px;
    z-index: 9999;
}




.tr-running{background-color: #dbe5ff; transition: background-color 1s;}
.tr-hiatus{background-color: #FFE2D5; transition: background-color 1s;}
.tr-finished{background-color: #dfdfdf; transition: background-color 1s;}
.tr-running:hover{background-color: #CFDCFF;}
.tr-hiatus:hover{background-color: #FFDAC9;}
.tr-finished:hover{background-color: #D5D5D5;}

.radio-div{
    cursor: default; 
    margin-top: -5px; }
.radio {
    padding-left: 0; }
.radio label {
    display: inline-block;
    position: relative;
    padding-left: 5px; }
.radio label::before {
    content: "";
    display: inline-block;
    position: absolute;
    width: 17px;
    height: 17px;
    left: 0;
    margin-left: -20px;
    border: 1px solid #cccccc;
    border-radius: 50%;
    background-color: #fff;
    -webkit-transition: border 0.15s ease-in-out;
    -o-transition: border 0.15s ease-in-out;
    transition: border 0.15s ease-in-out; }
.radio label::after {
    display: inline-block;
    position: absolute;
    content: " ";
    width: 11px;
    height: 11px;
    left: 3px;
    top: 3px;
    margin-left: -20px;
    border-radius: 50%;
    background-color: #555555;
    -webkit-transform: scale(0, 0);
    -ms-transform: scale(0, 0);
    -o-transform: scale(0, 0);
    transform: scale(0, 0);
    -webkit-transition: -webkit-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    -moz-transition: -moz-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    -o-transition: -o-transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33);
    transition: transform 0.1s cubic-bezier(0.8, -0.33, 0.2, 1.33); }
.radio input[type="radio"] {
    opacity: 0; }
.radio input[type="radio"]:checked + label::after {
    -webkit-transform: scale(1, 1);
    -ms-transform: scale(1, 1);
    -o-transform: scale(1, 1);
    transform: scale(1, 1); }
.radio input[type="radio"]:disabled + label {
    opacity: 0.65; }
.radio input[type="radio"]:disabled + label::before {
    cursor: not-allowed; }
.radio.radio-inline {
    display: inline-block;
    margin-top: 0; }

.radio-running input[type="radio"] + label::after {
    background-color: #3154b6; }
.radio-running input[type="radio"]:checked + label::before {
    border-color: #3154b6; }
.radio-running input[type="radio"]:checked + label::after {
    background-color: #3154b6; }

.radio-hiatus input[type="radio"] + label::after {
    background-color: #ff5e00; }
.radio-hiatus input[type="radio"]:checked + label::before {
    border-color: #ff5e00; }
.radio-hiatus input[type="radio"]:checked + label::after {
    background-color: #ff5e00; }

.radio-finished input[type="radio"] + label::after {
    background-color: #8394a3; }
.radio-finished input[type="radio"]:checked + label::before {
    border-color: #8394a3; }
.radio-finished input[type="radio"]:checked + label::after {
    background-color: #8394a3; }

svg{fill: #333333;}
svg#draggable{fill:rgba(0,0,0,0)}
table tr:hover svg#draggable{fill: #333333;}

</style>