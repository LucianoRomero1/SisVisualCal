<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Basso\VisualCalBundle;

/**
 * Description of MyTCPDFClass
 *
 * @author shidalgo
 */
class MyTCPDFClass extends \TCPDF {
    //put your code here
    
    /**
     * @var string
     *
     */
    private $idInforme;
    private $htmlHeader;
    private $htmlFooter;
    
    public function setIdInforme($idInforme)
    {
        $this->idInforme = $idInforme;

        return $this;
    }

    public function getIdInforme()
    {
        return $this->idInforme;
    }
    
    public function setHtmlFooter($htmlFooter)
    {
        $this->htmlFooter = $htmlFooter;

        return $this;
    }

    public function getHtmlFooter()
    {
        return $this->htmlFooter;
    }
    
    public function setHtmlHeader($htmlHeader)
    {
        $this->htmlHeader = $htmlHeader;

        return $this;
    }

    public function getHtmlHeader()
    {
        return $this->htmlHeader;
    }
    
    
    public function Header() {
        if ( $this->idInforme == "PalletEtiqGr"){
            
        }elseif ( $this->idInforme == "internoVenta"){
            $html = $this->getHtmlHeader();
            $this->SetY(15);
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
        }elseif ( $this->idInforme == "informe"){
            $html = $this->getHtmlHeader();
            $this->SetY(15);
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
        }else {
            
            parent::Header();
        }
    }
    // Page footer
    public function Footer() {
        if ($this->idInforme == "ryr" ){
            ////// Comienzo código estandard ///////////
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);

            $html = '<table border="0">';
            $html = $html . '<tr>';
            $html = $html . '<td style="width:33%">';
            $html = $html . '</td>';
            $html = $html . '<td style="width:33%;text-align:center;">';
            $html = $html . 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
            $html = $html . '</td>';
            $html = $html . '<td style="width:33%;text-align:right;">';
            $html = $html . 'RGQ-149';
            $html = $html . '</td>';
            $html = $html . '</tr>';
            $html = $html . '</table>';
            
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);

        }elseif ($this->idInforme == "internoVenta"){
            // Position at 15 mm from bottom
            $this->SetY(-35);
            // Set font
            $this->SetFont('helvetica', 'I', 10);
            $html = $this->getHtmlFooter();
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
        }
        else {
            ////// Comienzo código estandard ///////////
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages() , 0, false, 'C', 0, '', 0, false, 'T', 'M');
            //// Fin código estandard ///////////
        }
        
    }
}