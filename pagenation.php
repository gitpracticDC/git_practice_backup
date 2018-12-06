<?php

//データベース接続
$db = new PDO("mysql:host=localhost;dbname=test;charset=utf8",
    'root',
    '');

if (isset($_GET['page'])) {

    $page = (int) $_GET['page'];
    //例：3P目なら「20件目」からデータを取得する
    $initial_position = ($page * 10) - 10;

} else {
    $page = 1;
    $initial_position = 0;
}

//SELECTするデータの初期位置を、GETで取得したパラメーターによって変更する。
$limit_data = $db->prepare("SELECT id, comment FROM pagenation LIMIT 10 OFFSET {$initial_position}");

$limit_data->execute();
$limit_data = $limit_data->fetchAll(PDO::FETCH_ASSOC);

foreach ($limit_data as $value) {
    echo 'idは' . $value['id'] . '....!';
    echo 'コメントは' . $value['comment'] . '</br>';
}

//idのデータ数を取得する。
$whole_number = $db->prepare("SELECT COUNT(*) id FROM pagenation");
$whole_number->execute();

$whole_number = $whole_number->fetchColumn();

//小数点以下を切り上げる。
$paging_number = ceil($whole_number / 10);

?>



<?php for ($i = 1; $i <= $paging_number; $i++): ?>
<a href="?page=<?=$i?>"><?=$i?></a>
<?php endfor;?>
