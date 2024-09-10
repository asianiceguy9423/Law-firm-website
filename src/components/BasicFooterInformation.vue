<template>
  <div>    
    <table class="RouterPage">
      <tr class="ObjectBox ObjectBoxBoerderBottom">
        <h3 class="TitleH3">頁底資訊</h3>
      </tr>
      
      <div class="ObjectBox ObjectGrid">
        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="phone" 
            :checked="selectedOptions.includes('phone')" 
            @change="updateSelectedOptions('phone', $event)">
          </label>
          <td class="basicObject">電話</td>
          <td>
            <input type="text"
            :value="yourPhonenumber"
            @input = "$emit('update:yourPhonenumber', $event.target.value)" 
            placeholder="這邊輸入電話" 
            class="InputText">
          </td>              
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" 
            value="mail" 
            :checked="selectedOptions.includes('mail')" 
            @change="updateSelectedOptions('mail', $event)">
          </label>
          <td class="basicObject">信箱</td>
          <td>
            <input type="text"
            :value="yourMail"
            @input = "$emit('update:yourMail', $event.target.value)" 
            placeholder="這邊輸入信箱" 
            class="InputText">
          </td>
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="address" 
            :checked="selectedOptions.includes('address')" 
            @change="updateSelectedOptions('address', $event)">
          </label>
          <td class="basicObject">地址</td>
          <td>
            <input type="text"
            :value="yourAddress"
            @input = "$emit('update:yourAddress', $event.target.value)" 
            placeholder="這邊輸入地址" 
            class="InputText">
          </td>
        </tr>

        <tr class="labelDiv">
          <label>
            <input type="checkbox" value="time" 
            :checked="selectedOptions.includes('time')" 
            @change="updateSelectedOptions('time', $event)">
          </label>
          <td class="basicObject">營業時間</td>
          <td>
            <input type="text"
            :value="yourTime"
            @input = "$emit('update:yourTime', $event.target.value)" 
            placeholder="這邊輸入營業時間" 
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
  methods: {
    updateSelectedOptions(option, event) {
      let updatedOptions = [...this.selectedOptions];

      if (event.target.checked) {
        updatedOptions.push(option);
      } else {
        const index = updatedOptions.indexOf(option);
        if (index > -1) {
          updatedOptions.splice(index, 1);
        }
      }
      this.$emit('update:selectedOptions', updatedOptions);
    },
  }
}
</script>

<style>
</style>
