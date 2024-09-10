<template>
  <div>
    <nav>
        <ul>
          <router-link 
          :class="{ active: selectedItem.includes('home') }" @click.native="selectItem('home')"
          to="/BackStage/HomePage"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'house']" size="xs" />
            </span>
            首頁
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('about') }" @click.native="selectItem('about')"
          to="/BackStage/AboutPage"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'house']" size="xs" />
            </span>
            關於我們
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('legal') }" @click.native="selectItem('legal')"
          to="/BackStage/LawPage"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'gavel']"  size="xs"/>
            </span>          
            法律資訊
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('join') }" @click.native="selectItem('join')"
          to="/BackStage/JoinPage"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'person-walking']" />
            </span>          
            加入老周
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('contact')}" @click.native="selectItem('contact')"
          to="/BackStage/ContactPage"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'phone']"  size="xs"/>
            </span>聯絡我們
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('basicinformation')}" @click.native="selectItem('basicinformation')"
          to="/BackStage/BasicInformation"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'circle-info']"  size="xs"/>
            </span>店家基本資訊
          </router-link>

          <router-link 
          :class="{ active: selectedItem.includes('userdata')}" @click.native="selectItem('userdata')"
          to="/BackStage/UserData"
          class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'database']"  size="xs"/>
            </span>後台管理
          </router-link>

          <div @click="logout" class="li-router">
            <span class="IconSpan">
              <font-awesome-icon :icon="['fas', 'right-from-bracket']"  size="xs"/></span>
              登出
          </div>        
        </ul>
      </nav>
  </div>
</template>

<script>
import axios from 'axios';
import Cookies from 'js-cookie';
export default {
  name: 'NavBar',
  data() {
    return {
      selectedItem: ['home'],
    };
  },
  methods: {
    selectItem(item) {
        this.selectedItem = [item];
    },
    logout(){
      axios.post(`${this.$apiurl}/api/Logout.php`)
      .then(() =>{
          Cookies.remove('sessionId');
          this.$router.push('LoginPage');
      })
    }
  }
}
</script>

<style scoped>
nav{
  position: fixed;
  display: flex;
  flex-direction: column;
  height: 100vh;
  width: 250px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
}
.li-router{
  display: flex;
  align-items: center;
  width: 200px;
  padding: 8px 0;
  padding-left: 50px;
  position: relative;
}
li{
  padding: 15px 0;
  padding-left: 50px;
}
li:hover,
.li-router:hover,
.full-link:hover{
  cursor: pointer;
  color: rgb(214, 185, 105);
  transition: 0.4s;
  background-color: rgba(0, 0, 0, 0.2);
}
.full-link{
  padding: 15px 0;
  padding-left: 65px;
  font-size: 14px;
  display: flex;
  background-color: rgba(0, 0, 0, 0.4);
}
.active {
  color: rgb(214, 185, 105);
  background-color: rgba(0, 0, 0, 0.4);
}
.active:hover {
  background-color: rgba(0, 0, 0, 0.4);
}
.IconSpan{
  margin-bottom: 9px;
  margin-right: 12px;
  margin-top: 9px;
  transition: transform 0.5s;
}
.IconSpanPoint{
  margin-top: 12px;
  float: right;
  position: absolute;
  right: 0;
}
.rotate {
  transform: rotate(-90deg);
}
@media(max-width: 1250px){
nav{
  display: none;
}
}

</style>