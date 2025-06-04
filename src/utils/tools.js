import { computed, onMounted } from "vue";
import { useStore } from "vuex";

export const getIMGUrl = (apiUrl, location, filename) => {
  return filename && apiUrl ? `${apiUrl}/src/assets/${location}/${filename}` : '';
};

export const getRGB = (colorString) =>{
      if(!colorString) return 'rgb(0, 0, 0)';
      const match = colorString.match(/\d+,\s*\d+,\s*\d+/);
      return match ? match[0] : 'rgb(0, 0, 0)';
    } 

export const computedStyleVars = (imgGetter = () => '') =>{
  const store = useStore();
  onMounted(()=>{
    store.dispatch('WebsiteInformation/fetchDetails');
  })
  const colorInfo = computed(()=>
    store.getters['WebsiteInformation/getColor']
  )

  return computed(() =>{
    const Info = colorInfo.value;
    const style =  {
      '--main-color-rgb': Info.mainColor,
      '--secondary-color-rgb': Info.secondaryColor,
      '--third-color-rgb': Info.thirdColor,
      '--fourth-color-rgb': Info.fourthColor,
    };

    const imgUrl = imgGetter();
    if(imgGetter){
      style['--bg-url'] = `url(${imgUrl})`
    }
    
    return style;
  })
}