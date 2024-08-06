# Demo application for Symfony : authentication with CAS

This is a first demo application for the new CAS Token Authenticator implemented in Symfony 7.1 (https://symfony.com/blog/new-in-symfony-7-1-improved-access-token-authenticator)

The documentation in 7.1.1 isn't sufficient, so I proposed a demo application working with a CAS 2 server.

Ajust the `CAS_URL`, `CAS_VALIDATE_URL` and the userProvider in `security.yml`

`CAS_URL` is used in the `CasAuthenticatorEntryPoint`to redirect the user to authenticate
`CAS_VALIDATE_URL` is used in the Token Authenticator
