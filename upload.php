<?php
error_reporting(E_ALL);
//$fname=$_POST['fname'];
//$fcontent=$_POST['data'];

// pull the raw binary data from the POST array
$data = substr($_POST['data'], strpos($_POST['data'], ",") + 1);
// decode it
$decodedData = base64_decode($data);
$filename = "ciao.mp3";
$real="/var/www/web/speech2text/htdocs/dir/";
$e=null;
echo " </br>";
echo $real.$filename;
$fp = fopen($real.$filename, 'wb');
fwrite($fp, $decodedData);
     
fclose($fp);
print_r(error_get_last());
/*
try
    {
      


echo $real.$filename;
      

      if ( !$fp ) {
        throw new Exception('File open failed.');
      }
      
     

      // send success JSON

    } catch ( Exception $e ) {
        
     echo "error:</br>";
     print_r( $e);
     echo " errrors:";
     print_r(error_get_last());
     
    }
    */
    
  //  if($e==null){
        
        echo "</br>File is ready for the convertion in Flac </br>";
        
        //"/flac2mp3/./mp32flac.sh ";
        $output = system("ffmpeg -i ".$real."ciao.mp3 ".$real."ciao.flac");
       // echo "</br> E".$output;
        echo "Convertion is finish </br>";
        echo   $real."ciao.flac";
        echo "</br>";
        print_r(error_get_last());

    
        
        include 'GoogleSpeechToText.php';

// Your API Key goes here.
echo " include work";



$speech = new GoogleSpeechToText("AIzaSyDNsTkS0Jm6NQRFbaHKBHsaRO6BXNcjOtw");
echo "File flac is ready for to be converted in text </br>";



//CAMBIARE QUANDO STA SUL SERVER
//$file = realpath( '/home/a2124875/public_html/quick.flac');
$file= $real."ciao.flac";
echo $file;
$bitRate = 44100; // The bit rate of the file



$result = $speech->process($file, $bitRate, 'it-IT');



print_r(error_get_last());

/*

$result = $speech->process($file, $bitRate, 'it-IT');




if(!empty($result)){
  echo "</br> The result: </br>";
$array=$result[0]['alternative'];
foreach($array as $value){
    if(!empty($value['confidence']))
        echo $value['transcript'];

    }
    }
    else{
      echo "Please Retry";
    }

    echo "</br>";
    print_r(error_get_last());
   // unlink($real."/dir/ciao.flac");
   // unlink( $real."/dir/ciao.mp3");
    

   // }
*/
    
?>
