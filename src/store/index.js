import { createStore } from 'vuex';
import { WebsiteInformation } from './WebsiteInformation';
import { HomeStore } from './HomeStore';
import { AboutStore } from './AboutStore';
import { UserLoginStore } from './UserLoginStore';
import { JoinStore } from './JoinStore';
import { AboutMemberStore } from './AboutMemberStore';
import { ContactStore } from './ContactStore';
import { ArticleStore } from './ArticleStore';
import { ArticlesFuturerReleaseStore } from './ArticlesFuturerReleaseStore';
import { NavbarStore } from './NavbarStore';

// 定義一個工廠函數來初始化 store
export const createCustomStore = (apiUrl) => {
  return createStore({
    modules: {
      WebsiteInformation:           WebsiteInformation(apiUrl), // 傳遞 apiUrl 作為參數
      HomeStore:                    HomeStore(apiUrl),
      AboutStore:                   AboutStore(apiUrl),
      UserLoginStore:               UserLoginStore(apiUrl),
      JoinStore:                    JoinStore(apiUrl) ,
      AboutMemberStore:             AboutMemberStore(apiUrl),
      ContactStore:                 ContactStore(apiUrl),
      ArticleStore:                 ArticleStore(apiUrl),
      ArticlesFuturerReleaseStore:  ArticlesFuturerReleaseStore(apiUrl),
      NavbarStore:                  NavbarStore(),
    },
  });
};
