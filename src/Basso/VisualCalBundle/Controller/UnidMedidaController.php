<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\UnidMedida;

/**
 * UnidMedida controller.
 *
 * @Route("/unidmedida")
 */
class UnidMedidaController extends Controller
{
    /**
     * Lists all UnidMedida entities.
     *
     * @Route("/", name="unidmedida")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("UnidMedida", "unidmedida");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:UnidMedida')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($unidMedidas, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('unidmedida/index.html.twig', array(
            'unidMedidas' => $unidMedidas,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\UnidMedidaFilterType');

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
            return $me->generateUrl('unidmedida', $requestParams);
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
     * Displays a form to create a new UnidMedida entity.
     *
     * @Route("/new", name="unidmedida_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("UnidMedida", "unidmedida");
        $breadcrumbs->addRouteItem("Nuevo Registro", "unidmedida_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $unidMedida = new UnidMedida();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\UnidMedidaType', $unidMedida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidMedida);
            $em->flush();
            
            $editLink = $this->generateUrl('unidmedida_edit', array('id' => $unidMedida->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'unidmedida' : 'unidmedida_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('unidmedida/new.html.twig', array(
            'unidMedida' => $unidMedida,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a UnidMedida entity.
     *
     * @Route("/{id}", name="unidmedida_show")
     * @Method("GET")
     */
    public function showAction(UnidMedida $unidMedida)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("UnidMedida", "unidmedida");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($unidMedida);
        return $this->render('unidmedida/show.html.twig', array(
            'unidMedida' => $unidMedida,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing UnidMedida entity.
     *
     * @Route("/{id}/edit", name="unidmedida_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UnidMedida $unidMedida)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("UnidMedida", "unidmedida");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($unidMedida);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\UnidMedidaType', $unidMedida);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($unidMedida);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('unidmedida');
        }
        return $this->render('unidmedida/edit.html.twig', array(
            'unidMedida' => $unidMedida,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a UnidMedida entity.
     *
     * @Route("/{id}", name="unidmedida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UnidMedida $unidMedida)
    {
    
        $form = $this->createDeleteForm($unidMedida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unidMedida);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The UnidMedida was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the UnidMedida');
        }
        
        return $this->redirectToRoute('unidmedida');
    }
    
    /**
     * Creates a form to delete a UnidMedida entity.
     *
     * @param UnidMedida $unidMedida The UnidMedida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UnidMedida $unidMedida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unidmedida_delete', array('id' => $unidMedida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete UnidMedida by id
     *
     * @Route("/delete/{id}", name="unidmedida_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(UnidMedida $unidMedida){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($unidMedida);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The UnidMedida was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the UnidMedida');
        }

        return $this->redirect($this->generateUrl('unidmedida'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="unidmedida_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:UnidMedida');

                foreach ($ids as $id) {
                    $unidMedida = $repository->find($id);
                    $em->remove($unidMedida);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'unidMedidas was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the unidMedidas ');
            }
        }

        return $this->redirect($this->generateUrl('unidmedida'));
    }
    

}
