<?php


namespace Iphp\ContentBundle\Admin;

use Iphp\CoreBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class ContentAdmin extends Admin
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;


    /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */

    /*    function configure()
    {
        $this->configurationPool->getAdminByAdminCode('iphp.core.admin.rubric')
                ->addExtension( new RubricAdminExtension);
    }*/

    public function __construct($code, $class, $baseControllerName)
    {
        parent::__construct($code, $class, $baseControllerName);

        if (!$this->hasRequest()) {
            $this->datagridValues = array(
                '_per_page' => 30,
                '_page' => 1,
                '_sort_order' => 'DESC', // sort direction
                '_sort_by' => 'updatedAt' // field name
            );
        }
    }


    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
        // ->add('author')
            ->add('enabled', null, array('label' => 'Показывать на сайте'))
            ->add('title', null, array('label' => 'Заголовок'))
            ->add('abstract', null, array('label' => 'Анонс'))
            ->add('content', null, array('label' => 'Текст'));

    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('Base params')
            ->add('title', null, array('label' => 'Заголовок'))
            ->add('enabled', null, array('required' => false, 'label' => 'Показывать на сайте'))
            ->add('slug', 'slug_text', array(
            'blank_title' => 'индекс рубрики (код не вводится)',
            'source_field' => 'title',
            'usesource_title' => 'Использовать заголовок материала',
            'required' => false
        ))

            ->add('rubric', 'rubricchoice')
            ->add('redirectUrl')
        //    ->add('author', 'sonata_type_model_list', array('required' => false) /*, array('edit' => 'list')*/)


            ->add('date', 'genemu_jquerydate', array(
            'required' => false, 'widget' => 'single_text'))
            ->add('abstract', null, array('label' => 'Анонс'))
            ->add('content', 'genemu_tinymce', array('label' => 'Текст'))


            ->with('Images', array('collapsed' => true))

            ->add('image', 'iphp_file')
            ->add('images', 'sonata_type_collection',
            array('by_reference' => false),
            array(
                'edit' => 'inline',
                'sortable' => 'pos',
                'inline' => 'table',
            ))

            ->end()

            ->with('Files', array('collapsed' => true))
            ->add('files', 'sonata_type_collection',
            array('by_reference' => false),
            array(
                'edit' => 'inline',
                'sortable' => 'pos',
                'inline' => 'table',
            ))
            ->end()


            ->with('Links', array('collapsed' => true))
            ->add('links', 'sonata_type_collection',
            array('by_reference' => false),
            array(
                'edit' => 'inline',
                'sortable' => 'pos',
                'inline' => 'table',
            ))


            ->end();
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     *
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Заголовок'))
            ->add('enabled', null, array('label' => 'Показывать на сайте'))
            ->add('rubric', null, array('label' => 'Рубрика'))
        /*       ->add('image', 'text', array(
            'template' => 'IphpCoreBundle::image_preview.html.twig'
        ))*/


            ->add('updatedAt');
    }

    /**
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     *
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('rubric', null, array(), null, array(
            'property' => 'TitleLevelIndented',
            'query_builder' => function(\Doctrine\ORM\EntityRepository $er)
            {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.left', 'ASC');
            }
        ))
            ->add('title')
            ->add('enabled')
            ->add('id')//     ->add('date')// ->add('author')
        ;
    }

    public function prePersist($content)
    {
        if (!$content->getSlug()) $content->setSlug ('');
        parent::prePersist($content);
    }


    public function setUserManager($userManager)
    {
        $this->userManager = $userManager;
    }

    public function getUserManager()
    {
        return $this->userManager;
    }

}
