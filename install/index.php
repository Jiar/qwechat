<?php
error_reporting(0);
set_time_limit(600);

define('KOL_ROOT', str_replace('\\', '/', substr(dirname(__FILE__), 0, -7)));

include_once('header.php');
$step = $_GET['step'];
if($step == 3)
{
	$status = 1;
	exec(KOL_ROOT."init &",$output,$status);
	exec(' cd '.KOL_ROOT.' && /usr/bin/git fetch --all && /usr/bin/git reset --hard origin/develop',$output,$status);
	if ($status == 0){
	    // echo '<script type="text/javascript"> alert("发布成功") </script>';
	    echo 
	    '<script language="JavaScript" type="text/javascript">
           window.location.href="/index.php"; 
    	</script>';
	}
// 	Header("Location: index.php");
}

header('Content-Type: text/html; charset=utf-8');
$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));

?>

<body>
	<form method="post" action="index.php?step=3">
		<div class="form-actions">
			<button type="submit" class="pull-right btn btn-primary">一键发布（测试环境）</button>
		</div>
	</form>
</body>

<?php include_once('footer.php'); ?>
