<template>


  <div class="register flex flex-col max-w-prose mx-auto mt-28">
    <!--     <img alt="Vue logo" src="../assets/logo.png"> -->

    <div class="flex flex-col w-full bg-purple-600 text-lg rounded-b-md text-purple-50">
      <div class="flex justify-between relative px-9 pt-8 pb-24 bg-purplehl w-full h-44 rounded-t-md">
        <div class="w-1/3">
          <span class="text-2xl">Welcome!</span><br>
          Sign in to Serieslog now.
        </div>
        <img class="h-40 w-40 -mt-4 -mr-8" alt="Camera" src="../assets/sticker/camera.png"> 
        <router-link to="/" class="flex justify-center content-center absolute bottom-0 left-0 bg-purple rounded-full h-24 w-24 ml-8 -mb-16">
          <logo classnames="fill-current text-yellow-600 transform max-h-full max-w-full"></logo>
        </router-link>
      </div>
      <div class=" flex flex-col w-full h-auto place-content-end px-9 pb-9 pt-6 text-purple-100">
        <div class="flex w-full flex-row pb-16"><div class="ml-auto"> 
          Already have an<br> account? <router-link to="/login" class="text-purplehl-200 hover:text-purplehl-100">Log In</router-link>
        </div></div>
        <form action="">
          <div class="flex flex-col mb-3">
            Email
            <input type="email" class="w-auto h-12 px-4 bg-purple rounded text-gray-400 focus:bg-purple-400 focus:outline-none" placeholder="Enter email" required>
          </div>
          <div class="flex flex-col my-3">
            Username
            <input class="w-auto h-12 px-4 bg-purple rounded text-gray-400 focus:bg-purple-400 focus:outline-none" placeholder="Enter username" required>
          </div>
          <div class="flex flex-col my-3">
            Password
            <input type="password" class="w-auto h-12 px-4 bg-purple rounded text-gray-400 focus:bg-purple-400 focus:outline-none" placeholder="Enter password" required>
          </div>
          <div class="flex flex-col my-3">
            Confirm Password
            <input type="password" class="w-auto h-12 px-4 bg-purple rounded text-gray-400 focus:bg-purple-400 focus:outline-none" placeholder="Enter password" required>
          </div>

          <checkbox required="true">
            <template v-slot:label>
              I have read and agree to the <router-link to="/terms_and_conditions" class="text-purplehl-200 hover:text-purplehl-100">General Terms and Conditions</router-link> and acknowledge the <router-link to="/privacy" class="text-purplehl-200 hover:text-purplehl-100">Privacy Policy</router-link>.
            </template>
          </checkbox>
          
          <!-- <button type="submit" class="focus:outline-none w-full h-12 bg-purplehl-400 hover:bg-purplehl-300 rounded mt-3 text-center text-gray-300">Register</button> -->
          <ButtonComp class="focus:outline-none w-full h-12 bg-purplehl-400 hover:bg-purplehl-300 rounded mt-3 text-center text-gray-300"><template v-slot:button-name>Register</template></ButtonComp>
        </form>
        
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import {/* bsp, */ Logo} from '@/components/icons/index.js'  //get icons from icons/index.js
import Checkbox from '@/components/Checkbox.vue'
import ButtonComp from '@/components/ButtonComp.vue'

export default {
  name: 'Register',
  components: {
    Logo,
    Checkbox,
    ButtonComp
  }
}




</script>


<style lang="scss">
</style>




