<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>チャット</title>
</head>
 
<body>
     
 
 
<h1>チャット</h1>
   
 
 
<form method="post" action="chat.php">
        名前　　　　<input type="text" name="name">
        メッセージ　<input type="text" name="message">
        
        <button name="send" type="submit"  >送信</button>
        <button name="del" type="submit"  >削除</button>
        </br>
        チャット履歴
    </form>

    <section>
        
        
        <?php   $stmt = select(); foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                echo $message['time'],"：　",$message['name'],"：",$message['message'];
                echo nl2br("\n");
            }
        
 
            // 投稿内容を登録
            if(isset($_POST["send"])) {
                if($_POST['name'] != '' && $_POST['message'] != ''){
                    insert(); 
                    // 投稿した内容を表示
                    $stmt = select_new();
                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                        echo $message['time'],"：　",$message['name'],"：",$message['message'];
                        echo nl2br("\n");
                    }
                }else{
                    echo "<script type='text/javascript'>alert('名前またはメッセージが空欄です');</script>";
                }
            }
        
           if(isset($_POST["del"])) {
                delete();
            }
            
 
            // DB接続
            function connectDB() {
                $dbh = new PDO('mysql:host=localhost;dbname=chat','admin','admin');
                return $dbh;
            }
 
            // DBから投稿内容を取得
            function select() {
                $dbh = connectDB();
                $sql = "SELECT * FROM message ORDER BY time";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                return $stmt;
            }
 
            // DBから投稿内容を取得(最新の1件)
            function select_new() {
                $dbh = connectDB();
                $sql = "SELECT * FROM message ORDER BY time desc limit 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                return $stmt;
            }
 
            // DBから投稿内容を登録
            function insert() {
                $dbh = connectDB();
                $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
                $stmt = $dbh->prepare($sql);
                $params = array(':name'=>$_POST['name'], ':message'=>$_POST['message']);
                $stmt->execute($params);
            }
            
            //削除
            function delete(){
                $dbh = connectDB();
                $sql = "DELETE FROM `message`";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
            }
        
        ?>
    </section>
    
 
</body>
