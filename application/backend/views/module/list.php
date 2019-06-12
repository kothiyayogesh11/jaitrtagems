<?php
$assets_header['css'] = '<link href="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css').'" rel="stylesheet" /><link href="'.base_url('assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css').'" rel="stylesheet" />
	<link href="'.base_url('assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css').'" rel="stylesheet" />';
$this->load->view('top',$assets_header); 
?>
<div id="content" class="content">
<?php
$attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'name' => 'frm_add',"method"=>"post");
echo form_open_multipart('setting/module_list', $attributes);
?>
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Setting</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Module</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setting - Module list <!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
            <!-- begin nav-pills -->
			<p class="m-b-0">
                <a href="<?php echo base_url("setting/addModule"); ?>" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-plus"></i> Add</a>
                <a href="javascript:;" onclick="DeleteRow();" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-trash-alt"></i> Delete</a>
                <select class="selectpicker" data-size="10" data-live-search="true" data-style="btn-white" name="slt_panel" id="slt_panel" >
					<?php echo $this->page->generateComboByTable("panel_master","panel_id","panel_name","","where status='ACTIVE'",$panel_id,"All"); ?>
                </select>
           
                 <input type="submit" class="btn btn-grey btn-small" value="Search" onclick="return submit_form(this.form);">        
            </p>
            <br />
            <!-- end nav-pills -->
			<!-- begin section-container -->
			<div class="section-container section-with-top-border">
                <!-- begin panel -->
                <div class="panel pagination-grey clearfix m-b-0">
                	<span id="str_error_msg"><?php echo isset($this->error_msg) && !empty($this->error_msg) ? $this->error_msg : ''; ?></span>
                    <table id="data-table" data-order='[[1,"asc"]]' class="table table-bordered table-hover">
                        <thead>
                            <tr class="grey">
                                <th data-sorting="disabled"><input type="checkbox" name="record[]" value="" /></th>
                                <th>Module Name</th>
                                <th>Panel Id</th>
                                <th>Module Url</th>
                                <th>Sequence</th>
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
							$strEditLink	=	base_url("setting/AddModule/".$rec['module_id']);
							echo '<tr class="'.$row.'" id="row_'.$rec["module_id"].'" data-val="'.$rec["module_id"].'">';
							echo '<td><input type="checkbox" name="record[]" value="'.$rec["module_id"].'" /></td>';
							echo '<td><a href="'.$strEditLink.'" class="green" title="Edit">'. $rec['module_name'].'</a></td>';
							echo '<td>'. $rec['panel_name'] .'</td>';
							echo '<td>'. $rec['module_url'] .'</td>';
							echo '<td>'. $rec['seq'] .'</td>';
							echo '<td>'. $rec['status'] .'</td>';														
							echo '</tr>';
							$i++;
							
                        endforeach;
                        }else{
                            echo '<tr><td colspan="6">No data available</td></tr>';	
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
$assets_footer['js'] = '<script src="'.base_url('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js').'"></script></script><script src="'.base_url('assets/plugins/bootstrap-select/bootstrap-select.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/media/js/jquery.dataTables.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js').'"></script>
	<script src="'.base_url('assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js').'"></script>
    <script src="'.base_url('assets/js/page-table-manage-fixed-header.demo.min.js').'"></script>
    <script src="'.base_url('assets/js/demo.min.js').'"></script>
    <script src="'.base_url('assets/js/apps.min.js').'"></script>';
$this->load->view('bottom',$assets_footer); ?>
<script>
$(document).ready(function(e) {
    $("#slt_panel").selectpicker("render");
});
function DeleteRow(){
	var intChecked = $("input[name='record[]']:checked").length;
	if(intChecked == 0){
		alert("No User selected.");
		return false;
	}else{
		var responce = confirm("Do you want to delete selected record(s)?");
		if(responce==true){
			$('#frm_add').attr('action',BASE_URL+'setting/deleteModule');
			$('#frm_add').submit()	
		}
	}
}
</script>