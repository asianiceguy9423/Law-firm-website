<template>
  <div class="sidebarTop">
        <font-awesome-icon v-show="burgerbtn" :icon="['fas', 'bars']" size="2xl" style="color: #000624;" @click="BurgerButtonClick" class="Mark"/>
    </div>
</template>

<script>
export default {
  data(){
    return{
      burgerbtn:true
    }
  },
  created(){
    this.$bus.$on('clickXMark',this.BurgerButtonClick)
  },
  destroyed(){
    this.$bus.$off('clickXMark',this.BurgerButtonClick)
  },
  methods:{
    BurgerButtonClick(){
      this.$bus.$emit('clickSidebar')
      this.burgerbtn =! this.burgerbtn
    },
  }

}
</script>

<style scoped>
.sidebarTop{
    background-color: rgb(255, 255, 255);
    box-shadow:0px 4px 4px  rgba(0, 0, 0, 0.08);
    width: 100%;
    height: 64px;
    display: none;
    padding: 0 20px;
    justify-content: space-between;
    align-content: center;
    box-sizing: border-box;
  }
  .Mark{
    cursor: pointer;
    padding: 15px 15px;
  }
  @media(max-width:1250px){
  .sidebarTop{
    display: flex;
  }
  }

</style>