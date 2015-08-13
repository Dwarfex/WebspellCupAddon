<?php

if(!issuperadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

/* GET MEMORY USAGE */

function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

/* DATABASE OPTIMIZATION */

//get statuses for tables in db
$sql = "SHOW TABLE STATUS";
$result	= safe_query($sql);
 
//initialize array
$tables = array();
while($row = mysqli_fetch_array($result))
{
    // return the size in Kilobytes
    $table_size = ($row[ "Data_length" ] + $row[ "Index_length" ]) / 1024;
    $tables[$row['Name']] = sprintf("%.2f", $table_size);
 
    //get total size of all tables
    $total_size += round($table_size,2);
 
    // optimize tables
    $optimise_sql = "OPTIMIZE TABLE {$row['Name']}";
    $optimise_result = safe_query($optimise_sql);
}
 
//get statuses for tables in db after optimization
$sql = "SHOW TABLE STATUS";
 
//initialize array
$optimised_tables = array();
$result	= safe_query($sql);
while($row = mysqli_fetch_array($result))
{
	// return the size in Kilobytes
	$table_size = ($row[ "Data_length" ] + $row[ "Index_length" ]) / 1024;
	$optimised_tables[$row['Name']] = sprintf("%.2f", $table_size);
 
	//get total size of all tables after optimization
	$optimise_total_size += round($table_size,2);
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
	<thead>
		<tr>
			<td class="title">Table</td>
			<td class="title">Size (KB)</td>
			<td class="title">Optimised Size (KB)</td>
			<td class="title">Optimised</td>
		</tr>
	</thead>
	<tbody>
    <?
    
	foreach($tables as $table => $size):
	$n = 1;
    if($n%2) { $td='td1'; }
    else { $td='td2'; }
	?>
	<tr>
		<td class="<?=$td;?>"><?=$table;?></td>
		<td class="<?=$td;?>"><?=$size;?></td>
		<td class="<?=$td;?>"><?=$optimised_tables[$table];?></td>
		<td class="<?=$td;?>">
			<?if($size > $optimised_tables[$table]):?>
				<?=$size - $optimised_tables[$table];?>
			<?endif;?>
		</td>
	</tr>
	<? $n++; endforeach;?>
	<tr>
		<td class="td_head"><b>Total</b></td>
		<td class="td_head"><b><?=$total_size;?></b></td>
		<td class="td_head"><b><?=$optimise_total_size;?></b></td>
		<td class="td_head"><b><?=round($total_size - $optimise_total_size,2);?></b></td>
	</tr>
	<tr>
		<td colspan="1" align="left" class="td_head"><b>Memory Usage</b></td>
		<td colspan="3" align="right" class="td_head"><b><? echo convert(memory_get_usage(true)) ?></b></td>
	</tr>
	</tbody>
</table>