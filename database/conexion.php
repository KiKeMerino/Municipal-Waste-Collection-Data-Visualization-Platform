<?php 
$conecta = mysqli_connect("85.62.209.109:3306", "Ecopuntos", 'oQ4>hE3(E2', "sigma");
if(mysqli_connect_errno()){
printf("No se ha podido conectar con la base de datos: %s\n", mysqli_connect_error());
exit();
}
mysqli_set_charset($conecta, "utf8");
?>
