<?php 
require_once '../include/comum.php';
?>
<?php require_once '../include/header.php'; ?>
<!------------------------------------------------>
<iframe src="view_internet_iframe.php" width="1024" height="10250" style="border: 0px;" name="internetGathering" id="internetGathering"></iframe>
<script type="text/javascript">
    var iframeWidth = screen.width - 50; // Margem para ambientes gráficos com menus laterais
    document.getElementById("internetGathering").width = iframeWidth < 1024 ? 1024 : iframeWidth;
</script>
<!------------------------------------------------>
<?php require_once '../include/footer.php'; ?>