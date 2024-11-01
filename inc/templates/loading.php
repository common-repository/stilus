<?php
/*
  loading.php
  Popup template to be render while waiting mystilus response.
 */
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
	<title>Stilus</title>
	<meta name="description" content="" />
  <script>
    var i = 0;
	  function reload() {
  		document.getElementById('img').src = '../../img/loading'+i+'.png';
      i = ((i<5) ? i+1 : 0);

      setTimeout(reload, 300);
	  }
  </script>
</head>
<body onload="reload();window.opener.document.getElementById('st_PostForm').submit();">
	<div style="text-align:center;width:840px;">
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<img id="img" src="../../img/loading0.png" />
	</div>
</body>
</html>
