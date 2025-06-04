<template>
  <div class="loginPageRef" ref="loginPageRef">
    <form @submit.prevent="login">
      <div class="operate_part">
        <div>
          <h1>登入</h1>
          <h2>歡迎使用後台操作系統</h2>
        </div>

        <div class="user_input">
          <div 
            class="error_message"
            v-if="errorMessage"
          >{{ errorMessage }}</div>

          <div class="username_and_password__box">
            <div>
              <label for="username">帳號</label>
              <input 
                v-model="username" 
                type="text" 
                id="username" 
                required
              >
            </div>

            <div>
              <div class="passwoed_and_forget_message">
                <label for="password">密碼</label>
                <div class="forget_password_box">
                  <div class="forget_password_message">
                    <p>請盡快聯繫主管單位</p>
                    <div class="forgert_password_message_triangle"></div>
                  </div>
                  <p class="forget_message_warn">忘記密碼?</p>
                </div>
              </div>

              <div class="password_input_box">
                <input 
                  v-model="password"
                  :type="passwordVisibility ? 'text' : 'password'" 
                  id="password" 
                  required
                >
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  height="14" 
                  width="18" 
                  viewBox="0 0 576 512"
                  @click="togglePasswordVisibility"
                  v-if="!passwordVisibility"
                >
                  <path fill="currentColor" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                </svg>
                <svg 
                  xmlns="http://www.w3.org/2000/svg" 
                  height="14" 
                  width="18" 
                  viewBox="0 0 640 512"
                  @click="togglePasswordVisibility"
                  v-if="passwordVisibility"
                >
                  <path fill="currentColor" d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/>
                </svg>
              </div>
            </div>
          </div>
          
        </div>

        <button type="submit">登入</button>
      </div>

      <div class="image_box">
        <img :src="LoginIMG" class="parallax-image" ref="parallaxImage">
      </div>
    </form>
  </div>
</template>

<script>
import { computed, inject, onMounted, onUnmounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

export default {
  setup() {
    const apiUrl = inject('apiUrl');

    //獲取圖片
    const LoginIMG = computed(() => 
      `${apiUrl}/src/assets/basic/Mobile_login.svg`
    )
    //圖片晃動效果
    const loginPageRef = ref(null); 
    const parallaxImage = ref(null); 
    let frameId = null;

    const handleMouseMove = (e) => {
      if (frameId) return; // 若上一個 requestAnimationFrame 還沒完成，就跳過

      frameId = requestAnimationFrame(() => {
        frameId = null; // 清空 ID
        const image = parallaxImage.value;
        if (!image) return;

        const speed = 20;
        const x = (loginPageRef.value.clientWidth / 2 - e.clientX) / speed;
        const y = (loginPageRef.value.clientHeight / 2 - e.clientY) / speed;

        image.style.transform = `translate(${x}px, ${y}px)`;
      });
    };
    onMounted(() => {
      if (loginPageRef.value) {
        loginPageRef.value.addEventListener('mousemove', handleMouseMove);
      }
    })
    onUnmounted(() => {
      if (loginPageRef.value) {
        loginPageRef.value.removeEventListener('mousemove', handleMouseMove);
      }
    })

    //password顯示設定
    const passwordVisibility = ref(false);
    const togglePasswordVisibility = () => {
      passwordVisibility.value =! passwordVisibility.value;
    }

    //送出表單
    const store = useStore();
    const router = useRouter();

    const username = ref('');
    const password = ref('');
    const errorMessage = ref('');

    const login = async () =>{
      errorMessage.value = ''; // 清空錯誤訊息
      if(!username.value || !password.value) {
        errorMessage.value = '請輸入帳號和密碼';
        return;
      }

      const response = await store.dispatch('UserLoginStore/login', {
        username: username.value,
        password: password.value,
      });

      if(response.success) {
        // console.log('登入成功');
        await new Promise(resolve => setTimeout(resolve, 300));
        router.push('/BackStage/Home')
      } else {
        errorMessage.value = response.message;
      }
    }

    return{
      LoginIMG,
      loginPageRef,
      parallaxImage,
      togglePasswordVisibility,
      passwordVisibility,
      username,
      password,
      errorMessage,
      login,
    }
  }
}
</script>

<style lang="scss" scoped>
label{
  display: flex;
  font-size: 18px;
  font-weight: 400;
  margin-bottom: 4px;
}
input{
  width: 100%;
  height: 30px;
}

.loginPageRef{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  box-sizing: border-box;

  form{
    display: flex;
    align-items: center;
    box-sizing: border-box;

    .operate_part{
      display: block;
      width: 500px;
      height: auto;
      padding: 40px;
      border-radius: 10px;
      box-sizing: border-box;
      box-shadow:  2px 2px 8px 2px rgba(0, 0, 0, 0.1);

      div{
        h2{
          font-size: 16px;
          font-weight: normal;
        }
      }
      .user_input{
        padding: 20px 0;

        .error_message{
          text-align: right;
          color: red;
          font-size: 14px;
        }

        .username_and_password__box{
          display: flex;
          flex-direction: column;
          row-gap: 16px;

          div{
            .passwoed_and_forget_message{
              display: flex;
              justify-content: space-between;
              align-items: center;

              .forget_password_box{
                display: flex;
                justify-content: center;

                .forget_password_message{
                  position: absolute;
                  margin-top: -44px;
                  display: none;
                  flex-direction: column;
                  align-items: center;

                  p{
                    font-size: 14px;  
                    color: #fff;
                    background-color: #162d3d;
                    padding: 4px 8px;
                    border-radius: 6px;  
                  }
                  .forgert_password_message_triangle{
                    width: 0;
                    height: 0;
                    border-left: 8px solid transparent;
                    border-right: 8px solid transparent;
                    border-top: 8px solid #162d3d;
                  }
                }
                .forget_message_warn{
                  font-size: 14px;
                  line-height: 1;
                  margin-bottom: 4px;
                  cursor: pointer;
                  position: relative;
                }
                .forget_message_warn:hover{
                  border-bottom: 1px solid;
                }
              }
              .forget_password_box:hover .forget_password_message{
                display: flex;
              }
            }
            .password_input_box{
              position: relative;

              svg{
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
              }
            }

          }
        }
      }
    }
    button{
      width: 100%;
      font-size: 16px;
      text-align: center;
      padding: 10px;
      background-color: #5999ff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: 0.2s;
    }
    button:hover{
      background-color: #116dff;
    }
    .image_box{
      position: relative;
      overflow: hidden; /* 確保圖片不會移動到容器外部 */

      img{
        position: relative;
        transition: transform 0.1s ease-out;
        width: 600px;
        height: auto;
      }
    }
  }
}
@media (max-width:1250px) {
  form{
    width: 80% !important;
    justify-content: center !important;
  }
  .image_box{
    display: none !important;
  }
}

</style>