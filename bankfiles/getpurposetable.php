<?php
include '../ajaxconfig.php';

$getitem=$con->query("SELECT * FROM purpose WHERE  status=0 ");
if($getitem->num_rows<0){
	$message = 'Purpose Not Found';
	echo json_encode($message);
}
else{ ?>
<table id="purposetable" class="table custom-table">
		<thead>
			<tr>
			<th>S. No</th>
			<th>PURPOSE</th>
			<th>ACTION</th>
			</tr>
			</thead>
			<tbody><?php
			$i=1;
while($row=$getitem->fetch_assoc()) { ?>
<div style="overflow-x: auto;">
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php if(isset($row["purposename"])){ echo $row["purposename"]; }?></td>
					<td>
						<a id="editpurpose" value="<?php if(isset($row["purposeid"])){ echo $row["purposeid"];}?>"><span class="icon-border_color"></span></a> &nbsp

						 <a id="deletepurpose" value="<?php if(isset($row["purposeid"])){ echo $row["purposeid"]; }?>"><span class='icon-trash-2'></span>
					    </a>
			           </td>
			</tr>
			<?php $i=$i+1; } ?>
			</tbody>
			</table>	
		</div>
<?php } ?>

<script type="text/javascript">
	$(function(){
	  $('#purposetable').DataTable({
	    'iDisplayLength': 5,
	    "language": {
	      "lengthMenu": "Display _MENU_ Records Per Page",
	      "info": "Showing Page _PAGE_ of _PAGES_",
	    }
	  });
});
</script>