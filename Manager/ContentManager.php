<?php
/**
 * @author Vitiko <vitiko@mail.ru>
 */

namespace Iphp\ContentBundle\Manager;

use Doctrine\ORM\EntityManager;

class ContentManager {


    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em )
    {
        $this->em = $em;
    }


    /**
     * @return  \Iphp\ContentBundle\Entity\BaseContentRepository
     */
    function getRepository ()
    {
        return $this->em->getRepository ('ApplicationIphpContentBundle:Content');
    }

} 