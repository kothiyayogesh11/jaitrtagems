<?php
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header); 
?>
<div id="content" class="content">
<?php
$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'name' => 'frm_add',"method"=>"post");
echo form_open_multipart('pets/list_type', $attributes);
?>
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Order</a></li>
				<li class="breadcrumb-item active"><a href="javascript:;">Pending List</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Order - Pending List <!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
            <!-- begin nav-pills -->
			<p class="m-b-0">
                <a href="<?php echo base_url("order/form"); ?>" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-plus"></i> Add</a>
                <a href="javascript:;" onclick="DeleteRow();" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-trash-alt"></i> Delete</a>
            </p>
            <br />
            <!-- end nav-pills -->
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <!-- begin panel -->
                <div class="panel pagination-inverse clearfix m-b-0">
                	<span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                    <table id="data-table" data-order='[[1,"asc"]]' class="table table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th data-sorting="disabled"></th>
                                <th>Sr.No.</th>
                                <th>Customer</th>
                                <th>Order</th>
                                <th>Price</th>

                                <th>Partner</th>
                                <th>Employee</th>
                                <th>Order Status</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
                        if(isset($rsData) && !empty($rsData)){
						$i=0;
						$row = "";
                        foreach($rsData as $rec):
						if($i %2 == 0)$row = "odd";
						else $row = "even";
                        ?>
                        <tr class="<?php echo $row;?>" id="row_<?php echo $rec["order_id"]; ?>" data-val="<?php echo $rec["order_id"]; ?>">
                            <td><input type="checkbox" name="record[]" value="<?php echo $rec["order_id"]; ?>" /></td>
                            <td><a href="<?php echo base_url("order/form/".$rec["order_id"]); ?>"><?php echo ($i+1); ?></a></td>
                            <td><?php echo $rec["customer_name"]; ?></td>
                            <td><?php echo $rec["activity_name"]; ?></td>
                            <td><i class="fa fa-dollar-sign"></i> <?php echo $rec["activity_price"]; ?></td>

                            <td><?php echo $rec["partner_name"]; ?></td>
                            <td><?php echo $rec["employee_name"]; ?></td>
                            <td><button type="button" class="<?php echo $orderStatusLabel[$rec["order_status"]] ?>"><?php echo ucwords($rec["order_status"]); ?></button></td>
                            <td>
							<?php 
								$date 		= $rec["slot_date"] != "" ? date("D, d-M-Y",strtotime($rec["slot_date"])) : "";
								$from_time 	= $rec["from_order_time"] != "" ? date("h:1 A",strtotime($rec["from_order_time"])) : "";
								$to_time 	= $rec["to_order_time"] != "" ? date("h:1 A",strtotime($rec["to_order_time"])) : "";
								$slot_date = $date."<br>".$from_time." - ".$to_time;
                            echo $slot_date; ?>
                            </td>
                            <td><?php echo $activeArr[$rec["delete_flag"]]; ?></td>
                        </tr>
                        <?php
						$i++;
                        endforeach;
                        }else{
                            echo '<tr><td colspan="8">No data available</td></tr>';	
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- end panel -->
			</div>
			<!-- end section-container -->
<?php 
echo form_close();
$assets_footer['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js').'"></script>
    <script src="'.base_url('assets/js/page-table-manage-fixed-header.demo.min.js').'"></script>
    <script src="'.base_url('assets/js/demo.min.js').'"></script>
    <script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_footer); ?>
<script>
$(document).on("click",".delete-row",function(){
	var $obj = $(this);
	var id = $obj.attr("data-val");
	if(id != "" && confirm("Are you sure want to delete record ?")){
		$.ajax({
			type:"POST",
			url:BASE_URL+"pets/delete_type_by_id",
			data:{"id":id},
			dataType:"json",
			success: function(res){
				if(typeof res.error !== "undefined" && res.error == 1){
					var $tr = $obj.parents("tr");
					$tr.hide(200,function(){$tr.remove();})
					alert(res.message);
				}else{
					var $tr = $obj.parents("tr");
					$tr.hide(200,function(){$tr.remove();});
				}
			}
		});
	}
});

function DeleteRow(){
	var intChecked = $("input[name='record[]']:checked").length;
	if(intChecked == 0){
		alert("No User selected.");
		return false;
	}else{
		var responce = confirm("Do you want to delete selected record(s)?");
		if(responce==true){
			$('#frm_add').attr('action',BASE_URL+'pets/delete');
			$('#frm_add').submit()	
		}
	}
}
</script>