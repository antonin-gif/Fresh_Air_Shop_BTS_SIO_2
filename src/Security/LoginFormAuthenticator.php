<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Migrations\Generator\Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CredentialsInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class LoginFormAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{

    private RouterInterface $router;

    public function __construct(UserRepository $userRepository, RouterInterface $router)
    {
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'security_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        //dd($request);
        //$email = $request->request->get('login');
        $loginData = array();
        $loginData = $request->request->all()['login'];
        $email = $loginData['email'];
        $password = $loginData['password'];
        //dd($email);

        //$password = $request->request->get('password');

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password)

        );


        // TODO: Implement authenticate() method.
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse('/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);

        // return new RedirectResponse('/login');

        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse(
            $this->router->generate('security_login')
        );
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {

        return new RedirectResponse('/login');

        /*
            * If you would like this class to control what happens when an anonymous user accesses a
            * protected page (e.g. redirect to /login), uncomment this method and make this class
            * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
            *
            * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
            */
    }
}
