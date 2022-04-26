<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\CalibracionTipo;

/**
 * CalibracionTipo controller.
 *
 * @Route("/calibraciontipo")
 */
class CalibracionTipoController extends Controller
{
    /**
     * Lists all CalibracionTipo entities.
     *
     * @Route("/", name="calibraciontipo")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("CalibracionTipo", "calibraciontipo");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:CalibracionTipo')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($calibracionTipos, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('calibraciontipo/index.html.twig', array(
            'calibracionTipos' => $calibracionTipos,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionTipoFilterType');

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
            return $me->generateUrl('calibraciontipo', $requestParams);
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
     * Displays a form to create a new CalibracionTipo entity.
     *
     * @Route("/new", name="calibraciontipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("CalibracionTipo", "calibraciontipo");
        $breadcrumbs->addRouteItem("Nuevo Registro", "calibraciontipo_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $calibracionTipo = new CalibracionTipo();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\CalibracionTipoType', $calibracionTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calibracionTipo);
            $em->flush();
            
            $editLink = $this->generateUrl('calibraciontipo_edit', array('id' => $calibracionTipo->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'calibraciontipo' : 'calibraciontipo_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('calibraciontipo/new.html.twig', array(
            'calibracionTipo' => $calibracionTipo,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a CalibracionTipo entity.
     *
     * @Route("/{id}", name="calibraciontipo_show")
     * @Method("GET")
     */
    public function showAction(CalibracionTipo $calibracionTipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("CalibracionTipo", "calibraciontipo");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($calibracionTipo);
        return $this->render('calibraciontipo/show.html.twig', array(
            'calibracionTipo' => $calibracionTipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing CalibracionTipo entity.
     *
     * @Route("/{id}/edit", name="calibraciontipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CalibracionTipo $calibracionTipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("CalibracionTipo", "calibraciontipo");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($calibracionTipo);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\CalibracionTipoType', $calibracionTipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calibracionTipo);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('calibraciontipo');
        }
        return $this->render('calibraciontipo/edit.html.twig', array(
            'calibracionTipo' => $calibracionTipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a CalibracionTipo entity.
     *
     * @Route("/{id}", name="calibraciontipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CalibracionTipo $calibracionTipo)
    {
    
        $form = $this->createDeleteForm($calibracionTipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calibracionTipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The CalibracionTipo was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the CalibracionTipo');
        }
        
        return $this->redirectToRoute('calibraciontipo');
    }
    
    /**
     * Creates a form to delete a CalibracionTipo entity.
     *
     * @param CalibracionTipo $calibracionTipo The CalibracionTipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CalibracionTipo $calibracionTipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calibraciontipo_delete', array('id' => $calibracionTipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete CalibracionTipo by id
     *
     * @Route("/delete/{id}", name="calibraciontipo_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(CalibracionTipo $calibracionTipo){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($calibracionTipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The CalibracionTipo was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the CalibracionTipo');
        }

        return $this->redirect($this->generateUrl('calibraciontipo'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="calibraciontipo_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:CalibracionTipo');

                foreach ($ids as $id) {
                    $calibracionTipo = $repository->find($id);
                    $em->remove($calibracionTipo);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'calibracionTipos was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the calibracionTipos ');
            }
        }

        return $this->redirect($this->generateUrl('calibraciontipo'));
    }
    

}
