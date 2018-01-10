<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 10/01/2018
 * Time: 11:11
 */

session_start();
$login = $_POST['usuario'];
$senha = $_POST['senha'];

if( $login = "admin" and $senha = 123)
{
    $_SESSION['usuario'] = $login;
    $_SESSION['senha'] = $senha;
    header('location:index.php');
}
else{
    unset ($_SESSION['usuario']);
    unset ($_SESSION['senha']);
    header('location:index.php');

}

?>