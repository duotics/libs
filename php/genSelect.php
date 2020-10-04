<?php
//FUNCTION -genSelect- TO GENERATE SELECT (FORM html)
/* Documentation
	//PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
*/
/* version history
	v.3.0 show ini supported
	v.3.1 (Añadido params $valIni, $nomIni : para valores por defecto del option inicial)
	v.3.2 (Multiple con soporte choses, selected multiple)
	v.3.3 fix bug
	v.3.3.1 Added Extra Documentation
	v.4.0 mysqli implemented
*/
function genSelect($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){//duotics_lib->v.4.0
	if($RS){
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	//Show Ini Value
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($tRS>0){
	do {
		$grpAct=$dRS['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$dRS['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$dRS['sID'].'"'; 
		if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$dRS['sVAL'].'</option>';
	} while ($dRS = mysqli_fetch_assoc($RS));
	if($banG==true) echo '</optgroup>';
	$rows = mysqli_num_rows($RS);
	if($rows > 0) {
		mysqli_data_seek($RS, 0);
		$dRSe = mysqli_fetch_assoc($RS);
	}
	}
	echo '</select>';
	mysqli_free_result($RS);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}
?>

<?php  genSelect('txtProv', detRowGSel('tbl_prov','prov_id','prov_nom','1','1'), $detA['prov_id'], $class='form-control', 'required', 'txtProv', 'Seleccionar Provincia', TRUE,NULL,'Seleccione') ?>