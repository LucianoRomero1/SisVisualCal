<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;
use Symfony\Component\HttpFoundation\JsonResponse;

use Basso\VisualCalBundle\Entity\RyR;
use Basso\VisualCalBundle\Entity\Gage;
/**
 * RyR controller.
 *
 * @Route("/ryr")
 */
class RyRController extends Controller
{
    /**
     * Lists all RyR entities.
     *
     * @Route("/", name="ryr")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyR", "ryr");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:RyR')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($ryRs, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('ryr/index.html.twig', array(
            'ryRs' => $ryRs,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, Request $request)
    {
        $session = $request->getSession();
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\RyRFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('RyRControllerFilter');
        }

        // Filter action
        if ($request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->handleRequest($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('RyRControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('RyRControllerFilter')) {
                $filterData = $session->get('RyRControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('Basso\VisualCalBundle\Form\RyRFilterType', $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }


    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('ryr', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap4View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => '<<',
            'next_message' => '>>',
        ));

        return array($entities, $pagerHtml);
    }
    
    
    
    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Mostrando $startRecord - $endRecord de $totalOfRecords reg.";
    }
    
    /**
     *
     * @Route("/{id}/new_ryr_get", name="new_ryr_get", requirements={"id"=".+"})
     * @Method({"GET"})
     */
    public function newRyRGetAction(Request $request, Gage $gage)
    {
        $ryR = new RyR();
        $ryR->setGage ( $gage );
        $ryR->setFecha( new \Datetime() );
        $ryR->setSoloPdf(true);
        
        //Debe controlar que no se haya enviado anteriormente
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\RyRType', $ryR);
        $editForm->handleRequest($request);
       
        return $this->render('ryr/new.html.twig', array(
            'ryr' => $ryR,
            'form' => $editForm->createView(),
        ));
    }

    /**
     *
     * @Route("/new_ryr_post", name="new_ryr_post")
     * @Method({"POST"})
     */
    public function newRyRPostAction(Request $request)
    {
        //This is optional. Do not do this check if you want to call the same action using a regular request.
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }

        $ryR = new RyR();
        
        //Debe controlar que no se haya enviado anteriormente
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\RyRType', $ryR);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ryR->setFechaM( new \DateTime());
            $ryR->setUsuarioM($this->getUser()->getUsername());

            $gage = $ryR->getGage();

            //Calcula proximo vencimiento si es que pasa la calibracion
            
                
                $gage->setRrUltimaFecha($ryR->getFecha());
                $ryrProximaFecha = new \Datetime($ryR->getFecha()->format('Y-m-d'));
                if ($gage->getRrFrecuencia() > 0 and $gage->getRrFrecuenciaUM() != null) {
                    if ( $gage->getRrFrecuenciaUM()->getId() == 41 /*MESES*/ ){
                        $gage->setRrProximaFecha($ryrProximaFecha->modify('+' . strval( $gage->getRrFrecuencia()) . ' month'));
                    }
                    if ( $gage->getRrFrecuenciaUM()->getId() == 23 /*AÑOS */ ){
                        $gage->setRrProximaFecha($ryrProximaFecha->modify('+' . strval( $gage->getRrFrecuencia()) . ' year'));
                    }
                    if ( $gage->getRrFrecuenciaUM()->getId() == 22 /* SEMANAS*/ ){
                        $gage->setRrProximaFecha($ryrProximaFecha->modify('+' . strval( $gage->getRrFrecuencia() * 7 ) . ' days'));
                    }
                    if ( $gage->getRrFrecuenciaUM()->getId() == 21 /* DIAS*/ ){
                        $gage->setRrProximaFecha($ryrProximaFecha->modify('+' . strval( $gage->getRrFrecuencia()) . ' days'));
                    }
                }

                

            
            $em->persist($gage);
            $em->persist($ryR);
            $em->flush();
            
            
            return new JsonResponse(array('message' => 'Success!'), 200);
        }
        
        $response = new JsonResponse(
            array(
                'message' => 'Error',
                'form' => $this->renderView('ryr/new.html.twig',
                array(
            'ryr' => $ryR,
            'form' => $editForm->createView(),
        ))), 400);
 
        return $response;

    }

    /**
     * Displays a form to create a new RyR entity.
     *
     * @Route("/new", name="ryr_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyR", "ryr");
        $breadcrumbs->addRouteItem("Nuevo Registro", "ryr_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $ryR = new RyR();

        $ryR->setFecha( new \Datetime() );
        $ryR->setSoloPdf(true);
        
        $form   = $this->createForm('Basso\VisualCalBundle\Form\RyRType', $ryR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ryR->setFechaM( new \DateTime());
            $ryR->setUsuarioM($this->getUser()->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($ryR);
            $em->flush();
            
            $editLink = $this->generateUrl('ryr_edit', array('id' => $ryR->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'ryr' : 'ryr_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('ryr/new-copia.html.twig', array(
            'ryR' => $ryR,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a RyR entity.
     *
     * @Route("/{id}", name="ryr_show")
     * @Method("GET")
     */
    public function showAction(RyR $ryR)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyR", "ryr");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ryR);
        return $this->render('ryr/show.html.twig', array(
            'ryR' => $ryR,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing RyR entity.
     *
     * @Route("/{id}/edit", name="ryr_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RyR $ryR)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyR", "ryr");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ryR);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\RyRType', $ryR);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $ryR->setFechaM( new \DateTime());
            $ryR->setUsuarioM($this->getUser()->getUsername());

            $em = $this->getDoctrine()->getManager();
            $em->persist($ryR);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('ryr');
        }
        return $this->render('ryr/edit.html.twig', array(
            'ryR' => $ryR,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a RyR entity.
     *
     * @Route("/{id}", name="ryr_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RyR $ryR)
    {
    
        $form = $this->createDeleteForm($ryR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ryR);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El RyR fue eliminado satisfactoriamente');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'El RyR fue eliminado satisfactoriamente');
        }
        
        return $this->redirectToRoute('ryr');
    }
    
    /**
     * Creates a form to delete a RyR entity.
     *
     * @param RyR $ryR The RyR entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RyR $ryR)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ryr_delete', array('id' => $ryR->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete RyR by id
     *
     * @Route("/delete/{id}", name="ryr_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(RyR $ryR){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($ryR);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El RyR fue eliminado satisfactoriamente');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the RyR');
        }

        return $this->redirect($this->generateUrl('ryr'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="ryr_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:RyR');

                foreach ($ids as $id) {
                    $ryR = $repository->find($id);
                    $em->remove($ryR);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'Los RyRs fueron eliminados satisfactoriamente!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the ryRs ');
            }
        }

        return $this->redirect($this->generateUrl('ryr'));
    }
    
    /**
     * RyR to PDF
     *
     * @Route("/{id}/ryr_pdf", name="ryr_pdf")
     * 
     */
    public function ryrPDF(Request $request,  RyR $ryr)
    {
        $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('Hidalgo Sebastián');
        $pdf->SetTitle(('RyR'));
        $pdf->SetSubject("RyR");
        $pdf->SetKeywords('PDF, reporte, RyR');
        
        $title_header = "Reporte de R y R de Instrumentos";
        $subtitle_header = "METROLOGIA" ;
        
        //Para agregar el pie personalizado
        //$pdf->setIdInforme(('informe'));

        //Para agregar el pie personalizado
        $pdf->setIdInforme(('ryr'));

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title_header, $subtitle_header, array(0,0,0), array(0,0,0));
        $pdf->setFooterData(array(0,0,0), array(0,0,0));

        
        //dump($ryr);
        
        $html = $this->renderView('ryr/_ryrPDF.html.twig', array('ryr' => $ryr));
        //$htmlHeader = $this->renderView('ryr/_ryrPDFHeader.html.twig');
        //$htmlFooter = $this->renderView('ryr/_ryrPDFFooter.html.twig');
        //$pdf->setHtmlHeader( $htmlHeader );
        //$pdf->setHtmlFooter( $htmlFooter );
        $pdf->SetCellPadding(0);
        $pdf->setFooterData(array(0,0,0), array(0,0,0));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks. COINCIDE CON EL FOOTER PERSONALIZADO.
        $pdf->SetAutoPageBreak(TRUE, 50 /*PDF_MARGIN_BOTTOM*/ );

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        $pdf->setCellHeightRatio(1.25);

        $pdf->setFontSubsetting(true);
        $pdf->SetFont('courier', '', 10, '', true);
        //$pdf->SetMargins(20,20,40, true);
        $pdf->AddPage();
        
        //$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        //dump($resultados);
        $filename = 'ryr_' . sprintf('%08d',  $ryr->getId() ) ;
        
        

        //$html = $htmlHeader . $html . $htmlFooter;
        //return $this->render('movimiento/_ordenEntregaPDF.html.twig', array(
        //    'resultados' => $resultados,
        //));
        //
        //
        //$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output($filename.".pdf",'D'); // This will output the PDF as a response directly
    }
}
