<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Tipo;

/**
 * Tipo controller.
 *
 * @Route("/tipo")
 */
class TipoController extends Controller
{
    /**
     * Lists all Tipo entities.
     *
     * @Route("/", name="tipo")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Tipo", "tipo");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Tipo')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($tipos, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('tipo/index.html.twig', array(
            'tipos' => $tipos,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\TipoFilterType');

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
            return $me->generateUrl('tipo', $requestParams);
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
     * Displays a form to create a new Tipo entity.
     *
     * @Route("/new", name="tipo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Tipo", "tipo");
        $breadcrumbs->addRouteItem("Nuevo Registro", "tipo_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $tipo = new Tipo();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\TipoType', $tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
            $em->flush();
            
            $editLink = $this->generateUrl('tipo_edit', array('id' => $tipo->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'tipo' : 'tipo_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('tipo/new.html.twig', array(
            'tipo' => $tipo,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Tipo entity.
     *
     * @Route("/{id}", name="tipo_show")
     * @Method("GET")
     */
    public function showAction(Tipo $tipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Tipo", "tipo");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($tipo);
        return $this->render('tipo/show.html.twig', array(
            'tipo' => $tipo,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Tipo entity.
     *
     * @Route("/{id}/edit", name="tipo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tipo $tipo)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Tipo", "tipo");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($tipo);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\TipoType', $tipo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tipo);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('tipo');
        }
        return $this->render('tipo/edit.html.twig', array(
            'tipo' => $tipo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Tipo entity.
     *
     * @Route("/{id}", name="tipo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tipo $tipo)
    {
    
        $form = $this->createDeleteForm($tipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Tipo was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Tipo');
        }
        
        return $this->redirectToRoute('tipo');
    }
    
    /**
     * Creates a form to delete a Tipo entity.
     *
     * @param Tipo $tipo The Tipo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tipo $tipo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tipo_delete', array('id' => $tipo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Tipo by id
     *
     * @Route("/delete/{id}", name="tipo_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Tipo $tipo){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($tipo);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Tipo was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Tipo');
        }

        return $this->redirect($this->generateUrl('tipo'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="tipo_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Tipo');

                foreach ($ids as $id) {
                    $tipo = $repository->find($id);
                    $em->remove($tipo);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'tipos was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the tipos ');
            }
        }

        return $this->redirect($this->generateUrl('tipo'));
    }
    

}
