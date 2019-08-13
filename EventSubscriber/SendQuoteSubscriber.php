<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SendQuoteSubscriber implements EventSubscriberInterface
{
    private const SEND_QUOTE_ROUTE ='api_quotes_send_to_dom_item';
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * SendQuoteSubscriber constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::VIEW => ['sendQuote', EventPriorities::POST_VALIDATE]];
    }

    private function sendQuote(ViewEvent $event, \Swift_Mailer $mailer) {
        if(self::SEND_QUOTE_ROUTE !== $event->getRequest()->attributes->get('_route')) {
            $this->logger->critical("NOPE");
            return;
        }

        $this->logger->critical("Mail sent");

        /** @var \App\Entity\Quote $quote */
        $quote = $event->getControllerResult();

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('mathieu@example.com')
            ->setTo('dominique@example.com');

        $message->setBody($quote->getValue() . " by " . $quote->getOwner());

        $mailer->send($message);

        $event->setControllerResult(new JsonResponse(['result' => 'mail sent']));

    }
}