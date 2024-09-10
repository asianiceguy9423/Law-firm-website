<template>
  <div>
    <MessageDiv/>

    <div class="FlexBoxBottom PaddingLeftRight">
      <div>
        <div class="LinkButtonMarginLeft">
          <button @click="goBack" class="PointButton PointMargin" type="button">聯絡我們</button>
          <font-awesome-icon :icon="['fas', 'angle-right']" style="color: #acafc4;" class="PointMargin"/>
          <button class="PointButton" type="button">新增資訊</button>
        </div>
        <h1>增加文章 </h1>
      </div>
      <div>
        <button @click="goBack" type="button" class="ItemButton ItemButtonWhite">取消</button>
        <button @click="submitLawWriting" type="submit" class="ItemButton">確定新增</button>
      </div>
    </div>

      <form @submit.prevent="submitLawWriting" enctype="multipart/form-data" class="PaddingLeftRight">
        <table class="RouterPage">
          <tr class="ObjectBox ObjectBoxBoerderBottom">
            <h3 class="TitleH3">輸入文章</h3>
          </tr>
          <div class="ObjectBox ObjectGrid">
            <tr class="ObjectItem">
              <td>文章名稱</td>
              <td>
                <input type="text" v-model="LawTitle" placeholder="輸入文章標題" class="InputText">
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>文章類型</td>
              <td>
                <button 
                  class="ItemButton Lawbutton" 
                  :class="{'ActiveLawBtn' : LawClass.includes('智產')}" 
                  @click="LawClassClick('智產')" 
                  type="button">
                  智慧財產權
                </button>
                <button 
                  class="ItemButton Lawbutton" 
                  :class="{'ActiveLawBtn' : LawClass.includes('車禍')}" 
                  @click="LawClassClick('車禍')" 
                  type="button">
                  車禍
                </button>
                <button 
                  class="ItemButton Lawbutton" 
                  :class="{'ActiveLawBtn' : LawClass.includes('勞基')}" 
                  @click="LawClassClick('勞基')" 
                  type="button">
                  勞資糾紛
                </button>
                <button 
                  class="ItemButton Lawbutton" 
                  :class="{'ActiveLawBtn' : LawClass.includes('民事')}" 
                  @click="LawClassClick('民事')" 
                  type="button">
                  民事案件
                </button>
                <button 
                  class="ItemButton Lawbutton" 
                  :class="{'ActiveLawBtn' : LawClass.includes('刑事')}" 
                  @click="LawClassClick('刑事')" 
                  type="button">
                  刑事及毒品
                </button>
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>選擇Banner圖片</td>
              <td>
                <input class="fileInput fileInputBanner" type="file" @change="LawBannerImageUpload">
                <button type="button" class="ItemButton" @click="triggerBannerFileInput">選擇圖片</button>
                <div v-if="BannerImageName" class="Font14">{{ BannerImageName }}</div>
                <div v-else class="Font14">尚未更換圖片</div>
              </td>
            </tr>

            <tr class="ObjectItem">
              <td>選擇文章圖片</td>
              <td>
                <input class="fileInput fileInputBigImage" type="file" @change="LawBigImageUpload">
                <button type="button" class="ItemButton" @click="triggerBigFileInput">選擇圖片</button>
                <div v-if="BigimageName" class="Font14">{{ BigimageName }}</div>
                <div v-else class="Font14">尚未更換圖片</div>
              </td>
            </tr>

            <tr  class="ObjectItem">
              <td>文章介紹</td>
              <td>
                <textarea v-model="LawTextPoint" placeholder="輸入文章介紹" class="InputText"></textarea>
              </td>
            </tr> 

            <tr  class="ObjectItem">
              <td>文章內容(以html形式):</td>
              <td>
                <textarea v-model="LawText" placeholder="輸入內容" class="InputText"></textarea>
              </td>
            </tr> 
          </div>
        </table>
      </form>
  </div>
</template>

<script>
import MessageDiv from './MessageDiv.vue';
export default {
  components:{
    MessageDiv
  },
  data() {
    return {
      LawTitle:'',
      LawClass:[],
      LawBannerImage: null,
      LawBigImage: null,
      BannerImageName:'',
      BigimageName:'',
      LawTextPoint:'',
      LawText: `
      <!-- 請按照基本格式做修改 -->
         <!--第一段-->
        <!-- 這是上下有兩條線的大標 -->
        <div class="h3Div">
          <h3>這裡是標題
          </h3>
        </div>
      <!-- 這裡是內文 -->
        <h4>這裡是標題</h4>
        <p>
          這裡是文字
        </p>
        <h4>這裡是標題</h4>
        <li>
          <span>
            標籤:
          </span>
            標籤內文
        </li>
        <br>
        <p>
          文字部分
        </p>
        <!--有需要加上第二 三段-->        
        <br>
        <p>
          總結文字
        </p>
        <br>
        <p>
          <span>
            以上是智慧財產權的基本認知，如果您對某個特定電影台詞是否受到保護，或有相關疑問，歡迎跟我們諮詢!
          </span>
        </p>
      `,
    }
  },
  methods:{
    LawClassClick(event){
      if(this.LawClass.includes(event)){
        this.LawClass = this.LawClass.filter(item =>item !== event);
      }else{
        this.LawClass.push(event);
      }
      // console.log('LawClass:', ...this.LawClass);  //<--debug用 別刪
    },
    LawBannerImageUpload(event){
      this.LawBannerImage = event.target.files[0];
      this.BannerImageName = this.LawBannerImage ?this.LawBannerImage.name : '';
    },
    triggerBannerFileInput(){
      this.$el.querySelector('.fileInputBanner').click();
    },
    LawBigImageUpload(event){
      this.LawBigImage = event.target.files[0];
      this.BigimageName = this.LawBigImage ?this.LawBigImage.name : '';
    },
    triggerBigFileInput(){
      this.$el.querySelector('.fileInputBigImage').click();
    },
    submitLawWriting(){
      const formData = new FormData();
      formData.append('LawTitle', this.LawTitle);
      formData.append('LawClass', this.LawClass.join(','));
      formData.append('LawText', this.LawText);
      formData.append('LawTextPoint', this.LawTextPoint);
      if(this.LawBannerImage){
        formData.append('LawBannerImage', this.LawBannerImage);
      }
      if(this.LawBigImage){
        formData.append('LawBigImage', this.LawBigImage);
      }
      fetch(`${this.$apiurl}/api/AddLawWriting.php`,{
        method:'POST',
        body:formData
      })
      .then(Response => Response.json())
      .then(data => {
        if(data.success){
          localStorage.setItem('successMessage', `${data.message}`);
          this.$router.push('/BackStage/LawPage');
          this.$bus.$emit('fetchLaw');
        }else{
          this.$bus.$emit('setErrorMessage', `${data.message}`);
        }
      })
      .catch(error =>{
        this.$bus.$emit('setErrorMessage', `${error}`);
      })
    },
    goBack() {
      this.$router.go(-1);
    }
  }
 
}
</script>

<style scoped>
.ActiveLawBtn{
  background-color: #162d3d;
  color: #ffff;
  transition: background-color 0.2s;
}
.ActiveLawBtn:hover{
  background-color: #5f6375;
}
</style>
