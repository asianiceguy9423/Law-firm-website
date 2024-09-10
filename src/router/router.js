import Vue from "vue"
import Router from "vue-router"
import Cookies from "js-cookie"
import AbouPageThreeAdd from "../components/AbouPageThreeAdd.vue"
import AbouPageThreeUpdate from "../components/AbouPageThreeUpdate.vue"
import JoinPage from "../components/JoinPage.vue"
import ContactPage from "../components/ContactPage.vue"
import ContactInformationAdd from "../components/ContactInformationAdd.vue"
import ContactInformationUpdate from "../components/ContactInformationUpdate.vue"
import HomePage from "../components/HomePage.vue"
import HomePageTwoAdd from "../components/HomePageTwoAdd.vue"
import HomePageTwoUpdate from "../components/HomePageTwoUpdate.vue"
import LawPage from "../components/LawPage.vue"
import LawImprintAdd from "../components/LawImprintAdd.vue"
import LawImprintAddUpdate from "../components/LawImprintAddUpdate.vue"
import LoginPage from "@/components/LoginPage.vue"
import UserData from "@/components/UserData.vue"
import BackStage from "@/components/BackStage.vue"
import AbouPage from "@/components/AbouPage.vue"
import BasicInformation from "@/components/BasicInformation.vue"

import FrontStage from "../components/Front/FrontStage.vue"
import FrontHomePage from "../components/Front/FrontHomePage.vue"
import FrontAboutPage from "../components/Front/FrontAboutPage.vue"
import FrontJoinPage from "../components/Front/FrontJoinPage .vue"
import FrontConnectionPage from "../components/Front/FrontConnectionPage.vue"
import FrontLawTransportation from "../components/Front/FrontLawTransportation.vue"
import FrontLawWritings from "@/components/Front/FrontLawWritings.vue"
import FrontLawPatent from "@/components/Front/FrontLawPatent.vue"
import FrontLawLabor from "@/components/Front/FrontLawLabor.vue"
import FrontLawCivil from "@/components/Front/FrontLawCivil.vue"
import FrontLawCriminal from "@/components/Front/FrontLawCriminal.vue"

Vue.use(Router)

const router = new Router({
  mode: 'history',
  routes:[
    {path:'/LoginPage',
      name:'LoginPage',
      component:LoginPage,
    },
    {path:'/BackStage',
      name:'BackStage',
      component:BackStage,
      children:[
        {path:'/BackStage/AboutPage',
          name:'AboutPage',
          component:AbouPage,
        },
        {path:'/BackStage/AbouPageThreeAdd',
          name:'AbouPageThreeAdd',
          component:AbouPageThreeAdd,
        },
        {path:'/BackStage/AbouPageThreeUpdate/:id',
          name:'AbouPageThreeUpdate',
          component:AbouPageThreeUpdate,
        },
        {path:'/BackStage/JoinPage',
          name:'JoinPage',
          component:JoinPage,
        },
        {path:'/BackStage/ContactPage',
          name:'ContactPage',
          component:ContactPage,
        },
        {path:'/BackStage/ContactInformationAdd',
          name:'ContactInformationAdd',
          component:ContactInformationAdd,
        },
        {path:'/BackStage/ContactInformationUpdate/:id',
          name:'ContactInformationUpdate',
          component:ContactInformationUpdate,
        },
        {path:'/BackStage/HomePage',
          name:'HomePage',
          component:HomePage,
        },
        {path:'/BackStage/HomePageTwoAdd',
          name:'HomePageTwoAdd',
          component:HomePageTwoAdd,
        },
        {path:'/BackStage/HomePageTwoUpdate/:id',
          name:'HomePageTwoUpdate',
          component:HomePageTwoUpdate,
        },
        {path:'/BackStage/LawPage',
          name:'LawPage',
          component:LawPage,
        },
        {path:'/BackStage/LawImprintAdd',
          name:'LawImprintAdd',
          component:LawImprintAdd,
        },
        {path:'/BackStage/LawImprintAddUpdate/:id',
          name:'LawImprintAddUpdate',
          component:LawImprintAddUpdate,
        },        
        {path:'/BackStage/UserData',
          name:'UserData',
          component:UserData,
        },
        {
          path:'/BackStage/BasicInformation',
          name:'BasicInformation',
          component:BasicInformation,
        }
      ]
    },
    {path:'/FrontStage',
      name:'FrontStage',
      component:FrontStage,
      children:[
        {path:'//',
          name:'FrontHomePage',
          component:FrontHomePage,
        },
        {path:'/About',
          name:'FrontAboutPage',
          component:FrontAboutPage,
        },
        {path:'/Join',
          name:'FrontJoinPage',
          component:FrontJoinPage,
        },
        {path:'/Connection',
          name:'FrontConnectionPage',
          component:FrontConnectionPage
        },
        {path:'/Transportation',
          name:'FrontLawTransportation',
          component:FrontLawTransportation
        },
        {path:'/LawWritings/:id',
          name:'FrontLawWritings',
          component:FrontLawWritings,
        },
        {path:'/Patent',
          name:'FrontLawPatent',
          component:FrontLawPatent,
        },
        {path:'/Labor',
          name:'FrontLawLabor',
          component:FrontLawLabor,
        },
        {path:'/Civil',
          name:'FrontLawCivil',
          component:FrontLawCivil,
        },
        {path:'/Criminal',
          name:'FrontLawCriminal',
          component:FrontLawCriminal,
        },
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  const publicPages = ['/LoginPage'];
  const authRequired = !publicPages.includes(to.path) && to.path.startsWith('/BackStage');
  const sessionId = Cookies.get('sessionId');

  if (authRequired && !sessionId) {
    return next('/LoginPage');
  }
  next();
});

export default router;