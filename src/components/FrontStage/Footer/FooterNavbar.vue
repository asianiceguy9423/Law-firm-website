<template>
  <div class="middle Footers">
    <h3>常見法律問題</h3>
    <ul>
      <router-link 
        v-for="(option, index) in filterNavbarOptions" :key="index"
        :to="`/Articles/${option.number}`"
      >
        <li>{{ option.name }}</li>
      </router-link>
    </ul>
  </div>
</template>

<script>
import { computed } from 'vue';

export default {
  props: {
    navbarOptions: {
      type:     Array,
      default:  () => [],
    }
  },
  setup(props) {
    const filterNavbarOptions = computed(()=>
      props.navbarOptions.filter((option) => option.display)
    );
    
    return {
      filterNavbarOptions,
    }
  }
}
</script>

<style>
</style>