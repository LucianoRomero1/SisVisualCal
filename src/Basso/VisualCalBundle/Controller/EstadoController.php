<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Estado;

/**
 * Estado controller.
 *
 * @Route("/estado")
 */
class EstadoController extends Controller
{
    /**
     * Lists all Estado entities.
     *
     * @Route("/", name="estado")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Estado", "estado");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Estado')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($estados, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('estado/index.html.twig', array(
            'estados' => $estados,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\EstadoFilterType');

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
            return $me->generateUrl('estado', $requestParams);
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
     * Displays a form to create a new Estado entity.
     *
     * @Route("/new", name="estado_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Estado", "estado");
        $breadcrumbs->addRouteItem("Nuevo Registro", "estado_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $estado = new Estado();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\EstadoType', $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();
            
            $editLink = $this->generateUrl('estado_edit', array('id' => $estado->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'estado' : 'estado_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('estado/new.html.twig', array(
            'estado' => $estado,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Estado entity.
     *
     * @Route("/{id}", name="estado_show")
     * @Method("GET")
     */
    public function showAction(Estado $estado)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Estado", "estado");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($estado);
        return $this->render('estado/show.html.twig', array(
            'estado' => $estado,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Estado entity.
     *
     * @Route("/{id}/edit", name="estado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Estado $estado)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Estado", "estado");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($estado);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\EstadoType', $estado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estado);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('estado');
        }
        return $this->render('estado/edit.html.twig', array(
            'estado' => $estado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Estado entity.
     *
     * @Route("/{id}", name="estado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Estado $estado)
    {
    
        $form = $this->createDeleteForm($estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estado);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Estado was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Estado');
        }
        
        return $this->redirectToRoute('estado');
    }
    
    /**
     * Creates a form to delete a Estado entity.
     *
     * @param Estado $estado The Estado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Estado $estado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estado_delete', array('id' => $estado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Estado by id
     *
     * @Route("/delete/{id}", name="estado_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Estado $estado){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($estado);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Estado was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Estado');
        }

        return $this->redirect($this->generateUrl('estado'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="estado_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Estado');

                foreach ($ids as $id) {
                    $estado = $repository->find($id);
                    $em->remove($estado);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'estados was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the estados ');
            }
        }

        return $this->redirect($this->generateUrl('estado'));
    }
    

}
