<?php

namespace Wl\Controller\Api\User;

use Wl\Http\HttpService\IHttpService;
use Wl\Mvc\Exception\ControllerException;
use Wl\Mvc\Result\JsonResult;
use Wl\User\AuthService\Exception\AuthException;
use Wl\User\AuthService\IAuthService;
use Wl\User\AuthValidator\AuthValidator;
use Wl\User\AuthValidator\AuthValidatorException;
use Wl\User\ICredentialsFactory;

class AuthController
{
    /**
     * @Inject
     * @var IAuthService
     */
    private $authService;
    
    /**
     * @Inject
     * @var ICredentialsFactory
     */
    private $credFactory;

    /**
     * @Inject
     * @var IHttpService
     */
    private $http;

    /**
     * @Inject
     * @var AuthValidator
     */
    private $authValidator;

    public function get()
    {
        $account = $this->authService->account();

        $result = null;
        if ($account) {
            $result = [
                'id' => $account->getId(),
                'email' => $account->getEmail(),
                'username' => $account->getUsername(),
            ];
        }

        return new JsonResult($result);
    }

    public function post()
    {
        $post = $this->http->request()->post();

        $token = $this->credFactory->getDigestToken(
            $post->get('login'), 
            $post->get('password')
        );
        try {
            $this->authValidator->validateCredentials($token);
            $account = $this->authService->authenticate($token);
            if ($account) {
                $this->authService->login($account);
            }
        } catch (AuthValidatorException $e) {
            throw new ControllerException('ERROR_INVALID_CREDENTIALS');
        } catch (AuthException $e) {
            if ($e->getMessage() === AuthException::INVALID_LOGIN) {
                throw new ControllerException('ERROR_USER_NOT_FOUND');
            } else {
                throw new ControllerException('ERROR_INVALID_CREDENTIALS');
            }
        }
    }
}
