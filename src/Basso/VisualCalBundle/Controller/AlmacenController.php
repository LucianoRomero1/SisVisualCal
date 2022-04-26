<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Almacen;

/**
 * Almacen controller.
 *
 * @Route("/almacen")
 */
class AlmacenController extends Controller
{
    /**
     * Lists all Almacen entities.
     *
     * @Route("/", name="almacen")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Almacen", "almacen");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Almacen')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($almacens, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('almacen/index.html.twig', array(
            'almacens' => $almacens,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\AlmacenFilterType');

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
            return $me->generateUrl('almacen', $requestParams);
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
     * Displays a form to create a new Almacen entity.
     *
     * @Route("/new", name="almacen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Almacen", "almacen");
        $breadcrumbs->addRouteItem("Nuevo Registro", "almacen_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $almacen = new Almacen();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\AlmacenType', $almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($almacen);
            $em->flush();
            
            $editLink = $this->generateUrl('almacen_edit', array('id' => $almacen->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'almacen' : 'almacen_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('almacen/new.html.twig', array(
            'almacen' => $almacen,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Almacen entity.
     *
     * @Route("/{id}", name="almacen_show")
     * @Method("GET")
     */
    public function showAction(Almacen $almacen)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Almacen", "almacen");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($almacen);
        return $this->render('almacen/show.html.twig', array(
            'almacen' => $almacen,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Almacen entity.
     *
     * @Route("/{id}/edit", name="almacen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Almacen $almacen)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Almacen", "almacen");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($almacen);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\AlmacenType', $almacen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($almacen);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('almacen');
        }
        return $this->render('almacen/edit.html.twig', array(
            'almacen' => $almacen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Almacen entity.
     *
     * @Route("/{id}", name="almacen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Almacen $almacen)
    {
    
        $form = $this->createDeleteForm($almacen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($almacen);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Almacen was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Almacen');
        }
        
        return $this->redirectToRoute('almacen');
    }
    
    /**
     * Creates a form to delete a Almacen entity.
     *
     * @param Almacen $almacen The Almacen entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Almacen $almacen)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('almacen_delete', array('id' => $almacen->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Almacen by id
     *
     * @Route("/delete/{id}", name="almacen_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Almacen $almacen){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($almacen);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Almacen was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Almacen');
        }

        return $this->redirect($this->generateUrl('almacen'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="almacen_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Almacen');

                foreach ($ids as $id) {
                    $almacen = $repository->find($id);
                    $em->remove($almacen);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'almacens was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the almacens ');
            }
        }

        return $this->redirect($this->generateUrl('almacen'));
    }
    

}
