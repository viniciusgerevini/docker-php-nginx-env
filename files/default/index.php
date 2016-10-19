<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Example page</title>
  </head>
  <body>
    <h1>This is the default page!</h1>
    <?php
      phpinfo();

      // $pdo = new \PDO(
      //   'mysql:host=mariadb;dbname=test_db',
      //   'root',
      //   'test_pass'
      // );
      //
      // $query = $pdo->prepare('show tables');
      // $query->execute();
      //
      // while ($row = $query->fetch(PDO::FETCH_NUM)) {
      //     echo $row[0];
      // }
    ?>
  </body>
</html>
