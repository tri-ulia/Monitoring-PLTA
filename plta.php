<?php
class tb_plta{
 public $link='';
 function __construct($tegangan, $arus, $rpm){
  $this->connect();
  $this->storeInDB($tegangan, $arus, $rpm);
 }
 
 function connect(){
  $this->link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
  mysqli_select_db($this->link,'db_plta') or die('Cannot select the DB');
 }
 
 function storeInDB($tegangan, $arus, $rpm){
  $query = "insert into tb_plta set tegangan='".$tegangan."', arus='".$arus."', rpm='".$rpm."'";
  $result = mysqli_query($this->link,$query) or die('Errant query:  '.$query);
 }
 
}
if($_GET['tegangan'] != '' and  $_GET['arus'] != '' and  $_GET['rpm'] != ''){
  $tb_plta=new tb_plta($_GET['tegangan'],$_GET['arus'],$_GET['rpm']);
}


?>
