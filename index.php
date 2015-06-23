<?php
echo realpath(__DIR__);
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Live input record and playback</title>
  <style type='text/css'>
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
  </style>
   <link href="css/style.css" rel="stylesheet" type="text/css" />
   <script src="js/jquery-1.11.0.min.js"></script>	
  <script src="recordmp3.js"></script>
</head>
<body>

<button onclick="startRecording(this);">record</button>
  <button onclick="stopRecording(this);" disabled>stop</button>
  
  <h2>Recordings</h2>
  <ul id="recordingslist"></ul>
  
  <h2>Log</h2>
  <pre id="log"></pre>

  <script>
  function __log(e, data) {
    log.innerHTML += "\n" + e + " " + (data || '');
  }

  var audio_context;
  var recorder;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
    __log('Media stream created.' );
	__log("input sample rate " +input.context.sampleRate);
    
    input.connect(audio_context.destination);
    __log('Input connected to audio context destination.');
    
    recorder = new Recorder(input);
    __log('Recorder initialised.');
  }

  function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    button.nextElementSibling.disabled = false;
    __log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    __log('Stopped recording.');
    
    // create WAV download link using audio data blob
    createDownloadLink();
    
    recorder.clear();
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
      /*var url = URL.createObjectURL(blob);
      var li = document.createElement('li');
      var au = document.createElement('audio');
      var hf = document.createElement('a');
      
      au.controls = true;
      au.src = url;
      hf.href = url;
      hf.download = new Date().toISOString() + '.wav';
      hf.innerHTML = hf.download;
      li.appendChild(au);
      li.appendChild(hf);
      recordingslist.appendChild(li);*/
    });
  }

  window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                     navigator.msGetUserMedia);  
      window.URL = window.URL || window.webkitURL;
     
      audio_context = new AudioContext;
      __log('Audio context set up.');
      __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      alert('No web audio support in this browser!');
    }
    
 navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
      __log('No live audio input: ' + e);
    });
    
    
  };
  </script>
</body>
</html>



<?php
/*
include 'GoogleSpeechToText.php';

// Your API Key goes here.


$speech = new GoogleSpeechToText("AIzaSyDNsTkS0Jm6NQRFbaHKBHsaRO6BXNcjOtw");
//echo  realpath( __DIR__ . '/quick.flac');
//CAMBIARE QUANDO STA SUL SERVER
//$file = realpath( '/home/a2124875/public_html/quick.flac');
$file= realpath( __DIR__ . '/quick.flac');
$bitRate = 44100; // The bit rate of the file.
$result = $speech->process($file, $bitRate, 'en-US');
//print_r($result);
$array=$result[0]['alternative'];
foreach($array as $value){
    if(!empty($value['confidence']))
        echo $value['transcript'];
}


*/