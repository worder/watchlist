<?php

namespace Test\Unit\User;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wl\User\Account\Account;
use Wl\User\Account\IAccount;
use Wl\User\AccountService\AccountService;
use Wl\User\AccountService\IAccountService;
use Wl\User\AccountValidator\AccountValidator;
use Wl\User\AccountValidator\Exception\AccountValidationException;
use Wl\User\Credentials\DigestCredentials;
use Wl\User\Credentials\ICredentials;

class AccountValidatorTest extends TestCase
{
    // private $validator;

    protected function setUp(): void
    {
    }

    protected function createAccServiceMock($returnAccByEmail = true, $returnAccByUsername = true)
    {
        /**
         * @var MockObject&IAccountService
         */
        $as = $this->createStub(AccountService::class);
        if ($returnAccByEmail) {
            $as->method('getAccountByEmail')->willReturn($this->createAccountMock());
        }
        if ($returnAccByUsername) {
            $as->method('getAccountByUsername')->willReturn($this->createAccountMock());
        }
        return $as;
    }

    protected function createAccountMock($data = [])
    {
        /**
         * @var MockObject&IAccount
         */
        $account = $this->createStub(Account::class);
        if (isset($data['username'])) {
            $account->method('getUsername')->willReturn($data['username']);
        }
        if (isset($data['email'])) {
            $account->method('getEmail')->willReturn($data['email']);
        }
        return $account;
    }

    protected function _testAdd($accData, ?IAccountService $accSerivce = null)
    {
        $acc = $this->createAccountMock($accData);
        $validator = new AccountValidator($accSerivce ?: $this->createAccServiceMock(false, false));

        return $validator->validateAccount($acc, AccountValidator::SCHEME_ADD);
    }

    public function testInvalidValidationScheme()
    {
        $acc = $this->createAccountMock();
        $validator = new AccountValidator($this->createAccServiceMock());
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid validation scheme');
        $validator->validateAccount($acc, 'a');
    }

    public function testAddAllValid()
    {
        try {
            $this->assertTrue($this->_testAdd([
                'username' => 'Username',
                'email' => 'user@example.com'
            ]));
        } catch (AccountValidationException $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testAddInvalidEmail()
    {
        $invalidEmails = [
            'user@example',
            'userexample.com',
            'user@@example.com'
        ];

        foreach ($invalidEmails as $email) {
            $this->expectException(AccountValidationException::class);
            $this->expectExceptionMessage(AccountValidationException::EMAIL_INVALID);
            $this->_testAdd([
                'username' => 'Username',
                'email' => $email
            ]);
        }
    }

    public function testAddEmptyEmail()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::EMAIL_EMPTY);
        $this->_testAdd([
            'username' => 'Username',
            'email' => ''
        ]);
    }

    public function testAddExistEmail()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::EMAIL_EXISTS);
        $this->_testAdd([
            'username' => 'Username',
            'email' => 'user@example.com'
        ], $this->createAccServiceMock(true, false));
    }

    public function testAddExistUsername()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::USERNAME_EXISTS);
        $this->_testAdd([
            'username' => 'Username',
            'email' => 'user@example.com'
        ], $this->createAccServiceMock(false, true));
    }

    public function testAddEmptyUsername()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::USERNAME_EMPTY);
        $this->_testAdd([
            'username' => '',
            'email' => 'user@example.com'
        ], $this->createAccServiceMock(false, false));
    }

    public function testAddShortUsername()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::USERNAME_TOO_SHORT);
        $this->_testAdd([
            'username' => 'a',
            'email' => 'user@example.com'
        ], $this->createAccServiceMock(false, false));
    }

    public function testAddLongUsername()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::USERNAME_TOO_LONG);
        $this->_testAdd([
            'username' => 'iegahphaelaochohhaezoicoochailooGhimiupohToaZiephingohlonaigiecei',
            'email' => 'user@example.com'
        ], $this->createAccServiceMock(false, false));
    }

    protected function _validatePassword($pw)
    {
        $validator = new AccountValidator($this->createAccServiceMock());

        /**
         * @var ICredentials&MockObject
         */
        $cred = $this->getMockBuilder(DigestCredentials::class)->disableOriginalConstructor()->getMock();
        $cred->method('getPassword')->willReturn($pw);

        return $validator->validateCredentials($cred);
    }

    public function testValidPassword()
    {
        // pwgen -y 20 5
        $validPasswords = [
            'QuiF3Wai6nah0otha0ra',
            'zaitu[Zoh3oew1tohqu2',
            'eemie#ch5OT;eecheej2',
            'jaeNgir#ee6ooh`eek0x',
            'Ozai6oemi%o6eepha9zu',
        ];

        foreach ($validPasswords as $pw) {
            $this->assertTrue($this->_validatePassword($pw));
        }
    }

    public function testEmptyPassword()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::PASSWORD_EMPTY);
        $this->_validatePassword('');
    }

    public function testShortPassword()
    {
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::PASSWORD_TOO_SHORT);
        $this->_validatePassword('abc');
    }

    public function testLongPassword()
    {
        // pwgen 257 1
        $this->expectException(AccountValidationException::class);
        $this->expectExceptionMessage(AccountValidationException::PASSWORD_TOO_LONG);
        $this->_validatePassword('ni3io6sha3suaghoh2goo5thah2xietheijeeLahngao6wuf5ohV1bonah6Aseifeepahda8Muechaz6eejooKeNg3Ec2peetaph4eich7eexohKoo9howaec9Aishu9seek4poo6reith8ia9Ieghaibae8zuCah3thai0Rae3rah5Gaer8ohthaSee6ieDoaPupue8ahx0iehaBaophaingeeRaTh9sheekoh9aiFooh6taewei7penaenah7ei');
    }
}
