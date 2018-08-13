<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cocorico\CoreBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Cocorico\CoreBundle\Event\ListingFormEvents;
use Cocorico\CoreBundle\Event\ListingFormBuilderEvent;


class ListingFormBuilderSubscriber implements EventSubscriberInterface
{
    public function formBuild(ListingFormBuilderEvent $event)
    {
        $builder = $event->getFormBuilder();
        
        $builder->add('isbn', TextType::class, ['mapped' => false, 'label' => 'ISBN', 'required' => false, 'attr'=>['class' => 'form-control']]);

    }

    public static function getSubscribedEvents() {
        return array(ListingFormEvents::LISTING_NEW_FORM_BUILD => 'formBuild');
    }

}
