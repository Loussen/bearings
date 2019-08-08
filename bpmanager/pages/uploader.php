<?php
// Bu scriptde blog saytin index.php faylinin yaninda bu directoride olmalidir:   $site/images/fotoqalereya/$blog_id/$sekil_id.$sekil_tip;
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$add=intval($_GET["add"]);

if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from blog where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

if($_POST["add_yeni_sekil"])
{

	$sekil_hardans=$_FILES["yeni_sekil"]["tmp_name"];
	$sekil_tips=$_FILES["yeni_sekil"]["type"];
	$sekil_names=$_FILES["yeni_sekil"]["name"];
	$say=0;

	$time = time();
	foreach($sekil_hardans as $sekil_hardan){
		$tip=explode(".",$sekil_names[$say]);	$tip=end($tip);		$tip=strtolower($tip);
		$sekil_tip=$sekil_tips[$say];
		$sekil_name=$sekil_names[$say];
		$sekil_olar=false;

		if( ($tip!="exe" && $tip!="com"  && $tip!="msi" && $tip!="bat" && $tip!="php" && $tip!="phps" && $tip!="phtml" && $tip!="php3" && $tip!="php4" && $tip!="cgi" && $tip!="pl") ) $sekil_olar=true;
		if($sekil_olar==true)
		{

            $image_upload_name = substr(sha1(mt_rand()),17,5)."-".$sekil_name;
			mysqli_query($db,"insert into $do values (0,'$time','$image_upload_name') ");

			$last_id=mysqli_insert_id($db);
			move_uploaded_file($sekil_hardan,'../images/uploader/'.$image_upload_name);
			chmod('../images/uploader/'.$image_upload_name, 0755);
			//Thumb yaradir
			$uploaded_sekil='../images/uploader/'.$image_upload_name;
//			list($width, $height, $type, $attr) = getimagesize($uploaded_sekil);
//			if ($width>1000 or $height>800){
//				$image = new SimpleImage();
//				$image->load($uploaded_sekil);
//
//				if($width>1000) $image->resizeToWidth(1000);
//				if($height>800) $image->resizeToHeight(800);
//				$image->save($uploaded_sekil);
//			}

//			create_thumbnail($uploaded_sekil,'../images/telim_photos/'.$last_id.'_thumb.'.$tip,107,107);
//			checkMaxSizeImage($uploaded_sekil,$maxWidth=700,$maxHeight=345);
//			$thumbFile='../images/news_gallery/'.$last_id.'_thumb.'.$tip;
//			makeThumb($uploaded_sekil,$thumbFile,265,180);
			$ok="Yeni şəkil əlavə olundu.";


		}
		$say++;
		$auto_id++;
	}
}
elseif($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where id='$delete' "))>0)
{
	$tip=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where id='$delete'")); $tip=$tip["tip"];
	mysqli_query($db,"delete from $do where id='$delete' ");
	@unlink('../images/uploader/'.$delete.'.'.$tip);
//	@unlink('../images/news_gallery/'.$delete.'_thumb.'.$tip);
	$ok="Silindi.";
}
?>
<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
</script>
<div class="onecolumn">
	<div class="header">
		<span>Serverə fayl yükləmək</span>

	</div>
	<br class="clear"/>
	<div class="content">
		<?php
		if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
		if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
		?>
		<!-- Content start-->
		<form action="index.php?do=<?php echo $do; ?><?php if($edit>0) echo '&edit='.$edit; if($add==1) echo '&add='.$add;?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
			<u>Fayllar:</u><br class="clear" />
			<ul class="media_photos">
				<?php
				$sql=mysqli_query($db,"select * from $do order by id");
				while($row=mysqli_fetch_assoc($sql))
				{
					echo '<li style="margin-bottom:20px; width: 120px;">
				  <a target="_blank" href="../images/uploader/'.$row["tip"].'" title="">
				  	Fayl linki ('.$row["tip"].')
				  </a>
				  <br class="clear" />
				  '.$row["basliq"].' <a href="index.php?do='.$do.'&delete='.$row["id"].'" title="Sil" class="delete"><img src="images/icon_delete.png" alt="" /></a>
			</li>';
				}
				?>
			</ul>
			<br class="clear" />
			<div style="display:<?php if($add==0 && $edit_blog==0) echo "block"; else echo "none"; ?>">
				<b>Yeni əlavə et:</b><br /><br />
				Fayl: <input name="yeni_sekil[]" type="file" multiple />
                <br />
                <input type="submit" name="add_yeni_sekil" value=" Save " />
			</div>
		</form>
		<!-- Content end-->
	</div>
</div>