<html>
<head>
  <link href="https://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">

  <!-- If you'd like to support IE8 -->
  <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
</head>

<body>
  <video id="my-video" class="video-js vjs-default-skin vjs-big-play-centered" controls preload="auto" width="720" height="480"
  poster="<?php echo $img ?>" data-setup='{"playbackRates": [1, 1.5, 2, 2.5, 3]}'>
    <source src="<?php echo $url ?>" type='video/mp4'>
    <p class="vjs-no-js">
      To view this video please enable JavaScript, and consider upgrading to a web browser that
      <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
  </video>

  <script src="https://vjs.zencdn.net/5.8.8/video.js"></script>
</body>
</html>
