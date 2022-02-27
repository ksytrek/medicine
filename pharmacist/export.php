<?php
// include_once('dbconnect.php');
include_once('../plugins/fpdf/fpdf.php');
include_once "../config/config.inc.php";
include_once "../config/connectdb.php";


class PDF extends FPDF
{

	
	function Footer()
	{
		// Go to 1.5 cm from bottom
		$this->SetY(-15);
		// Select Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		// Print current and total page numbers
		$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}
	function header()
	{
		$id_pma = $_GET['id_pma'];;
		
		$name_pma  = Database::query("SELECT * FROM `pharmacist` WHERE id_pma = '$id_pma'", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ)->name_pma;
		$this->AddFont('sarabun', 'B', 'THSarabunB.php');
		$this->AddFont('sarabun', '', 'THSarabun.php');
		// Set font
		// $this->SetFont('Arial', 'B', 16);
		// $this->AddFont('THSarabunNew','B',16);
		// Move to 8 cm to the right
		$this->SetFont('sarabun', 'B', 16);
		$this->Cell(50);
		$this->Cell(20, 10, iconv('utf-8', 'cp874', 'ใบเสร็จ'), 0, 0, 'C');
		$this->Cell(20, 10, iconv('utf-8', 'cp874', ''), 0, 0, 'C');
		$this->Ln();
		// $this->Cell(15);
		$this->Cell(20, 10, iconv('utf-8', 'cp874', 'เภสัชที่ขาย : '), 0, 0, 'L');
		$this->Cell(30, 10, iconv('utf-8', 'cp874', "{$name_pma}"), 0, 0, 'R');
		$this->Ln();
		// $this->Cell(15);
		$this->Cell(10, 10, iconv('utf-8', 'cp874', 'ลำดับ'), 1, 0, 'C');
		$this->Cell(35, 10, iconv('utf-8', 'cp874', 'ชื่อยา'), 1, 0, 'C');
		$this->Cell(20, 10, iconv('utf-8', 'cp874', 'จำนวน'), 1, 0, 'C');
		$this->Cell(30, 10, iconv('utf-8', 'cp874', 'ราคา'), 1, 0, 'C');
		$this->Cell(30, 10, iconv('utf-8', 'cp874', 'ราคารวม'), 1, 0, 'C');


		$id_oh = $_GET['id_oh'] ;
		$i = null;
		$sum = null;
		$sql = "SELECT * FROM `detail_history` as det INNER JOIN drug_information as dru ON det.id_drug = dru.id_drug WHERE det.id_oh = '$id_oh'";
		$this->SetFont('sarabun', '', 16);
		foreach (Database::query($sql, PDO::FETCH_OBJ) as $row) {
			$this->Ln();
			// $this->Cell(15);
			$this->Cell(10, 5, iconv('utf-8', 'cp874', ++$i), 1, 0, 'C');
			$this->Cell(35, 5, iconv('utf-8', 'cp874', $row->name_drug), 1, 0, 'C');
			$this->Cell(20, 5, iconv('utf-8', 'cp874', $row->item), 1, 0, 'C');
			$this->Cell(30, 5, iconv('utf-8', 'cp874', $row->price_drug), 1, 0, 'C');
			$this->Cell(30, 5, iconv('utf-8', 'cp874', $row->price_drug * $row->item), 1, 0, 'C');
			$sum += $row->price_drug * $row->item;
		}

		$this->Ln();
		// $this->Cell(15);
		
		$this->Cell(20, 10, iconv('utf-8', 'cp874', 'ยอดรวม : '), 0, 0, 'L');
		$this->SetFont('sarabun', 'B', 16);
		$this->Cell(30, 10, iconv('utf-8', 'cp874', $sum . " บาท"), 0, 0, 'R');
	}
}

$pdf = new PDF('P','mm',"A5");
$pdf->AliasNbPages();
$pdf->Output();
