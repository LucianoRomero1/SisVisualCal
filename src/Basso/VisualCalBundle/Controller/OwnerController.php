<?php

namespace Basso\VisualCalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap4View;

use Basso\VisualCalBundle\Entity\Owner;

/**
 * Owner controller.
 *
 * @Route("/owner")
 */
class OwnerController extends Controller
{
    /**
     * Lists all Owner entities.
     *
     * @Route("/", name="owner")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Owner", "owner");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('BassoVisualCalBundle:Owner')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($owners, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('owner/index.html.twig', array(
            'owners' => $owners,
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
        $filterForm = $this->createForm('Basso\VisualCalBundle\Form\OwnerFilterType');

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
            return $me->generateUrl('owner', $requestParams);
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
     * Displays a form to create a new Owner entity.
     *
     * @Route("/new", name="owner_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Owner", "owner");
        $breadcrumbs->addRouteItem("Nuevo Registro", "owner_new");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $owner = new Owner();
        $form   = $this->createForm('Basso\VisualCalBundle\Form\OwnerType', $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($owner);
            $em->flush();
            
            $editLink = $this->generateUrl('owner_edit', array('id' => $owner->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Registro creado Satisfactoriamente.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'owner' : 'owner_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('owner/new.html.twig', array(
            'owner' => $owner,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Owner entity.
     *
     * @Route("/{id}", name="owner_show")
     * @Method("GET")
     */
    public function showAction(Owner $owner)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Owner", "owner");
        
        $breadcrumbs->addItem("Vista Previa");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($owner);
        return $this->render('owner/show.html.twig', array(
            'owner' => $owner,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Owner entity.
     *
     * @Route("/{id}/edit", name="owner_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Owner $owner)
    {
		$breadcrumbs = $this->get("white_october_breadcrumbs");
           
        $breadcrumbs->addRouteItem("Owner", "owner");
        
        $breadcrumbs->addItem("Editar Registro");
        
        $breadcrumbs->prependRouteItem("Inicio", "homepage");
		
        $deleteForm = $this->createDeleteForm($owner);
        $editForm = $this->createForm('Basso\VisualCalBundle\Form\OwnerType', $owner);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($owner);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Editado Satisfactoriamente!');
            return $this->redirectToRoute('owner');
        }
        return $this->render('owner/edit.html.twig', array(
            'owner' => $owner,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Owner entity.
     *
     * @Route("/{id}", name="owner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Owner $owner)
    {
    
        $form = $this->createDeleteForm($owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($owner);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Owner was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Owner');
        }
        
        return $this->redirectToRoute('owner');
    }
    
    /**
     * Creates a form to delete a Owner entity.
     *
     * @param Owner $owner The Owner entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Owner $owner)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('owner_delete', array('id' => $owner->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Owner by id
     *
     * @Route("/delete/{id}", name="owner_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Owner $owner){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($owner);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Owner was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Owner');
        }

        return $this->redirect($this->generateUrl('owner'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="owner_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('BassoVisualCalBundle:Owner');

                foreach ($ids as $id) {
                    $owner = $repository->find($id);
                    $em->remove($owner);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'owners was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the owners ');
            }
        }

        return $this->redirect($this->generateUrl('owner'));
    }
    

}
