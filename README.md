# Demo application for Symfony : authentication with CAS

## Introduction
This is a demo application for the new CAS Token Authenticator implemented in Symfony 7.1 (https://symfony.com/blog/new-in-symfony-7-1-improved-access-token-authenticator)

The documentation in 7.1.1 wasn't sufficient, so I created a demo application working with a CAS 2 server.
Benjamin Feron helped with fixing the issue with the revalidation of the ticket.

### In this demo, you must adjust some settings:

The `.env` variables `CAS_URL`, `CAS_VALIDATE_PATH`, `CAS_LOGIN_PATH` have to be set according to your CAS server

The username in `userProvider` in `config/pacakges/security.yaml` has to be updated.

`CAS_URL` ,`CAS_LOGIN_PATH`, `CAS_VALIDATE_PATH` are used in `services.yaml`.

### Using the demo
- Start the application with `symfony server:start`
- The route `/` is public
- The route `/number` is protected by CAS
- Open `https://localhost:8000/` in your browser

Acceding to the `/number` route redirects you to the CAS server to authenticate. In the profiler : the session is authenticated

## Using CAS authentification in your application

  * `service.yaml`:
    ```
    parameters:
        cas_url: '%env(CAS_URL)%'
        cas_validate_url: '%cas_url%%env(CAS_VALIDATE_PATH)%'
        cas_login_url: '%cas_url%%env(CAS_LOGIN_PATH)%'

    services:
        security.access_token_extractor.cas:
            class: Symfony\Component\Security\Http\AccessToken\QueryAccessTokenExtractor
            arguments:
                - 'ticket'
        App\Security\CasAuthenticatorEntryPoint:
            arguments:
                $casUrl: '%cas_login_url%'
    ```
  * Add `src/Security/CasAuthenticatorEntryPoint.php` :  This class redirects the user for authentication.
  * Add `src/Security/CasAuthenticatorListener.php` : This class removes the ticket from the URI (no more validation: the session is created and the CAS ticket can only be valided once)
  * Adapt this snipplet in `security.yaml` for your firewall:
    ```
    security:
        firewalls:
            cas_firewall:
            pattern: ^/
            provider: app_user_provider
                access_token:
                    token_handler:
                        cas:
                            validation_url: '%cas_validate_url%'
                    token_extractors:
                        - security.access_token_extractor.cas
                entry_point: App\Security\CasAuthenticatorEntryPoint
    ```
