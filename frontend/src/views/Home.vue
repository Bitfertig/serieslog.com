<template>


  <div class="home">
<!--     <img alt="Vue logo" src="../assets/logo.png"> -->
    <!--HelloWorld msg="Welcome to Your Vue.js App"/-->

    <div class="form">
      <div class="header"></div>
      <div class="center">
        <div class="content">
          <div class="input w-56"></div>
          <div class="input"></div>
          <div class="input"></div>
          <div class="input"></div>
        </div>
      </div>
    </div>

    
  </div>
</template>

<script>
// @ is an alias to /src
import HelloWorld from '@/components/HelloWorld.vue'

export default {
  name: 'Home',
  components: {
    HelloWorld
  }
}
</script>


<style lang="scss">
@import '../css/variables.scss';

.form * { display:flex; }
.form{
  display: flex;
  flex-direction: column;
  width: 400px;
  height: 500px;
  .header{
    justify-content:center;
    background-color:$baseColorIntense;
    width: 100%;
    height: 130px;
  }
  .center{
    justify-content: center;
    height: 100%;
    width: 100%;
    background-color:$baseColor;
    .content{
      flex-direction: column;
      justify-content:space-around;
      height: 100%;
      .input{
        justify-content:center;
        background-color:green;
        //width: 350px;
        height: 50px;
      }
    }
  }
}


</style>
