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
				<li class="breadcrumb-item"><a href="javascript:;">Setting</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Map User Type Module</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Setting - Map User Type to Module <!--<small>header small text goes here...</small>--></h1>
			<!-- end page-header -->
            <!-- begin nav-pills -->
			<p class="m-b-0">
                <!--<a href="<?php echo base_url("client/form"); ?>" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-plus"></i> Add</a>
                <a href="javascript:;" onclick="DeleteRow();" class="btn btn-white m-r-5"><i class="fa fa-fw m-r-10 pull-left f-s-18 fa-trash-alt"></i> Delete</a>-->
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
                            <tr style="width:10%;" class="hdr">
                                <th class="center">+/-</th>
                                <th>User Type</th>
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
                        <tr id="row_<?php echo $rec['u_typ_id']; ?>" class="<?php echo $row;?>" data-val="<?php echo $rec['u_typ_id']; ?>">
                            <td style="width:10%;" class="plus span1 center" id="<?php echo $rec['u_typ_id']; ?>">+</td>
                            <td>
                                <?php echo $rec['u_typ_name']; ?>
                            </td>
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
            <!-- START GRID -->
<div class="resp">
</div>
<!-- END GRID -->
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
<script type="text/javascript">
	$(document).ready(function(){
		$(".plus").click(function(){
			var utype_id = this.id;
			$(".resp").remove();
			if($.trim($(this).html()) == '+')
			{
				$(".plus").html('+');
				$(this).html('-');
				$.ajax({
					type:"POST",
					url:"<?php echo base_url('commonajax/getUtypeModuleDetails'); ?>",
					data:"utype_id="+utype_id,
					beforeSend:function(){
					},
					success:function(res){
						$("#row_"+utype_id).after('<tr class="resp"><td colspan="2">'+res+'</td></tr>');
					}
				});
			}
			else
			{
				$(this).html('+');
			}
		});
	});
</script>