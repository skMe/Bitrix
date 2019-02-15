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
	#fd_dmp .fd_name {font-weight:700;}
	#fd_dmp .fd_toggle > .fd_name {color:#08c;cursor: pointer;border-bottom:1px dotted #08c;}
	#fd_dmp .fd_toggle:before {content:'';position:absolute;left:2px;top:3px;display:block;border:5px solid #eee;border-left-color:#555;margin:0;width:0;}
	#fd_dmp .fd_open:before {border-left-color:#eee;border-top-color:#555;top:5px;left:0;}
	#fd_dmp .fd_toggle ul {display: none;}
	#fd_dmp .fd_open > ul {display: block;}
	#fd_dmp .fd_type {display:inline-block;color:#fff;background:#5ae;font: 700 10px/10px Arial;padding:1px 2px 2px;border-radius:2px;}
</style>
<div id="fd_dmp" class="fd_<?=$r?>">
<ul>
<?
		ob_start();
		var_dump($var);
		$dump = ob_get_clean();
		$ent_dump = strtr($dump, array("&" => "&amp;", "<" => "&lt;", ">" => "&gt;"));
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*?\n\s*?(\S+).*\(\d+?\)\s(\"[\s\w\W]*?\")$/m", "<li>[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$2</span>: $3</li>", $ent_dump); //string
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*\n\s*?(\S+).*\((\d+?)\)$/m", "<li>[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$2</span>: $3</li>", $ent_dump); //int
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*\n\s*?(\S+).*\((\D+?)\)$/m", "<li>[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$2</span>: $3</li>", $ent_dump); //bool
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*\n\s*?(\w+?)$/m", "<li>[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$2</span>: $2</li>", $ent_dump); //null
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*\n(\s*?)(\S+).*(\([1-9]\d*\))\s\{$/m", "<li class=\"fd_toggle\">[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$3</span> $4:\n$2{", $ent_dump); //not empty arr
		$ent_dump = preg_replace("/\[\"?(.*?)\"?\].*\n(\s*?)(\S+).*(\(0\))\s\{$/m", "<li>[<span class=\"fd_name\">$1</span>] <span class=\"fd_type\">$3</span> $4:\n$2{", $ent_dump); //empty arr
		$ent_dump = preg_replace("/^(\S+).*\(\d+?\)\s(\"[\s\w\W]*?\")$/m", "<li>[<span class=\"fd_name\">$1</span>]: $2</li>", $ent_dump); //root str
		$ent_dump = preg_replace("/^(\S+).*\((\d+?)\)$/m", "<li>[<span class=\"fd_name\">$1</span>]: $2</li>", $ent_dump); //root int
		$ent_dump = preg_replace("/^(\S+).*\((\D+?)\)$/m", "<li>[<span class=\"fd_name\">$1</span>]: $2</li>", $ent_dump); //root bool
		$ent_dump = preg_replace("/^(\w+?)$/m", "<li>[<span class=\"fd_name\">$1</span>]: $1</li>", $ent_dump); //root null
		$ent_dump = preg_replace("/^(\S+).*(\([1-9]\d*\))\s\{$/m", "<li class=\"fd_toggle fd_open\">[<span class=\"fd_name\">$1</span>] $2:\n{", $ent_dump);//not empty root arr
		$ent_dump = preg_replace("/^(\S+).*(\(0\))\s\{$/m", "<li>[<span class=\"fd_name\">$1</span>] $2:\n{", $ent_dump);//empty root arr
		$ent_dump = preg_replace("/^(\s*)\{/m", "$1<ul>", $ent_dump);
		$ent_dump = preg_replace("/^(\s*)\}/m", "$1</ul>\n$1</li>", $ent_dump);
		echo $ent_dump;
?>
</ul>
</div>

<script>
	var fdToggles = document.querySelectorAll('.fd_<?=$r?> .fd_toggle > .fd_name');
	fdToggles.forEach(function(item) {
		item.addEventListener('click', function(e) {e.stopPropagation(); this.parentNode.classList.toggle('fd_open');});
	});
</script>

<?
		if ($debug) echo "\n<!-- FD_DBG_START \n\n".$dump."\n\n FD_DBG_END -->\n";
	}
	if ($die) die;
}

?>
