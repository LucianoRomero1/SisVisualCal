<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Fabricante;

/**
 * Fabricante controller.
 *
 * @Route("/fabricante")
 */
class FabricanteController extends Controller
{
    /**
     * Lists all Fabricante entities.
     *
     * @Route("/", name="fabricante")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Fabricante", "fabricante");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Fabricante')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($fabricantes, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('fabricante/index.html.twig', array(
            'fabricantes' => $fabricantes,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\FabricanteFilterType');

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
            return $me->generateUrl('fabricante', $requestParams);
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
     * Displays a form to create a new Fabricante entity.
     *
     * @Route("/new", name="fabricante_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Fabricante", "fabricante");
        $breadcrumbs->addRouteItem("Nuevo Registro", "fabricante_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $fabricante = new Fabricante();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\FabricanteType', $fabricante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fabricante);
            $em->flush();
            
            $editLink = $this->generateUrl('fabricante_edit', array('id' => $fabricante->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'fabricante' : 'fabricante_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('fabricante/new.html.twig', array(
            'fabricante' => $fabricante,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Fabricante entity.
     *
     * @Route("/{id}", name="fabricante_show")
     * @Method("GET")
     */
    public function showAction(Fabricante $fabricante)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Fabricante", "fabricante");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($fabricante);
        return $this->render('fabricante/show.html.twig', array(
            'fabricante' => $fabricante,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Fabricante entity.
     *
     * @Route("/{id}/edit", name="fabricante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Fabricante $fabricante)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Fabricante", "fabricante");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($fabricante);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\FabricanteType', $fabricante);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fabricante);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('fabricante');
        }
        return $this->render('fabricante/edit.html.twig', array(
            'fabricante' => $fabricante,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Fabricante entity.
     *
     * @Route("/{id}", name="fabricante_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Fabricante $fabricante)
    {
    
        $form = $this->createDeleteForm($fabricante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fabricante);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Fabricante was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Fabricante');
        }
        
        return $this->redirectToRoute('fabricante');
    }
    
    /**
     * Creates a form to delete a Fabricante entity.
     *
     * @param Fabricante $fabricante The Fabricante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fabricante $fabricante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fabricante_delete', array('id' => $fabricante->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Fabricante by id
     *
     * @Route("/delete/{id}", name="fabricante_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Fabricante $fabricante){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($fabricante);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Fabricante was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Fabricante');
        }

        return $this->redirect($this->generateUrl('fabricante'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="fabricante_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Fabricante');

                foreach ($ids as $id) {
                    $fabricante = $repository->find($id);
                    $em->remove($fabricante);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'fabricantes was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the fabricantes ');
            }
        }

        return $this->redirect($this->generateUrl('fabricante'));
    }
    

}
