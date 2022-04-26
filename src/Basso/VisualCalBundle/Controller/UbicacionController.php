<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Ubicacion;

/**
 * Ubicacion controller.
 *
 * @Route("/ubicacion")
 */
class UbicacionController extends Controller
{
    /**
     * Lists all Ubicacion entities.
     *
     * @Route("/", name="ubicacion")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Ubicacion", "ubicacion");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Ubicacion')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($ubicacions, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('ubicacion/index.html.twig', array(
            'ubicacions' => $ubicacions,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }


    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, $request)
    {
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\UbicacionFilterType');

        // Bind values from the request
        $filterForm->handleRequest($request);

        if ($filterForm->isValid()) {
            // Build the query from the given form object
            $this->get('petkopara_multi_search.builder')->searchForm( $queryBuilder, $filterForm->get('search'));
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
            return $me->generateUrl('ubicacion', $requestParams);
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
     * Displays a form to create a new Ubicacion entity.
     *
     * @Route("/new", name="ubicacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Ubicacion", "ubicacion");
        $breadcrumbs->addRouteItem("Nuevo Registro", "ubicacion_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $ubicacion = new Ubicacion();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\UbicacionType', $ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion);
            $em->flush();
            
            $editLink = $this->generateUrl('ubicacion_edit', array('id' => $ubicacion->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'ubicacion' : 'ubicacion_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('ubicacion/new.html.twig', array(
            'ubicacion' => $ubicacion,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Ubicacion entity.
     *
     * @Route("/{id}", name="ubicacion_show")
     * @Method("GET")
     */
    public function showAction(Ubicacion $ubicacion)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Ubicacion", "ubicacion");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ubicacion);
        return $this->render('ubicacion/show.html.twig', array(
            'ubicacion' => $ubicacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Ubicacion entity.
     *
     * @Route("/{id}/edit", name="ubicacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ubicacion $ubicacion)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Ubicacion", "ubicacion");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ubicacion);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\UbicacionType', $ubicacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ubicacion);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('ubicacion');
        }
        return $this->render('ubicacion/edit.html.twig', array(
            'ubicacion' => $ubicacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Ubicacion entity.
     *
     * @Route("/{id}", name="ubicacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ubicacion $ubicacion)
    {
    
        $form = $this->createDeleteForm($ubicacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ubicacion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Ubicacion was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Ubicacion');
        }
        
        return $this->redirectToRoute('ubicacion');
    }
    
    /**
     * Creates a form to delete a Ubicacion entity.
     *
     * @param Ubicacion $ubicacion The Ubicacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ubicacion $ubicacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ubicacion_delete', array('id' => $ubicacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Ubicacion by id
     *
     * @Route("/delete/{id}", name="ubicacion_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Ubicacion $ubicacion){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($ubicacion);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Ubicacion was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Ubicacion');
        }

        return $this->redirect($this->generateUrl('ubicacion'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="ubicacion_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Ubicacion');

                foreach ($ids as $id) {
                    $ubicacion = $repository->find($id);
                    $em->remove($ubicacion);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'ubicacions was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the ubicacions ');
            }
        }

        return $this->redirect($this->generateUrl('ubicacion'));
    }
    

}
