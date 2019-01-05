<?php

function lgedit_add_url($table){
	return site_url('/lgedit/add/'.$table);
}

function lgedit_generate_cards($t,$datas=array(),$links=false){
	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgtables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$table = $tables[$t];

	$html ="<div data-table='$t' class='lgedit_cards row'>";

	foreach($datas as $data){

	$color = isset($data['ccolor']) ? $data['ccolor'] : 'blue-grey darken-1';
	$html .= "<div class='col s12 m6 l4'>";
	$html .= '<div class="card '.$color.' darken-3" data-id="'.$data['id'].'".>
            <div class="card-content white-text">
              <span class="card-title">'.$data['ctitle'];

	if(isset($data['creveal']) && !empty($data['creveal'])){
		$html.='<i class="material-icons right activator">more_vert</i>';
	}
	$html.='</span>
            	<p>'.$data['ccontent'].'</p>
			</div>';
	
	if(isset($data['creveal']) && !empty($data['creveal'])){
		$html.='<div class="card-reveal">
      <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
      <p>'.$data['creveal'].'</p></div>';

	};

    $html .='<div class="card-action">';
	if(!$CI->ion_auth->in_group('clients')){	
              $html .='<a class="copy" data-id="'.$data['id'].'" href="#">COPY</a>
              <a class="delete" data-id="'.$data['id'].'" href="#">DEL</a>';
	}
    //$html .='<a href="'.site_url($link[1].$data['id']).'">'.$link[0].'</a>';
    
	foreach($links as $lk => $lv){
		$html .='--'.$lv.$data['id'].'++';
		//$html .='<a href="'.site_url($lv.$data['id']).'">'.$lk.'</a>';
	}
    $html .='</div></div>';
	$html .= "</div>";
	}

	$html .= "</div>";
	return $html;	
	
}

function lgedit_generate_table($t,$datas=array(),$editable=true,$links=false,$dbclick=false){
	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgtables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$table = $tables[$t];

	$html = "<div id='lgedit_table' data-table=\"$t\">";
	$html .= '
		<form>
        <div class="input-field">
          <input id="lgedit_search" type="search" />
          <label for="lgedit_search"><i class="material-icons">search</i></label>
        </div>
      </form>

	';
	$html .= "<table class='highlight'>";
	$html .= "<thead>";
	$html.='<tr>';
	foreach($table['fields'] as $k => $v){
		$l = isset($v['label']) ? $v['label'] : $k;
		$c = isset($v['table_hide']) ? 'hide' : ''; 
		$html.="<th class='$c'>$l</th>";
	}
	$html.="<th></th>";
	$html.="</tr>";
	$html .= "<thead>";
	$html .= "<tbody>";
	foreach($datas as $d){

		$ccolor = '';
		if(isset($d['ccolor'])){
			$ccolor = $d['ccolor']." lighten-3";
		}

		$dblclick = $dbclick ? site_url($dbclick."/".$d[$table['id']]) : "";  
		
		$html.='<tr data-id="'.$d[$table['id']].'" class="'.$ccolor.'" data-dblclick="'.$dblclick.'">';
		foreach($table['fields'] as $kk => $vv){

			$val = $d[$kk];
			$dvals='';
			if(in_array($vv['type'],array('select','select_multi','checkboxs'))){
			
				$vals = $vv['values'];
				if(!is_array($vals)){
					$vals = call_user_func($vals);
				}

				$json_val = json_encode($vals);
				$multi = in_array($vv['type'],array('select_multi','checkboxs')) ? true : false;
				$dvals = "data-values='".$json_val."' data-real='$val' data-multi=$multi";

				if($multi){
					$nval=json_decode($val,true);
					if($nval){
						$val=array();
						foreach($nval as $v){
							$val[] = isset($vals[$v]) ? $vals[$v] : ''; 	
						}
						$val = implode(",",$val);
					}
				}else{
					$val = isset($vals[$val]) ? $vals[$val] : '';
				}
			}

			$c = isset($vv['table_hide']) ? 'hide' : ''; 

			if( ($kk=='delivered') || ($kk=='created') ){
				$val = date(  "d/m/Y", strtotime( $val ) );
			}

			$html .= "<td data-name='$kk' class='$c' $dvals>";
			$html .= $val;
			$html .= "</td>";
		}

		if(is_array($links) && !empty($links)){
			$html .= "<th class='links'>";
			foreach($links as $k => $v){
				$html .= '<span><a href="'.site_url($v."/".$d[$table['id']]).'" <i class="material-icons dp48">'.$k.'</i></span>';
			}
			$html .= "</th>";
		}

		$html .= "<th class='actions'>";
		if(!$CI->ion_auth->in_group('clients')){	
			if($editable){
				$html .= "<span><i class=\"material-icons dp48 edit\">edit</i></span>";
			}
			$html .= "<span><i class=\"material-icons dp48 copy\">add</i></span>";
			$html .= "<span><i class=\"material-icons dp48 delete\">delete</i></span>";
		};
		$html .= "</th>";
		$html.="</tr>";
	}
	$html .= "</tbody>";
	$html .="</table>";
	$html .= "</div>";

	return $html;
}

function lgedit_generate_form($t,$values=array(),$visible=false){
	$CI =& get_instance();
	$CI->load->config('lgedit');

	$tables = $CI->config->item('lgtables');
	if(!isset($tables[$t])) return "table doesnt exists";

	$table = $tables[$t];

	$v = $visible ? 'visible' : '';
	$html = "<div id='lgedit_form' class='".$v."'>";

	$html .= "<form action='#' method='POST' data-table=\"$t\">";	
	foreach($table['fields'] as $k => $v){
		if($k == $table['id']) continue;

		/*if(isset($v['table_hide'])){
			$k = '';
			$l = '';
			$c = 'hide'; 
			$val = isset($values[$k]) ? $values[$k] : '';
			$r = isset($v['required']) ? $v['required'] : '' ;
		}else{
			$l = isset($v['label']) ? $v['label'] : $k;
			$c = ''; 
			$val = isset($values[$k]) ? $values[$k] : '';
			$r = isset($v['required']) ? $v['required'] : '' ;
		}*/
		$val = isset($values[$k]) ? $values[$k] : '';
		$r = isset($v['required']) ? $v['required'] : '' ;
		$l = isset($v['label']) ? $v['label'] : $k;
		$c = isset($v['form_hide']) ? 'hide' : ''; 

		$bd = isset($v['browser-default']) && $v['browser-default'] ? 'browser-default' : ''; 
		$html .= '<div class="row '.$c.'">';
	
		if($v['type'] == "select" || $v['type'] == "select_multi"){
		
			$m = $v['type'] == "select_multi" ? 'multiple' : '';
		
	        $html.='<div class="input-field col s12">
				<select id="lgedit_'.$k.'" name="'.$k.'" class="validate '.$bd.'" '.$r.' '.$m.'>';

			$vals = $v['values'];
			if(!is_array($vals)){
				$vals = call_user_func($vals);
			}
			if($val && !is_array($val) && isset($vals[$val])){
				$html.='<option value="'.$val.'" selected>'.$vals[$val].'</option>';
			}else{
				$html.='<option value="" disabled selected>'.$l.'</option>';
			}

			if(isset($v['opt']) && $v['opt']){
				foreach($vals as $kk => $vv){
					$html .="<optgroup label=\"$kk\">";
					foreach($vv as $kkk => $vvv){
      					$html .='<option value="'.$kkk.'">'.$vvv.'</option>';
					}
					$html .="</optgroup>";
				}
			}else{
				foreach($vals as $kk => $vv){
      				$html .='<option value="'.$kk.'">'.$vv.'</option>';
				}
			}

			$html .='</select>';
          	$html .='<label for="lgedit_'.$k.'">'.$l.'</label>';
			$html .='</div>';

		}else if($v['type'] == "checkboxs"){
		var_dump($values); exit;
			$vals = $v['values'];
			if(!is_array($vals)){
				$vals = call_user_func($vals);
			}
			$col = isset($v['cols']) ? 12/$v['cols'] : 12;
			$html .= "<h5>$l</h5>";

			foreach($vals as $kk => $vv){
				$checked = is_array($val) && in_array($kk,$val) ? 'checked' : '';
				$html.="<div class='col s$col'>";
				$html.='<input id="checkbox'.$k.$kk.'" type="checkbox" name="'.$k.'[]" value="'.$kk.'" '.$checked.'/>';
				$html.='<label for="checkbox'.$k.$kk.'">'.$vv.'</label>';
				$html.="</div>";
			}

		}else if($v['type'] == "textarea"){
			$html .= '<div class="input-field col s12">';
			$html.="<textarea id='lgedit_$k' class='materialize-textarea' name='$k'>$val</textarea>";
			$html.='<label for="legedit_'.$k.'">'.$l.'</label>';
			$html .= "</div>";

		}else{
			$c1 = $v['type'] == "date" ? 'datepicker' : '';
			$t = $v['type'];

			
			$t = 'text';
			$html .= '<div class="input-field col s12">
          			<input id="lgedit_'.$k.'" name="'.$k.'" type="'.$t.'" class="validate '.$c1.'" value="'.$val.'" '.$r.'/>
          	 		<label for="lgedit_'.$k.'">'.$l.'</label>
        		</div>';
		}

		$html .="</div>";
	}

	$html .= '<div class="row">
		<button class="btn waves-effect waves-light" type="submit" name="action">Ajouter
  		</button>
		<button class="btn waves-effect waves-light" type="reset" name="action">Reset
  		</button>
	</div>';

	$html .= "</form>";
	$html .= "</div>";

	return $html;	
}

?>
