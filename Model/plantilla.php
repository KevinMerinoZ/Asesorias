<?php
require_once ('Model/fpdf/fpdf.php');
	
    class PDF extends FPDF
    {
        function Header()
        {
            $this->Image('Model/fpdf/imagenes/logoUp.png', 100, 5, 30);
            $this->SetFont('Arial','B',18);
            $this->Ln(20);
            $this->Cell(40);
            $this->Cell(120,30,'Reportes del sistema web',0,0,'C');
            $this->Ln(40);
        }
        
        function Footer()
        {
            
            $this->SetY(-15);
            $this->SetFont('Arial','I', 8);
            $this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
        }		
    }

?>