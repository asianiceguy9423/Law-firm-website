<template>
  <div class="Footers">
    <img v-if="LOGOimage" v-lazy="LOGOimage" alt="Logo">
    <ul>
      <li v-for="(info, index) in sortedStoreInfo" :key="index">
        <svg 
          v-if="info.name === 'phone'" 
          xmlns="http://www.w3.org/2000/svg" 
          height="14" 
          width="14" 
          viewBox="0 0 512 512"
        >
          <path 
            fill="currentColor" 
            d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"
          />
        </svg>
        
        <svg 
          v-if="info.name === 'mail'" 
          xmlns="http://www.w3.org/2000/svg" 
          height="14" 
          width="14" 
          viewBox="0 0 512 512"
        >
          <path 
            fill="currentColor" 
            d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"
          />
        </svg>

        <svg 
          v-if="info.name === 'address'" 
          xmlns="http://www.w3.org/2000/svg" 
          height="14" 
          width="10.5" 
          viewBox="0 0 384 512"
        >
          <path 
            fill="currentColor" 
            d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"
          />
        </svg>

        <svg 
          v-if="info.name === 'time'" 
          xmlns="http://www.w3.org/2000/svg" 
          height="14" 
          width="14" 
          viewBox="0 0 512 512"
        >
          <path 
            fill="currentColor" 
            d="M256 0a256 256 0 1 1 0 512A256 256 0 1 1 256 0zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"
          />
        </svg>
        {{ info.detail }}
      </li>
    </ul>
  </div>
</template>

<script>
import { computed } from 'vue';

export default {
  props: {
    LOGOimage:{
      type: String,
      default: '',
    },
    storeInfo:{
      type:     Array,
      default:  () =>{},
    }
  },
  setup(props) {
    const filteredStoreInfo = computed(() =>
      props.storeInfo.filter((info) => info.display)
  );

  const desiredOrder = ['address', 'time', 'mail', 'phone'];

  const sortedStoreInfo  = computed(()=>{
    return [...filteredStoreInfo.value].sort((a, b) =>{
      return desiredOrder.indexOf(a.name) - desiredOrder.indexOf(b.name);
    })
  })

    return {
      sortedStoreInfo,
    };
  },
};
</script>

<style lang="scss" scoped>
.Footers{
  img{
    width: 150px;
    margin-bottom: 8px;
    height: auto;
    object-fit: cover;
  }
  ul{
    li{
      svg{
        margin-right: 13px;
      }
    }
  }
}

@media (max-width:1024px ) {
  .Footers{
    img{
      width: 200px;
    }
  }  
}
</style>
