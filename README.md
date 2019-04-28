# Web
Markdown語法: https://ithelp.ithome.com.tw/articles/10203758?sc=iThelpR
Web Design 網頁設計
### pic/ : logo放置地點
### uploads/ : 新增商品資料放置地點
# new.html : 上架商品主頁面
## connect_sql.php : 連線到製商中心的主機資料庫
## connect_zhbot.php : 將uploads下的PlainInfo.html資訊加入資料庫中
## Duplicate.php : 判斷資料庫中是否有重複資料
## myUpload.php : 上傳商品資訊到uploads/以創建日期時間作為資料夾放入商品詳細資訊和照片 並將PlainInfo.html複製到uploads底下
## Review.php : 審查頁面
## Review_to_check.php : 審查結果 1=通過 2=駁回
