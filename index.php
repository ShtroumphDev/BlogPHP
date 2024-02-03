<?php
require_once('src\PDO\DataBaseConnection.php');

use App\PDO\DataBaseConnection;
use Dotenv\Dotenv;

session_start();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dataBaseConnection = new DataBaseConnection;
$users = $dataBaseConnection->getAllUsers();

// On affiche chaque recette une à une
/* foreach ($users as $user) {
?>
    <p><?php echo $user['pseudo']; ?></p>
<?php
} */
/* <?php if($error)
<?= $error ?> */

echo '
<pre>';
print_r($users);
echo '</pre>';


if (isset($_GET['page']) && $_GET['page'] !== '') {
    if (file_exists('src\\templates\\' . $_GET['page'] . '.html')) {
        require_once('src\\templates\\' . $_GET['page'] . '.html');
    } else {
        require_once('src\\templates\Error404.html');
    }
} else {
    require_once('src\\templates\HomePage.html');
}
