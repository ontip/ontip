<?php
// bevat PHP Excel style sheets

   $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THICK
            )
        )
    );
    
    $borders = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
      
    $align_right_style = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '2F4F4F')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );
    
	 //  centreren kop
   $hor_center_style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
  
   $ver_center_style = array(
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );
	
	$ver_bottom_style = array(
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        )
    );
     
    $red_style_11= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 11,
                   'name'  => 'Arial'
       ));
       
        $red_style_10 = array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Calibri'
       ));
   
     $red_style_12= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 12,
                   'name'  => 'Arial'
       ));
           
    $red22_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 22,
                   'name'  => 'Arial'
       ));
     
   $black10_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 11,
                   'name'  => 'Arial'
       ));
	   
   $black11_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 11,
                   'name'  => 'Arial'
       ));
	   
	   
   $black12_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 12,
                   'name'  => 'Arial'
       ));
	   
   $black14_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 14,
                   'name'  => 'Arial'
       ));
       
       
       
  	 $blue11_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '0000ff'),
                   'size'  => 11,
                   'name'  => 'Verdana'
       ));
  
     ?>