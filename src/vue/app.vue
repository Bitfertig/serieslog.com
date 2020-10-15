<template>
    <div>

        <div class="container">
            <div class="my-4"><img src="/../../logo-proposals/logo.png" alt=""></div>
                <table class="table">
                    <draggable tag="tbody" v-model="list" draggable="tr">
                        <template v-for="(item, index) in list">
                            <tr :key="index" :class="{'tr-running':item.status == 'running','tr-hiatus':item.status == 'hiatus','tr-finished':item.status == 'finished'}">
                                <td>
                                    <div class="dropdown d-flex justify-content-between">
                                        <div v-if="item.open == false">{{item.seriesname}}</div>
                                        <div v-if="item.open == true"><input class="w-100" type="text" :placeholder="item.seriesname" v-model="item.seriesname" name="serie"></div>
                                        <button @click="item.open=!item.open"><icons type="pen"></icons></button>
                                        <div :class="{x:true, open:item.open}"> 
                                            <input class="w-100" type="url" placeholder="URL" v-model="item.url" name="url">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        Season:
                                        <div @click="item.season--">
                                            <icons type="caret_left"></icons>
                                        </div>
                                        {{item.season}}
                                        <div @click="item.season++">
                                            <icons type="caret_right"></icons>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        Episode:
                                        <div @click="item.episode--">
                                            <icons type="caret_left"></icons>
                                        </div>
                                        {{item.episode}}
                                        <div @click="item.episode++">
                                            <icons type="caret_right"></icons>
                                        </div>
                                    </div>
                                </td>
                                <td>
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
                                </td>
                            </tr>
                        </template>
                    </draggable>
                </table>

                <button
                    @click="list.push({
                        'seriesname':'DDDDDDDDD',
                        'url':'https://youtube.com',
                        'season':1,
                        'episode':5,
                        'status':'finished'
                    })"
                >
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
                    "seriesname":"AAAAAAAAAA",
                    "url": "https://youtube.com",
                    "season":1,
                    "episode":5,
                    "status":"running",
                    "open": false
                },
                {
                    "seriesname":"BBBBBBBBBBB",
                    "url": "https://youtube.com",
                    "season":4,
                    "episode":3,
                    "status":"hiatus",
                    "open": false
                },
                {
                    "seriesname":"CCCCCCCCCC",
                    "url": "https://youtube.com",
                    "season":4,
                    "episode":3,
                    "status":"finished",
                    "open": false
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
        onUpdate: function (event) {
            //this.list.splice(event.newIndex, 0, this.list.splice(event.oldIndex, 1)[0])
        }
    },
}
</script>

<style lang="scss">
* {outline:none !important;}
.dropdown {
    position: relative;
    .x {
        position:absolute;
        left:0;
        top:100%;
        height:0;
        overflow: hidden;
    }
    .x.open {
        height:auto;
    }
}

button {
    background-color: rgba(255,255,255,0); 
    border:none;
    //padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
}

.tr-running{background-color: #c6d5ff;}
.tr-hiatus{background-color: #fdc9a7;}
.tr-finished{background-color: #dbdbdb;}

.radio-div{cursor: default; }
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
      /* .radio input[type="radio"]:focus + label::before {
      outline: thin dotted;
      outline: 5px auto -webkit-focus-ring-color;
      outline-offset: -2px; 
      } */
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

/* .radio-warning input[type="radio"] + label::after {
  background-color: #f0ad4e; }
.radio-warning input[type="radio"]:checked + label::before {
  border-color: #f0ad4e; }
.radio-warning input[type="radio"]:checked + label::after {
  background-color: #f0ad4e; }

.radio-success input[type="radio"] + label::after {
  background-color: #5cb85c; }
.radio-success input[type="radio"]:checked + label::before {
  border-color: #5cb85c; }
.radio-success input[type="radio"]:checked + label::after {
  background-color: #5cb85c; } */


</style>