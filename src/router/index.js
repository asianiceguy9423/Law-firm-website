import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: '/',
    redirect: '/', // 重定向到 Home
  },
  {
    path:'/',
    name:'FrontStage',
    component: () => import('../components/FrontStage/FrontStage.vue'),
    children:[
      {path:'//',
        name:'HomePage',
        component: () => import('../components/FrontStage/Home/Home.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
      {path:'About',
        name:'AboutPage',
        component: () => import('../components/FrontStage/About/About.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
      {path:'Articles/:number',
        name:'ArticlesPage',
        component: () => import('../components/FrontStage/Articles/Articles.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
      {path:'Articles/:number/ArticlesWrok/:id',
        name:'ArticlesWork',
        component: () => import('../components/FrontStage/Articles/ArticlesWork.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
      {path:'Join',
        name:'JoinPage',
        component: () => import('../components/FrontStage/Join/Join.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
      {path:'Contact',
        name:'ContactPage',
        component: () => import('../components/FrontStage/Contact/Contact.vue'),
        meta: {
          title: '諮詢事務所'
        }
      },
    ]
  },
  {
    path: "/Login",
    name: 'Login',
    component: ()=> import('../components/BackStage/Login.vue'),
    meta: {
      title: '後台登入-諮詢事務所'
    }
  },
  {
    path: "/BackStage",
    name: 'BackStage',
    component: ()=> import('../components/BackStage/BackStage.vue'),
    children:[
      {path:'/BackStage/Home',
        name:'HomeSetting',
        component: () => import('../components/BackStage/Home/Home.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/About',
        name:'AboutSetting',
        component: () => import('../components/BackStage/About/About.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/About/MemberAdd',
        name:'AboutMemberAdd',
        component: () => import('../components/BackStage/About/AboutMemberAdd.vue'),
        meta: {
          title:'後台設定_新增人員'
        }
      },
      {path:'/BackStage/About/MemberEdit/:id',
        name:'AboutMemberUpdate',
        component: () => import('../components/BackStage/About/AboutMemberUpdate.vue'),
        meta: {
          title:'後台設定_編輯人員'
        },
        props: (route) =>({
          id:route.params.id,
        }),
      },
      {path:'/BackStage/Article',
        name:'ArticleSetting',
        component: () => import('../components/BackStage/Article/Article.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/Article/ArticleOptionEdit/:number',
        name:'ArticleOptionEdit',
        component: () => import('../components/BackStage/Article/ArticleOptionEdit.vue'),
        meta: {
          title:'後台設定_編輯分類'
        },
        props: true
      },
      {path:'/BackStage/Article/ArticleAdd',
        name:'ArticleAdd',
        component: () => import('../components/BackStage/Article/ArticleAllArticlesAdd.vue'),
        meta: {
          title:'後台設定-新增文章'
        },
      },
      {path:'/BackStage/Article/ArticleEdite/:id',
        name:'ArticleEdite',
        component: () => import('../components/BackStage/Article/ArticleAllArticlesEdite.vue'),
        meta: {
          title:'後台設定_編輯文章'
        },
        props: true
      },
      {path:'/BackStage/Join',
        name:'JoinSetting',
        component: () => import('../components/BackStage/Join/Join.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/Contact',
        name:'ContactSetting',
        component: () => import('../components/BackStage/Contact/Contact.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/Contact/ContactInfoEdit/:id',
        name:'ContactInfoEdit',
        component: () => import('../components/BackStage/Contact/ContactInfoEdit.vue'),
        meta: {
          title:'後台設定_編輯資訊'
        },
        props: (route) =>({
          id:route.params.id,
        }),
      },
      {path:'/BackStage/Contact/InfoAdd',
        name:'ContactAdd',
        component: () => import('../components/BackStage/Contact/ContactInfoAdd.vue'),
        meta: {
          title:'後台設定_新增資訊'
        }
      },
      {path:'/BackStage/BasicInfo',
        name:'BasicInfoSetting',
        component: () => import('../components/BackStage/BasicInfo/BasicInfo.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/StoreInfo',
        name:'StoreInfoSetting',
        component: () => import('../components/BackStage/BasicInfo/BasicStoreInfo.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/UserData',
        name:'UserDataSetting',
        component: () => import('../components/BackStage/UserData/UserData.vue'),
        meta: {
          title:'後台設定'
        }
      },
      {path:'/BackStage/UserData/CheckPassword',
        name:'UserDataCheckPassword',
        component: () => import('../components/BackStage/UserData/UserDataCheckPassword.vue'),
        meta: {
          title:'後台設定-確認密碼'
        }
      },
      {path:'/BackStage/UserData/UserDataChangePassword',
        name:'UserDataChangePassword',
        component: () => import('../components/BackStage/UserData/UserDataChangePassword.vue'),
        meta: {
          title:'後台設定-重設密碼'
        }
      },
    ]
  }
];

const router = createRouter({
  history: createWebHistory(), // 使用 HTML5 模式
  routes,
});

router.afterEach((to) => {
  const defaultTitle = '諮詢事務所';
  document.title = to.meta.title || defaultTitle;
});

export default router;