<?php
if(!empty($partner)){
?>
<div>
<?php
    $html = "";
    foreach($partner as $val){
        $html .= '<div class="row partner-accelerate mt-4 pointer" data-partner="'.$val["partner_id"].'">';
            $html .= '<div class="col-sm-5">';
                $html .= '<div class="h6 mb-0"> <img style="max-width:40px;" src="'.SITEURL.'assets/icons/company.png" /> '.ucwords($val["partner_name"]).'</div>';
            $html .= '</div>';

            $html .= '<div class="col-sm-2">';
                $html .= '<span class="text-muted">3 kms</span>';
            $html .= '</div>';

            $html .= '<div class="col-sm-2">';
                //$html .= '<div class="h6 mb-0">'.ucwords($val["partner_name"]).'</div>';
                if($val["city_name"] != "")
                $html .= '<div class="text-muted">'.ucwords($val["city_name"]).', '.strtoupper($val["city_code"]).' </div>';
                
            $html .= '</div>';

            $html .= '<div class="col-sm-3"><div><i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i></div>';
            $html .= '</div>';

        $html .= '</div>';
    }
    echo $html;
?>
</div>
<?php
}
?>