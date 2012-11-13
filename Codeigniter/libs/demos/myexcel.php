<?php 

	public function cuentaProveedorExcel(){
		$res = $this->getCuentaProveedorData();
		
		$this->load->library('myexcel');
		$xls = new myexcel();
	
		$worksheet =& $xls->workbook->addWorksheet();
	
		$xls->titulo2 = 'Cuenta de '.$res['proveedor']->nombre;
		$xls->titulo3 = 'Del: '.$this->input->get('ffecha1')." Al ".$this->input->get('ffecha2')."\n";
		$xls->titulo4 = ($this->input->get('ftipo') == 'pv'? 'Plazo vencido': 'Pendientes por pagar');
		
		if(is_array($res['anterior'])){
			$res['anterior'] = new stdClass();
			$res['anterior']->cargo = 0;
			$res['anterior']->abono = 0;
			$res['anterior']->saldo = 0;
		}else{
			$res['anterior']->cargo = $res['anterior']->total;
			$res['anterior']->abono = $res['anterior']->abonos;
		}
		$res['anterior']->fecha = $res['anterior']->serie = $res['anterior']->folio = '';
		$res['anterior']->concepto = $res['anterior']->estado = $res['anterior']->fecha_vencimiento = '';
		$res['anterior']->dias_transc = '';
		
		array_unshift($res['cuentas'], $res['anterior']);
		
		$data_fac = $res['cuentas'];
			
		$row=0;
		//Header
		$xls->excelHead($worksheet, $row, 8, array(
				array($xls->titulo2, 'format_title2'), 
				array($xls->titulo3, 'format_title3'),
				array($xls->titulo4, 'format_title3')
		));
			
		$row +=3;
		$xls->excelContent($worksheet, $row, $data_fac, array(
				'head' => array('Fecha', 'Serie', 'Folio', 'Concepto', 'Cargo', 'Abono', 'Saldo', 'Estado', 'Fecha Vencimiento', 'Dias Trans.'),
				'conte' => array(
						array('name' => 'fecha', 'format' => 'format4', 'sum' => -1),
						array('name' => 'serie', 'format' => 'format4', 'sum' => -1),
						array('name' => 'folio', 'format' => 'format4', 'sum' => -1),
						array('name' => 'concepto', 'format' => 'format4', 'sum' => -1),
						array('name' => 'cargo', 'format' => 'format4', 'sum' => 0),
						array('name' => 'abono', 'format' => 'format4', 'sum' => 0),
						array('name' => 'saldo', 'format' => 'format4', 'sum' => 0),
						array('name' => 'estado', 'format' => 'format4', 'sum' => -1),
						array('name' => 'fecha_vencimiento', 'format' => 'format4', 'sum' => -1),
						array('name' => 'dias_transc', 'format' => 'format4', 'sum' => -1))
		));
	
		$xls->workbook->send('cuentaProveedor.xls');
		$xls->workbook->close();
	}



 ?>