<?php

// require 'classes/Database.php';
// require 'classes/Article.php';
// require 'classes/Auth.php';

require '../includes/init.php';
// session_start();
// if () {
//     Url::redirect("/login.php");
// };
// $db = new Database();
// $conn = $db -> getConn();
$conn = require '../includes/db.php';

$articles = Article::getAll($conn);






// ***** old mysqli
// $conn = getDB();




//***** old mysqli
// $results = mysqli_query($conn, $sql);

// if ($results === false) {
//     $conn -> errorInfo();
//
// // ****** old mysqli
//     // echo mysqli_error($conn);
// } else {


    // **** old mysqli
    // $articles = mysqli_fetch_all($results, MYSQLI_ASSOC);
    // var_dump($articles);
// }

?>

<?php require '../includes/header.php'; ?>


<!-- <?php var_dump($_SESSION); ?> -->

<?php if (Auth::isLoggedIn()): ?>
  <p>You are loggend in. <a href="logout.php">Log out</a></p>
  <h2><a href="new-article.php">New Article</a></h2>
<?php else: ?>

<p>You are not logged in. <a href="login.php">Log in</a></p>

<?php endif; ?>

<h2>Administration</h2>

<!-- <h2><a href="new-article.php">New Article</a></h2> -->
      <?php if (empty($articles)): ?>
        <p>No articles found.</p>
      <?php else: ?>

      <table>
        <thead>
          <th>Title</th>
        </thead>
        <tbody>
        <?php foreach ($articles as $article) : ?>
          <tr>
            <td>
              <!-- <?= $article['id']; ?> -->
              <a href="article.php?id=<?= $article["id"]; ?>"><?= htmlspecialchars($article["title"]); ?></a>
              <!-- <p><?= htmlspecialchars($article["content"]);?></p>
              <p><?= $article["published_at"];?></p> -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
    <?php endif; ?>

<?php require '../includes/footer.php'; ?>
