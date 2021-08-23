<?php

namespace Test\Unit\User\AuthStorage;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Wl\User\Account\IAccount;
use Wl\User\AuthStorage\AuthCompositeStorage;
use Wl\User\AuthStorage\IAuthStorage;

class CompositeStorageTest extends TestCase
{
    public function testStorage()
    {
        /**
         * @var IAccount&MockObject
         */
        $accountMock = $this->createStub(IAccount::class);

        $storageA = $this->getMockBuilder(IAuthStorage::class)->getMock();
        $storageA->expects($this->once())->method('saveAccount')->with($accountMock);
        $storageA->expects($this->once())->method('loadAccount')->willReturn($accountMock);
        $storageA->expects($this->once())->method('reset');

        $storageB = $this->getMockBuilder(IAuthStorage::class)->getMock();
        $storageB->expects($this->once())->method('saveAccount')->with($accountMock);
        $storageB->expects($this->never())->method('loadAccount');
        $storageB->expects($this->once())->method('reset');

        $storageC = $this->getMockBuilder(IAuthStorage::class)->getMock();
        $storageC->expects($this->once())->method('loadAccount');

        $storage = new AuthCompositeStorage([
            $storageA, // will return account on loadAccount
            $storageB
        ]);

        $storage->saveAccount($accountMock);
        $this->assertInstanceOf(IAccount::class, $storage->loadAccount());
        $storage->reset();

        $storage = new AuthCompositeStorage([
            $storageC,
        ]);
        $this->assertNull($storage->loadAccount());
    }
}
