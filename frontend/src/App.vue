<template>
  <div id="app">
    <div id="nav">
      <router-link to="/">Home</router-link> 

      <router-link to="/about">About</router-link>
      <router-link to="/impress">Impress</router-link>
      <router-link to="/privacy">Privacy</router-link>
      <br>

      <router-link to="/register">Register</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/logout">Logout</router-link>
      <router-link to="/pass_forgotten">Password forgotten?</router-link>
      <router-link to="/settings">Settings</router-link>
      <br>

      <router-link to="/list">List</router-link>
      <router-link to="/search">Search</router-link>
      <router-link to="/genres">Genres</router-link>
      <router-link to="/description">Description</router-link>
      <router-link to="/rated">Rated</router-link>
    </div>
    <router-view/>
  </div>
</template>

<style lang="scss">

</style>
