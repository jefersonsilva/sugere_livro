<?php include 'index.php'; ?>


<br>


<table border="1">
    <th>Nome</th>
    <th>Email</th>
<?php
include 'autoload.php';

$user = new user();
$obj = new database();

$usuarios = $user->list_user($obj);

foreach ($usuarios as $pessoa):
?>

    <tr>
        <td>
            <?php echo $pessoa['name'] ?>
        </td>
        <td>
            <?php echo $pessoa['username'] ?>
        </td>
    </tr>



<?php endforeach; ?>

</table>

