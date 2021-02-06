<template>
  <div id="app" class="flex flex-col h-full w-full bg-purple-700">
   
    <router-view class="flex-grow" />

    <PageFooter></PageFooter>
      

  </div>
</template>

<script>
import PageFooter from '@/components/PageFooter.vue'
export default {
  components: {
    PageFooter
  }
}
</script>