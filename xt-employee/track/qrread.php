<?php 
require_once('../includes/lib/QrReader.php');

$filename = $_REQUEST["filename"];
$_dir = $_REQUEST["_dir"];

$qrcode = new QrReader("../../images/track/$_dir/$filename");
$text = explode("|",$qrcode->text()); //return decoded text from QR Code        

if(count($text)>0)
{
	echo $text[2];
?>
<script type="text/javascript">
	parent.co_post.value = <?php echo $text[0] ?>
	parent.ds_post.value = <?php echo $text[2] ?>
</script>
<?php 
}
?>
asd