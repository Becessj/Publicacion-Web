<?php
 // directory to delete
$directory = 'public_html/publicacion/uploads/';
 // ftp connection
$connection = ftp_connect("municalca.gob.pe");
ftp_login($connection, "municalca@municalca.gob.pe", "Munic@lc@2020");
 // change the directory
ftp_chdir($connection, $directory);
 // list all files
$files = ftp_nlist($connection, ".");
foreach ($files as $file)
{
 // delete all files in directory
 ftp_delete($connection, $file);
}