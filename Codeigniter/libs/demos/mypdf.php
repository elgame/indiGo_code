<?php 

	/**
	 * Descarga el listado de cuentas por pagar en formato pdf
	 */
	public function cuentasXPagarPdf(){
		$this->load->library('mypdf');
		// Creación del objeto de la clase heredada
		$pdf = new MYpdf('P', 'mm', 'Letter');
		$pdf->titulo2 = 'Cuentas por pagar';
		$pdf->titulo3 = 'Del: '.$this->input->get('ffecha1')." Al ".$this->input->get('ffecha2')."\n";
		$pdf->titulo3 .= ($this->input->get('ftipo') == 'pv'? 'Plazo vencido': 'Pendientes por pagar');
		$pdf->AliasNbPages();
		//$pdf->AddPage();
		$pdf->SetFont('Arial','',8);
		
		$aligns = array('L', 'R');
		$widths = array(150, 55);
		$header = array('Proveedor', 'Saldo');
		
		$res = $this->getCuentasXPagarData();
		$total_saldo = 0;
		foreach($res['cuentas'] as $key => $item){
			$band_head = false;
			if($pdf->GetY() >= $pdf->limiteY || $key==0){ //salta de pagina si exede el max
				$pdf->AddPage();
				
				$pdf->SetFont('Arial','B',8);
				$pdf->SetTextColor(255,255,255);
				$pdf->SetFillColor(160,160,160);
				$pdf->SetX(6);
				$pdf->SetAligns($aligns);
				$pdf->SetWidths($widths);
				$pdf->Row($header, true);
			}
			
			$pdf->SetFont('Arial','',8);
			$pdf->SetTextColor(0,0,0);
			$datos = array($item->nombre, String::formatoNumero($item->saldo));
			$total_saldo += $item->saldo;
			
			$pdf->SetX(6);
			$pdf->SetAligns($aligns);
			$pdf->SetWidths($widths);
			$pdf->Row($datos, false);
		}
		
		$pdf->SetX(6);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Row(array('Total:', String::formatoNumero($total_saldo)), true);
		
		$pdf->Output('cuentas_x_pagar.pdf', 'I');
	}


 ?>