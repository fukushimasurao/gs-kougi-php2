<?php
$name = $_POST['name'];
$email = $_POST['email'];
$naiyou = $_POST['naiyou'];

//2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', 'root');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

// 1. SQL文を用意
$stmt = $pdo->prepare(
    "INSERT INTO
        gs_an_table(id, name, email, naiyou, indate)
    VALUES(
        NULL, :name, :email, :naiyou, sysdate())"
);

//  2. バインド変数を用意
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:" . print_r($error, true));
} else {
    //５．index.phpへリダイレクト
    header('Location: index.php');
}
