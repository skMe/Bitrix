<?
function dmp($var, $all = false, $die = false)
{
	global $USER;
	if ($USER->isAdmin() || $all)
	{
?>
<script type="text/javascript">
function tree_toggle(event) {
	event = event || window.event;
	var node = event.target.parentElement || event.srcElement.parentElement;
	if (node.className.search("\\bexpanded\\b") != -1) node.className = node.className.replace('expanded','contracted');
	else if (node.className.search("\\bcontracted\\b") != -1) node.className = node.className.replace('contracted','expanded');
}
</script>

<style type="text/css">
	.skdmp {width:100%;padding:10px;font: 400 12px Consolas, 'Lucida Console', 'Courier New', monospace;background: #eee;box-sizing:content-box;word-break:break-all;}
	.skdmp ul {padding: 0;margin: 0;list-style-type:none;}
	.skdmp li {padding-left: 12px;color:#555;position:relative;}
	.skdmp li.expanded>span, .skdmp li.contracted>span {color:#08c;cursor: pointer;border-bottom:1px dashed #08c;font-weight:700;}
	.skdmp .expanded:before, .skdmp .contracted:before {content: '';position:absolute;left:2px;display:block;border:5px solid transparent;}
	.skdmp .expanded:before {border-top-color:#555;top:5px;left:0;}
	.skdmp .contracted:before {border-left-color:#555;top:3px;}
	.skdmp .expanded ul {display: block;}
	.skdmp .contracted ul {display: none;}
</style>
<div class="skdmp" onclick="tree_toggle(arguments[0])">
<?=formatHtm($var)?>
</div>
<?
	}
	if ($die) die;
}

function formatHtm($var) {
	if (is_array($var) || is_object($var)) {
		$out = "<ul>\n";
		foreach ($var as $k => $v) {
			if (is_array($v) || is_object($v)) {
				$out .= '<li class="contracted"><span>['.$k."]</span> (".count($v)."):".formatHtm($v);
			} else {
				$out .= '<li><b>['.$k."]</b>: ".formatHtm($v);
			}
		}
		return $out."</ul>\n";
	} else {
		return htmlspecialchars($var)."\n";
	}
}