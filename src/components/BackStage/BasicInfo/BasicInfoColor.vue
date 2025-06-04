<template>
  <table class="RouterPage">
    <thead class="ObjectBox ObjectBoxBoerderBottom">
        <th class="TitleH3">網站配色</th>           
    </thead>
    <tbody>
      <tr class="ObjectBox ObjectGrid ColoeObjectGrid">
        <td class="ColoeObjectGrid">
          <div>主要顏色:</div>
          <div class="colorInputBox">
            <input 
              type="color" 
              id="colorPicker" 
              name="head" 
              v-model="colorMainHex"
              @input="updateRGB('main')"
            />

            <input 
              type="text" 
              id="rgbInput" 
              v-model="colorMainRGB"
              @input="updateHex('main')"
              placeholder="(214, 185, 105)"
              class="enterRGB"
            />
          </div>
        </td>
      </tr>

      <tr class="ObjectBox ObjectGrid">
        <td class="ColoeObjectGrid">
          <div>輔助顏色</div>
          <div class="colorInputBox">
            <input 
              type="color" 
              id="colorPicker" 
              name="head" 
              v-model="colorSecondaryHex"
              @input="updateRGB('secondary')"
            />

            <input 
              type="text" 
              id="rgbInput" 
              v-model="colorSecondaryRGB"
              @input="updateHex('secondary')"
              placeholder="(214, 185, 105)"
              class="enterRGB"
            />
          </div>
        </td>
      </tr>

      <tr class="ObjectBox ObjectGrid">
        <td class="ColoeObjectGrid">
          <div>配色一</div>
          <div class="colorInputBox">
            <input 
              type="color" 
              id="colorPicker" 
              name="head" 
              v-model="colorThirdHex"
              @input="updateRGB('third')"
            />

            <input 
              type="text" 
              id="rgbInput" 
              v-model="colorThirdRGB"
              @input="updateHex('third')"
              placeholder="(214, 185, 105)"
              class="enterRGB"
            />
          </div>
        </td>
      </tr>

      <tr class="ObjectBox ObjectGrid">
        <td class="ColoeObjectGrid">
          <div>配色二</div>
          <div class="colorInputBox">
            <input 
              type="color" 
              id="colorPicker" 
              name="head" 
              v-model="colorFourthHex"
              @input="updateRGB('fourth')"
            />

            <input 
              type="text" 
              id="rgbInput" 
              v-model="colorFourthRGB"
              @input="updateHex('fourth')"
              placeholder="(214, 185, 105)"
              class="enterRGB"
            />
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import { ref, watch } from 'vue';

export default {
  props:{
    websiteColor:{
      type:   Array,
      default:  ()  => [],
    },
  },
  emits: ['update:websiteColor'],
  setup(props, {emit}){

    // 預設顏色
    const colorArr = {
      main      :{colorHex: ref(""), colorRGB: ref("")},
      secondary :{colorHex: ref(""), colorRGB: ref("")},
      third     :{colorHex: ref(""), colorRGB: ref("")},
      fourth    :{colorHex: ref(""), colorRGB: ref("")},
    };

    const getColorFromProps = (name) =>{
      const colorItem = props.websiteColor.find(item => item.name === name);
      return colorItem ? colorItem.color : ""
    }

    watch(() => props.websiteColor, (newValue) => {
      if (newValue.length) {
        colorArr['main'].colorRGB.value       = getColorFromProps("mainColor");
        colorArr['secondary'].colorRGB.value  = getColorFromProps("secondaryColor");
        colorArr['third'].colorRGB.value      = getColorFromProps("thirdColor");
        colorArr['fourth'].colorRGB.value       = getColorFromProps("fourthColor");

        colorArr['main'].colorHex.value       = rgbToHex(colorArr['main'].colorRGB.value);
        colorArr['secondary'].colorHex.value  = rgbToHex(colorArr['secondary'].colorRGB.value);
        colorArr['third'].colorHex.value      = rgbToHex(colorArr['third'].colorRGB.value);
        colorArr['fourth'].colorHex.value       = rgbToHex(colorArr['fourth'].colorRGB.value);
      }
    }, { immediate: true }); // 🔹 `immediate: true` 讓它初始化時執行一次

    //當接收到父組件emit，將四個顏色打包成array傳過去
    const emitColorUpdate = () => {
      const updatedColors = [
        { name: "mainColor",        color: colorArr['main'].colorRGB.value },
        { name: "secondaryColor",   color: colorArr['secondary'].colorRGB.value },
        { name: "thirdColor",       color: colorArr['third'].colorRGB.value },
        { name: "fourthColor",      color: colorArr['fourth'].colorRGB.value },
      ];
      emit('update:websiteColor', updatedColors);
    };

    // Hex 轉換成 RGB
    const hexToRgb = (hex) => {
      if (!hex || hex.length !== 7) return "0, 0, 0"; // 避免 undefined 时报错，默认返回黑色
      let r = parseInt(hex.substring(1, 3), 16);
      let g = parseInt(hex.substring(3, 5), 16);
      let b = parseInt(hex.substring(5, 7), 16);
      return `${r}, ${g}, ${b}`;
    };

    // RGB 轉換成 Hex
    const rgbToHex = (rgb) => {
      let rgbArr = rgb.split(",").map((num) => parseInt(num.trim()));
      if (rgbArr.length === 3 && rgbArr.every((n) => !isNaN(n) && n >= 0 && n <= 255)) {
        return `#${rgbArr.map((n) => n.toString(16).padStart(2, "0")).join("")}`;
      }
      return colorArr['main'].colorHex.value; // 如果格式錯誤，不改變顏色
    };

    const getColorRef = (type) => colorArr[type] ?? null;

    const updateRGB = (type) => {
      const color = getColorRef(type);
      if(!color) return;
      color.colorRGB.value = hexToRgb(color.colorHex.value);
      emitColorUpdate();
    };

    // 當手動輸入 RGB 時，更新顏色選擇器
    const updateHex = (type) => {
      const color = getColorRef(type);
      if(!color) return;
      color.colorHex.value = rgbToHex(color.colorRGB.value);
      emitColorUpdate();
    };

    // 監聽 `colorHex` 變化時同步更新 `colorRGB`
    watch([
      colorArr['main'].colorHex,
      colorArr['secondary'].colorHex,
      colorArr['third'].colorHex,
      colorArr['fourth'].colorHex,
    ], 
      ([newMain, newSecond, newThird, newFourth]) => {
        colorArr['main'].colorRGB.value = hexToRgb(newMain ?? "#000000");
        colorArr['secondary'].colorRGB.value = hexToRgb(newSecond ?? "#000000");
        colorArr['third'].colorRGB.value = hexToRgb(newThird ?? "#000000");
        colorArr['fourth'].colorRGB.value = hexToRgb(newFourth ?? "#000000");
    });

    return {
      updateRGB, 
      updateHex,
      colorArr,
      colorMainHex: colorArr['main'].colorHex,
      colorMainRGB: colorArr['main'].colorRGB,
      colorSecondaryHex: colorArr['secondary'].colorHex,
      colorSecondaryRGB: colorArr['secondary'].colorRGB,
      colorThirdHex: colorArr['third'].colorHex,
      colorThirdRGB: colorArr['third'].colorRGB,
      colorFourthHex: colorArr['fourth'].colorHex,
      colorFourthRGB: colorArr['fourth'].colorRGB,
    }
  }
}
</script>

<style lang="scss" scoped>
.ColoeObjectGrid{
  display: flex;
  grid-gap: 8px;
}
.colorInputBox{
  display: flex;
}
.enterRGB{
  width: 100px;
  padding: 4px;
  margin-left: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>