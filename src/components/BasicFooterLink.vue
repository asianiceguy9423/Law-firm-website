<template>
  <div>    
    <table class="RouterPage">
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <h3 class="TitleH3">相關連結</h3>
      </tr>
      <div class="ObjectBox ObjectGrid">
        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="facebook" 
            :checked="selectedLinkOptions.includes('facebook')" 
            @change="updateSelectedLinkOptions('facebook', $event)">
          </label>
          <td class="basicObject">Facebook</td>
          <td>
            <input type="text"
            :value="yourFacebook"
            @input = "$emit('update:yourFacebook', $event.target.value)"
            placeholder="這邊輸入Facebook" 
            class="InputText">
          </td>              
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="instagram" 
            :checked="selectedLinkOptions.includes('instagram')" 
            @change="updateSelectedLinkOptions('instagram', $event)">
          </label>
          <td class="basicObject">Instagram</td>
          <td>
            <input type="text"
            :value="yourInstagram"
            @input = "$emit('update:yourInstagram', $event.target.value)"
            placeholder="這邊輸入Instagram" 
            class="InputText">
          </td>
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="line" 
            :checked="selectedLinkOptions.includes('line')" 
            @change="updateSelectedLinkOptions('line', $event)">
          </label>
          <td class="basicObject">Line</td>
          <td>
            <input type="text"
            :value="yourLine"
            @input = "$emit('update:yourLine', $event.target.value)"
            placeholder="這邊輸入Line" 
            class="InputText">
          </td>
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="youtube" 
            :checked="selectedLinkOptions.includes('youtube')" 
            @change="updateSelectedLinkOptions('youtube', $event)">
          </label>
          <td class="basicObject">Youtube</td>
          <td>
            <input type="text"
            :value="yourYoutube"
            @input = "$emit('update:yourYoutube', $event.target.value)"
            placeholder="這邊輸入Youtube" 
            class="InputText">
          </td>
        </tr>
      </div>
    </table>
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
      type:Array,
      default(){
        return [];
      }
    }    
  },
  methods: {
    updateSelectedLinkOptions(option, event) {
      let updateLinkOptions = [...this.selectedLinkOptions]
      if (event.target.checked) {
        updateLinkOptions.push(option);
      } else {
        const index = updateLinkOptions.indexOf(option);
        if (index > -1) {
          updateLinkOptions.splice(index, 1);
        }
      }
      this.$emit('update:selectedLinkOptions', updateLinkOptions);
    },
  }
}
</script>

<style>
</style>
