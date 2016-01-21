	<?php
	  //POST送信が行われたら、下記の処理を実行
	  //テストコメント
	  if(isset($_POST) && !empty($_POST)){

		    //データベースに接続
	  	$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
	  	$user = 'root';
	  	$password = '';
	  	$dbh = new PDO($dsn, $user, $password);
	  	$dbh->query('SET NAMES utf8');


	
	  	$nickname = $_POST['nickname'];
		$comment = $_POST['comment'];
			date_default_timezone_set("Asia/Manila");
		$datetime = date_create()->format('Y-m-d H:i:s');
		$nickname = htmlspecialchars($nickname);
		$comment = htmlspecialchars($comment);

	    //SQL文作成(INSERT文)
	  	$sql = 'INSERT INTO `posts`(`nickname`,`comment`,`created`)';
	  	$sql .= 'values("'.$nickname.'","'.$comment.'","'.$datetime.'")';
	  	$stmt=$dbh->prepare($sql);
	    //INSERT文実行
	    $stmt->execute();

	    $sql = 'SELECT * FROM posts ORDER BY id DESC'; //データベースを切断する前に再度命令を出す
	  	$stmt=$dbh->prepare($sql);
	    //INSERT文実行
	    $stmt->execute();

	    while(1)
	    {
	    	$rec = $stmt->fetch(PDO::FETCH_ASSOC); //FETCHはデータベース単位で一回しか動かない
	    	if($rec==false)
	    	{
	    		break;
	    	}

	    $posts[]=$rec;
	    echo $rec['id'];
	    echo $rec['nickname'];
	    echo $rec['comment'];
	    echo $rec['created'];
	    echo '<hr noshade="noshade">';


	    }

	    //データベースから切断
	    $dbh=null;

	    }

	?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
	<h1>投稿フォーム</h1>
	<p>下のボックスにニックネーム・コメントを入力して投稿して下さい。</p>
    <form action="bbs.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <br />
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <br />
      <button type="submit" >つぶやく</button>
    </form>

    <?php
    foreach ($posts as $post) { ?>
    	
    }
    ?>




    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:20</span></h2>
    <p>つぶやきコメント</p>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p>
</body>
</html>