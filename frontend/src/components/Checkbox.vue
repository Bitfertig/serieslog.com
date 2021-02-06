<template>
  <!-- Specify the state of require in <checkbox require="true/false">  -->
  <label class="checkbox flex flex-row">
      <span class="checkbox__input pt-1 mr-2">
          <input type="checkbox" name="checkbox" :required="required">
          <span class="checkbox__control">
              <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' aria-hidden="true" focusable="false">
              <path fill='none' stroke='currentColor' stroke-width='3' d='M1.73 12.91l6.37 6.37L22.79 4.59' /></svg>
          </span>
      </span>
      <span class="radio__label">
          <slot name="label"></slot>
      </span>
  </label>
</template>

<script>
export default {
  name: 'Checkbox',
  props: [
        'required'
    ]
}

</script>

<style lang="scss">
.checkbox__control {
  display: inline-grid;
  width: 1.3em;
  height: 1.3em;
  border-radius: 0.25em;
  border: 0.1em solid currentColor;

  svg {
    transition: transform 0.1s ease-in 25ms;
    transform: scale(0);
    transform-origin: bottom left;
  }
}
.checkbox__input {
  display: grid;
  grid-template-areas: "checkbox";

  > * {
    grid-area: checkbox;
  }
  input {
    opacity: 0;
    width: 1.3em;
    height: 1.3em;
    &:checked + .checkbox__control {
      @apply border-purplehl-200;
    }
    &:checked + .checkbox__control svg {
      transform: scale(1);
      @apply fill-current text-purplehl-200;
    }
    
  }
}

</style>
