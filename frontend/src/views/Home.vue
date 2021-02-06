<template>
  <div class="home">
     <div id="nav">
      <router-link to="/">Home</router-link> 

      <router-link to="/register">Register</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/logout">Logout</router-link>
      <router-link to="/passforgotten">Password forgotten?</router-link>
      <router-link to="/settings">Settings</router-link>
      <br>

      <router-link to="/list">List</router-link>
      <router-link to="/search">Search</router-link>
      <router-link to="/genres">Genres</router-link>
      <router-link to="/description">Description</router-link>
      <router-link to="/rated">Rated</router-link>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import {/* bsp, */ Logo} from '@/components/icons/index.js'  //get icons from icons/index.js

export default {
  name: 'Home',
  components: {
    Logo
  }
}
</script>

<style lang="scss">


  
  #nav {
    padding: 30px;
  
    a {
      font-weight: bold;
      color: #f8f8f8;
  
      &.router-link-exact-active {
        color: green;
      }
    }
  }
</style>
