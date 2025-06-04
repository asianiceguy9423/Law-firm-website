<template>
  <table class="RouterPage">
    <thead>
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <th class="TitleH3">導覽列名稱</th>
      </tr>
      <tr class="FormItem BackColorBlue">
        <th class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          編號      
        </th>
        <th class="FormItemObjectNumber ObjectBoxNumber">
          顯示       
        </th>
        <th class="FormItemObjectBox">
          名稱       
        </th>
      </tr>
    </thead>    

    <tbody>
      <tr  
        class="FormItem ObjectBoxBoerderBottom FormItemToHover"
        v-for="(navbarItem, index) in navbarMainOption"
        :key="navbarItem.id"
      >
        <td class="FormItemObjectNumber ObjectBoxNumber ObjectToMinWidthDisplayNone">
          {{ index+1 }}
        </td>
        <td class="FormItemObjectNumber ObjectBoxNumber TextAlignLeft">
          <input 
            type="checkbox"
            :checked="(navbarItem.display)"
            @change="updateNavbarDisplay(index, $event.target.checked)"
          >
        </td>
        <td class="FormItemObjectBox TextAlignLeft">
          <input 
            type="text" 
            class="InputText" 
            placeholder="輸入項目"
            v-model="(navbarItem.name)"
            @input="updateNavbarName(index, $event.target.value)"
          >
        </td>
      </tr>
    </tbody>
    
  </table>
</template>

<script>
import { useStore } from 'vuex';

export default {
  props:{
    navbarMainOption:{
      type:     Array,
      default:  () => [],
    }
  },
  emit:['update:navbarMainOption'],
  setup(props, {emit}){
    const store=  useStore();
    //打包成array
    const emitnavbarMainOptionUpdate = (updatedNavbar) => {
      emit('update:navbarMainOption', updatedNavbar);
    };

    const updateNavbarName = (index, newName) => {
      const updatedNavbar = [...props.navbarMainOption];
      updatedNavbar[index] = { ...updatedNavbar[index], name: newName };
      emitnavbarMainOptionUpdate(updatedNavbar);
    };

    const updateNavbarDisplay = (index, newDisplay) => {
      const updatedNavbar = [...props.navbarMainOption];
      updatedNavbar[index] = { ...updatedNavbar[index], display: newDisplay };     emitnavbarMainOptionUpdate(updatedNavbar);
      
      store.dispatch("WebsiteInformation/updateNavbarDisplay", {
        number: updatedNavbar.number, // ✅ 傳遞 number 代替 id
        newDisplay
      });
    };

    return{
      updateNavbarName,
      updateNavbarDisplay,
    }
  }
}
</script>

<style lang="scss" scoped>
.FormItemObjectBox{
  display: flex;
  padding: 16px 20px;
  width: 24%;
}
.FormItemObjectNumber{
  display: flex;
  padding: 16px 20px;
  width: 6%;
}
@media (max-width:1024px){
  .FormItemObjectBox{
    padding: 12px 16px;
    width: 24%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
  }
}
@media (max-width:768px) {
  .FormItemObjectBox{
    width: 28%;
  }
  .FormItemObjectNumber{
    padding: 12px 16px;
    width: 10%;
  }
  .ObjectToMinWidthDisplayNone{
    display: none;
  }  
}
</style>