<?php

declare(strict_types=1);

/*
 * This file is part of Result Type.
 *
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\ResultType;

use GrahamCampbell\ResultType\Error;
use GrahamCampbell\ResultType\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ResultTest extends TestCase
{
    public function testSuccessValue(): void
    {
        self::assertTrue(Success::create('foo')->error()->isEmpty());
        self::assertTrue(Success::create('foo')->success()->isDefined());
        self::assertSame('foo', Success::create('foo')->success()->get());
    }

    public function testSuccessMapping(): void
    {
        $r = Success::create('foo')
            ->map('strtoupper')
            ->mapError('ucfirst');

        self::assertTrue($r->success()->isDefined());
        self::assertSame('FOO', $r->success()->get());
    }

    public function testSuccessFlatMappingSuccess(): void
    {
        $r = Success::create('foo')->flatMap(function (string $data): Success {
            return Success::create('OH YES');
        });

        self::assertTrue($r->success()->isDefined());
        self::assertSame('OH YES', $r->success()->get());
    }

    public function testSuccessFlatMappingError(): void
    {
        $r = Success::create('foo')->flatMap(function (string $data): Error {
            return Error::create('OH NO');
        });

        self::assertTrue($r->error()->isDefined());
        self::assertSame('OH NO', $r->error()->get());
    }

    public function testSuccessFail(): void
    {
        $result = Success::create('foo');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('None has no value.');

        $result->error()->get();
    }

    public function testErrorValue(): void
    {
        self::assertTrue(Error::create('foo')->error()->isDefined());
        self::assertTrue(Error::create('foo')->success()->isEmpty());
        self::assertSame('foo', Error::create('foo')->error()->get());
    }

    public function testErrorMapping(): void
    {
        $r = Error::create('foo')
            ->map('strtoupper')
            ->mapError('ucfirst');

        self::assertSame('Foo', $r->error()->get());
    }

    public function testErrorFail(): void
    {
        $result = Error::create('foo');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('None has no value.');

        $result->success()->get();
    }
}
