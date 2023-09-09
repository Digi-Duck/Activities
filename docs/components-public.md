# 《Public》組件說明文件

## Editor組件使用說明：
* 在要放置組件的地方插入
  ```html
  <Editor
    editor-data="編輯文本的內容(string, 必填)"
    editor-option="編輯器的其他設定(object, 選填)"
    editor-id="該編輯器的代號(string, 選填)"
    img-upload-dir="上傳圖片所放的資料夾(string, 選填)"
    img-upload-url="上傳圖片的路徑(string, 選填)"
    @update-content="回傳更新後的文本及編輯器的代號(string, string)"
  />
  ```
  >**editor-option傳入物件的設定如下：**
  ```js
  {
    image: 是否能夠插入圖片(boolean, 預設值: false),
    media: 是否能夠插入影片(boolean, 預設值: false),
    resize: 是否能夠自行調整編輯器大小(boolean, 預設值: false),
    code: 是否能夠修改原始碼(boolean, 預設值: false),
  }
  ```
---

## Pagination組件使用說明：
* 在要放置組件的地方插入：
  ```html
  <Pagination
    pagination-data="後端傳過來的分頁資料，注意分頁資料是指物件內有帶total、current_page、per_page三個參數(object, 必填)"
    other-param="換頁時要帶的其他參數(object, 選填)"
    keep-state="換頁時是否保持狀態(boolean, 選填)"
  />
  ```
  >**※使用範例：**
  ```js
  computed: {
    // 後端傳來的分頁資料
    paginationData() {
      return this.response?.rt_data ?? {};
    },
  },
  ```
  ```html
  <Pagination :pagination-data="paginationData" />
  ```
---

## Swiper組件使用說明：
* 在要放置組件的地方插入：
  ```html
  <Swiper
    v-slot="{ slide }"
    slide-data="輪播的資料陣列(any[], 必填)"
    slides-per-view="每頁要呈現的資料數量(number, 選填, 預設3)"
    space-between="每筆資料間的間距(number, 選填, 預設50)"
    autoplay="自動撥放(boolean, 選填)"
    pagination-el="分頁容器的dom(選填)"
    bullet-class="分頁按鈕的tailwind樣式(選填)"
    bullet-active-class="分頁按鈕被選擇時的class名稱(選填)"
    btn-prev="向上一張滑動按鈕的dom(選填)"
    btn-next="向下一張滑動按鈕的dom(選填)"
  >
    <div>
      自由使用每筆資料的空間，slide為輪播的資料陣列的每一筆，以下為範例
      <div>{{ slide }}</div>
      <img :src="slide.img" alt="產業類別圖片">
    </div>
  </Swiper>
  ```
  >**※如要使用導航按鈕則需要綁定按鈕的dom**
  ```html
  <button ref="btnPrev" type="button">Prev</button>
  <button ref="btnNext" type="button">Next</button>
  <Swiper :btn-prev="$refs.btnPrev" :btn-next="$refs.btnNext"></Swiper>
  ```

  >**※如要使用分頁則需要綁定分頁容器的dom及分頁按鈕的樣式**
  ```html
  <Swiper
    :pagination-el="$refs.paginationEl"
    bullet-class="w-[20px] h-[20px] bg-red-500"
    bullet-active-class="custom-bullet-active"
  ></Swiper>
  <div ref="paginationEl"></div>
  ```
  ```css
  :global(.custom-bullet-active) {
    @apply bg-blue-500;
  }
  ```
---
