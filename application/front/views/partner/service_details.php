<?php
if(!empty($partner)){
?>
<div>
<?php
    $html = "";
    
        $html .= '<div class="row mt-2">';
            $html .= '<div class="col-sm-4 text-center">';
                $html .= '<div class="mb-3"><img src="'.SITEURL.'assets/icons/company.png" class="img-thumbnail" /></div>';
                $html .= '<div class="h6 mb-2 font-weight-bold">'.ucwords($partner["business_name"]).'</div>';
                $html .= '<div class="mb-3"><i class="fa fa-map-marker theam-color"></i> '.ucwords($partner["city_state"]).'</div>';
                $html .= '<div class="mb-3"><input type="button" value="Message" class="btn btn-primary login-form-button py-2 px-4 text-white"></div>';
                $html .= '<div class="mb-3"><input type="button" value="Book" class="btn btn-primary login-form-button book-accelaret py-2 px-4 text-white text-center active"></div>';
            $html .= '</div>';

            /* $html .= '<div class="col-sm-9">';
                $html .= '<div class="h6 mb-0">'.ucwords($val["partner_name"]).'</div>';
                if($val["city_name"] != "")
                $html .= '<div class="text-muted">'.ucwords($val["city_name"]).', '.strtoupper($val["city_code"]).' </div>';
                $html .= '<div><i class="fa fa-user-o"></i> <i class="fa fa-user-o"></i> <i class="fa fa-user-o"></i> <i class="fa fa-user-o"></i></div>';
            $html .= '</div>'; */

            $html .= '<div class="col-sm-8">';
                $html .= '<div class="row">';
                    $html .= '<div class="col-sm-6"><i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i> <i class="fa fa-star-half-o" aria-hidden="true"></i></div>';

                    $html .= '<div class="col-sm-6 text-right font-weight-bold"> $25 per hour</div>';
                    $html .= '<div class="col-sm-12 mb-3">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Ciceros De Finibus Bonorum et Malorum for use in a type specimen book.';
                    $html .= '</div>';


                    $html .= '<div class="col-sm-12 mb-3">';
                        if(isset($media) && !empty($media)){
                            $i=0;
                            foreach($media as $val){
                                if($i <= 3){
                                    $html .= '<div class="activity-media p-2"><a data-fancybox="images" href="'.SITEURL.$val["media"].'"><img class="img img-fluid" src="'.SITEURL.$val["media"].'" /></a></div>';
                                    $i++;
                                }
                            }
                        }
                    $html .= '</div>';

                    $html .= '<div class="col-sm-12">';
                        $html .= '<div id="geomap"></div>';
                    $html .= '</div>';

                $html .= '</div>';
            $html .= '</div>';

        $html .= '</div>';
    echo $html;
?>
</div>
<?php
}
?>