<?php

namespace Iphp\ContentBundle\Admin;

use Iphp\CoreBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class ContentImageMediaAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'pos'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', null, ['required' => false])
            ->add('pos', null, ['required' => false])
            ->add('main', null, ['required' => false ])
            ->add('media', 'sonata_type_model_list', ['required' => true], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'default'
                ],
            ])
            ->add('mediaDisplay', 'iphp_display', [
                'label' => 'Media',
                'required' => false,
                'data_class' => 'Application\\Sonata\\MediaBundle\\Entity\\Media'])

        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setPos(1);

        return $instance;
    }
}
