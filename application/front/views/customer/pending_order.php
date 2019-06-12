<?php
$html = '';
if(isset($pending_order) && !empty($pending_order)){
    $html .= '<div class="row">';
    foreach($pending_order as $val){
        $html .= '<div class="col-md-6 mb-3 pending-order-wrapper" data-activity="'.$val["activity_id"].'" data-order="'.$val["order_id"].'">';
            $html .= '<div class="request-wrap" style="border: 2px solid #ccc; border-radius: 15px;">';
                $html .= '<div class="request-date paddind10 gray">';
                    $html .= date("d F, Y",strtotime($val["activity_date"]));
                $html .= '</div>';
                $html .= '<div class="request-date paddind10">';
                    $book_time = date("H A",strtotime($val["order_start_date"])).' - '.date("H A",strtotime($val["order_end_date"]));
                    $html .= '<span class="request-time gray">'.$book_time.' </span><span class="bold500">&nbsp '.$val["order_title"].'   </span>';
                $html .= '</div>';
                $html .= '<div class="paddind10 text-center">';
                    $html .= '<input type="button" value="View Details" class="btn btn-primary login-form-button order-view-accelerate py-2 px-4 text-white text-center"> <input type="button" data-partner="get" value="Book" class="btn btn-primary login-form-button  py-2 px-4 text-white text-center active">';
                $html .= '</div>';
            $html .= '</div>';
        $html .= '</div>';
    }
    $html .= '</div>';
}
echo $html;
?>