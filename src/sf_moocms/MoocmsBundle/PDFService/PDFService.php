<?php

namespace sf_moocms\MoocmsBundle\PDFService;
use \TCPDF;



/**
* 
*/

class PDFService extends TCPDF {

    public function Header() {
        
        // $image_file = K_PATH_IMAGES.'logo_example.jpg';
        // $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 10, 'Préparation de cours Active LMS', 'B', 0, 'C');
        $this->Ln(40);
    }


    public function Footer() {
        /* Position at 15 mm from bottom */
        $this->SetY(-20);
        /* Set font */
        $this->SetFont('helvetica', 'I', 8);
        /* Page number */
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, 'Active LMS - Copyright 2017 Lab3216', 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    public function generateLesson($lesson, $sequences) {

        /* ---------------------------------------------
        * Set header and footer
        * -------------------------------------------- */
        $this->SetHeaderData(10,50,10,10);
        $this->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        /* ---------------------------------------------
        * Create page
        * -------------------------------------------- */
        $this->AddPage();
        $this->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        $this->SetFont('Times','B',16);
        /* $pdf->Cell(40,10,'Hello World!'); */

        /* $pdf->writeHTML('<META http-equiv="Content-Type" content="text/html; charset=UTF-8">'); */

        /* print title  */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Titre: "); $this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getName());
        $this->Ln(7);

        /* print topic */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Discipline: ");
        $this->SetFont("", "", 12);
        $this->Write(7, ' ' . $lesson->getTopic()->getName());
        $this->Ln(7);

        /* print summary */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Résumé: ");$this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getSummary());
        $this->Ln(7);

        /* print prerequists  */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Prérequis: ");$this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getPrerequisite());
        $this->Ln(7);

        /*  print goals  */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Objectifs: ");$this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getGoals());
        $this->Ln(7);

        /*  print behaviours  */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Compétences comportementales: ");$this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getBehaviours());
        $this->Ln(7);

        /* print purpose */
        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Finalité: ");$this->Ln();
        $this->SetFont("", "", 12);
        $this->Write(7, $lesson->getPurposes());
        $this->Ln(7);


        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Séquences du cours: ");
        $this->Ln(7);

        $this->Ln(3);
        $this->SetFont('', '');

         $tbl_st = '<table border="1" cellpadding="3">';

        foreach ($sequences as $sequence) {
            $tbl_st .='<tr align="center">'
            . '<th width="10%"><b>Numéro</b></th><th><b>Titre</b></th><th width="40%"><b>Objectifs</b></th><th><b>Méthode pédagogique</b></th>'
            . '</tr>'
            . '<tr>'
            . '<td align="left" width="10%"><b>' . $sequence->getNumber() . '</b></td>'
            . '<td align="left">' . $sequence->getTitle() . '</td>'
            . '<td align="left" width="40%">' . $sequence->getGoals() . '</td>'
            . '<td align="left">' . $sequence->getPedagogicalMethod() . '</td>'
            . '</tr>'            
            . '<tr>'
            . '<td colspan="4" align="left"><b>Description de la méthodologie</b></td>'
            . '</tr>'
            . '<tr>'
            . '<td colspan="4" align="left">' . $sequence->getMethodDescription() . '</td>'
            // . '</tr>'
            // . '<tr>'
            // . '<td colspan="4" align="left"><b>Contenu</b></td>'
            // . '</tr>'
            // . '<tr>'
            // . '<td colspan="4" align="left">' . $sequence->getContent() . '</td>'
            . '</tr>';

        }

        $tbl_st .= '</table>';

        $this->writeHTML($tbl_st, true, false, false, false, 'C');


        $this->Ln(3);
        $this->SetFont("", "BU", 12);
        $this->Write(7, "Contenu: ");
        $this->Ln(7);


        foreach ($sequences as $sequence) {

            /* print Title */
        $this->Ln(3);
        $this->SetFont("", "B", 16);
        $this->Write(7, $sequence->getTitle());
        $this->Ln(7);

        /* print content */
        $this->Ln(3);
        $this->SetFont("", "", 12);
        $this->WriteHTML($sequence->getContent(), true, false, false, false, 'L');
        $this->Ln(7);

        }

        $this->Output($lesson->getName() . '.pdf', 'D');

        return;
    }


}