<?php

/**
 * @author "Benjamin Feron"
 */

namespace App\Security;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

#[AsEventListener(event: LoginSuccessEvent::class, method: 'onLoginSuccessEvent')]
class CasAuthenticatorListener
{
    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $request = $event->getRequest();

        $request->query->remove('ticket');
        $request->overrideGlobals();

        $event->setResponse(new RedirectResponse($request->getUri()));
    }
}
