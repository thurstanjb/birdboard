<template>
    <div class="dropdown relative">
        <!-- trigger -->
        <div class="dropdown-toggle"
             aria-haspopup="true"
             :aria-expanded="is_open"
             @click.prvent="is_open = !is_open"
        >
            <slot name="trigger"></slot>
        </div>

        <!-- links -->
        <div v-show="is_open"
             class="dropdown-menu absolute bg-card mt-2 py-2 rounded shadow"
             :class="align === 'left' ? 'pin-l' : 'pin-r'"
             :style="{width}"
        >
            <slot></slot>
        </div>
    </div>

</template>

<script>
    export default {
      props:{
        width: {default: 'auto'},
        align: {default: 'left'}
      },

      watch:{
        is_open(isOpen){
          document.addEventListener('click', this.closeIfClickedOutside);
        }
      },

      data(){
        return {
          is_open: false
        }
      },

      methods:{
        closeIfClickedOutside(event){
          if(!event.target.closest('.dropdown')){
            this.is_open = false;

            document.removeEventListener('click', this.closeIfClickedOutside)
          }
        }
      }
    }
</script>