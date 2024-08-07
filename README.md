# Demo application for Symfony : authentication with CAS

## Introduction
This is a first demo application for the new CAS Token Authenticator implemented in Symfony 7.1 (https://symfony.com/blog/new-in-symfony-7-1-improved-access-token-authenticator)

The documentation in 7.1.1 isn't sufficient, so I proposed a demo application working with a CAS 2 server.

Ajust the `CAS_URL`, `CAS_VALIDATE_URL` and the userProvider in `security.yml`

`CAS_URL` is used in the `CasAuthenticatorEntryPoint`to redirect the user to authenticate
`CAS_VALIDATE_URL` is used in the Token Authenticator

## Adapt for your usage

  * `service.yml`: Load the CAS_URL, and define the service redirecting to the cas service:
    ```
    parameters:
      cas_url: '%env(CAS_URL)%'
    services:
        security.access_token_extractor.cas:
            class: Symfony\Component\Security\Http\AccessToken\QueryAccessTokenExtractor
            arguments:
                - 'ticket'
        App\Security\CasAuthenticatorEntryPoint:
            arguments:
                $casUrl: '%cas_url%'
    ```
  * Add `src/Security/CasAuthenticatorEntryPoint.php`
  * Add the snipplet to `security.yml`:
    ```
           access_token:
                 token_handler:
                     cas:
                         validation_url: '%env(CAS_VALIDATE_URL)%'
                 token_extractors:
                     - security.access_token_extractor.cas
             entry_point: App\Security\CasAuthenticatorEntryPoint
    ```
