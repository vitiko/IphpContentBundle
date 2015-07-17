<?php

namespace Iphp\ContentBundle\Admin;

use Iphp\ContentBundle\Admin\ContentFileAdmin as BaseContentFileAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class ContentFileMediaAdmin extends BaseContentFileAdmin
{
    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'pos'
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description', null, ['required' => false])
            ->add('pos')
            ->add('file', 'sonata_type_model_list', ['required' => true], [
                'link_parameters' => [
                    'provider' => 'sonata.media.provider.file',
                    'context' => 'default'
                ],
            ])
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