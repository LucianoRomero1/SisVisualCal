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

use Basso\VisualCalBundle\Entity\Calibracion;
use Basso\VisualCalBundle\Entity\Gage;

/**
 * Calibracion controller.
 *
 * @Route("/calibracion")
 */
class CalibracionController extends Controller
{
    /**
     * Lists all Calibracion entities.
     *
     * @Route("/", name="calibracion")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Calibracion", "calibracion");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Calibracion')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($calibracions, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('calibracion/index.html.twig', array(
            'calibracions' => $calibracions,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('CalibracionControllerFilter');
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
                $session->set('CalibracionControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('CalibracionControllerFilter')) {
                $filterData = $session->get('CalibracionControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionFilterType', $filterData);
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
            return $me->generateUrl('calibracion', $requestParams);
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
     * @Route("/{id}/new_calibracion_get", name="new_calibracion_get", requirements={"id"=".+"})
     * @Method({"GET"})
     */
    public function newCalibracionGetAction(Request $request, Gage $gage)
    {
        $calibracion = new Calibracion();

        //recupera desde paramentros
        $em = $this->getDoctrine()->getManager();
        $parametro = $em->getRepository('BassoVisualCalBundle:Parametro')->find(1);

        if ( $parametro != null){
            if ($parametro->getDefAlmacen() != null ){
                $calibracion->setAlmacen($parametro->getDefAlmacen() );
            }
            if ($parametro->getDefCalibracionTipo() != null ){
                $calibracion->setCalibracionTipo($parametro->getDefCalibracionTipo() );
            }
        }

        $calibracion->setGage ( $gage );
        $calibracion->setRealizadaPor( $this->getUser()->getUsername());
        $calibracion->setPasa( true );
        $calibracion->setFecha( new \Datetime() );
        
        //Debe controlar que no se haya enviado anteriormente
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionType', $calibracion);
        $editForm->handleRequest($request);
       
        return $this->render('calibracion/new.html.twig', array(
            'calibracion' => $calibracion,
            'form' => $editForm->createView(),
        ));
    }

    /**
     *
     * @Route("/new_calibracion_post", name="new_calibracion_post")
     * @Method({"POST"})
     */
    public function newCalibracionPostAction(Request $request)
    {
        //This is optional. Do not do this check if you want to call the same action using a regular request.
        if (!$request->isXmlHttpRequest()) {
            return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
        }

        $calibracion = new Calibracion();
        
        //Debe controlar que no se haya enviado anteriormente
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionType', $calibracion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $gage = $calibracion->getGage();

            //Calcula proximo vencimiento si es que pasa la calibracion
            if ( $calibracion->getPasa()){
                $gage->setUltCalibrador($calibracion->getRealizadaPor());
                $gage->setCalUltimaFecha($calibracion->getFecha());
                $calProximaFecha = new \Datetime($calibracion->getFecha()->format('Y-m-d'));
                if ($gage->getCalFrecuencia() > 0 and $gage->getCalFrecuenciaUM() != null) {
                    if ( $gage->getCalFrecuenciaUM()->getId() == 41 /*MESES*/ ){
                        $gage->setCalProximaFecha($calProximaFecha->modify('+' . strval( $gage->getCalFrecuencia()) . ' month'));
                    }
                    if ( $gage->getCalFrecuenciaUM()->getId() == 23 /*AÑOS */ ){
                        $gage->setCalProximaFecha($calProximaFecha->modify('+' . strval( $gage->getCalFrecuencia()) . ' year'));
                    }
                    if ( $gage->getCalFrecuenciaUM()->getId() == 22 /* SEMANAS*/ ){
                        $gage->setCalProximaFecha($calProximaFecha->modify('+' . strval( $gage->getCalFrecuencia() * 7 ) . ' days'));
                    }
                    if ( $gage->getCalFrecuenciaUM()->getId() == 21 /* DIAS*/ ){
                        $gage->setCalProximaFecha($calProximaFecha->modify('+' . strval( $gage->getCalFrecuencia()) . ' days'));
                    }
                }

                //El gage toma desde la calibracion el almacen y el tipo( color )
                $gage->setAlmacen( $calibracion->getAlmacen());
                $gage->setTipo($editForm->get("gageTipo")->getData() );//es un campo not mapped
                $gage->setUbicacion($editForm->get("ubicacion")->getData() );//es un campo not mapped

            }
            $em->persist($gage);
            $em->persist($calibracion);
            $em->flush();
            
            
            return new JsonResponse(array('message' => 'Success!'), 200);
        }
        
        $response = new JsonResponse(
            array(
                'message' => 'Error',
                'form' => $this->renderView('calibracion/new.html.twig',
                array(
            'calibracion' => $calibracion,
            'form' => $editForm->createView(),
        ))), 400);
 
        return $response;

    }

    /**
     * Displays a form to create a new Calibracion entity.
     *
     * @Route("/new", name="calibracion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Calibracion", "calibracion");
        $breadcrumbs->addRouteItem("Nuevo Registro", "calibracion_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $calibracion = new Calibracion();

        $calibracion->setFecha( new \DateTime());
        $calibracion->setRealizadaPor($this->getUser()->getUsername());

        $form   = $this->createForm('Basso\VisualCalBundle\Form\CalibracionType', $calibracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calibracion);
            $em->flush();
            
            $editLink = $this->generateUrl('calibracion_edit', array('id' => $calibracion->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'calibracion' : 'calibracion_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('calibracion/new.html.twig', array(
            'calibracion' => $calibracion,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Calibracion entity.
     *
     * @Route("/{id}", name="calibracion_show")
     * @Method("GET")
     */
    public function showAction(Calibracion $calibracion)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Calibracion", "calibracion");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($calibracion);
        return $this->render('calibracion/show.html.twig', array(
            'calibracion' => $calibracion,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Calibracion entity.
     *
     * @Route("/{id}/edit", name="calibracion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Calibracion $calibracion)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Calibracion", "calibracion");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");

        $deleteForm = $this->createDeleteForm($calibracion);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionType', $calibracion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calibracion);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('calibracion');
        }
        return $this->render('calibracion/edit.html.twig', array(
            'calibracion' => $calibracion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Calibracion entity.
     *
     * @Route("/{id}", name="calibracion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calibracion $calibracion)
    {
    
        $form = $this->createDeleteForm($calibracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calibracion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Calibracion was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Calibracion');
        }
        
        return $this->redirectToRoute('calibracion');
    }
    
    /**
     * Creates a form to delete a Calibracion entity.
     *
     * @param Calibracion $calibracion The Calibracion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Calibracion $calibracion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calibracion_delete', array('id' => $calibracion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Calibracion by id
     *
     * @Route("/delete/{id}", name="calibracion_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Calibracion $calibracion){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($calibracion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Calibracion was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Calibracion');
        }

        return $this->redirect($this->generateUrl('calibracion'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="calibracion_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Calibracion');

                foreach ($ids as $id) {
                    $calibracion = $repository->find($id);
                    $em->remove($calibracion);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'calibracions was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the calibracions ');
            }
        }

        return $this->redirect($this->generateUrl('calibracion'));
    }
    

}
