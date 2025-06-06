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
- **視覺設計:**  採用黑金配色結合精緻排版，營造高端、專業的品牌形象，提升使用者的第一印象與信任感。
- **後台介面:**  導覽清楚、間距適當，操作直覺流暢，提升管理效率與使用體驗。
- **整體一致性:** 從配色、字體到動畫細節皆統一設計，強化視覺連貫性與品牌辨識度。
- **內容更新:** 支援後台即時編輯圖片、文字與標題，讓網站維護更加靈活方便。
- **響應式體驗:** 採用響應式設計，網站可自動適應桌機、平板與手機，提供一致的瀏覽體驗。
- **互動設計:** 頁腳整合社群連結與 LINE 快速聯繫按鈕，提升使用者互動性與網站黏著度。
- **資料同步:** 更換或刪除圖片時，系統會同步更新資料庫，確保內容一致、不留殘留資料。
- **載入優化:** 網站載入時顯示 Loading 畫面，避免內容閃現或異常顯示，提升整體使用體驗。

### 網站操作
- 前台架構圖
![工作區域 1](https://github.com/user-attachments/assets/6a8b5fa1-f9c1-45f6-8e36-04a4ee78799a)
- navbar
![navbar ](https://github.com/user-attachments/assets/ce232cba-eb31-43a5-b812-ea44aae2698b)
- 至頂按鈕
![至頂按鈕](https://github.com/user-attachments/assets/3da2b942-9874-4778-b9c0-f2de30fadfe2)
- 首頁操作
![首頁操作_01](https://github.com/user-attachments/assets/b151bb64-10be-4d61-a7e5-e0a46bb524f2)
![首頁操作_02](https://github.com/user-attachments/assets/9c54e1a3-d33a-4190-addc-75fca7289eb4)
![首頁操作_03](https://github.com/user-attachments/assets/87a34fc3-953a-41ed-b09d-c50853802986)
- 前台響應式設計
![前台響應式設計_01](https://github.com/user-attachments/assets/bb608d31-0671-4992-824b-db76d91b3c7a)
![前台響應式設計_02](https://github.com/user-attachments/assets/b973baa1-fa1b-4069-978c-1a0a8d6d9f88)

- 後台架構圖  
![工作區域 1 複本](https://github.com/user-attachments/assets/3b25fdb3-c540-4462-8209-14ff53fcbbb9)
- 後台燈入
![後台燈入](https://github.com/user-attachments/assets/d4045718-4433-4dd9-a652-189e1113882b)
- 操作新增
![操作新增_01](https://github.com/user-attachments/assets/477cec28-9350-41b9-a9af-051147393d07)
- 操作編輯
![操作編輯_01](https://github.com/user-attachments/assets/db9898b4-885c-4c01-bf13-bd4dc8f3b9e6)
![操作編輯_02](https://github.com/user-attachments/assets/13e49015-026b-4cd0-a0b8-515e3efbc1a4)
![操作編輯_03](https://github.com/user-attachments/assets/f8063f23-f59b-4edc-a0a5-9021429d9cad)
- 操作刪除
![操作刪除_01](https://github.com/user-attachments/assets/950adcf0-8dcc-474f-a544-eb7cdea7b2c4)
- 變更頁尾資訊
![變更頁尾資訊_01](https://github.com/user-attachments/assets/29469e5a-e098-479a-a8fb-0ab1dd7a32d3)
- 更換密碼
![更換密碼](https://github.com/user-attachments/assets/5e0a1206-a045-4478-9040-588ed4e099f5)
- 後台響應式設計
![後台響應式設計](https://github.com/user-attachments/assets/24bac9e0-d48e-4f7c-98a1-fa9ffaa57b66)
