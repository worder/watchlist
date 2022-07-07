<?php

namespace Wl\Controller\Api\User;

use Wl\Http\HttpService\IHttpService;
use Wl\Mvc\Exception\ControllerException;
use Wl\Mvc\Result\ApiResult;
use Wl\Mvc\Result\JsonResult;
use Wl\User\AuthService\Exception\AuthException;
use Wl\User\AuthService\IAuthService;
use Wl\User\AuthValidator\AuthValidator;
use Wl\User\AuthValidator\AuthValidatorException;
use Wl\User\ICredentialsFactory;

class SignInController
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
            $this->authService->login($account);
            return ApiResult::success('OK');
        } catch (AuthValidatorException $e) {
            return ApiResult::error('invalid_credentials');
        } catch (AuthException $e) {
            if ($e->getMessage() === AuthException::INVALID_LOGIN) {
                return ApiResult::error('user_not_found');
            } else {
                return ApiResult::error('invalid_credentials');
            }
        }
    }
}
