<?php
$add=intval($_GET["add"]);
$edit=intval($_GET["edit"]);
$delete=intval($_GET["delete"]);
$up=intval($_GET["up"]);
$down=intval($_GET["down"]);
$parent=intval($_GET["parent"]);
if($edit>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where auto_id='$edit' "))==0) header("Location: index.php?do=$do");

if($_POST) // Add && edit
{
    extract($_POST);
    $parent_auto_id=intval($parent_auto_id);
    $link=safe($link);

    $last_order=mysqli_fetch_assoc(mysqli_query($db,"select order_number from $do where parent_auto_id='$parent_auto_id' order by order_number desc"));
    $last_order=intval($last_order["order_number"])+1;
    $auto_id=mysqli_fetch_assoc(mysqli_query($db,"select auto_id from $do order by auto_id desc"));
    $auto_id=intval($auto_id["auto_id"])+1;
    $active=1;

    if($edit>0)
    {
        $info_edit=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' "));
        $add_where="and auto_id='$edit' ";
        $auto_id=$edit;
        $last_order=$info_edit["order_number"];
        $active=$info_edit["active"];

        if($parent_auto_id!=$info_edit["parent_auto_id"])
        {
            $info_edit2=mysqli_fetch_assoc(mysqli_query($db,"select order_number from $do where parent_auto_id='$parent_auto_id' order by order_number desc limit 1 "));
            $last_order=$info_edit2["order_number"]+1;
        }
    }
    else $add_where="";

    $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");

    $time = time();

    while($row=mysqli_fetch_assoc($sql))
    {
        $name="name_".$row["id"]; $name=mysqli_real_escape_string($db,htmlspecialchars($$name));
        $text="text_".$row["id"]; $text=mysqli_real_escape_string($db,htmlspecialchars($$text));

        if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$row[id]' $add_where"))>0 && $edit>0)
        {
            mysqli_query($db,"update $do set name='$name',text='$text',parent_auto_id='$parent_auto_id', order_number='$last_order', link='$link',updated_at='$time' where lang_id='$row[id]' $add_where");

            if($info_edit["parent_auto_id"]!=$parent_auto_id)
            {
                $new_order=1;
                $sql2=mysqli_query($db,"select auto_id from $do where lang_id='$esas_dil' and parent_auto_id='$parent_auto_id' order by order_number");
                while($row2=mysqli_fetch_assoc($sql2))
                {
                    mysqli_query($db,"update $do set order_number='$new_order' where parent_auto_id='$parent_auto_id' and auto_id='$row2[auto_id]' ");

                    $new_order++;
                }
            }
        }
        else
            mysqli_query($db,"insert into $do values (0,'$name','$link','$text','$parent_auto_id','$last_order', '$active', '$row[id]', '$auto_id', '$time', '0') ");
    }

    $ok="Data has been successfully saved.";
    $edit=0;
}

if($delete>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$delete'"))>0)
{
    mysqli_query($db,"delete from $do where parent_auto_id='$parent' and auto_id='$delete' ");
    mysqli_query($db,"delete from $do where parent_auto_id='$delete' ");

    $ok="Data has been successfully deleted.";

    $new_order=1;
    $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='$parent' order by order_number");       $order_update='';

    while($row=mysqli_fetch_assoc($sql))
    {
        $order_update.=" when auto_id='$row[auto_id]' and parent_auto_id='$parent' then '$new_order' ";
        $new_order++;
    }
    $query_update="update $do set order_number=case".$order_update."else order_number end;";
    if($order_update!='') mysqli_query($db,$query_update);
}
elseif($up>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$up' "))>0)
{
    $current_order=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' and auto_id='$up' "));     $current_order=$current_order["order_number"];
    if($current_order>1)
    {
        $previous_order=$current_order-1;
        mysqli_query($db,"update $do set order_number='-1' where parent_auto_id='$parent' and order_number='$previous_order' ");
        mysqli_query($db,"update $do set order_number='$previous_order' where parent_auto_id='$parent' and order_number='$current_order' ");
        mysqli_query($db,"update $do set order_number='$current_order' where parent_auto_id='$parent' and order_number='-1' ");
    }
}
elseif($down>0 && mysqli_num_rows(mysqli_query($db,"select id from $do where parent_auto_id='$parent' and auto_id='$down' "))>0)
{
    $current_order=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' and auto_id='$down' "));
    $current_order=$current_order["order_number"];
    $last_order=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where parent_auto_id='$parent' order by order_number desc"));
    $last_order=$last_order["order_number"];
    if($current_order<$last_order)
    {
        $next_order=$current_order+1;
        mysqli_query($db,"update $do set order_number='-1' where parent_auto_id='$parent' and order_number='$next_order' ");
        mysqli_query($db,"update $do set order_number='$next_order' where parent_auto_id='$parent' and order_number='$current_order' ");
        mysqli_query($db,"update $do set order_number='$current_order' where parent_auto_id='$parent' and order_number='-1' ");
    }
}
?>
<div class="onecolumn">
    <div class="header">
        <span>Menus</span>
        <div class="switch">
            <table cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <?php
                    $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");
                    if(mysqli_num_rows($sql)>1 and ($add==1 || $edit>0) )
                    {
                        while($row=mysqli_fetch_assoc($sql))
                        {
                            echo '<td><input type="button" id="tab_lang'.$row["id"].'" onclick="tab_select(this.id)" class="left_switch" value="'.$row["ad"].'" style="width:50px"/></td>';
                        }
                    }
                    ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br class="clear"/>
    <div class="content">
        <?php
        if($ok!="") echo '<div class="alert_success"><p><img src="images/icon_accept.png" alt="success" class="mid_align"/>'.$ok.'</p></div>';
        if($error!="") echo '<div class="alert_error"><p><img src="images/icon_error.png" alt="delete" class="mid_align"/>'.$error.'</p></div>';
        ?>
        <!-- Content start-->
        <form action="index.php?do=<?php echo $do; ?><?php if($edit>0) echo '&edit='.$edit.''; ?>" method="post" id="form_login" name="form_login" enctype="multipart/form-data">
            <a href="index.php?do=<?php echo $do; ?>&add=1" style="margin-right:50px"><img style="vertical-align: text-top;" src="images/icon_add.png" alt="" /> <b>Create new</b></a>
            <hr class="clear" />
            <?php
            $sql=mysqli_query($db,"select * from diller where aktivlik=1 order by sira");
            while($row=mysqli_fetch_assoc($sql))
            {
                if($add==1 || $edit>0) $hide=""; else $hide="hide";
                $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$row[id]' "));

                if($lang_count>1) echo '<div id="tab'.$row["id"].'_content" class="tab_content '.$hide.'">'; else echo '<div class="'.$hide.'">';
                echo '  Name:<br />
			  <input type="text" name="name_'.$row["id"].'" value="'.$information["name"].'" style="width:250px" />
			  <br /><br />
			  Text:<br />
			<textarea name="text_'.$row["id"].'" rows="1" cols="1" id="editor'.$row["sira"].'">'.$information["text"].'</textarea>
			<br /></div>
			  ';
            }
            $information=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where auto_id='$edit' and lang_id='$main_lang' "));
            echo '<div class="'.$hide.'">';

            echo 'Link:<br /><input type="text" name="link" value="'.$information["link"].'" style="width:250px" /><br /><br />
		    
		    Parent menu<br />
			<select name="parent_auto_id" id="cat">
			<option value="0"> </option>';
            $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id!='$edit' order by order_number");
            while($row=mysqli_fetch_assoc($sql))
            {
                if($row["auto_id"]==$information["parent_auto_id"]) echo '<option value="'.$row["auto_id"].'" selected="selected">'.$row["name"].'</option>';
                else echo '<option value="'.$row["auto_id"].'">'.$row["name"].'</option>';
            }
            echo '</select><br /><br />
			<input type="submit" name="button" value=" Save " />
			  <hr class="clear" />
			  <br class="clear" /></div>';

            ?>
        </form>
        <a href="javascript:void(0);" class="chbx_del"><img src="images/icon_delete.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="1"><img src="images/1_lamp.png" alt="" title="" /></a>
        <a href="javascript:void(0);" class="chbx_active" data-val="2"><img src="images/0_lamp.png" alt="" title="" /></a>
        <input type="hidden" value="index.php?do=<?=$do?>&page=<?=$page?>&limit=<?=$limit?>&forId=2" id="current_link" />

        <?php
        function sub_menular($do,$main_lang,$parent_auto_id)
        {
            global $db;
            $mesafe='';
            $yoxlanis_parent_auto_id=$parent_auto_id;
            for($i=1;$i<=10;$i++)
            {
                $yoxlanis=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$yoxlanis_parent_auto_id' "));
                if($yoxlanis["auto_id"]==0) break;
                else
                {
                    $yoxlanis_parent_auto_id=$yoxlanis["parent_auto_id"];
                    $mesafe.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }

            $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='$parent_auto_id' order by order_number");
            while($row=mysqli_fetch_assoc($sql))
            {
                $ana_menyu=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$row[parent_auto_id]' "));
                echo '<tr>
						<td>'.$mesafe.'<input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.$row["name"].'</td>
						<td>'.$ana_menyu["name"].'</td>
						<td>
							<a href="index.php?do='.$do.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Düzəliş" /></a>
							';
//						if($row["vacib_menu"]=="0") echo '<a href="index.php?do='.$do.'&parent='.$row["parent_auto_id"].'&delete='.$row["auto_id"].'" class="delete" data-title='.$row['name'].'><img src="images/icon_delete.png" alt="" title="Sil" /></a>';
                echo '
							<a href="index.php?do='.$do.'&up='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/up.png" alt="" title="Up" /></a>
							<a href="index.php?do='.$do.'&down='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/down.png" alt="" title="Down" /></a>';
                if($row["active"]==1) $title='Active'; else $title='Deactive';
                echo '<img src="images/'.$row["active"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />';
                echo '</td>
					</tr>';

                if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$main_lang' and parent_auto_id='$row[auto_id]' and $row[auto_id]>0"))>0)
                {
                    $parent_auto_id=$row["auto_id"];
                    sub_menular($do,$main_lang,$parent_auto_id);
                }
            }
        }
        //////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////
        echo '<table class="data" width="100%" cellpadding="0" cellspacing="0" ><thead><tr>
	<th style="width:40%"><input type="checkbox" data-val="0" name="all_check" id="hamisini_sec" value="all_check" /> Name</th>
	<th style="width:30%">Parent menu</th>
	<th style="width:30%">Editing</th>
</tr></thead><tbody>';
        $sql=mysqli_query($db,"select * from $do where lang_id='$main_lang' and parent_auto_id='0' order by order_number");
        while($row=mysqli_fetch_assoc($sql))
        {
            $ana_menyu=mysqli_fetch_assoc(mysqli_query($db,"select * from $do where lang_id='$main_lang' and auto_id='$row[parent_auto_id]' "));
            echo '<tr>
					<td><input type="checkbox" id="chbx_'.$row["auto_id"].'" value="'.$row["auto_id"].'" onclick="chbx_(this.id)" /> '.$row["name"].'</td>
					<td>'.$ana_menyu["name"].'</td>
					<td>
						<a href="index.php?do='.$do.'&edit='.$row["auto_id"].'"><img src="images/icon_edit.png" alt="" title="Edit" /></a>
						';
//						if($row["vacib_menu"]=="0") echo '<a href="index.php?do='.$do.'&parent='.$row["parent_auto_id"].'&delete='.$row["auto_id"].'" class="delete" data-title="'.$row["name"].'"><img src="images/icon_delete.png" alt="" title="Sil" /></a>';
            echo '
						<a href="index.php?do='.$do.'&up='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/up.png" alt="" title="Up" /></a>
						<a href="index.php?do='.$do.'&down='.$row["auto_id"].'&parent='.$row["parent_auto_id"].'"><img src="images/down.png" alt="" title="Down" /></a>';
            if($row["active"]==1) $title='Active'; else $title='Deactive';
            echo '<img src="images/'.$row["active"].'_lamp.png" title="'.$title.'" border="0" align="absmiddle" style="cursor:pointer" id="info_'.$row["auto_id"].'" onclick="aktivlik(\''.$do.'\',this.id,this.title)"  />';
            echo '</td>
				</tr>';


            if(mysqli_num_rows(mysqli_query($db,"select id from $do where lang_id='$main_lang' and parent_auto_id='$row[auto_id]' and $row[auto_id]>0"))>0)
            {
                $parent_auto_id=$row["auto_id"];
                sub_menular($do,$main_lang,$parent_auto_id);
            }
        }
        echo '</tbody></table>';
        ?>
        <br class="clear"/>
        <!-- Content end-->
    </div>
</div>