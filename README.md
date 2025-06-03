# 諮詢事務所網站

前台:[http://laucho.atwebpages.com/](http://simulation4516423.medianewsonline.com/)
<br>
後台:[http://laucho.atwebpages.com/LoginPage](http://simulation4516423.medianewsonline.com/Login)
<br>
(帳號:zzz密碼:zzz)
<br>
本專案為模擬法律諮詢事務所網站，作為全端開發作品之一，展示本人於 Vue.js 及相關前後端技術的整合與實作能力。整體設計著重於專業形象、良好的使用者體驗與響應式介面，確保網站在各類裝置上皆具備一致且流暢的操作體驗。
<hr>

### 使用技術
- **前端框架:**  採用 Vue 3 作為核心框架，搭配 Composition API 編寫邏輯結構，透過 Vuex 實現全站狀態管理，並結合 SCSS 提升樣式的可維護性與彈性。
- **後端與資料庫:** 以 PHP 作為後端語言，連接 MySQL 資料庫，實現前後端分離架構，優化資料傳輸效率並提升系統擴展性與開發靈活度。
- **動態網站:** 前台所有圖片與文字內容皆由資料庫動態載入，透過後台管理即可即時更新，實現內容維護的高彈性。
- **數據請求:** 全站資料統一由 Vuex 管理，並透過 Vuex 的 actions 搭配 Axios 向後端 PHP API 發送請求，以執行資料的讀取與提交，確保前台內容的即時同步與一致性。
- **響應式設計:** 前後台網站皆採用響應式設計，確保在各種裝置（如桌面、平板及手機）上都有良好的使用體驗。
- **安全性防護:** 後端實作多重防護機制，包括將用戶輸入轉換為純文字以防止 XSS 與 SQL 注入攻擊；登入機制則透過比對瀏覽器 Cookie 中的 Session ID 與資料庫中所儲存的 Session ID，若不一致即強制登出，確保後台存取安全。
- **惰加載:** 網站圖片皆採用惰性加載技術，僅在即將進入視窗範圍時才載入，藉此有效降低初始載入資源，提升頁面載入效率與使用者體驗。
<hr>

### 專案特色
- 黑金配色結合精緻版面，營造專業形象，凸顯專業與清晰的瀏覽體驗。
- 後台設計強調清楚的導航與適當間距，操作直觀，提升管理效率。
- 從配色、字體到動畫細節皆統一設計，強化品牌形象與用戶信任。
- 支援即時更新圖片、文字與標題，後台操作靈活便捷。
- 採用響應式設計，無論桌機或手機皆能自適應顯示，確保一致體驗。
- 頁腳整合社群連結，方便用戶互動，提升黏著度。
- 提供 LINE 快速聯繫功能，方便即時溝通。
- 更換或刪除圖片時，系統將同步移除資料庫對應資料，確保整體一致性。
- 載入期間顯示 Loading 畫面，避免異常顯示，提升整體使用體驗。

### 網站操作
- 前台架構圖
![工作區域 1](https://github.com/user-attachments/assets/6a8b5fa1-f9c1-45f6-8e36-04a4ee78799a)
- navbar
![navbarshow](https://github.com/user-attachments/assets/b2e1f9d6-ce01-4c36-b75c-784755ec64fe)
- 至頂按鈕
![home5](https://github.com/user-attachments/assets/260cecbe-c096-49c8-b7d1-1ae015032db7)
- 首頁操作
![home1](https://github.com/user-attachments/assets/3a542d15-4866-488c-9717-72278f862b6c)
![home2](https://github.com/user-attachments/assets/e1681a46-c46c-422c-a4e6-b4f02fc4a7de)
![home3](https://github.com/user-attachments/assets/0452bff5-0540-4f07-9013-781332e21a39)
- 前台響應式設計
![前臺響應式](https://github.com/user-attachments/assets/90252ce9-aa6b-4586-8e67-562b392444eb)
![前臺響應式_navbar](https://github.com/user-attachments/assets/98944d17-53f2-4d1e-b2eb-86e8dda1c8b6)

- 後台架構圖  
![工作區域 1 複本](https://github.com/user-attachments/assets/3b25fdb3-c540-4462-8209-14ff53fcbbb9)
- 後台燈入
![登入畫面](https://github.com/user-attachments/assets/3f7e4c55-907a-4619-a01f-48cff8d8e818)
- 操作新增
![人員新增](https://github.com/user-attachments/assets/111df59a-b3dd-49b1-a359-b2699e844d94)
- 操作編輯
![人員編輯](https://github.com/user-attachments/assets/22eae008-9b8f-49f2-9185-f7d00b240ac9)
- 操作刪除
![人員刪除](https://github.com/user-attachments/assets/dd976688-140b-446e-a95a-11fedb43cfc2)
- 操作變更前台頁尾資訊
![footer演示](https://github.com/user-attachments/assets/24d03eb4-f239-448c-b483-115c91ff36c9)
- 更換帳號及密碼
![更換帳號](https://github.com/user-attachments/assets/9b0c4e48-5151-4121-a88a-616bfb39f1ca)
![更換密碼](https://github.com/user-attachments/assets/61dca9c0-5ba4-4d18-85c6-d8bb84a822b8)
- 後台響應式設計
![後臺響應式](https://github.com/user-attachments/assets/569f116a-8ec9-4408-891b-876e105ada28)
