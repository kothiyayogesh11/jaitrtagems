<?php
if(isset($getSeatData)){
	$this->table->set_heading(array('SeatNM','IS_BOOKED','Status','Pay Mode','Pay Through','Pay Status','Customer Name','Contact','Email','Customer Type','Seat Amount','Total Pay'));
	$this->table->set_template(table_template());
	foreach($getSeatData as $sv){
		$tdata['seat_name'] = $sv['seat_name'];
		$tdata['seat_booked'] = $sv['seat_booked'];
		$tdata['seat_status'] = $sv['seat_status'];
		$tdata['pay_mode'] = $sv['pay_mode'];
		$tdata['bayment_by'] = $sv['bayment_by'];
		$tdata['pay_status'] = $sv['pay_status'];
		$tdata['cname'] = $sv['cname'];
		$tdata['ccontact'] = $sv['ccontact'];
		$tdata['cemail'] = $sv['cemail'];
		$tdata['ctype'] = $sv['ctype'];
		$tdata['seat_fare'] = $sv['seat_fare'];
		$tdata['mer_pay'] = $sv['mer_pay'];
		$this->table->add_row($tdata);
	}
	echo $this->table->generate();
}

if(isset($bookingData) && !empty($bookingData)){
	$total_get = $pending= 0;
	foreach($bookingData as $val){
?>
    <h3><?php echo $val['cname'].' '.date('D, d-m-Y',strtotime($val['d_date'])) ?></h3>
    <div class="form-group">
    	<label class="form-label">Payment Total : <b><span class="pamount" data-val="<?php echo $val['b_fare'] ?>"><?php echo $val['b_fare'] ?></span></b></label>
        
    </div>
    <div class="form-group">
    	<label class="form-label">Payment By : <span><?php echo $val['pd_payment_by']  == '' ? 'Cash' : $val['pd_payment_type'];?></span></label>
        
    </div>
    <div class="form-group">
    	<label class="form-label">Payment Type : <span><?php echo $val['pd_payment_type'] == '' ? 'Cash' : $val['pd_payment_type']; ?></span></label>
        
    </div>
    <div class="form-group">
    	<label class="form-label">Payment Status : <span><?php echo $val['pd_order_status'] == '' ? 'pending' : $val['pd_order_status']; ?></span></label>
        
    </div>
    <?php 
		if($val['pd_order_status'] == ''){
			$pending 	+= $val['b_fare'];
		}else{
			$total_get 	+= $val['b_fare'];
		}
	
	}
?>
	<h3><b>Credited : </b><?php echo $total_get; ?></h3>
    <h3><b>Pending : </b><?php echo $pending; ?></h3>
    <h3><b>Total Payment : </b><?php echo $pending + $total_get; ?></h3>
<?php
}
?>