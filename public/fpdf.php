<?php
//use setasign\Fpdi\Fpdi;
//use setasign\Fpdi\PdfReader;

//require_once('fpdf182/fpdf.php');
//require_once('Fpdi/src/autoload.php');
require_once('fpdm/fpdm.php');


$fields = array('day1' => '03rd',
    'month_year' => 'January   2021',
    'authsig_name1' => 'Mr.C.PRABHU,',
    'authsig1_details' => 'son of Late Mr.S.Chakkarai, aged about 36 years, and',
    'authsig_name2' => 'Ms.R.SARANYA,',
    'authsig2_details' => 'wife of Mr.B.Balamurali, aged about 26 years,',
    'board_resol_date' => '05.10.2020',
    'allottee' => 'Mrs.S.DEVI',
    'allotee_Pan_Email ID' => '(PAN:  DSTPD7842F)    (Aadhaar  Card   No.9594 3208 0390)   (Email ID: shaanmugamm71@yahoo.com)    wife    of   Mr.M.Shanmugam,',
    'Residing_at_ln1' => 'Hindu, aged about 35 years, residing at No.6, 1st Right',
    'Residing_at_ln2' => 'Cross Street, Manikandapuram, Thirumullaivoyal, Chennai 600 062,',
    'allottee_amount1' => '11,47,375/- (Rupees Eleven Lakhs ',
    'allotee_amount_ln2' => 'Forty  Seven  Thousand Three Hundred and Seventy Five Only)',
    'Allotteepg' => 'Mrs.S.Devi',
    'allottee_pg_addr1' => 'No.6, 1st Right Cross Street, Manikandapuram,',
    'allottee_pg_addr2' => 'Thirumullaivoyal, Chennai 600 062,',
    'allottee_pg_emailid' => 'shaanmugamm71@yahoo.com',
    'sqft' =>'685 (Six Hundred and Eighty Five)'
    );

    $pdf = new FPDM('datafinal.pdf');
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output();




?>