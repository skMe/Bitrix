<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Test");
?>
<?//##### DiViER banner start ######?>
<div id="bn_view" style="display:none;align-items:center;justify-content:center;background:rgba(0,0,0,0.7);position:fixed;top:0;left:0;width:100%;height:100%;z-index:2000;">
	<div style="position:relative;flex:0 1 auto;">
 <img alt="banner" src="/local/templates/divier/images/banner.jpg" style="width:100%;max-width:1100px;">
		<div id="bn_close" style="position:absolute;top:6px;right:8px;font-weight:700;font-size:40px;cursor:pointer">
			 ×
		</div>
	</div>
</div>
<script type="text/javascript">
window.onload = function () {
	var expires = new Date('2018-02-10'); // expiry date
	var bn_close = document.getElementById('bn_close');
	var bn_view = document.getElementById('bn_view');
	bn_close.onclick = function() {
		bn_view.style.display = 'none';
	}

	if (expires > new Date()) {
		var shown = getCookie('bn_shown');
		if (!shown) {
			 bn_view.style.display = 'flex';
			 document.cookie = 'bn_shown=true; path=/; expires=' + expires;
		}
	}

	function getCookie(c_name) {
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1) return true;
		return false;
	}
}
</script>
<?//##### DiViER banner end ######?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>