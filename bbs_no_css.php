



<?php
  // ここにDBに登録する処理を記述する
	//データベースに接続し、SQLを実行し、切断する部分を記述しましょう。
	//insert文でデータを保存するところまで宿題。


	  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	  $user = 'root'; 
	  $password=''; 
	  $dbh = new PDO($dsn, $user, $password);
	  $dbh->query('SET NAMES utf8');


	//配列で取得したデータを格納
	//配列を初期化
	//ifの手前に持ってくると、ifの条件に左右されずに上手くいく。
	$posts_datas = array();


	//POST送信された時だけINSERT文を実行するためのif文が必要
	 if (!empty($_POST)) {
		  $nickname = htmlspecialchars($_POST['nickname']);
		  $comment = htmlspecialchars($_POST['comment']);

		  // ２．SQL文を実行する
		  $sql = 'INSERT INTO `posts`(`nickname`, `comment`,`created`) VALUES ("'. $nickname.'", "'.$comment.'",now());'; //←ここ以外テンプレートで用意しとくと楽！。
		  //INSERT文を実行
		  $stmt = $dbh->prepare($sql); 
		  $stmt->execute();



		  //SELECT文の実行もhrmlの上のここでやる！
		  //SQL文作成（SELECT文）データをもらう
		  $sql = 'SELECT * FROM `posts` ORDER BY id DESC;';
		  

		  //実行
		  $stmt = $dbh->prepare($sql); 
		  $stmt->execute();
		  //下で使いたい時は一旦変数に代入することで、その変数を使って下(html)で表示できる！
				//↓
		  		//↓
		  		//↓
		  

		  //繰り返し文でデータの取得（フェッチ）
		  while (1) {
		      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
		      if ($rec == false) {
		        break;
		      }
		      // echo $rec['nickname'] . '<br>';
		      // echo $rec['comment'] . '<br>';
		      // echo $rec['created'] . '<br>';
		      $posts_datas[] = $rec;
		      //recには一人分の呟きしか入っていないので、posts_datasで皆の呟きを入れる。そこから取ってくるので[]を付ける。？？
	      }

	      var_dump($sql);

	 }


  // ３．データベースを切断する
  $dbh = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p><br>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
    <?php 
    	foreach ($posts_datas as $post_each) {
    		echo $post_each['nickname'].'<br>';
			echo $post_each['comment'].'<br>';
			echo $post_each['created'].'<br>'; 
			echo '<hr>';   		
    	}





    ?>



	
		<!-- <span id="view_time"></span>
		<script type="text/javascript">
		document.getElementById("view_time").innerHTML = getNow();

		function getNow() {
			var now = new Date();
			var year = now.getFullYear();
			var mon = now.getMonth()+1; //１を足すこと
			var day = now.getDate();
			var hour = now.getHours();
			var min = now.getMinutes();
			var sec = now.getSeconds();

			//出力用
			var s = year + "年" + mon + "月" + day + "日" + hour + "時" + min + "分" + sec + "秒"; 
			return s;
		}
		</script>
		<br><br>
 -->


	 <!-- <?php
	  // １．データベースに接続する
	  $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	  $user = 'root';
	  $password = '';
	  $dbh = new PDO($dsn, $user, $password);
	 	// dbh : Database Handle
		// PDO : PHP Data Objects
		// dsn : Data Source Name
	  $dbh->query('SET NAMES utf8');

	  // POSTでデータが送信された時のみSQLを実行する
	  if (!empty($_POST)) {
		  // ２．SQL文を実行する
	  	$sql = 'SELECT * FROM `posts` ORDER BY id DESC CONVERT(date, getdate())'; //into型。
	  	// $data[] =  $_POST['code']; //何も指定してないと1番最後になる。[]が付かないと只の代入。[]がつくと配列(重箱)の下に順々に入っていく。
		  // SQLを実行
		$stmt = $dbh->prepare($sql);
		  // $stmt->execute();
		$stmt->execute(); //?に配列の0番目を入れる。


	    
  	  }


	  // ３．データベースを切断する
	  $dbh = null;
 	 ?>



 -->





</body>
</html>





