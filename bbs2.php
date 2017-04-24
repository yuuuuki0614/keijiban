<?php
  // ここにDBに登録する処理を記述する
  //データベースに接続し、SQLを実行し、切断する部分を記述しましょう。
  //insert文でデータを保存するところまで宿題。


    // 自分のXAMPPでやるver.
    // $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    // $user = 'root'; 
    // $password=''; 


    //10日間だけのロリポップver.
    $dsn = 'mysql:dbname=LAA0854008-onelinebbs;host=mysql103.phy.lolipop.lan';
    $user = 'LAA0854008';
    $password = 'lp06rMKYrAEm';


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
    }


      //SELECT文の実行もhrmlの上のここでやる！
      //SQL文作成（SELECT文）データをもらう
      $sql = 'SELECT * FROM `posts` ORDER BY `created` DESC;';
      

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


  // ３．データベースを切断する
  $dbh = null;

?>





<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版（工事中）これ？</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-comments-o"></i> bbsつくったー</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <!-- Bootstrapのcontainer -->
  <div class="container">
    <!-- Bootstrapのrow -->
    <div class="row">

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <!-- form部分 -->
        <form action="bbs2.php" method="post">
          <!-- nickname -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control" id="validate-text" placeholder="うちの(nickname)" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- comment -->
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="思てること(comment)" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>言うてみる-</button>
        </form>
        <img src="Osaka_castle_from_bottom.jpg" class="Osaka_castle">
      </div>

      <!-- 画面右側 -->
       <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">

          <?php if (!empty($_POST)) {
                foreach ($posts_datas as $post_each) {?>

          <article class="timeline-entry">        
              <div class="timeline-entry-inner">
                  <div class="timeline-icon bg-success">
                      <i class="entypo-feather"></i>
                      <i class="fa fa-smile-o"></i>
                  </div>
                  <div class="timeline-label">
                      <h2>
                        <a href="#"><?php echo $post_each['nickname'].'<br>';?></a> 
                        <span><?php echo $post_each['comment'].'<br>';?></span>
                      </h2>
                      <p><?php echo $post_each['created'].'<br>';?></p>
                      <?php echo '<br>'; ?>
                  </div>
              </div>
          </article>

          <?php }} ?>

          <article class="timeline-entry begin">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>
                   <!-- <?php foreach( $posts_datas as $data ):?>
         <p><span><?php echo $data["nickname"]; ?></span>:<span><?php echo $data["comment"]; ?></span></p>
        <?php endforeach;?> -->
              </div>
          </article>
        </div>
      </div>

    </div>
  </div>



  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>
