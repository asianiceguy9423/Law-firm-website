<template>
  <div>
      <ul class="right">
        <h3>相關連結</h3>
        <div class="link">
            <div class="link_border fb"
            v-if="selectedLinkOptions.includes('facebook')"
            @click="GoToRelatedLinks(yourFacebook)">
              <font-awesome-icon  class="icon" :icon="['fab', 'facebook-f']" size="lg"/>
            </div>       

            <div class="link_border ig"
            v-if="selectedLinkOptions.includes('instagram')"
            @click="GoToRelatedLinks(yourInstagram)">
              <font-awesome-icon class="icon" :icon="['fab', 'instagram']" size="lg"/>
            </div>

            <div class="link_border line"
            v-if="selectedLinkOptions.includes('line')"
            @click="GoToRelatedLinks(yourLine)">
              <font-awesome-icon class="icon" :icon="['fab', 'line']" size="lg" />   
            </div>       

            <div class="link_border yt"
            v-if="selectedLinkOptions.includes('youtube')"
            @click="GoToRelatedLinks(yourYoutube)">
              <font-awesome-icon class="icon" :icon="['fab', 'youtube']" size="lg"/>
            </div>          
        </div>        
      </ul>
  </div>
</template>

<script>
export default {
  props:{
    yourFacebook:{
      type: String,
      default:''
    },
    yourInstagram:{
      type: String,
      default:''
    },
    yourLine:{
      type: String,
      default:''
    },
    yourYoutube:{
      type: String,
      default:''
    },
    selectedLinkOptions:{
      type: Array,
      default(){
        return [];
      }
    }
  },
  methods:{
    GoToRelatedLinks(url){
      if(url){
        window.open(url,"_blank");
      }
    }
  }
}
</script>

<style scoped>
.link{
  display: flex;
  column-gap: 5px;
  padding: 8px 0;
}
.link_border{
  border: 1px solid #fff;
  border-radius: 50px;
  height: 35px;
  width: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: 0.4s;
}
.link_border:hover{
  background-color: #fff;
  border-color:rgb(214, 185, 105);
}
.link_border:hover .icon{
  color: rgb(214, 185, 105);
}
</style>