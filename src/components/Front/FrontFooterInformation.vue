<template>
  <div>    
    <ul class="left">
      <img :src="currentLOGOImage">
      <div class="LiDiv">
        <li class="footer_text"
        v-if="selectedOptions.includes('phone')">
          <font-awesome-icon class="icon" :icon="['fas', 'phone']" size="sm" />
          {{ yourPhonenumber }}
        </li>

        <li class="footer_text"
        v-if="selectedOptions.includes('mail')">
          <font-awesome-icon class="icon" :icon="['fas', 'envelope']" size="sm" />
          {{ yourMail }}
        </li>

        <li class="footer_text"
        v-if="selectedOptions.includes('address')">
          <font-awesome-icon class="icon" :icon="['fas', 'location-dot']" size="sm" />
          {{ yourAddress }}
        </li>

        <li class="footer_text"
        v-if="selectedOptions.includes('time')">
          <font-awesome-icon class="icon" :icon="['fas', 'clock']" size="xs" />
          {{ yourTime }}
        </li>
      </div>        
    </ul>
  </div>
</template>

<script>
export default {
  props:{
    currentLOGO:{
      type: String,
      default:''
    },
    yourPhonenumber:{
      type: String,
      default:''
    },
    yourMail:{
      type: String,
      default:''
    },
    yourAddress:{
      type: String,
      default:''
    },
    yourTime:{
      type: String,
      default:''
    },
    selectedOptions:{
      type:Array,
      default(){
        return [];
      }
    }
  },
  computed:{
    currentLOGOImage(){
      return `${this.$apiurl}/src/assets/basic/${this.currentLOGO}`;
    }
  },
}
</script>

<style scoped>
img{
  width: 150px;
  height: auto;
  object-fit: cover;
}
.icon{
  margin-right: 13px;
}
@media(max-width: 1000px){
  img{
    width: 200px;
  }
}


</style>