<template>
<div class="container">

    <div class="logo d-flex align-items-baseline">
        <icons type="logo"></icons><!-- <img src="/../../logo-proposals/logo.png" alt=""> -->
        <div class="ml-1 d-flex align-items-start flex-column">
            <div class="font_equality_s4em">Serieslog</div>
            <div class="font_equality_s2em">Manage your series.</div>
        </div>
        <button v-if="authorized" id="logout" class="ml-auto" @click="logout()">
            <icons type="logout"></icons>
        </button>
        <div v-if="list_exists && !authorized && authorized_required" class="login_section d-flex ml-auto">
            <button id="login" @click="login()">
                <icons type="login"></icons>
            </button>
            <input type="text" name="listname" :value="listname" style="display:none;">
            <input type="password" v-model="login_password" @keyup.enter="login()" class="form-control pw_input" id="exampleInputPassword1" placeholder="Password">
        </div>
    </div>

    <div v-if="list_exists && !authorized && authorized_required" id="listname_login">
        <div>Listname:</div>
        <div>{{listname}}</div>
    </div>
    <div v-else>
        <div class="d-flex justify-content-between">
            <!-- login -->
            <div id="login">      
                <div v-if="listname != ''" id="list_edit_section" class="d-flex justify-content-start">
                    <div>
                        <div>Listname:</div>
                        <div>{{listname}}</div>
                    </div>
                    <button v-if="listname" @click="lightbox_open()"><icons type="pen_bc"></icons></button>
                </div>

                <div v-if="lightbox == true" class="lb-wrapper">
                    <div @click="lightbox_close()" class="lightbox"></div>
                    <div class="lb-form d-flex flex-column">
                        <div>
                            You can give your list a new name, but it also requires a password. <br>
                            It will make the list private.
                        </div>
                        <div>Listname:</div>
                        <input type="text" id="listname" v-model="form_listname" placeholder="listname">
                        <div>Password:</div>
                        <input type="password" id="password" v-model="form_password" placeholder="password">
                        <br>
<!--                         <div>Email is optional, but you can't reset your password without it!</div>
                        <input type="email" id="email" v-model="form_email" placeholder="email"> -->

                        <button>
                            <input type="submit" @click="saveListname()" value="Submit">
                        </button>
                    </div>
                </div>
            </div>
            <!-- add button -->
            <button id="add" @click="list.unshift(defaultSeries())">
                <icons type="add"></icons>
            </button>
        </div>

        <div v-if="listname == ''" class="mt-4">Start to manage your series. Click on the big + button to add a new row! <br> It will save automatically. You can also make your list private when you add a password.</div>

        <table class="table">
            <draggable tag="tbody" handle=".handle" v-model="list" draggable="tr">
                <template v-for="(item, index) in list">
                    <tr :key="index" :class="{'tr-running':item.status == 'running','tr-hiatus':item.status == 'hiatus','tr-finished':item.status == 'finished', 'd-flex':1}">
                        <td class="d-flex flex-fill">
                            <div class="drag-padding handle"><button><icons type="draggable"></icons></button></div>
                            <div class="svg_hover">
                                <div class="dropdown d-flex justify-content-between">
                                    <div v-if="item.open == false">
                                        <a v-if="item.url!=''" :href="addScheme(item.url)" target="_blank">{{item.seriesname}}</a>
                                        <span v-else>{{item.seriesname}}</span>
                                    </div>
                                    <div v-if="item.open == true"><input class="w-100" type="text" :placeholder="item.seriesname" v-model="item.seriesname" name="serie" :ref="'oc-'+index+'-link'"></div>
                                    <button @click="toggle(index);register_outerclick(['oc-'+index, 'oc-'+index+'-dropdown', 'oc-'+index+'-link'], ()=>close(index))" :ref="'oc-'+index"><icons type="pen"></icons></button><!-- @click="(e)=>handleClick(e,index)" toggle(index);  -->
                                    <div :class="{x:true, open:item.open}" :ref="'oc-'+index+'-dropdown'"> 
                                        <input class="w-100" type="url" placeholder="url" v-model="item.url" name="url">
                                    </div>
                                </div>
                            </div>
                            <div class="svg_hover">
                                <div class="d-flex justify-content-start">
                                    Season:
                                    <div @click="item.season--" class="numChange pointer"><icons type="caret_left"></icons></div>
                                    <div class="season">{{item.season}}</div>
                                    <div @click="item.season++" class="numChange pointer"><icons type="caret_right"></icons></div>
                                </div>
                            </div>
                            <div class="svg_hover">
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
                            <div class="delete-padding" @click="list.splice(index, 1)"><button><icons type="delete"></icons></button></div>
                        </td>
                    </tr>
                </template>
            </draggable>
        </table>

    </div>

    <details v-if="debug" style="font-size:11px;font-family:sans-serif;border:1px solid red;margin:1px 0;">
        <summary style="color:red;">Debug</summary>
        <b>Actions:</b>
        <div>
            <input type="button" value="Add example list data" @click="
                list = [
                    {
                        'seriesname':'The Walking Dead',
                        'url': 'https://youtube.com',
                        'season':42,
                        'episode':9337,
                        'status':'running',
                        'open': false,
                        'note':'',
                        'opennote': false
                    },
                    {
                        'seriesname':'BBBBBBBBBBB',
                        'url': 'https://youtube.com',
                        'season':4,
                        'episode':3,
                        'status':'hiatus',
                        'open': false,
                        'note':'',
                        'opennote': false
                    },
                    {
                        'seriesname':'CCCCCCCCCC',
                        'url': 'https://youtube.com',
                        'season':5,
                        'episode':2,
                        'status':'finished',
                        'open': false,
                        'note':'',
                        'opennote': false
                    }
                ];
                "
            >
            </div>
        <b>Current list:</b>
        <pre>{{list}}</pre>
    </details>
</div>
</template>

<script>
import draggable from 'vuedraggable';
import icons from './icons.vue';
//import outerclickMixin from './outerclickMixin.js';
import outerclick from '@dipser/outerclick.vuejs';
export default {
    mixins: [
        //outerclickMixin
        outerclick
    ],
    components: {
        draggable,
        icons,
    },
    data: function() {
        return {
            debug: false,

            //example: 'seriesname',

            lightbox: false,

            login_password: '',

            authorized: '',
            authorized_required: '',
            list_exists: '',
            listname: '',

            form_listname:'',
            form_password:'',
            form_email:'',
            list: [],
        }
    },
    computed: {
    },
    created() {
        this.authorized = JSON.parse(JSON.stringify(window.authorized));
        this.authorized_required = JSON.parse(JSON.stringify(window.authorized_required));
        this.list_exists = JSON.parse(JSON.stringify(window.list_exists));
        this.listname = JSON.parse(JSON.stringify(window.path));
        this.form_listname = JSON.parse(JSON.stringify(window.path));
        this.getList();
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
                var that = this;
                let data = {action:'savelist', list:newValue, listname:this.listname};
                fetch('/fetch.php', {
                    method: 'POST',
                    headers: {'Content-Type' : 'application/json'},
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    //console.log(response);
                    if(typeof response !== 'undefined' && typeof response.listname !== 'undefined'){
                        that.listname = response.listname;
                        that.list_exists = true;
                        history.pushState({}, '', '/list/'+that.listname);
                    }
                });
            }
        }
    },
    methods: {
        lightbox_open: function() {
            this.form_listname = JSON.parse(JSON.stringify(this.listname));
            this.lightbox = true;
        },
        lightbox_close: function() {
            this.lightbox = false;
        },
        login: function() {
            var data = { action:'login', listname:this.listname, password:this.login_password };
            fetch('/fetch.php', {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                if (response.login === true) {
                    this.login_password = '';
                    this.authorized = true;
                    this.getList();
                }
                else {
                    this.login_password = '';
                }
            });
        },
        logout: function() {
            var data = { action:'logout', listname:this.listname };
            fetch('/fetch.php', {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response.logout === true) {
                    this.authorized = false;
                }
            });
        },
        onUpdate: function (event) {
            //this.list.splice(event.newIndex, 0, this.list.splice(event.oldIndex, 1)[0])
        },
        toggle: function(index){
            this.list.forEach((item,i)=>{
                item.open = (index == i) ? !item.open : false;
            });
        },
        close: function(index) {
            //console.log('close', arguments);
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
            if ( this.list_exists ) {
                let data = { listname:this.listname, action:'getlist' };
                fetch('/fetch.php', {
                    method: 'POST',
                    headers: {'Content-Type' : 'application/json'},
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(response => {
                    //console.log(response);
                    if ( response.data ) {
                        this.list = JSON.parse(response.data);
                    }
                });
            }
        },
        addScheme: function(url){
            if ( !Boolean(url.match(/^https?:\/\//)) ) url = 'http://' + url;
            return url;
        },
        saveListname: function(){
            var that = this;
            let data = {action:'savelistname', old_listname:this.listname, new_listname:this.form_listname, password:this.form_password, email:this.form_email};
            //console.log('sending',data);
            fetch('/fetch.php', {
                method: 'POST',
                headers: {'Content-Type' : 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                //console.log('response',response);
                if ( response.savelistname == true ) {
                    that.authorized_required = response.authorized_required;
                    that.authorized = response.authorized;
                    that.listname = response.listname;

                    history.pushState({}, '', '/list/'+response.listname);

                    that.lightbox = false;

                } else {
                    alert('Failed.');
                }
                this.form_password = '';
            });
        }
    }
}
</script>

<style lang="scss"></style>