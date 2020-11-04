<template>
<div>
    <div class="container">
        <div class="my-4"><img src="/../../logo-proposals/logo.png" alt=""></div>

        <div id="login">
            <!--input type="text" id="listname" v-model="listname" placeholder="listname"-->
            <button v-if="listname" @click="lightbox=true"><icons type="pen"></icons></button>
            <div v-if="lightbox == true" class="lb-wrapper">
                <div @click="lightbox=false" class="lightbox"></div>
                <div class="lb-form d-flex flex-column">
                    <div>
                        You can give your list a new name, but it also requires a password. <br>
                        It will make the list private.
                    </div>
                    <div>Listname:</div>
                    <input type="text" id="listname" v-model="form_listname" placeholder="listname">
                    <div>Password:</div>
                    <input type="text" id="password" v-model="form_password" placeholder="password">
                    <br>
                    <div>Email is optional, but you can't reset your password without it!</div>
                    <input type="email" id="email" v-model="form_email" placeholder="email">

                    <button>
                        <input type="submit" @click="saveListname()" value="Submit">
                    </button>
                </div>
            </div>
        </div>

        <table class="table">
            <draggable tag="tbody" handle=".handle" v-model="list" draggable="tr">
                <template v-for="(item, index) in list">
                    <tr :key="index" :class="{'tr-running':item.status == 'running','tr-hiatus':item.status == 'hiatus','tr-finished':item.status == 'finished', 'd-flex':1}">
                        <td class="d-flex flex-fill">
                            <div class="drag-padding handle"><button><icons type="draggable"></icons></button></div>
                            <div>
                                <div class="dropdown d-flex justify-content-between">
                                    <div v-if="item.open == false">
                                        <a v-if="item.url!=''" :href="addScheme(item.url)">{{item.seriesname}}</a>
                                        <span v-else>{{item.seriesname}}</span>
                                    </div>
                                    <div v-if="item.open == true"><input class="w-100" type="text" :placeholder="item.seriesname" v-model="item.seriesname" name="serie" :ref="'oc-'+index+'-link'"></div>
                                        <button @click="toggle(index);register_outerclick(['oc-'+index, 'oc-'+index+'-dropdown', 'oc-'+index+'-link'], ()=>close(index))" :ref="'oc-'+index"><icons type="pen"></icons></button><!-- @click="(e)=>handleClick(e,index)" toggle(index);  -->
                                        <div :class="{x:true, open:item.open}" :ref="'oc-'+index+'-dropdown'"> 
                                            <input class="w-100" type="url" placeholder="url" v-model="item.url" name="url">
                                        </div>
                                    </div>
                                </div>
                                    <div>
                                        <div class="d-flex justify-content-start">
                                            Season:
                                            <div @click="item.season--" class="numChange pointer"><icons type="caret_left"></icons></div>
                                            <div class="season">{{item.season}}</div>
                                            <div @click="item.season++" class="numChange pointer"><icons type="caret_right"></icons></div>
                                        </div>
                                    </div>
                                <div>
                                <div class="d-flex justify-content-start">
                                    Episode:
                                    <div @click="item.episode--" class="numChange pointer"><icons type="caret_left"></icons></div>
                                    <div class="episode">{{item.episode}}</div>
                                    <div @click="item.episode++" class="numChange pointer"><icons type="caret_right"></icons></div>
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
import outerclickMixin from './outerclickMixin.js';
export default {
    mixins: [
        outerclickMixin
    ],
    components: {
        draggable,
        icons,
    },
    data: function() {
        return {
            example: 'seriesname',
            lightbox: false,
            listname: window.path,
            form_listname:'',
            form_password:'',
            form_email:'',
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
                    "season":5,
                    "episode":2,
                    "status":"finished",
                    "open": false,
                    "note":'',
                    "opennote": false
                }
            ],
        }
    },
    computed: {
    },
    created() {
        this.getList();
        this.form_listname = JSON.parse(JSON.stringify(window.path));
    },
    beforeDestroy() {
        
    },
    mounted () {
        console.log('app.vue mounted.');
    },
    watch: {
        list: {
            deep: true,
            handler(newValue, oldValue){
                let data = {action:'savelist', list:newValue, listname:window.path};
                fetch('/fetch.php', {
                    method: 'POST',
                    headers: {'Content-Type' : 'application/json'},
    	            body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    console.log(response);
                    if(typeof response !== 'undefined' && typeof response.listname !== 'undefined'){
                        window.path = response.listname;
                        this.listname = window.path;
                        window.list = true;
                        history.pushState({}, '', 'list/'+window.path);
                    }
                    // TODO: adressleiste anpassen
                });
            }
        }
    },
    methods: {
        onUpdate: function (event) {
            //this.list.splice(event.newIndex, 0, this.list.splice(event.oldIndex, 1)[0])
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
        defaultSeries: function (){
            return {
                'seriesname': '',
                'url': '',
                'season': 1,
                'episode': 1,
                'status': 'running',
                'open': '',
                'note': '',
                'opennote': false
            };
        },
        getList: function(){
            if(window.list){
                let data = {listname:window.path, action:'getlist'};
                fetch('/fetch.php', {
                    method: 'POST',
                    headers: {'Content-Type' : 'application/json'},
    	            body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    this.list = JSON.parse(data.data);
                });
            }
            console.log(window.location.href);
        },
        addScheme: function(url){
            if ( !Boolean(url.match(/^https?:\/\//)) ) url = 'http://' + url;
            return url;
        },
        saveListname: function(){
            console.log(this.listname, this.form_listname, this.form_password, this.form_email);
            let data = {action:'savelistname', old_listname:this.listname, new_listname:this.form_listname, password:this.form_password, email:this.form_email};
            fetch('/fetch.php', {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                //this.list = JSON.parse(data.data);

                // TODO: adressleiste anpassen
            });
        }
    }
}
</script>

<style lang="scss"></style>