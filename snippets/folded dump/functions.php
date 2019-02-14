<?
$fd_enc = SITE_CHARSET == "windows-1251" ? "cp1251" : "UTF-8";

function dmp($var, $debug = false, $all = false, $die = false)
{
	global $USER;
	if ($USER->isAdmin() || $all)
	{
?>

<style type="text/css">
	#fd_dmp {width:100%;padding:10px;font:400 12px/14px Consolas, 'Lucida Console', 'Courier New', monospace;background:#eee;box-sizing:border-box;word-break:break-all;}
	#fd_dmp ul {padding: 0;margin: 0;list-style-type:none;}
	#fd_dmp li {padding-left:12px;color:#555;position:relative;text-align:left;}
	#fd_dmp li:before, #fd_dmp li:after {content:none;}
	#fd_dmp .fd_name {font-weight:700;}
	#fd_dmp .fd_toggle > .fd_name {color:#08c;cursor: pointer;border-bottom:1px dotted #08c;}
	#fd_dmp .fd_toggle:before {content: '';position:absolute;left:2px;top:3px;display:block;border:5px solid #eee;border-left-color:#555;}
	#fd_dmp .fd_open:before {border-left-color:#eee;border-top-color:#555;top:5px;left:0;}
	#fd_dmp .fd_toggle ul {display: none;}
	#fd_dmp .fd_open > ul {display: block;}
	#fd_dmp .fd_type {display:inline-block;color:#fff;background:#5ae;font: 700 10px/10px Arial;padding:1px 2px 2px;border-radius:2px;}
</style>
<div id="fd_dmp">
<ul>
<?
$top = "";
$type = strtoupper(gettype($var));
if (is_array($var) || is_object($var)) {
	$var = (array) $var;
	$top .= '<li class="fd_toggle fd_open">[<span class="fd_name">'.$type."</span>] (".count($var)."):";
} else {
	$top .= '<li><b>['.$type."]</b>: ";
}
echo $top.formatHtm($var);
?>
</ul>
</div>

<script type="text/javascript">
	var fdToggles = document.querySelectorAll('.fd_toggle > .fd_name');
	fdToggles.forEach(function(item) {
		item.addEventListener('click', function(e) {e.stopPropagation(); this.parentNode.classList.toggle('fd_open');});
	});
</script>

<?
		if ($debug) echo "\n<!-- FD_DBG_START \n\n".print_r($var, 1)."\n\n FD_DBG_END -->\n";
	}
	if ($die) die;
}

function formatHtm($var) {
	if (is_array($var) || is_object($var)) {
		$out = "<ul>\n";
		foreach ($var as $k => $v) {
			$type = "<span class=\"fd_type\">".gettype($v)."</span>";
			$cnt = "";
			$cls = "";
			if (is_array($v) || is_object($v)) {
				$v = (array) $v;
				$c = count($v);
				$cnt = " ($c)";
				if ($c) $cls = " class=\"fd_toggle\"";
			}
			$out .= "<li$cls>[<span class=\"fd_name\">$k</span>] $type$cnt:".formatHtm($v);
		}
		return $out."</ul>\n";
	} else {
		return htmlspecialchars($var, ENT_COMPAT, $fd_enc)."\n";
	}
}

?>
