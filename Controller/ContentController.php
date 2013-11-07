<?php

namespace Iphp\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Application\Iphp\CoreBundle\Entity\Rubric;
use Iphp\CoreBundle\Controller\RubricAwareController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ContentController extends RubricAwareController
{
    /**
     * @Template("IphpContentBundle:Content:content.html.twig")
     */
    public function indexAction()
    {
        $content = $this->getRubricIndex($this->getCurrentRubric());

        if ($content && !$content->getEnabled()) $content = null;
        //if (!$content) throw $this->createNotFoundException('Индексный материал не найден');

        return   array('content' => $content);
    }

    /**
     * @Template()
     */
    function listAction()
    {
        $rubric = $this->getCurrentRubric();
        $query = $this->getRepository()->createQuery('c', function ($qb) use ($rubric)
        {
            $qb->fromRubric($rubric)->whereEnabled()->whereIndex(false)
                    ->addOrderBy ('c.date','DESC')->addOrderBy ('c.updatedAt','DESC');
        });


        return  array('entities' => $this->paginate($query, 20));
    }


    /**
     * @Template("IphpContentBundle:Content:content.html.twig")
     */
    public function contentBySlugAction($slug)
    {
        $rubric = $this->getCurrentRubric();
        $content = $this->getRepository()->createQuery('c', function ($qb) use ($rubric, $slug)
        {
            $qb->fromRubric($rubric)->whereSlug($slug)->whereEnabled();
        })->getOneOrNullResult();

        if (!$content) throw $this->createNotFoundException('Материал с кодом "' . $slug . '" не найден');


        if ($content->getRedirectUrl())
            return $this->redirect($content->getRedirectUrl());


        return   array('content' => $content);

    }


    /**
     * @Template()
     */
    function searchAction(Request $request)
    {
        $searchStr = $request->get ('search');


        $query =    $searchStr  ? $this->getRepository()->createQuery('c', function ($qb) use($searchStr)
        {
            $qb->whereEnabled()->search ($searchStr);
        }) : null;

        return $this->render(
            'IphpContentBundle::search.html.twig',
            array('contents' => $query ? $this->paginate($query, 20) :  array(), 'searchStr' => $searchStr ));
    }







    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository('ApplicationIphpContentBundle:Content');
    }


    protected function getRubricIndex(Rubric $rubric)
    {
        return $this->getRepository()->rubricIndex($rubric);
    }


}
