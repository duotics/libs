<?php 
/*SELECT PARA UN GENERARSELECT WITH N PARAMS
Select para un Listado Form HTML
v.0.1
v.0.2 -> 2017-05-05 :: Correcciones codigo
v.0.3 -> 2017-11-22 :: Valida si el parametro tiene valor
v.1.0 -> 20191009 : mysqli updated
v.1.1 -> 20200612 : add $lP=null - fix bug php 7 undefined
v.1.2 -> 20200612 : add null vars $orderBy and $list - fix bug php 7 undefined
*/
function detRowSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//duotics-lib -> v1.2
	global $conn;
	$lP=null;
	$orderBy=null;
	$list=null;
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal){
				$lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'];
				//if($xVal[val]) $lP.=' "'.$xVal['val'].'" ';
				$lP.=' "'.$xVal['val'].'" ';
			}
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP.' %s',
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	SSQL($orderBy,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$tRS=mysqli_num_rows($RS);
	
	if($tRS>0){ $x=0;
		do{ 
			$list[$x]=$dRS['sID'];
			$x++;
		}while ($dRS = mysqli_fetch_assoc($RS));
	}
	mysqli_free_result($RS);
	return ($list);
}
?>
<?php
/*HOW TO USE*/
$paramsN[]=array(
	array("cond"=>"AND","field"=>"fiel_db","comp"=>"=","val"=>$val1),
	array("cond"=>"AND","field"=>"fiel_db","comp"=>'=',"val"=>$val1)
);
$RS=detRowGSelNP('table','field_id','field_nom',$paramsN,TRUE,'field_ord','ASC');
//Used with function genSelect
echo genSelect('name_select', $RS, $valSel, 'form-control input-sm '); ?>