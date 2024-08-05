<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class CasAuthenticatorEntryPoint implements AuthenticationEntryPointInterface
{
    private string $casUrl;

    public function __construct(string $casUrl)
    {
        $this->casUrl = $casUrl;
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $currentUrl = $request->getUri();
        $redirectUrl = sprintf('%s?service=%s', $this->casUrl, urlencode($currentUrl));

        return new RedirectResponse($redirectUrl);
    }
}
