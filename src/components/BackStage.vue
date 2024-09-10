<template>
  <div class="container">
    <NavBar class="navbar"/>
    <Sidebar v-show="Sidebarshow" class="navbar"/>
    <div class="RouterClass">
      <SidebarTop/>
        <router-view/>
      </div>
  </div>
  
</template>

<script>
import NavBar from './NavBar.vue';
import Sidebar from './Sidebar.vue';
import SidebarTop from './SidebarTop.vue';
export default {
  components:{
    NavBar,
    SidebarTop,
    Sidebar,
  },
  data(){
    return{
      Sidebarshow:false
    }
  },
  created(){
    this.$bus.$on('clickSidebar',this.clicksivebarshaow)
  },
  destroyed(){
    this.$bus.$off('clickSidebar',this.clicksivebarshaow)
  },
  methods:{
    clicksivebarshaow(){
      this.Sidebarshow =! this.Sidebarshow
    }
  }
}
</script>

<style>
body {
  background: #eceff3;
}
a {
  text-decoration: none;
  color: inherit;
}
img {
  width: 150px;
  height: 100px;
  object-fit: cover;
}
h1{
  font-size: 28px;
}
textarea{
  height: 350px;
}
.error {
  color: red;
}
.container {
  display: flex;
}
.RouterClass{
  margin-left: 250px;
  width: 100%;
}
.RouterPage{
  background-color: white;
  border-radius: 8px;
  width: 100%;
}
.ObjectBox{
  display: flex;
  padding: 18px 24px;
}
.ObjectBoxNumber{
  width: 300px;
}
.ObjectBoxBoerderBottom{
  border-bottom: 2px solid #eceff3;
}
.ObjectBoxFlex{
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 25px 0;
}
.FlexBoxBottom{
  display: flex;
  justify-content: space-between;
  align-items: end;
  padding: 25px 0;
}
.PaddingLeftRight{
  padding-left: 25px;
  padding-right: 25px;
}
.PaddingBottom{
  padding-bottom: 25px;
}
.formGrid{
  display: grid;
  grid-gap: 18px;
}
.TitleH3{
  font-size: 18px;
  font-weight: normal;
}
.ObjectItem{
  display: grid;
  grid-gap: 6px;
}
.InputText{
  font-size: 16px;
  padding: 5px 9px 5px 12px;
  border: 1.5px solid #dfe5eb;
  border-radius: 6px;
  width: 100%; 
  box-sizing: border-box;
}
.ObjectGrid{
  display: grid;
  grid-gap: 16px;
}
.FormItem{
  display: flex;
  align-items: center;
}
.FormItemToHover:hover{
  background: #e7f0ff;
  cursor: pointer;
}
.BackColorBlue{
  background: #d6e6fe;
}
.ItemButton{
  background-color: #5999ff;
  color: #ffff;
  font-size: 16px;
  padding: 6px 24px;
  border: none;
  border-radius: 40px;
  cursor: pointer;
  display: inline-block;
  transition: 0.2s;
}
.ItemButtonWidthMax{
  flex-grow: 0.6;
}
.ItemButton:hover{
  background-color: #116dff;
}
.ItemButtonWhite{
  background-color: #ffff;
  color: #5999ff;
  border: 1px solid #d6e6fe;
  margin-right: 16px;
}
.ItemButtonTh{
  display: flex;
  flex-wrap: wrap;
  gap: 12px;  
}
.Lawbutton{
  background-color: #ffff;
  color: #162d3d;
  border: 1px solid #162d3d;
  font-size: 14px;
  padding: 6px 16px;  
}
.Lawbutton:hover{
  background-color: #cfd1dc;
}
.hidden,
.fileInput {
  display: none;
}
.FormItemToHover:hover .ItemButton {
  display: inline-block;
}
.Font14{
  font-size: 14px;
  color: #5999ff;;
}
.TextAlignLeft{
  text-align: left;
}
.MarginRight12{
  margin-right: 12px;
}
.PointButton{
  border: none;
  border-radius: 40px;
  padding: 4px 10px;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s;
}
.PointButton:hover{
  background-color: #ffffff;
}
.PointMargin{
  margin-right: 6px;
}
.SuccessColor{
  background-color: #51b77b;
}
.ErrorColor{
  background-color: #b75151;
}

table {
  width: 100%;
  border-collapse: collapse;
}
td {
  width: 100%;
}
.success-enter-active,
.success-leave-active {
  transition: all 0.5s;
}

.success-enter {
  transform: translateY(-100%);
  opacity: 0;
}
.success-enter-to {
  transform: translateY(0);
  opacity: 1;
}
.success-leave {
  transform: translateY(0);
  opacity: 1;
}

.success-leave-to {
  transform: translateY(-100%);
  opacity: 0;
}
.LinkButtonMarginLeft{
  margin-left: -8px;
  margin-bottom: 4px;
}
@media(max-width:1250px){
  .RouterClass{
    margin-left: 0px;
  }
  .sidebarTop{
    display: flex;
  }
  .hidden {
  display: inline-block;
}
}
@media(max-width:1050px){

}

</style>