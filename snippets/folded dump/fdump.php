<?
function dmp($var, $debug = false, $all = false, $die = false) {
	global $USER;
	if ($USER->isAdmin() || $all) {
		$r = rand(1000, 9999);
?>
<style>
	#fd_dmp {width:100%;padding:10px;font:400 12px/14px Consolas, 'Lucida Console', 'Courier New', monospace;background:#eee;box-sizing:border-box;word-break:break-all;}
	#fd_dmp ul {padding: 0;margin: 0;list-style-type:none;}
	#fd_dmp li {padding-left:12px;color:#555;position:relative;text-align:left;}
	#fd_dmp li:before, #fd_dmp li:after {content:none;}
	#fd_dmp .fd_toggle > .fd_name > .fd_var {color:#08c;cursor: pointer;border-bottom:1px dotted #08c;}
	#fd_dmp .fd_toggle:before {content:'';position:absolute;left:2px;top:3px;display:block;border:5px solid #eee;border-left-color:#555;margin:0;width:0;}
	#fd_dmp .fd_open:before {border-left-color:#eee;border-top-color:#555;top:5px;left:0;}
	#fd_dmp .fd_toggle ul {display: none;}
	#fd_dmp .fd_open > ul {display: block;}
	#fd_dmp .fd_row {display: flex;}
	#fd_dmp .fd_name {white-space: nowrap;}
	#fd_dmp .fd_type {display:inline-block;color:#fff;background:#5ae;font: 700 10px/11px Arial;padding:1px 4px;border-radius:2px;}
</style>
<div id="fd_dmp" class="fd_<?=$r?>">
<ul>
<?
		ob_start();
		var_dump($var);
		$dump = ob_get_clean();
		$ent_dump = preg_replace_callback("/(^\s*string.*\(\d+?\)\s\")([\s\w\W]*?)(\"\r?\n)/m", function($m){return $m[1].strtr($m[2], 
			array("&" => "&amp;", "<" => "&lt;", ">" => "&gt;", "'" => "&#39;", "\"" => "&#34;", "(" => "&#40;", ")" => "&#41;", "{" => "&#123;", "}" => "&#125;")).$m[3];}, $dump);
		$patterns = array(
			"/^(\s*)\[(\"?.*?\"?)\].*?\n\s*?(\S+).*\(\d+?\)\s(\"[\s\w\W]*?\")$/m", //string
			"/^(\s*)\[(\"?.*?\"?)\].*\n\s*?(\S+).*\(([\d\.]+?)\)$/m", //int, float
			"/^(\s*)\[(\"?.*?\"?)\].*\n\s*?(\S+).*\((\D+?)\)$/m", //bool
			"/^(\s*)\[(\"?.*?\"?)\].*\n\s*?(\*?\w+?\*?)$/m", //null, recursion
			"/^(\s*)\[(\"?.*?\"?)\].*\n(\s*?)(\S+).*(\([1-9]\d*\))\s\{$/m", //not empty arr
			"/^(\s*)\[(\"?.*?\"?)\].*\n(\s*?)(\S+).*(\(0\))\s\{$/m", //empty arr
			"/^(\S+).*\(\d+?\)\s(\"[\s\w\W]*?\")$/m", //root str
			"/^(\S+).*\(([\d\.]+?)\)$/m", //root int, float
			"/^(\S+).*\((\D+?)\)$/m", //root bool
			"/^(\*?\w+?\*?)$/m", //root null, recursion
			"/^(\S+).*(\([1-9]\d*\))\s\{$/m", //not empty root arr
			"/^(\S+).*(\(0\))\s\{$/m", //empty root arr
			"/^(\s*)\{$/m",
			"/^(\s*)\}$/m"
		);
		$rpl1 = "$1<li class=\"fd_row\"><div class=\"fd_name\">[<b class=\"fd_var\">$2</b>] <span class=\"fd_type\">$3</span>:&nbsp;</div><div class=\"fd_value\">$4</div></li>"; //string, int, float, bool
		$rpl2 = "<li class=\"fd_row\"><div class=\"fd_name\">[<b class=\"fd_var\">$1</b>]:&nbsp;</div><div class=\"fd_value\">$2</div></li>"; //root string, int, float, bool
		$replace = array(
			$rpl1, $rpl1, $rpl1,
			"$1<li class=\"fd_row\"><div class=\"fd_name\">[<b class=\"fd_var\">$2</b>] <span class=\"fd_type\">$3</span>:&nbsp;</div><div class=\"fd_value\">$3</div></li>", //null, recursion
			"$1<li class=\"fd_toggle\"><div class=\"fd_name\">[<b class=\"fd_var\">$2</b>] <span class=\"fd_type\">$4</span> $5:</div>\n$3{", //not empty arr
			"$1<li><div class=\"fd_name\">[<b class=\"fd_var\">$2</b>] <span class=\"fd_type\">$4</span> $5:</div>\n$3{", //empty arr
			$rpl2, $rpl2, $rpl2,
			"<li class=\"fd_row\"><div class=\"fd_name\">[<b class=\"fd_var\">$1</b>]:&nbsp;</div><div class=\"fd_value\">$1</div></li>", //root null, recursion
			"<li class=\"fd_toggle fd_open\"><div class=\"fd_name\">[<b class=\"fd_var\">$1</b>] $2:</div>\n{", //not empty root arr
			"<li><div class=\"fd_name\">[<b class=\"fd_var\">$1</b>] $2:</div>\n{", //empty root arr
			"$1<ul>",
			"$1</ul>\n$1</li>"
		);
		echo preg_replace($patterns, $replace, $ent_dump);
?>
</ul>
</div>
<script>
	var fdToggles = document.querySelectorAll('.fd_<?=$r?> .fd_toggle > .fd_name > .fd_var');
	if (fdToggles) {
		for (var i=0;i<fdToggles.length;i++) {
			fdToggles[i].addEventListener('click', function(e) {e.stopPropagation(); this.parentNode.parentNode.classList.toggle('fd_open');});
		}
	}
</script>
<?
		if ($debug) echo "\n<!-- FD_DBG_START (All sequences of two «-» replaced by «-#-»)\n\n".strtr($ent_dump, array("--" => "-#-"))."\n\n FD_DBG_END -->\n";
	}
	if ($die) die;
}

?>
