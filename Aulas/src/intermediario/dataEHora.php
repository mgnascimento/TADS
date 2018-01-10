<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 04/01/2018
 * Time: 17:10
 */

//1) Data
echo $data = date("d/m/Y");

//2) Exibindo a data e a hora no formato 14/02/2004 21:04:02
date_default_timezone_set('America/Sao_Paulo');
echo "<br>". $data = date("d/m/Y H:i:s ");

//3) Exibindo a data por extenso
// ex. Sat, 14 de Jan de 20017.
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
echo "<br>". strftime('%A, %d de %B de %Y', strtotime('today'));

//4) Verificar horário de verão
//FUNÇÃO DATE(i em maiúsculo)
$data = date("I");
//VERIFICA O RESULTADO
echo "<br>". $data ? " Horário de Verão" : " Horário Normal";
?>

