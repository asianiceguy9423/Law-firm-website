<template>
  <div class="IsLoading">
    <div class="loadingio-spinner-eclipse-2by998twmg8">
      <div class="ldio-yzaezf3dcmj">
        <div></div>
      </div>
    </div>
    <h1>讀取中...</h1>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.IsLoading{
  position: fixed;
  display: flex;
  height: 100vh;
  width: 100%;
  justify-content: center;
  align-items: center;
  background-color: white;
  z-index: 2000;
}
h1{
  font-size: 32px;
  color: rgb(66, 66, 66);
}
@keyframes ldio-yzaezf3dcmj {
  0% { transform: rotate(0deg) }
  50% { transform: rotate(180deg) }
  100% { transform: rotate(360deg) }
}
.ldio-yzaezf3dcmj div {
  position: absolute;
  animation: ldio-yzaezf3dcmj 1s linear infinite;
  width: 104px;
  height: 104px;
  top: 13px;
  left: 13px;
  border-radius: 50%;
  box-shadow: 0 4px 0 0 #1d3f72;
  transform-origin: 52px 53.300000000000004px;
}
.loadingio-spinner-eclipse-2by998twmg8 {
  width: 130px;
  height: 130px;
  display: inline-block;
  overflow: hidden;
  background: none;
}
.ldio-yzaezf3dcmj {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(1);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-yzaezf3dcmj div { box-sizing: content-box; }
</style>