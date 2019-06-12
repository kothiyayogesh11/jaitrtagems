<table style="width:100%">

<!--<thead>

	<tr>

        <th>Media</th>

    </tr>

</thead>-->

<tbody>

	<tr>

     <td>

     <div  style="max-height: 200px; overflow: auto; margin:0 auto;" class="html5gallery" data-skin="light" data-width="420" data-height="272" data-slideshadow="false" data-resizemode="fill">

	<?php 

		$i = 0;

		if(!empty($NewsMedia)){

			foreach($NewsMedia as $mval){

				$i++;

				$file = $mval['file'];

				$type = $mval['type'];

				$path = file_check($file);

				

				$disp_file = '';

				if(in_array(strtolower($type),array('image'))){

					$disp_file = '<a class="fancybox-button" data-fancybox="gallery" rel="fancybox-button" href="'.$path.'"><img class="table-news-image" src="'.$path.'"></a>';

					//$disp_file = '<a class="example-image-link" href="'.$path.'" data-lightbox="example-1"><img class="table-news-image" src="'.$path.'" /></a>';

					

				}else if(in_array(strtolower($type),array('video'))){

					$disp_file = '<a class="fancybox-button" css-attr="video" data-fancybox="gallery" rel="fancybox-button" href="'.$path.'"><video style="height:100px; width:200px;vertical-align: middle;" controls>

									  <source src="'.$path.'" type="video/'.$type.'">

									  <source src="movie.ogg" type="video/ogg">

									   Your browser does not support the video tag.

									   </video></a>';

				}else if(in_array(strtolower($type),array('audio'))){

					$disp_file = '<a class="fancybox-button" css-attr="video" data-fancybox="gallery" rel="fancybox-button" href="'.$path.'"><audio style="height:100px; width:200px;vertical-align: middle;" controls>

									  <source src="'.$path.'" type="audio/'.$type.'">

									  <source src="movie.ogg" type="audio/ogg">

									Your browser does not support the audio element.

									</audio></a>';

				}

				echo $disp_file;    	

			}

		}else{		

			echo 'No media record found.';	

		}

	?>

    </div>

    </td>

    </tr>

</tbody>

</table>

