<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\RyRTipo;

/**
 * RyRTipo controller.
 *
 * @Route("/ryrtipo")
 */
class RyRTipoController extends Controller
{
    /**
     * Lists all RyRTipo entities.
     *
     * @Route("/", name="ryrtipo")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyRTipo", "ryrtipo");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:RyRTipo')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($ryRTipos, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('ryrtipo/index.html.twig', array(
            'ryRTipos' => $ryRTipos,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\RyRTipoFilterType');

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
            return $me->generateUrl('ryrtipo', $requestParams);
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
     * Displays a form to create a new RyRTipo entity.
     *
     * @Route("/new", name="ryrtipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyRTipo", "ryrtipo");
        $breadcrumbs->addRouteItem("Nuevo Registro", "ryrtipo_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $ryRTipo = new RyRTipo();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\RyRTipoType', $ryRTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ryRTipo);
            $em->flush();
            
            $editLink = $this->generateUrl('ryrtipo_edit', array('id' => $ryRTipo->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'ryrtipo' : 'ryrtipo_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('ryrtipo/new.html.twig', array(
            'ryRTipo' => $ryRTipo,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a RyRTipo entity.
     *
     * @Route("/{id}", name="ryrtipo_show")
     * @Method("GET")
     */
    public function showAction(RyRTipo $ryRTipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyRTipo", "ryrtipo");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ryRTipo);
        return $this->render('ryrtipo/show.html.twig', array(
            'ryRTipo' => $ryRTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing RyRTipo entity.
     *
     * @Route("/{id}/edit", name="ryrtipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RyRTipo $ryRTipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("RyRTipo", "ryrtipo");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($ryRTipo);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\RyRTipoType', $ryRTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ryRTipo);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('ryrtipo');
        }
        return $this->render('ryrtipo/edit.html.twig', array(
            'ryRTipo' => $ryRTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a RyRTipo entity.
     *
     * @Route("/{id}", name="ryrtipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RyRTipo $ryRTipo)
    {
    
        $form = $this->createDeleteForm($ryRTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ryRTipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The RyRTipo was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the RyRTipo');
        }
        
        return $this->redirectToRoute('ryrtipo');
    }
    
    /**
     * Creates a form to delete a RyRTipo entity.
     *
     * @param RyRTipo $ryRTipo The RyRTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RyRTipo $ryRTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ryrtipo_delete', array('id' => $ryRTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete RyRTipo by id
     *
     * @Route("/delete/{id}", name="ryrtipo_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(RyRTipo $ryRTipo){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($ryRTipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The RyRTipo was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the RyRTipo');
        }

        return $this->redirect($this->generateUrl('ryrtipo'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="ryrtipo_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:RyRTipo');

                foreach ($ids as $id) {
                    $ryRTipo = $repository->find($id);
                    $em->remove($ryRTipo);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'ryRTipos was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the ryRTipos ');
            }
        }

        return $this->redirect($this->generateUrl('ryrtipo'));
    }
    

}
