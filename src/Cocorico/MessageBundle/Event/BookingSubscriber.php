<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\MessageBundle\Event;


use Cocorico\CoreBundle\Event\BookingEvent;
use Cocorico\CoreBundle\Event\BookingEvents;
use Cocorico\MessageBundle\Model\ThreadManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Cocorico\CoreBundle\Mailer\TwigSwiftMailer;


class BookingSubscriber implements EventSubscriberInterface
{
    protected $threadManager;
    protected $mailer;

    /**
     * @param ThreadManager $threadManager
     */
    public function __construct(ThreadManager $threadManager, TwigSwiftMailer $mailer)
    {
        $this->threadManager = $threadManager;
        $this->mailer = $mailer;
    }


    public function onBookingNewCreated(BookingEvent $event)
    {
        $booking = $event->getBooking();
        $user = $booking->getUser();
        $this->threadManager->createNewListingThread($user, $booking);
        
        $this->mailer->sendMessageToAdmin(
                    'New booking created',
                    'New booking created'
                );        
    }


    public static function getSubscribedEvents()
    {
        return array(
            BookingEvents::BOOKING_NEW_CREATED => array('onBookingNewCreated', 1),
        );
    }

}