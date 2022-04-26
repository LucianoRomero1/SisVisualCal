<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;
use Symfony\Component\HttpFoundation\Response;
use Basso\VisualCalBundle\Entity\Gage;

/**
 * Gage controller.
 *
 * @Route("/gage")
 */
class GageController extends Controller
{
    /**
     * Lists all Gage entities.
     *
     * @Route("/", name="gage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Instrumentos", "gage");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Gage')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($gages, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('gage/index.html.twig', array(
            'gages' => $gages,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\GageFilterType');

        // Reset filter
        if ($request->get('filter_action') == 'reset') {
            $session->remove('GageControllerFilter');
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
                $session->set('GageControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('GageControllerFilter')) {
                $filterData = $session->get('GageControllerFilter');
                
                foreach ($filterData as $key => $filter) { //fix for entityFilterType that is loaded from session
                    if (is_object($filter)) {
                        $filterData[$key] = $queryBuilder->getEntityManager()->merge($filter);
                    }
                }
                
                $filterForm = $this->createForm('Basso\VisualCalBundle\Form\GageFilterType', $filterData);
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
            return $me->generateUrl('gage', $requestParams);
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
     * Displays a form to create a new Gage entity.
     *
     * @Route("/new", name="gage_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Instrumentos", "gage");
        $breadcrumbs->addRouteItem("Nuevo Registro", "gage_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $gage = new Gage();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\GageType', $gage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $gage->setFechaM( new \DateTime());
            $gage->setUsuarioM($this->getUser()->getUsername());

            $em->persist($gage);
            $em->flush();
            
            $editLink = $this->generateUrl('gage_edit', array('id' => $gage->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'gage' : 'gage_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('gage/new.html.twig', array(
            'gage' => $gage,
            'form'   => $form->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing Gage entity.
     *
     * @Route("/edit/{id}", name="gage_edit", requirements={"id"=".+"})
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gage $gage)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Instrumentos", "gage");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($gage);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\GageType', $gage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $gage->setFechaM( new \DateTime());
            $gage->setUsuarioM($this->getUser()->getUsername());
            
            $em->persist($gage);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('gage');
        }
        return $this->render('gage/edit.html.twig', array(
            'gage' => $gage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    // public function editAction(Request $request)
    // {
	// 	$breadcrumbs = $this->get("white_october_breadcrumbs");
           
    //     $breadcrumbs->addRouteItem("Gage", "gage");
        
    //     $breadcrumbs->addItem("Editar Registro");
        
    //     $breadcrumbs->prependRouteItem("Inicio", "homepage");

    //     //"edit/xnj 689"
    //     $gageId = substr($gageId, 6);

    //     $gage =  $em->getRepository('BassoVisualCalBundle:Gage')->find($gageId);
		
    //     $deleteForm = $this->createDeleteForm($gage);
    //     $editForm = $this->createForm('Basso\VisualCalBundle\Form\GageType', $gage);
    //     $editForm->handleRequest($request);

    //     if ($editForm->isSubmitted() && $editForm->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($gage);
    //         $em->flush();
            
    //         $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
    //         return $this->redirectToRoute('gage');
    //     }
    //     return $this->render('gage/edit.html.twig', array(
    //         'gage' => $gage,
    //         'edit_form' => $editForm->createView(),
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Muestra el detalle de la caja, USUARIO+PARTIDA+...+CANTIDAD
     *
     * @Route("/{id}/ultimasCalibraciones", name="ultimasCalibraciones", requirements={"id"=".+"})
     * @Method({"get"})
     */
    public function ultimasCalibraciones(Request $request, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
            FROM BassoVisualCalBundle:Calibracion e
            WHERE e.gage = :id 
            ORDER BY e.fecha DESC
            '
        )->setParameter('id', $id);
        //$query->orderBy('e.id', 'DESC');

        $contenido = $query->getResult();

        return $this->render('gage/_ultimasCalibraciones.html.twig', array(
            'contenido' => $contenido,
        ));
        
    }

    /**
     * Muestra el detalle de la caja, USUARIO+PARTIDA+...+CANTIDAD
     *
     * @Route("/{id}/ultimasRyR", name="ultimasRyR", requirements={"id"=".+"})
     * @Method({"get"})
     */
    public function ultimasRyR(Request $request, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT e
            FROM BassoVisualCalBundle:RyR e
            WHERE e.gage = :id 
            ORDER BY e.fecha DESC
            '
        )->setParameter('id', $id);
        //$query->orderBy('e.id', 'DESC');

        $contenido = $query->getResult();

        return $this->render('gage/_ultimasRyR.html.twig', array(
            'contenido' => $contenido,
        ));
        
    }
    /**
     * Deletes a Gage entity.
     *
     * @Route("/{id}", name="gage_delete", requirements={"id"=".+"})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gage $gage)
    {
    
        $form = $this->createDeleteForm($gage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gage);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Gage was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Gage');
        }
        
        return $this->redirectToRoute('gage');
    }
    
    /**
     * Creates a form to delete a Gage entity.
     *
     * @param Gage $gage The Gage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gage $gage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gage_delete', array('id' => $gage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Gage by id
     *
     * @Route("/delete/{id}", name="gage_by_id_delete", requirements={"id"=".+"})
     * @Method("GET")
     */
    public function deleteByIdAction(Gage $gage){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($gage);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El instrumento fue eliminado satisfactoriamente.');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Gage');
        }

        return $this->redirect($this->generateUrl('gage'));

    }

    /**
     * @Route("/{id}/ObtenerDatosGage", name="ObtenerDatosGage_get", requirements={"id"=".+"})
     * @Method({"GET"})
     */
    public function getObtenerDatosGage (Request $request, Gage $gage = null )
    {
        
        $serializer = $this->container->get('jms_serializer')
        ->serialize($gage, 'json');
        
        if ( $serializer == "null" ) {
            return new Response($serializer, 200);
        }
        
        return new Response($serializer, 200);

    }
    
    /**
     * Finds and displays a Gage entity.
     *
     * @Route("/{id}", name="gage_show", requirements={"id"=".+"})
     * @Method("GET")
     */
    public function showAction(Gage $gage)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Instrumentos", "gage");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($gage);
        return $this->render('gage/show.html.twig', array(
            'gage' => $gage,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="gage_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Gage');

                foreach ($ids as $id) {
                    $gage = $repository->find($id);
                    $em->remove($gage);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'gages was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the gages ');
            }
        }

        return $this->redirect($this->generateUrl('gage'));
    }
    
    
}
