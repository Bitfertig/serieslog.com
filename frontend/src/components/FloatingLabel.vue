<template>
  <form class="floating-label w-full">
    <div class="floating-input mb-5 relative">
      <input type="email" id="email" class="focus:outline-none rounded-md w-full p-3 h-16" placeholder="name@example.com" autocomplete="off" />
      <label for="email" class="absolute top-0 left-0 px-3 py-5 h-full pointer-events-none transform origin-left transition-all duration-100 ease-in-out ">Email address</label>
    </div>
    <div class="floating-input mb-5 relative">
      <input type="password" id="password" class="focus:outline-none rounded-md w-full p-3 h-16" placeholder="password" autocomplete="off" />
      <label for="password" class="absolute top-0 left-0 px-3 py-5 h-full pointer-events-none transform origin-left transition-all duration-100 ease-in-out ">Password</label>
    </div>
  </form>
</template>

<style scoped>
/* Floating Label */
.floating-input>input::placeholder {
    color: transparent;
}
.floating-input>input:focus,
.floating-input>input:not(:placeholder-shown) { 
@apply pt-8
}
.floating-input>input:focus~label, 
.floating-input>input:not(:placeholder-shown)~label {
  @apply opacity-75 scale-75 -translate-y-3 translate-x-1; 
}
</style>