<?php
if(isset($_GET)&& $_GET['X']==Stop)
{
  die("Stopped");
}else {
  // code...

for($i=0;$i<30;$i++)
{
  ImageGen($i);
}
VideoGen();
$G=md5(rand()*1000%255);
echo $G;
}
function ImageGen($FileCount)
{
$Height=500;
$R=(@date('Y'))%255;
$G=rand()*1000%255;
$B=rand()*1000%255;
$image = imagecreatetruecolor($Height, $Height);
$background_color = imagecolorallocate($image, $R, $G, $B);
imagefilledrectangle($image,0,0,$Height,$Height,$background_color);

$R=(@date('Y'))%255;
$G=rand()*1000%255;
$B=rand()*1000%255;
$Rnd=rand();
$LineCount=$Rnd%100;
$Line_color = imagecolorallocate($image, $R, $G, $B);
for($i=0;$i<$LineCount;$i++) {
    imageline($image,0,rand()%$Height,$Height,rand()%$Height,$Line_color);
}

$pixel_color = imagecolorallocate($image, 0,0,0);
for($i=0;$i<10;$i++) {
    imagesetpixel($image,rand()%$Height,rand()%$Height,$pixel_color);
}

$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
$len = strlen($letters);
$letter = $letters[rand(0, $len-1)];
$LetterCount=$Rnd%20;
$text_color = imagecolorallocate($image, 0,0,0);
for ($i = 0; $i<$LetterCount ;$i++) {
    $letter = $letters[rand(0, $len-1)];
    $FontSize=rand(12,20);
    echo "<script>console.log(".$FontSize.")</script>";
    imagestring($image,$LetterCount,rand()%$Height,rand()%$Height, $letter, $text_color);
    $word.=$letter;
}

imagepng($image, "imageset/img_".$FileCount.".png");

}
function VideoGen()
{
  echo "Hitting VideoGen<br>";


    echo "Creating AudioGen<br>";
  AudioGen();
  echo "Exiting AudioGen<br>";

  $command2="/usr/local/bin/ffmpeg -r 1/2  -i imageset/img_%d.png -i output.mp3 -c:v libx264 -r 30 -pix_fmt yuv420p Video_".@date('d-m-y-h-s-i').".mp4";
//  $command2="ps -A";
  echo exec($command2)."<br>";
  echo "Exiting VideoGen<br>";

}

function AudioGen()
{
  $Files=array();
  $numberoffiles=16;
  for($i=100;$i<2000;$i+=50)
  {
    array_push($Files,"audioset/".$i.".wav");
  }
  $random_keys=array_rand($Files,$numberoffiles);
  $K=0;
  $C1=$C2="";
  foreach($random_keys as $key) 
  {
     $C1.=" -i ".$Files[$key];
     $C2.="[".$K.":0]";
     $K++;

  }
  
  $command2="/usr/local/bin/ffmpeg".$C1." -filter_complex '".$C2."concat=n=".$numberoffiles.":v=0:a=1[out]' -map '[out]' outputX.wav";
  echo exec($command2)."<br>";
  $command2="/usr/local/bin/ffmpeg -i outputX.wav -vn -ar 44100 -ac 2 -ab 192k -f mp3 output.mp3";
  echo exec($command2)."<br>";
}
